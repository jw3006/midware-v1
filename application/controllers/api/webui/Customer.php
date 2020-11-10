<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class Customer extends REST_Controller
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
                $data = $this->interface_model->get_customer();
                $notif = $this->interface_model->get_notif();
            } else {
                $this->db->where('id', $id);
                $data = $this->interface_model->get_customer();
                $notif = $this->interface_model->get_notif();
            }

            $this->response([
                'status' => 'success',
                'message' => 'The customer data has been generated.',
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

    public function sync_post()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $etype = 'sync_now';
            $code   = $this->input->post('code');

            if (!$code) {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date']   = $this->input->post('end_date');
                $data['code']       = str_replace('-', '', $data['start_date'] . $data['end_date']);
            } else {
                $data['code']   = $this->input->post('code');
                $data['start_date'] = '2020-01-01';
                $data['end_date']   = date('Y-m-d');
            }
            $this->_sap_wsdl($etype, $data);
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
            $etype = 'repost';
            $data_json      = $this->midware_model->get_json($id);
            $data['id']   = $id;
            $data['code']   = $data_json['code'];
            $data['params'] = json_decode($data_json['backend_text'], true);
            $data['frontend_text'] = $data_json['frontend_text'];

            $this->_sap_wsdl($etype, $data);
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
                    'message' => 'The customer data has been deleted.',
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

    private function _sap_wsdl($etype, $data)
    {
        $mode = 'SAP_BPGET';
        $modes = 'SCM_BPPOST';
        $type = 'customer';

        if ($etype == 'repost') {
            $params = $data['params'];
            $code = $data['code'];
            if (substr($data['code'], 0, 1) == 0) {
                $code_sap = $data['code'];
            } else {
                $code_sap = '';
            }

            $id = $data['id'];
        } else {
            $date_from = $data['start_date'];
            $date_to = $data['end_date'];
            if (substr($data['code'], 0, 1) == 0) {
                $code = $data['code'];
                $code_sap = $data['code'];
            } else {
                $code       = str_replace('-', '', $date_from . $date_to);
                $code_sap = '';
            }

            #Setup input parameters (SAP Likes to Capitalise the parameter names)
            $output = array('Kunnr' => '');

            #Setup input parameter (SAP item table array)
            $item = array('item' => $output);

            #Setup input parameter (SAP table array)
            $params = array(
                'DateFr'    => $date_from,
                'DateTo'    => $date_to,
                'YfiCustomer' => $item
            );
        }

        $backend_text   = json_encode($params, true);
        $frontend_text = json_encode($params, true);

        #Call Operation (Function). Catch and display any errors
        $wsdl = 'http://pbbs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/yficustomer_4/320/yser_customer_4/ybin_customer_4?sap-client=320';
        $function = 'YfwsCustomer2';
        $username = 'HR-ABAP01';
        $password = '123456789';
        $result = $this->wsdl_controller->_sap_wsdl($wsdl, $function, $username, $password, $params);

        if ($result['status'] == 'E') {
            $this->midware_model->insert_tb_interface($code, $result['message'], $frontend_text, $backend_text, $type, $mode);
            $this->response([
                'status' => 'fail',
                'message' => 'Oops, Something went wrong!',
                'data' => $result['message']
            ], REST_Controller::HTTP_NOT_FOUND);
        } else {
            if ($etype == 'repost') {
                $data_sap = $this->bp_postcus->_get_result($result, $code_sap);
                $array_cus = $this->bp_postcus->_get_array($result, $code_sap);
            } else {
                $data_sap = $this->bp_postcus->_get_result($result, $code_sap);
                $array_cus = $this->bp_postcus->_get_array($result, $code_sap);
            }
            $Return = json_encode($data_sap, true);

            if ($data_sap !== false) {
                if ($data_sap['ResponseDetail']['Status'] == 'Fail') {
                    $JMessages = $data_sap['ResponseDetail']['ErrorDescription'];
                    if ($etype == 'repost') {
                        $this->midware_model->update_tb_interface($id, $JMessages);
                    } else {
                        $this->midware_model->insert_tb_interface($code, $JMessages, $Return, $backend_text, $type, $modes);
                    }
                    $this->response([
                        'status' => 'fail',
                        'message' => 'Oops, Something went wrong!',
                        'data' => $code
                    ], REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    $this->midware_model->insert_tb_success($code, $Return, $type);
                    $this->db->delete('tb_interfaces', array('code' => $code));
                    $this->response([
                        'status' => 'success',
                        'message' => 'The customer data has been syncronized.',
                        'data' => $code
                    ], REST_Controller::HTTP_OK);
                    $this->midware_model->insert_tb_debtor($code, $array_cus);
                }
            } else {
                if ($etype == 'repost') {
                    $this->midware_model->update_tb_interface($id, 'Bad response from SCM API');
                } else {
                    $this->midware_model->insert_tb_interface($code, 'Bad response from SCM API', $frontend_text, $backend_text, $type, $modes);
                }
                $this->response([
                    'status' => 'fail',
                    'message' => 'Oops, Something went wrong!',
                    'data' => $code
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
