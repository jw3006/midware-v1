<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('wsdl_controller');
        $this->load->library('keys_controller');
        $this->load->library('template/bp_postven');
        $this->load->model('midware_model');
    }

    public function sapwsdl()
    {
        $mode = 'SAP_BPGET';
        $modes = 'SCM_BPPOST';
        $type = 'vendor';

        $output = array('Lifnr' => '');
        $item = array('item' => $output);

        $params = array(
            'DateFr'    => date('Y-m-d'),
            'DateTo'    => date('Y-m-d'),
            'YfiVendor' => $item
        );

        $code_sap = '';
        $backend_text   = json_encode($params, true);
        $frontend_text = json_encode($params, true);

        #Call Operation (Function). Catch and display any errors
        $wsdl = 'http://pbbs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/yfi_vendor_4/320/yser_vendor_4/ybin_vendor_4?sap-client=320';
        $function = 'YfwsVendor2';
        $username = 'HR-ABAP01';
        $password = '123456789';
        $result = $this->wsdl_controller->_sap_wsdl($wsdl, $function, $username, $password, $params);

        if ($result['status'] == 'E') {
            print_r($result);
        } else {
            if ($result['message']['Return'] !== 'Data tdk ditemukan') {
                $items = $result['message']['YfiVendor']['item'];
                if ($items[0]) {
                    foreach ($items as $k => $v) {
                        $office = $this->midware_model->get_office_code($items[$k]['Ekorg'], $items[$k]['Bukrs']);

                        $cust['Code'] = $items[$k]['Lifnr'];
                        $cust['Name'] = $items[$k]['NameOrg1'] . ' ' . $items[$k]['NameOrg2'];
                        $cust['AddressLine'] = $items[$k]['Stras'] ? $items[$k]['Stras'] : '-';
                        $cust['City'] = $items[$k]['Ort01'] ? $items[$k]['Ort01'] : 'Jakarta';
                        $cust['ZipCode'] = $items[$k]['Pstlz'] ? $items[$k]['Pstlz'] : '-';
                        $cust['CountryCode'] = $items[$k]['Land1'] ? $items[$k]['Land1'] : 'ID';
                        $cust['FirstName'] = $items[$k]['NameFirst'] ? $items[$k]['NameFirst'] : '-';
                        $cust['Number'] = $items[$k]['Telf1'] ? $items[$k]['Telf1'] : '-';
                        $cust['Email'] = $items[$k]['SmtpAddr'] ? $items[$k]['SmtpAddr'] : '-';
                        $cust['OfficeCode'] = $office['code'] ? $office['code'] : 'SYIT';
                        $cust['OfficeName'] = $office['name'] ? $office['name'] : 'IRON BIRD TRANSPORT JAKARTA';
                        $cust['CreditTerm'] = $items[$k]['Zterm'] ? $items[$k]['Zterm'] : '0';
                        $cust['BillingCurrency'] = $items[$k]['Waers'] ? $items[$k]['Waers'] : 'IDR';
                        $cust['FirstName'] = $items[$k]['CpNameFirst'] ? $items[$k]['CpNameFirst'] : '-';
                        $cust['LastName'] = $items[$k]['CpNameLast'] ? $items[$k]['CpNameLast'] : '-';

                        $data_sap = $this->bp_postven->_scm_xml($cust, $code_sap);

                        $Return = json_encode($data_sap, true);
                        if ($data_sap !== false) {
                            if ($data_sap['ResponseDetail']['Status'] == 'Fail') {
                                $JMessages = $data_sap['ResponseDetail']['ErrorDescription'];
                                $rows = $this->db->get_where('tb_interfaces', ['code' => $cust['Code']])->num_rows();
                                if ($rows > 0) {
                                    $this->midware_model->update_tb_interface2($cust['Code'], $JMessages);
                                } else {
                                    $this->midware_model->insert_tb_interface($cust['Code'], $JMessages, $Return, $backend_text, $type, $modes);
                                }
                            } else {
                                $this->db->delete('tb_interfaces', array('code' => $cust['Code']));
                            }
                        } else {
                            $rows = $this->db->get_where('tb_interfaces', ['code' => $cust['Code']])->num_rows();
                            if ($rows > 0) {
                                $this->midware_model->update_tb_interface2($cust['Code'], 'Bad response from SCM API');
                            } else {
                                $this->midware_model->insert_tb_interface($cust['Code'], 'Bad response from SCM API', $frontend_text, $backend_text, $type, $modes);
                            }
                        }
                    }
                } else {
                    $office = $this->midware_model->get_office_code($items['Ekorg'], $items['Bukrs']);

                    $cust['Code'] = $items['Lifnr'];
                    $cust['Name'] = $items['NameOrg1'] . ' ' . $items['NameOrg2'];
                    $cust['AddressLine'] = $items['Stras'] ? $items['Stras'] : '-';
                    $cust['City'] = $items['Ort01'] ? $items['Ort01'] : 'Jakarta';
                    $cust['ZipCode'] = $items['Pstlz'] ? $items['Pstlz'] : '-';
                    $cust['CountryCode'] = $items['Land1'] ? $items['Land1'] : 'ID';
                    $cust['FirstName'] = $items['NameFirst'] ? $items['NameFirst'] : '-';
                    $cust['Number'] = $items['Telf1'] ? $items['Telf1'] : '-';
                    $cust['Email'] = $items['SmtpAddr'] ? $items['SmtpAddr'] : '-';
                    $cust['OfficeCode'] = $office['code'] ? $office['code'] : 'SYIT';
                    $cust['OfficeName'] = $office['name'] ? $office['name'] : 'IRON BIRD TRANSPORT JAKARTA';
                    $cust['CreditTerm'] = $items['Zterm'] ? $items['Zterm'] : '0';
                    $cust['BillingCurrency'] = $items['Waers'] ? $items['Waers'] : 'IDR';
                    $cust['FirstName'] = $items['CpNameFirst'] ? $items['CpNameFirst'] : '-';
                    $cust['LastName'] = $items['CpNameLast'] ? $items['CpNameLast'] : '-';

                    $data_sap = $this->bp_postven->_scm_xml($cust, $code_sap);

                    $Return = json_encode($data_sap, true);
                    if ($data_sap !== false) {
                        if ($data_sap['ResponseDetail']['Status'] == 'Fail') {
                            $JMessages = $data_sap['ResponseDetail']['ErrorDescription'];

                            $rows = $this->db->get_where('tb_interfaces', ['code' => $cust['Code']])->num_rows();
                            if ($rows > 0) {
                                $this->midware_model->update_tb_interface2($cust['Code'], $JMessages);
                            } else {
                                $this->midware_model->insert_tb_interface($cust['Code'], $JMessages, $Return, $backend_text, $type, $modes);
                            }
                        } else {
                            $this->db->delete('tb_interfaces', array('code' => $cust['Code']));
                        }
                    } else {
                        $rows = $this->db->get_where('tb_interfaces', ['code' => $cust['Code']])->num_rows();
                        if ($rows > 0) {
                            $this->midware_model->update_tb_interface2($cust['Code'], 'Bad response from SCM API');
                        } else {
                            $this->midware_model->insert_tb_interface($cust['Code'], 'Bad response from SCM API', $frontend_text, $backend_text, $type, $modes);
                        }
                    }
                }
                //print_r($data_sap);
                echo "Data has been syncronized";
            } else {
                echo "Data not found";
            }
        }
    }
}
