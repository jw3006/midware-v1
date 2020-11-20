<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Debtor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('wsdl_controller');
        $this->load->library('keys_controller');
        $this->load->library('template/bp_postcus');
        $this->load->model('midware_model');
    }

    public function sapwsdl()
    {
        $modes = 'SCM_BPPOST';
        $type = 'customer';

        $output = array('Kunnr' => '');
        $item = array('item' => $output);

        $params = array(
            'DateFr'    => date('Y-m-d'),
            'DateTo'    => date('Y-m-d'),
            'YfiCustomer' => $item
        );

        $code_sap = '';
        $backend_text   = json_encode($params, true);
        $frontend_text = json_encode($params, true);

        #Call Operation (Function). Catch and display any errors
        $wsdl = 'http://pbbs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/yficustomer_4/320/yser_customer_4/ybin_customer_4?sap-client=320';
        $function = 'YfwsCustomer2';
        $username = 'HR-ABAP01';
        $password = '123456789';
        $result = $this->wsdl_controller->_sap_wsdl($wsdl, $function, $username, $password, $params);

        if ($result['status'] == 'E') {
            print_r($result);
        } else {
            if ($result['message']['Return'] !== 'Data tdk ditemukan') {
                $items = $result['message']['YfiCustomer']['item'];
                if ($items[1]) {
                    foreach ($items as $k => $v) {
                        $office = $this->midware_model->get_office_code($items[$k]['Vkbur'], $items[$k]['Vkorg']);

                        $cust['Code'] = $items[$k]['Kunnr'];
                        $cust['Name'] = $items[$k]['NameOrg1'] . ' ' . $items[$k]['NameOrg2'];
                        $cust['AddressLine'] = $items[$k]['Stras'] ? $items[$k]['Stras'] : '-';
                        $cust['City'] = $items[$k]['Ort01'] ? $items[$k]['Ort01'] : 'Jakarta';
                        $cust['ZipCode'] = $items[$k]['Pstlz'] ? $items[$k]['Pstlz'] : '-';
                        $cust['CountryCode'] = $items[$k]['Land1'] ? $items[$k]['Land1'] : 'ID';
                        $cust['Number'] = $items[$k]['Telfx'] ? $items[$k]['Telfx'] : '-';
                        $cust['Email'] = $items[$k]['SmtpAddr'] ? $items[$k]['SmtpAddr'] : '-';
                        $cust['OfficeCode'] = $office['code'] ? $office['code'] : 'SYIT';
                        $cust['OfficeName'] = $office['name'] ? $office['name'] : 'IRON BIRD TRANSPORT JAKARTA';
                        $cust['CreditTerm'] = $items[$k]['Zterm'] ? $items[$k]['Zterm'] : '0';
                        $cust['BillingCurrency'] = $items[$k]['Waers'] ? $items[$k]['Waers'] : 'IDR';
                        $cust['FirstName'] = $items[$k]['CpNameFirst'] ? $items[$k]['CpNameFirst'] : '-';
                        $cust['LastName'] = $items[$k]['CpNameLast'] ? $items[$k]['CpNameLast'] : '-';

                        $custs['code'] = $items[$k]['Kunnr'];
                        $custs['name'] = $items[$k]['NameOrg1'] . ' ' . $items[$k]['NameOrg2'];
                        $custs['address'] = $items[$k]['Stras'] ? $items[$k]['Stras'] : '-';
                        $custs['city'] = $items[$k]['Ort01'] ? $items[$k]['Ort01'] : 'Jakarta';
                        $custs['zip_code'] = $items[$k]['Pstlz'] ? $items[$k]['Pstlz'] : '-';
                        $custs['country_code'] = $items[$k]['Land1'] ? $items[$k]['Land1'] : 'ID';
                        $custs['phone'] = $items[$k]['Telfx'] ? $items[$k]['Telfx'] : '-';
                        $custs['email'] = $items[$k]['SmtpAddr'] ? $items[$k]['SmtpAddr'] : '-';
                        $custs['npwp'] = $items[$k]['Stcd1'] ? $items[$k]['Stcd1'] : '-';
                        $custs['office_code'] = $office['code'] ? $office['code'] : 'SYIT';
                        $custs['credit_term'] = $items[$k]['Zterm'] ? $items[$k]['Zterm'] : '0';
                        $custs['currency'] = $items[$k]['Waers'] ? $items[$k]['Waers'] : 'IDR';
                        $custs['contact_person'] = $items[$k]['CpNameFirst'] ? $items[$k]['CpNameFirst'] . ' ' . $items[$k]['CpNameLast'] : '-';
                        $custs['created'] = date('Y-m-d H:i:s');
                        $custs['created_by'] = 'bp_postcus';
                        $cust_array = $custs;

                        $data_sap = $this->bp_postcus->_scm_xml($cust, $code_sap);

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
                                $this->midware_model->insert_tb_debtor($cust['Code'], $cust_array);
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
                    $office = $this->midware_model->get_office_code($items['Vkbur'], $items['Vkorg']);

                    $cust['Code'] = $items['Kunnr'];
                    $cust['Name'] = $items['NameOrg1'] . ' ' . $items['NameOrg2'];
                    $cust['AddressLine'] = $items['Stras'] ? $items['Stras'] : '-';
                    $cust['City'] = $items['Ort01'] ? $items['Ort01'] : 'Jakarta';
                    $cust['ZipCode'] = $items['Pstlz'] ? $items['Pstlz'] : '-';
                    $cust['CountryCode'] = $items['Land1'] ? $items['Land1'] : 'ID';
                    $cust['Number'] = $items['Telfx'] ? $items['Telfx'] : '-';
                    $cust['Email'] = $items['SmtpAddr'] ? $items['SmtpAddr'] : '-';
                    $cust['OfficeCode'] = $office['code'] ? $office['code'] : 'SYIT';
                    $cust['OfficeName'] = $office['name'] ? $office['name'] : 'IRON BIRD TRANSPORT JAKARTA';
                    $cust['CreditTerm'] = $items['Zterm'] ? $items['Zterm'] : '0';
                    $cust['BillingCurrency'] = $items['Waers'] ? $items['Waers'] : 'IDR';
                    $cust['FirstName'] = $items['CpNameFirst'] ? $item['CpNameFirst'] : '-';
                    $cust['LastName'] = $items['CpNameLast'] ? $items['CpNameLast'] : '-';

                    $custs['code'] = $items['Kunnr'];
                    $custs['name'] = $items['NameOrg1'] . ' ' . $items['NameOrg2'];
                    $custs['address'] = $items['Stras'] ? $items['Stras'] : '-';
                    $custs['city'] = $items['Ort01'] ? $items['Ort01'] : 'Jakarta';
                    $custs['zip_code'] = $items['Pstlz'] ? $items['Pstlz'] : '-';
                    $custs['country_code'] = $items['Land1'] ? $items['Land1'] : 'ID';
                    $custs['phone'] = $items['Telfx'] ? $items['Telfx'] : '-';
                    $custs['email'] = $items['SmtpAddr'] ? $items['SmtpAddr'] : '-';
                    $custs['npwp'] = $items['Stcd1'] ? $items['Stcd1'] : '-';
                    $custs['office_code'] = $office['code'] ? $office['code'] : 'SYIT';
                    $custs['credit_term'] = $items['Zterm'] ? $items['Zterm'] : '0';
                    $custs['currency'] = $items['Waers'] ? $items['Waers'] : 'IDR';
                    $custs['contact_person'] = $items['CpNameFirst'] ? $items['CpNameFirst'] . ' ' . $items['CpNameLast'] : '-';
                    $custs['created'] = date('Y-m-d H:i:s');
                    $custs['created_by'] = 'bp_postcus';
                    $cust_array = $custs;

                    $data_sap = $this->bp_postcus->_scm_xml($cust, $code_sap);

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
                            $this->midware_model->insert_tb_debtor($cust['Code'], $cust_array);
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
