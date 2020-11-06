<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');


use Restserver\Libraries\REST_Controller;

class Sddocpostcr extends REST_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('template/sd_postcr');
    }

    public function index_post()
    {
        $data   = $this->post();
        $code = $data['Debtors']['DebtorCreditInfo']['AccountCode'];
        $jwt = $this->input->get_request_header('Authorization');
        try {
            $result = $this->keys_controller->_check_keys($jwt);
            if ($result) {
                $this->_post_sap();
            }
        } catch (Exception $e) {
            $this->response(array(
                'Response' => array(
                    'Message' => 'Access denied',
                    'RefId' => $code,
                    'Status' => 'E'
                ), 400
            ));
        }
    }

    private function _post_sap()
    {

        $data   = $this->post();
        $code = $data['Debtors']['DebtorCreditInfo']['AccountCode'];

        $params = $this->sd_postcr->_array_sap($code);

        #Call Operation (Function). Catch and display any errors
        $wsdl = 'http://PBBs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/yfi_cust_open_items/320/yser_cust_open_items/ybin_cust_open_items?sap-client=320';
        $function = 'YfwsCustOpenItems';
        $username = 'HR-ABAP01';
        $password = '123456789';
        $result = $this->wsdl_controller->_sap_wsdl($wsdl, $function, $username, $password, $params);

        if ($result['status'] == 'E') {

            $Response = array(
                'Message' => $result['message'],
                'RefId' => $code,
                'Status' => 'E'
            );

            print_r($this->sd_postcr->arrayToXml($Response));
        } else {
            $data_sap = array(
                'Office' => $data['Debtors']['DebtorCreditInfo']['Office'],
                'SCMProFitDebtorCode' => $data['Debtors']['DebtorCreditInfo']['SCMProFitDebtorCode'],
                'AccountCode' => $data['Debtors']['DebtorCreditInfo']['AccountCode'],
                'AmountOutstanding' => $result['message']['Total'],
                'AmountOutstandingCurrency' => $data['Debtors']['DebtorCreditInfo']['AmountOutstandingCurrency'],
                'IsInvoiceDue' => $data['Debtors']['DebtorCreditInfo']['IsInvoiceDue'],
                'HoldStatus' => $data['Debtors']['DebtorCreditInfo']['HoldStatus']
            );

            $xml_data = $this->sd_postcr->_array_map($data, $data_sap);

            print_r($xml_data);
        }
    }
}
