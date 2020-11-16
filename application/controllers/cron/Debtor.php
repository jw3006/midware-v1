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
        $this->load->model('interface_model');
        $this->load->model('midware_model');
    }

    public function index()
    {
        $this->_sap_wsdl();
    }

    private function _sap_wsdl()
    {
        $output = array('Kunnr' => '');
        $item = array('item' => $output);

        $params = array(
            'DateFr'    => date('Y-m-d'),
            'DateTo'    => date('Y-m-d'),
            'YfiCustomer' => $item
        );

        $code_sap = '';

        #Call Operation (Function). Catch and display any errors
        $wsdl = 'http://pbbs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/yficustomer_4/320/yser_customer_4/ybin_customer_4?sap-client=320';
        $function = 'YfwsCustomer2';
        $username = 'HR-ABAP01';
        $password = '123456789';
        $result = $this->wsdl_controller->_sap_wsdl($wsdl, $function, $username, $password, $params);

        if ($result['status'] == 'E') {
            print_r($result);
        } else {
            $items = $result['message']['YfiCustomer']['item'];
            if ($items[1]) {
                foreach ($items as $k => $v) {
                    $cust['Code'] = $items[$k]['Kunnr'];
                    $cust['Name'] = $items[$k]['NameOrg1'] . ' ' . $items[$k]['NameOrg2'];
                    $cust['AddressLine'] = $items[$k]['Stras'] ? $items[$k]['Stras'] : '-';
                    $cust['City'] = $items[$k]['Ort01'] ? $items[$k]['Ort01'] : 'Jakarta';
                    $cust['ZipCode'] = $items[$k]['Pstlz'] ? $items[$k]['Pstlz'] : '-';
                    $cust['CountryCode'] = $items[$k]['Land1'] ? $items[$k]['Land1'] : 'ID';
                    $cust['Number'] = $items[$k]['Telfx'] ? $items[$k]['Telfx'] : '-';
                    $cust['Email'] = $items[$k]['SmtpAddr'] ? $items[$k]['SmtpAddr'] : '-';
                    $cust['OfficeCode'] = $items[$k]['Vkbur'] ? $items[$k]['Vkbur'] : 'CKIB';  //CKIB is default for testing
                    $cust['OfficeName'] = $items[$k]['VkburName'] ? $items[$k]['VkburName'] : 'Iron Bird Jakarta'; //Iron Bird Jakarta is default for testing
                    $cust['CreditTerm'] = $items[$k]['Zterm'] ? $items[$k]['Zterm'] : '0';
                    $cust['BillingCurrency'] = $items[$k]['Waers'] ? $items[$k]['Waers'] : 'IDR';
                    $cust['FirstName'] = $items[$k]['CpNameFirst'] ? $items[$k]['CpNameFirst'] : '-';
                    $cust['LastName'] = $items[$k]['CpNameLast'] ? $items[$k]['CpNameLast'] : '-';

                    $data_sap[] = $this->bp_postcus->_scm_xml($cust, $code_sap);
                }
            } else {
                $cust['Code'] = $items['Kunnr'];
                $cust['Name'] = $items['NameOrg1'] . ' ' . $items['NameOrg2'];
                $cust['AddressLine'] = $items['Stras'] ? $items['Stras'] : '-';
                $cust['City'] = $items['Ort01'] ? $items['Ort01'] : 'Jakarta';
                $cust['ZipCode'] = $items['Pstlz'] ? $items['Pstlz'] : '-';
                $cust['CountryCode'] = $items['Land1'] ? $items['Land1'] : 'ID';
                $cust['Number'] = $items['Telfx'] ? $items['Telfx'] : '-';
                $cust['Email'] = $items['SmtpAddr'] ? $items['SmtpAddr'] : '-';
                $cust['OfficeCode'] = $items['Vkbur'] ? $items['Vkbur'] : 'CKIB';  //CKIB is default for testing
                $cust['OfficeName'] = $items['VkburName'] ? $items['VkburName'] : 'Iron Bird Jakarta'; //Iron Bird Jakarta is default for testing
                $cust['CreditTerm'] = $items['Zterm'] ? $items['Zterm'] : '0';
                $cust['BillingCurrency'] = $items['Waers'] ? $items['Waers'] : 'IDR';
                $cust['FirstName'] = $items['CpNameFirst'] ? $item['CpNameFirst'] : '-';
                $cust['LastName'] = $items['CpNameLast'] ? $items['CpNameLast'] : '-';

                $data_sap = $this->bp_postcus->_scm_xml($cust, $code_sap);
            }
            print_r($data_sap);
        }
    }
}
