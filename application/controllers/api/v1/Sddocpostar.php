<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');


use Restserver\Libraries\REST_Controller;

class Sddocpostar extends REST_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('wsdl_controller');
        $this->load->model('midware_model');
        $this->load->library('template/sd_postar');
        $this->load->library('template/sd_postcr');
    }

    public function index_post()
    {
        $data   = $this->post();
        $code   = $data['Invoices']['InvoiceInfo']['InvoiceNo'];
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
                    'Status' => 'Fail',
                    'StatusCode' => 401
                )
            ), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    private function _post_sap()
    {
        $type   = 'receivable';
        $mode   = 'SAP_FIPOST';
        $modes  = 'SCM_FIGET';
        $data   = $this->post();

        $check_rows = $data['Invoices']['InvoiceInfo']['Charges']['ChargeInfo'];
        $rows = array_count_values(array_column($check_rows, 'SeqNo'))['2'];
        if ($rows == 1) {
            $params = $this->sd_postar->_array_sap($data);
        } else {
            $params = $this->sd_postar->_array_sap1($data);
        }

        $code   = $data['Invoices']['InvoiceInfo']['InvoiceNo'];
        $frontend_text  = json_encode($data, true);
        $backend_text   = json_encode($params, true);

        $this->form_validation->set_data($params['Fitrxlgc']['item'][0]);
        $this->form_validation->set_rules('Xblnr', 'Invoice No', 'required|max_length[16]|is_unique[tb_success.code]', array(
            'is_unique'     => 'This Document has already syncronized.'
        ));
        $this->form_validation->set_rules('Bktxt', 'Remark', 'required|max_length[25]');
        $this->form_validation->set_rules('Hkont', 'Account Posting Code', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->response(array(
                'Response' => array(
                    'Message' => preg_replace('/<p>(.*?)<\/p>/', '$1', validation_errors()),
                    'RefId' => $code,
                    'Status' => 'Fail',
                    'StatusCode' => 400
                )
            ), REST_Controller::HTTP_BAD_REQUEST);
        } else {

            #Call Operation (Function). Catch and display any errors
            $wsdl = 'http://PBBs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/zifi_post_fitrx_rfc_2/320/zifi_post_fitrx_rfc_2/zifi_post_fitrx_rfc_2?sap-client=320';
            $function = 'ZifiPostFitrxRfc2';
            $username = 'HR-ABAP01';
            $password = '123456789';
            $result = $this->wsdl_controller->_sap_wsdl($wsdl, $function, $username, $password, $params);

            if ($result['status'] == 'E') {
                $this->response(array(
                    'Response' => array(
                        'Message' => $result['message'],
                        'RefId' => $code,
                        'Status' => 'Fail',
                        'StatusCode' => 500
                    )
                ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                $this->midware_model->insert_tb_interface($code, $result['message'], $frontend_text, $backend_text, $type, $mode);
            } else {

                $Code               = $result['message']['Belnr'];
                $ar['kunnr']        = $data['Invoices']['InvoiceInfo']['Debtor']['Code'];
                $ar['account_code'] = $data['Invoices']['InvoiceInfo']['Debtor']['AccountCode'];

                if ($Code) {
                    $Return     = $result['message']['Return']['item']['Message'];
                    $this->response(array(
                        'Response' => array(
                            'Message' => $Return,
                            'RefId' => $code,
                            'Status' => 'Success',
                            'StatusCode' => 200
                        )
                    ), REST_Controller::HTTP_OK);
                    //$this->_get_sap($ar); //method to post credit limit
                    $this->_post_db($data, $Code);  // save to tb_invoice
                    $this->midware_model->insert_tb_success($code, $Return, $type);
                    $this->db->delete('tb_interfaces', array("code" => $code));
                } else {
                    $Return     = $result['message']['Return']['item'];

                    foreach ($Return as $r => $b) {
                        $message[] = $Return[$r]['Message'];
                    }
                    $JMessages = json_encode($message, true);

                    $this->response(array(
                        'Response' => array(
                            'Message' => $message,
                            'RefId' => $code,
                            'Status' => 'Fail',
                            'StatusCode' => 400
                        )
                    ), REST_Controller::HTTP_BAD_REQUEST);
                    $this->midware_model->insert_tb_interface($code, $JMessages, $frontend_text, $backend_text, $type, $mode);
                }
            }
        }
    }

    private function _get_sap($ar)
    {
        $code = $ar['kunnr'];
        $acc_code = $ar['account_code'];
        $params = $this->sd_postcr->_array_sap($code);

        #Call Operation (Function). Catch and display any errors
        $wsdl = 'http://PBBs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/yfi_cust_open_items/320/yser_cust_open_items/ybin_cust_open_items?sap-client=320';
        $function = 'YfwsCustOpenItems';
        $username = 'HR-ABAP01';
        $password = '123456789';
        $result = $this->wsdl_controller->_sap_wsdl($wsdl, $function, $username, $password, $params);

        if ($result['status'] == 'E') {
            $this->response(array(
                'Response' => array(
                    'Message' => $result['message'],
                    'RefId' => $code,
                    'Status' => 'Fail',
                    'StatusCode' => 500
                )
            ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            $xml = $this->sd_postcr->_scm_xml($code, $acc_code, $result['message']['Total']);
            print_r($xml);
        }
    }

    private function _post_db($data, $Code)
    {
        $detail = array(
            'id'            => uniqid(),
            'code'          => $data['Invoices']['InvoiceInfo']['InvoiceNo'],
            'sap_reference' => $Code,
            'inv_date'      => $data['Invoices']['InvoiceInfo']['InvoiceDate'],
            'due_date'      => $data['Invoices']['InvoiceInfo']['InvoiceDueDate'],
            'office_code'   => $data['Invoices']['InvoiceInfo']['Office'],
            'debtor_code'   => $data['Invoices']['InvoiceInfo']['Debtor']['Code'],
            'debtor_name'   => $data['Invoices']['InvoiceInfo']['Debtor']['Name'],
            'booking_code'  => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['BookingNo'],
            'job_number'    => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobNumber'],
            'job_date'      => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['BookingConfirmationDate'],
            'job_type'      => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['JobType'],
            'job_ref'       => $data['Invoices']['InvoiceInfo']['JobSummary']['JobSummaryInfo']['PoNumber'],
            'pay_term'      => $data['Invoices']['InvoiceInfo']['PaymentTerms'],
            'currency'      => $data['Invoices']['InvoiceInfo']['AmountSummary']['BillingInvoiceCurrency'],
            'amount'        => $data['Invoices']['InvoiceInfo']['AmountSummary']['TotalGrossAmount'],
            'tax_amount'    => $data['Invoices']['InvoiceInfo']['AmountSummary']['TotalTaxAmount'],
            'total_amount'  => $data['Invoices']['InvoiceInfo']['AmountSummary']['GrandInvoiceAmount'],
            'created'       => date('Y-m-d H:i:s'),
            'created_by'    => 'sddodpostar',
        );
        $this->form_validation->set_data($detail);
        $this->form_validation->set_rules('code', 'Invoice No', 'is_unique[tb_invoice.code]');
        if ($this->form_validation->run() == true) {
            $this->db->insert('tb_invoice', $detail);
        }
    }
}
