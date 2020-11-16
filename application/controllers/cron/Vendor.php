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
        $this->load->model('interface_model');
        $this->load->model('midware_model');
    }

    public function index()
    {
        $this->_sap_wsdl();
    }

    private function _sap_wsdl()
    {
        $output = array('Lifnr' => '');
        $item = array('item' => $output);

        $params = array(
            'DateFr'    => date('Y-m-d'),
            'DateTo'    => date('Y-m-d'),
            'YfiVendor' => $item
        );

        $code_sap = '';

        #Call Operation (Function). Catch and display any errors
        $wsdl = 'http://pbbs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/yfi_vendor_4/320/yser_vendor_4/ybin_vendor_4?sap-client=320';
        $function = 'YfwsVendor2';
        $username = 'HR-ABAP01';
        $password = '123456789';
        $result = $this->wsdl_controller->_sap_wsdl($wsdl, $function, $username, $password, $params);

        if ($result['status'] == 'E') {
            print_r($result);
        } else {
            $items = $result['message']['YfiVendor']['item'];
            if ($items[0]) {
                foreach ($items as $k => $v) {
                    $cust['Code'] = $items[$k]['Lifnr'];
                    $cust['Name'] = $items[$k]['NameOrg1'] . ' ' . $items[$k]['NameOrg2'];
                    $cust['AddressLine'] = $items[$k]['Stras'] ? $items[$k]['Stras'] : '-';
                    $cust['City'] = $items[$k]['Ort01'] ? $items[$k]['Ort01'] : 'Jakarta';
                    $cust['ZipCode'] = $items[$k]['Pstlz'] ? $items[$k]['Pstlz'] : '-';
                    $cust['CountryCode'] = $items[$k]['Land1'] ? $items[$k]['Land1'] : 'ID';
                    $cust['FirstName'] = $items[$k]['NameFirst'] ? $items[$k]['NameFirst'] : '-';
                    $cust['Number'] = $items[$k]['Telf1'] ? $items[$k]['Telf1'] : '-';
                    $cust['Email'] = $items[$k]['SmtpAddr'] ? $items[$k]['SmtpAddr'] : '-';
                    $cust['OfficeCode'] = $items[$k]['Ekorg'] ? $items[$k]['Ekorg'] : 'CKIB';  //CKIB is default for testing
                    $cust['OfficeName'] = $items[$k]['EkorgName1'] ? $items[$k]['EkorgName1'] : 'Iron Bird Jakarta'; //Iron Bird Jakarta is default for testing
                    $cust['CreditTerm'] = $items[$k]['Zterm'] ? $items[$k]['Zterm'] : '0';
                    $cust['BillingCurrency'] = $items[$k]['Waers'] ? $items[$k]['Waers'] : 'IDR';
                    $cust['FirstName'] = $items[$k]['CpNameFirst'] ? $items[$k]['CpNameFirst'] : '-';
                    $cust['LastName'] = $items[$k]['CpNameLast'] ? $items[$k]['CpNameLast'] : '-';

                    $data_sap[] = $this->bp_postven->_scm_xml($cust, $code_sap);
                }
            } else {
                $cust['Code'] = $items['Lifnr'];
                $cust['Name'] = $items['NameOrg1'] . ' ' . $items['NameOrg2'];
                $cust['AddressLine'] = $items['Stras'] ? $items['Stras'] : '-';
                $cust['City'] = $items['Ort01'] ? $items['Ort01'] : 'Jakarta';
                $cust['ZipCode'] = $items['Pstlz'] ? $items['Pstlz'] : '-';
                $cust['CountryCode'] = $items['Land1'] ? $items['Land1'] : 'ID';
                $cust['FirstName'] = $items['NameFirst'] ? $items['NameFirst'] : '-';
                $cust['Number'] = $items['Telf1'] ? $items['Telf1'] : '-';
                $cust['Email'] = $items['SmtpAddr'] ? $items['SmtpAddr'] : '-';
                $cust['OfficeCode'] = $items['Ekorg'] ? $items['Ekorg'] : 'CKIB';  //CKIB is default for testing
                $cust['OfficeName'] = $items['EkorgName1'] ? $items['EkorgName1'] : 'Iron Bird Jakarta'; //Iron Bird Jakarta is default for testing
                $cust['CreditTerm'] = $items['Zterm'] ? $items['Zterm'] : '0';
                $cust['BillingCurrency'] = $items['Waers'] ? $items['Waers'] : 'IDR';
                $cust['FirstName'] = $items['CpNameFirst'] ? $items['CpNameFirst'] : '-';
                $cust['LastName'] = $items['CpNameLast'] ? $items['CpNameLast'] : '-';

                $data_sap = $this->bp_postven->_scm_xml($cust, $code_sap);
            }
            print_r($data_sap);
        }
    }
}
