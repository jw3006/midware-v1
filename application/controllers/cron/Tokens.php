<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tokens extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('template/bp_token');
        $this->load->library('keys_controller');
    }

    public function gettoken()
    {
        $data['grant_type'] = 'password';
        $data['username'] = 'sapadmin';
        $data['password'] = 'aurionpro@2013';
        $result = $this->bp_token->_get_tokens($data);
        if ($result == true) {
            echo "Token has been generated";
        } else {
            echo "Oops, Something went wrong!";
        }
    }
}
