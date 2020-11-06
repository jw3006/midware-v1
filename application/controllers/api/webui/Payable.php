<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class Payable extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('interface_model');
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
                $data = $this->interface_model->get_ap();
                $notif = $this->interface_model->get_notif();
            } else {
                $this->db->where('id', $id);
                $data = $this->interface_model->get_ap();
                $notif = $this->interface_model->get_notif();
            }

            $this->response([
                'status' => true,
                'message' => 'The payable data has been generated.',
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
            $type           = 'payable';
            $params         = json_decode($data_json['backend_text'], true);

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
                    $this->db->delete('tb_interfaces', array("code" => $code));
                    $this->response([
                        'status' => true,
                        'message' => 'The payable data has been reposted.',
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
}
