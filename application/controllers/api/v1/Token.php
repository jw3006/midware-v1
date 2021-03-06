<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class Token extends REST_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('keys_controller');
    }

    public function index_post()
    {
        $username = $this->post('username');
        $password = password_hash(MD5($this->post('password')), PASSWORD_DEFAULT);
        $user = $this->db->get_where('tb_user', ['username' => $username])->row_array();

        if ($user) {
            if ($user['is_active'] == 1) {
                if (password_verify($user['password'], $password)) {
                    $data = [
                        'user_id' => $user['user_id'],
                        'username' => $user['username'],
                        'email'    => $user['email']
                    ];
                    $result = $this->keys_controller->_generate_key($data);
                    $this->response(array(
                        'Response' => array(
                            'Message' => $result,
                            'RefId' => $username . $password,
                            'Status' => 'Success',
                            'StatusCode' => 200
                        )
                    ), REST_Controller::HTTP_OK);
                } else {
                    $this->response(array(
                        'Response' => array(
                            'Message' => 'Authorization has been denied for this request.',
                            'RefId' => $username . $password,
                            'Status' => 'Fail',
                            'StatusCode' => 400
                        )
                    ), REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response(array(
                    'Response' => array(
                        'Message' => 'Username has been inactived for this request.',
                        'RefId' => $username . $password,
                        'Status' => 'Fail',
                        'StatusCode' => 400
                    )
                ), REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(array(
                'Response' => array(
                    'Message' => 'Username is not registered for this request.',
                    'RefId' => $username . $password,
                    'Status' => 'Fail',
                    'StatusCode' => 401
                )
            ), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}
