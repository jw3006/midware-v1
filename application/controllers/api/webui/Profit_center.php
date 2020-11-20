<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class Profit_center extends REST_Controller
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
                $data = $this->interface_model->get_profitcost('PC');
                $office_code = $this->interface_model->get_office_code();
                $services = $this->interface_model->get_services();
                $vehicle = $this->interface_model->get_vehicle();
                $pc = $this->interface_model->get_pc('PC');
                $notif = $this->interface_model->get_notif();
            } else {
                $this->db->where('id', $id);
                $data = $this->interface_model->get_profitcost('PC');
                $office_code = $this->interface_model->get_office_code();
                $services = $this->interface_model->get_services();
                $vehicle = $this->interface_model->get_vehicle();
                $pc = $this->interface_model->get_pc('PC');
                $notif = $this->interface_model->get_notif();
            }

            $this->response([
                'status' => true,
                'message' => 'The profit center data has been generated.',
                'data' => $data,
                'notif' => $notif,
                'oc' => $office_code,
                'services' => $services,
                'vehicle' => $vehicle,
                'pc' => $pc
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
            $rows = $this->db->get_where('tb_map_pc', ['office_code' => $data['office_code'], 'service_code' => $data['service_code'],  'vehicle_type' => $data['vehicle_type'], 'type' => 'PC'])->num_rows();
            if ($rows > 0) {
                $this->response([
                    'status' => 'fail',
                    'message' => 'Oops, This Profit Center already exists.',
                    'data' => ''
                ], REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $insert = $this->db->insert('tb_map_pc', $data);
                if ($insert) {
                    $this->response([
                        'status' => 'success',
                        'message' => 'The profit center data has been posted.',
                        'data' => $data
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => 'fail',
                        'message' => 'Oops, Something went wrong!',
                        'data' => ''
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

    public function index_put()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $data = $this->put();
            $this->db->where('id', $data['id']);
            $update = $this->db->update('tb_map_pc', $data);
            if ($update) {
                $this->response([
                    'status' => 'success',
                    'message' => 'The profit center data has been updated.',
                    'data' => ''
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
            $result = $this->mapping_model->delete($code);
            if ($result) {
                $this->response([
                    'status' => 'success',
                    'message' => 'The profit center data has been deleted.',
                    'data' => ''
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
                'message' => 'Authorization has been denied for this request.',
                'data' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function offices_post()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $data = $this->post();
            $rows = $this->db->get_where('tb_map_office', ['code' => $data['code']])->num_rows();
            if ($rows > 0) {
                $this->response([
                    'status' => 'fail',
                    'message' => 'Oops, This Office Code already exists.',
                    'data' => ''
                ], REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $insert = $this->db->insert('tb_map_office', $data);
                if ($insert) {
                    $this->response([
                        'status' => 'success',
                        'message' => 'The Office data has been posted.',
                        'data' => $data
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => 'fail',
                        'message' => 'Oops, Something went wrong!',
                        'data' => ''
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

    public function services_post()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $data = $this->post();
            $rows = $this->db->get_where('tb_map_service', ['code' => $data['code']])->num_rows();
            if ($rows > 0) {
                $this->response([
                    'status' => 'fail',
                    'message' => 'Oops, This Service Code already exists.',
                    'data' => ''
                ], REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $insert = $this->db->insert('tb_map_service', $data);
                if ($insert) {
                    $this->response([
                        'status' => 'success',
                        'message' => 'The Service data has been posted.',
                        'data' => $data
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => 'fail',
                        'message' => 'Oops, Something went wrong!',
                        'data' => ''
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

    public function vehicle_post()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $data = $this->post();
            $rows = $this->db->get_where('tb_map_vehicle', ['code' => $data['code']])->num_rows();
            if ($rows > 0) {
                $this->response([
                    'status' => 'fail',
                    'message' => 'Oops, This Vehicle Code already exists.',
                    'data' => ''
                ], REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $insert = $this->db->insert('tb_map_vehicle', $data);
                if ($insert) {
                    $this->response([
                        'status' => 'success',
                        'message' => 'The Vehicle data has been posted.',
                        'data' => $data
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => 'fail',
                        'message' => 'Oops, Something went wrong!',
                        'data' => ''
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

    public function costs_post()
    {
        $auth = $this->_get_auth();
        if ($auth == true) {
            $data = $this->post();
            $rows = $this->db->get_where('tb_map_profitcost', ['code' => $data['code'], 'type' => $data['type']])->num_rows();
            if ($rows > 0) {
                $this->response([
                    'status' => 'fail',
                    'message' => 'Oops, This Profit Center already exists.',
                    'data' => ''
                ], REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $insert = $this->db->insert('tb_map_profitcost', $data);
                if ($insert) {
                    $this->response([
                        'status' => 'success',
                        'message' => 'The Profit Center has been posted.',
                        'data' => $data
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => 'fail',
                        'message' => 'Oops, Something went wrong!',
                        'data' => ''
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
}
