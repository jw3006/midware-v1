<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class Settlement extends REST_Controller
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
                $data = $this->interface_model->get_settlement();
                $notif = $this->interface_model->get_notif();
            } else {
                $this->db->where('id', $id);
                $data = $this->interface_model->get_settlement();
                $notif = $this->interface_model->get_notif();
            }

            $this->response([
                'status' => true,
                'message' => 'The settlement data has been generated.',
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
            $type           = 'settlement';
            $params         = json_decode($data_json['backend_text'], true);
            $data           = json_decode($data_json['frontend_text'], true);

            $amount_adv = $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['AdvanceAmount'];
            $amount_stt = $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['AmountSettled'];

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

                    $this->response([
                        'status' => true,
                        'message' => 'The settlement data has been reposted.',
                        'data' => $id
                    ], REST_Controller::HTTP_OK);
                    $this->midware_model->insert_tb_success($code, $Return, $type);
                    $this->db->delete('tb_interfaces', array("code" => $code));

                    #If any additional or refund
                    if ($amount_adv !== $amount_stt) {
                        $this->_post_sap1($data);
                    }
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
                    'message' => 'The settlement data has been deleted.',
                    'data' => $code
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => 'failed',
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

    private function _post_sap1($data)
    {
        $type   = 'settlment';
        $mode   = 'SAP_FIPOST';
        $modes  = 'SCM_FIGET';
        $code   = $data['SettlementDetail']['Settlement']['BasicDetails']['SettlementNo'];
        $params1 = $this->fi_postst->_array_sap1($data);
        $frontend_text  = json_encode($data, true);
        $backend_text   = json_encode($params1, true);

        #Call Operation (Function). Catch and display any errors
        $wsdl = 'http://PBBs4hdap00.ic4sap.bluebirdgroup.com:8000/sap/bc/srt/wsdl/flv_10002A111AD1/bndg_url/sap/bc/srt/rfc/sap/zifi_post_fitrx_rfc_2/320/zifi_post_fitrx_rfc_2/zifi_post_fitrx_rfc_2?sap-client=320';
        $function = 'ZifiPostFitrxRfc2';
        $username = 'HR-ABAP01';
        $password = '123456789';
        $result = $this->wsdl_controller->_sap_wsdl($wsdl, $function, $username, $password, $params1);

        if ($result['status'] == 'E') {

            $this->response(array(
                'Response' => array(
                    'Message' => $result['message'],
                    'RefId' => $code,
                    'Status' => 'E'
                ), 500
            ));
            $this->midware_model->insert_tb_interface($code, $result['message'], $frontend_text, $backend_text, $type, $mode);
        } else {

            $Code     = $result['message']['Belnr'];

            if ($Code) {
                $Return     = $result['message']['Return']['item']['Message'];

                $this->response(array(
                    'Response' => array(
                        'Message' => $Return,
                        'RefId' => $code,
                        'Status' => 'S'
                    ), 200
                ));
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
                        'Status' => 'E'
                    ), 204
                ));
                $this->midware_model->insert_tb_interface($code, $JMessages, $frontend_text, $backend_text, $type, $mode);
            }
        }
    }
}
