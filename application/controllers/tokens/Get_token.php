<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Get_token extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('login');
        }
        $this->load->library('template/bp_token');
    }

    public function tokens($type)
    {
        $data['grant_type'] = 'password';
        $data['username'] = 'sapadmin';
        $data['password'] = 'aurionpro@2013';
        $result = $this->bp_token->_get_tokens($data);

        if ($result == true) {
            $this->session->set_flashdata('message', 'generated');
            redirect('webui/' . $type);
        } else {
            $this->session->set_flashdata('message', 'failed');
            redirect('webui/' . $type);
        }
    }
}
