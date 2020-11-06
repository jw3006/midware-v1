<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class Get_token extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('template/bp_token');
        $this->load->library('keys_controller');
    }

    public function tokens_post()
    {
        $keys = $this->input->get_request_header('Authorization');
        $result = $this->keys_controller->_check_auth($keys);
        if ($result == true) {
            $data['grant_type'] = 'password';
            $data['username'] = 'sapadmin';
            $data['password'] = 'aurionpro@2013';
            $result = $this->bp_token->_get_tokens($data);
            if ($result == true) {
                $this->response([
                    'status' => true,
                    'message' => 'The tokens data has been generated.',
                    'data' => ''
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => 'fail',
                    'message' => 'Authorization has been denied for this request.',
                    'data' => ''
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
