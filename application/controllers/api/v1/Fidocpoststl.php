<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');


use Restserver\Libraries\REST_Controller;

class Fidocpoststl extends REST_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('wsdl_controller');
        $this->load->model('midware_model');
        $this->load->library('template/fi_postst');
    }

    public function index_post()
    {
        $data   = $this->post();
        $code   = $data['SettlementDetail']['Settlement']['BasicDetails']['SettlementNo'];
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
        $type   = 'settlement';
        $mode   = 'SAP_FIPOST';
        $modes  = 'SCM_FIGET';
        $data   = $this->post();
        $code   = $data['SettlementDetail']['Settlement']['BasicDetails']['SettlementNo'];
        $params = $this->fi_postst->_array_sap($data);
        $frontend_text  = json_encode($data, true);
        $backend_text   = json_encode($params, true);

        $amount_adv = $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['AdvanceAmount'];
        $amount_stt = $data['SettlementDetail']['Settlement']['AdvanceRequests']['AdvanceRequest']['BasicDetails']['AmountSettled'];

        $this->form_validation->set_data($params['Fitrxlgc']['item'][0]);
        $this->form_validation->set_rules('Xblnr', 'Settlement No', 'required|max_length[16]|is_unique[tb_success.code]', array(
            'is_unique'     => 'This Document has already syncronized.'
        ));
        $this->form_validation->set_rules('Bktxt', 'Remark', 'required|max_length[25]');
        $this->form_validation->set_rules('Hkont', 'Account Posting Code', 'required');

        if ($this->form_validation->run() == FALSE) {
            $result = validation_errors();
            $this->response(array(
                'Response' => array(
                    'Message' => preg_replace('/<p>(.*?)<\/p>/', '$1', validation_errors()),
                    'RefId' => $code,
                    'Status' => 'E'
                )
            ), 400);
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
