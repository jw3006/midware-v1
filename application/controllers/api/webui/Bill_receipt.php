<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class Bill_receipt extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('receipt_model');
        $this->load->library('keys_controller');
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
                $data = $this->receipt_model->get_all();
                $office_code = $this->receipt_model->get_office_code();
                $debtor_code = $this->receipt_model->get_debtor_code();
                $notif = $this->receipt_model->get_notif();
            } else {
                $this->db->where('id', $id);
                $data = $this->receipt_model->get_all();
                $office_code = $this->receipt_model->get_office_code();
                $debtor_code = $this->receipt_model->get_debtor_code();
                $notif = $this->receipt_model->get_notif();
            }

            $this->response([
                'status' => true,
                'message' => 'The invoice receipt data has been generated.',
                'data' => $data,
                'notif' => $notif,
                'oc' => $office_code,
                'debtor' => $debtor_code
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => 'fail',
                'message' => 'Authorization has been denied for this request.',
                'data' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function invoice_get()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $office_code = $this->get('office_code');
            $debtor_code = $this->get('debtor_code');

            $data = $this->receipt_model->get_invoice($office_code, $debtor_code);
            $company_code = $this->receipt_model->get_company_code($office_code);
            $office_code = $this->receipt_model->get_office_code();
            $debtor_code = $this->receipt_model->get_debtor_code();
            $notif = $this->receipt_model->get_notif();

            $this->response([
                'status' => true,
                'message' => 'The invoice data has been generated.',
                'data' => $data,
                'notif' => $notif,
                'comc' => $company_code,
                'oc' => $office_code,
                'debtor' => $debtor_code
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => 'fail',
                'message' => 'Authorization has been denied for this request.',
                'data' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function edit_get()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $code = $this->get('code');

            $header = $this->receipt_model->get_bill_header($code);
            $detail = $this->receipt_model->get_bill_detail($code);
            $office_code = $this->receipt_model->get_office_code();
            $debtor_code = $this->receipt_model->get_debtor_code();
            $notif = $this->receipt_model->get_notif();

            $data = array(
                'header' => $header,
                'detail' => $detail
            );

            $this->response([
                'status' => true,
                'message' => 'The invoice receipt data has been generated.',
                'data' => $data,
                'notif' => $notif,
                'oc' => $office_code,
                'debtor' => $debtor_code
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => 'fail',
                'message' => 'Authorization has been denied for this request.',
                'data' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function print_get()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $code = $this->get('code');

            $header = $this->receipt_model->get_print_header($code);
            $detail = $this->receipt_model->get_print_detail($code);
            $office_code = $this->receipt_model->get_office_code();
            $debtor_code = $this->receipt_model->get_debtor_code();
            $notif = $this->receipt_model->get_notif();

            $data = array(
                'header' => $header,
                'detail' => $detail
            );

            $this->response([
                'status' => true,
                'message' => 'The invoice receipt data has been generated.',
                'data' => $data,
                'notif' => $notif,
                'oc' => $office_code,
                'debtor' => $debtor_code
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => 'fail',
                'message' => 'Authorization has been denied for this request.',
                'data' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_post()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $data = $this->post();
            $doc_code = $this->receipt_model->get_pattern($data['Header']['office_code']);
            /* Generate Due Date */
            $date = date_create(date('Y-m-d'));
            date_add($date, date_interval_create_from_date_string($data['Header']['credit_term'] . ' days'));
            $due_date =  date_format($date, 'Y-m-d');


            $header = array(
                'code'          => $doc_code,
                'doc_date'      => date('Y-m-d'),
                'due_date'      => $due_date,
                'inv_year'      => $data['Header']['inv_year'],
                'company_code'  => $data['Header']['company_code'],
                'office_code'   => $data['Header']['office_code'],
                'debtor_code'   => $data['Header']['debtor_code'],
                'terms'         => $data['Header']['credit_term'],
                'remarks'       => $data['Header']['remarks'],
                'status'        => 'New',
                'created'       => date('Y-m-d H:i:s'),
                'created_by'    => $data['Header']['created_by']
            );

            $details = $data['Details'];
            foreach ($details as $k => $v) {
                $detail[] = [
                    'id'   => uniqid(),
                    'detail_id'     => $details[$k]['row_id'],
                    'code'          => $doc_code,
                    'inv_no'        => $details[$k]['inv_code'],
                    'inv_date'      => $details[$k]['inv_date'],
                    'currency'      => $details[$k]['currency'],
                    'amount'        => $details[$k]['amount'],
                    'tax_amount'    => $details[$k]['tax_amount'],
                    'sap_reference' => $details[$k]['sap_reference'],
                    'booking_code'  => $details[$k]['booking_code'],
                    'job_number'    => $details[$k]['job_number'],
                    'job_ref'       => $details[$k]['job_ref']
                ];
            }

            $insert = $this->db->insert('tb_app_receipt', $header);
            if ($insert) {
                $insertd = $this->db->insert_batch('tb_app_receipt_items', $detail);
                if ($insertd) {
                    foreach ($details as $k => $v) {
                        $this->db->where('id', $details[$k]['row_id'])
                            ->update('tb_invoice', ['receipt_code' => $doc_code, 'receipt_flag' => '1']);
                    }
                    $this->response([
                        'status' => 'success',
                        'message' => 'The invoice receipt has been generated.',
                        'data' => $doc_code
                    ], REST_Controller::HTTP_OK);
                } else {
                    //$this->db->delete('tb_app_receipt', array('code' => $doc_code));
                    $this->response([
                        'status'    => 'fail',
                        'message'   => 'Oops, Something went wrong!',
                        'data'      => $doc_code
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => 'fail',
                    'message' => 'Oops, Something went wrong!',
                    'data' => $doc_code
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

    public function index_put()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $data = $this->put();
            $data_put = array(
                'doc_date'      => $data['doc_date'],
                'due_date'      => $data['due_date'],
                'contact_person'      => $data['contact_person'],
                'remarks'       => $data['remarks'],
                'modified'       => date('Y-m-d H:i:s'),
                'modified_by'    => $data['created_by']
            );

            $update = $this->db->where('code', $data['code'])
                ->update('tb_app_receipt', $data_put);
            if ($update) {
                $this->response([
                    'status' => true,
                    'message' => 'The invoice receipt data has been updated.',
                    'data' => $data['code']
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => 'fail',
                    'message' => 'Oops, Something went wrong!',
                    'data' => $data['code']
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

    public function status_put()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $data = $this->put();
            if ($data['type'] == 'sender') {
                $data_put = array(
                    'sender_name'   => $data['sender_name'],
                    'sender_date'   => $data['sender_date'],
                    'status'        => 'Submitted',
                    'modified'      => date('Y-m-d H:i:s'),
                    'modified_by'   => $data['created_by']
                );
            } else {
                $date = $data['receiver_date'];
                date_add($date, date_interval_create_from_date_string('30 days'));
                $due_date =  date_format($date, 'Y-m-d');
                $data_put = array(
                    'due_date'      => $due_date,
                    'receiver_name' => $data['receiver_name'],
                    'receiver_date' => $data['receiver_date'],
                    'status'        => 'Completed',
                    'modified'      => date('Y-m-d H:i:s'),
                    'modified_by'   => $data['created_by']
                );
            }

            $update = $this->db->where('code', $data['code'])
                ->update('tb_app_receipt', $data_put);
            if ($update) {
                $this->response([
                    'status' => true,
                    'message' => 'The invoice receipt data has been updated.',
                    'data' => $data['code']
                ], REST_Controller::HTTP_OK);
                if ($data['type'] == 'received') {
                    /* Update Baseline Date SAP */
                    $detail = $this->db->get_where('tb_app_receipt_items', ['code' => $data['code']])->result();
                    $details = json_decode(json_encode($detail), true);
                    $this->_post_sap($details, $data['receiver_date']);
                }
            } else {
                $this->response([
                    'status' => 'fail',
                    'message' => 'Oops, Something went wrong!',
                    'data' => $data['code']
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

    public function index_delete()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $code = $this->delete('code');
            $status = $this->delete('status');
            if ($status == 'New') {
                $delete =  $this->db->delete('tb_app_receipt', array('code' => $code));
                if ($delete) {
                    $this->db->delete('tb_app_receipt_items', array('code' => $code));
                    $this->db->where('receipt_code', $code)
                        ->update('tb_invoice', ['receipt_code' => '', 'receipt_flag' => '']);
                    $this->response([
                        'status' => true,
                        'message' => 'The invoice receipt has been deleted.',
                        'data' => $code
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => 'fail',
                        'message' => 'Oops, Something went wrong!',
                        'data' => ''
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => 'fail',
                    'message' => 'Oops, This invoice receipt can not be deleted!',
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

    public function del_items_post()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $code = $this->post('code');
            $status = $this->post('status');
            $detail_id = $this->post('detail_id');
            if ($status == 'New') {
                $delete =  $this->db->delete('tb_app_receipt_items', array('id' => $code));
                if ($delete) {
                    $this->db->where('id', $detail_id)
                        ->update('tb_invoice', ['receipt_code' => '', 'receipt_flag' => '']);
                    $this->response([
                        'status' => true,
                        'message' => 'The invoice receipt has been deleted.',
                        'data' => $status
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => 'fail',
                        'message' => 'Oops, Something went wrong!',
                        'data' => ''
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => 'fail',
                    'message' => 'Oops, This invoice receipt can not be deleted!',
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

    public function bill_report_get()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $dt['office_code'] = $this->get('office_code');
            $dt['debtor'] = $this->get('debtor');
            $dt['invoice_no'] = $this->get('invoice_no');
            $dt['receipt_no'] = $this->get('receipt_no');
            $dt['start_date'] = $this->get('start_date');
            $dt['end_date'] = $this->get('end_date');
            $dt['start_rc_date'] = $this->get('start_rc_date');
            $dt['end_rc_date'] = $this->get('end_rc_date');

            $data = $this->receipt_model->get_bill_all($dt);
            $office_code = $this->receipt_model->get_bill_oc();
            $debtor_code = $this->receipt_model->get_bill_debtor();
            $receipt_code = $this->receipt_model->get_bill_rc();
            $notif = $this->receipt_model->get_notif();

            $this->response([
                'status' => true,
                'message' => 'The invoice receipt data has been generated.',
                'data' => $data,
                'notif' => $notif,
                'oc' => $office_code,
                'debtor' => $debtor_code,
                'rc' => $receipt_code
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => 'fail',
                'message' => 'Authorization has been denied for this request.',
                'data' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    private function _post_sap($detail, $Zfbdt)
    {
        foreach ($detail as $k => $v) {
            $this->db->select('inv_year, company_code');
            $oc = $this->db->get_where('tb_app_receipt', ['code' => $detail[$k]['code']])->row_array();

            $params = array(
                'Belnr' => $detail[$k]['sap_reference'],
                'Bukrs' => $oc['company_code'],
                'Buzei' => '1',
                'Gjahr' => $oc['inv_year'],
                'Zfbdt' => $Zfbdt
            );

            #Call Operation (Function). Catch and display any errors
            $wsdl = 'http://PBBs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/yfi_update_cust_bldate/320/yser_update_cust_bldate/ybin_update_cust_bldate?sap-client=320';
            $function = 'YfwsUpdateCustBldate';
            $username = 'HR-ABAP01';
            $password = '123456789';
            $result = $this->wsdl_controller->_sap_wsdl($wsdl, $function, $username, $password, $params);
        }
        return $params;
    }
}
