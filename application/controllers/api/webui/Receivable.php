<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class Receivable extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('wsdl_controller');
        $this->load->library('keys_controller');
        $this->load->model('interface_model');
        $this->load->model('midware_model');
    }

    public function _get_auth()
    {
        $keys = $this->input->get_request_header('Authorization');
        $result = $this->keys_controller->_check_auth($keys);
        return $result;
    }

    public function index_get()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $id = $this->get('id');
            if ($id == '') {
                $data = $this->interface_model->get_ar();
                $notif = $this->interface_model->get_notif();
            } else {
                $this->db->where('id', $id);
                $data = $this->interface_model->get_ar();
                $notif = $this->interface_model->get_notif();
            }

            $this->response([
                'status' => true,
                'message' => 'The receivable data has been generated.',
                'data' => $data,
                'notif' => $notif
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => 'fail',
                'message' => 'Authorization has been denied for this request.',
                'data' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function repost_put()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $id = $this->put('code');
            $data_json      = $this->midware_model->get_json($id);
            $code           = $data_json['code'];
            $type           = 'receivable';
            $params         = json_decode($data_json['backend_text'], true);
            print_r($code);
            #Call Operation (Function). Catch and display any errors
            $wsdl = 'http://PBBs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/zifi_post_fitrx_rfc_2/320/zifi_post_fitrx_rfc_2/zifi_post_fitrx_rfc_2?sap-client=320';
            $function = 'ZifiPostFitrxRfc2';
            $username = 'HR-ABAP01';
            $password = '123456789';
            $result = $this->wsdl_controller->_sap_wsdl($wsdl, $function, $username, $password, $params);

            if ($result['status'] == 'E') {
                $this->midware_model->update_tb_interface($id, $result['message']);
                $this->response([
                    'status' => 'fail',
                    'message' => 'Oops, Something went wrong!',
                    'data' => $result['message']
                ], REST_Controller::HTTP_NOT_FOUND);
            } else {
                $Code     = $result['message']['Belnr'];

                if ($Code) {
                    $Return     = $result['message']['Return']['item']['Message'];
                    $this->midware_model->insert_tb_success($code, $Return, $type);
                    $this->db->delete('tb_interfaces', array("code" => $Code));
                    //$this->_get_sap($ar); //method to post credit limit
                    $this->_post_db(json_decode($data_json['frontend_text'], true), $Code); // Insert to tb_invoice
                    $this->response([
                        'status' => true,
                        'message' => 'The receivable data has been reposted.',
                        'data' => $id
                    ], REST_Controller::HTTP_OK);
                } else {
                    $Return     = $result['message']['Return']['item'];

                    foreach ($Return as $r => $b) {
                        $message[] = $Return[$r]['Message'];
                    }
                    $JMessages = json_encode($message, true);
                    $this->midware_model->update_tb_interface($id, $JMessages);
                    $this->response([
                        'status' => 'fail',
                        'message' => 'Oops, Something went wrong!',
                        'data' => $code
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        } else {
            $this->response([
                'status' => 'fail',
                'message' => 'Authorization has been denied for this request.',
                'data' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $code = $this->delete('code');
            $result = $this->midware_model->delete($code);
            if ($result) {
                $this->response([
                    'status' => 'success',
                    'message' => 'The receivable data has been deleted.',
                    'data' => $code
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => 'fail',
                    'message' => 'Oops, Something went wrong!',
                    'data' => $code
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response([
                'status' => 'fail',
                'message' => 'Authorization has been denied for this request.',
                'data' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
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
            'created_by'    => $this->session->userdata('username'),
        );
        $this->form_validation->set_data($detail);
        $this->form_validation->set_rules('code', 'Invoice No', 'is_unique[tb_invoice.code]');
        if ($this->form_validation->run() == true) {
            $this->db->insert('tb_invoice', $detail);
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
                    'Status' => 'E'
                ), 500
            ));
        } else {
            $xml = $this->sd_postcr->_scm_xml($code, $acc_code, $result['message']['Total']);
            print_r($xml);
        }
    }
}
