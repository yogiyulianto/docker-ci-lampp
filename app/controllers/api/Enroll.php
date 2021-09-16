<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;
use chriskacerguis\RestServer\RestController;

class Enroll extends RestController {
    
    function __construct() {
        parent::__construct();
        $this->load->model('api/M_user');
        $this->load->library('tupload');
        $this->load->library('form_validation');
        $this->decode();
    }


    public function index_post(){
        $params = array(
            'user_id' => $this->user_data->user_id,
            'enroll_date' => date('Y-m-d H:i:s'),
            'payment_st' => 'unpaid',
            'total_payment' => 20000 + $this->M_user->generate_uniq_number(),
            'unique_number' => $this->M_user->generate_uniq_number(),
        );

        $result = $this->M_user->insert('user_enroll', $params);
        if($result){
            $response = array(
                'status' => true,
                'message' => 'Berlangganan berhasil!',
                'data' => $params
                );
            $this->response($response, 200); 
        } else {
            $response = array(
                'status' => false,
                'message' => 'Terjadi kesalahan! berlangganan gagal!',
                );
            $this->response($response, 404); 
        }  
    }

    public function all_get(){
        $user = $this->user_data;
        $base_url = base_url();
        // if data exist
        if($user){
            $response = $this->M_user->get_all_enrollment($user->user_id);
            $result = array(
                'status' => true,
                'message' => 'Sukses Mengambil Data!',
                'data' => $response
                );
            $this->response($result, 200); 
        } else {
            $result = array(
                'status' => false,
                'message' => 'Data Tidak ditemukan!'
            );
            $this->response($result, 200);
        }
    }
    public function check_get(){
        $user = $this->user_data;
        $base_url = base_url();
        $id = $this->get('id');
        // if data exist
        if($id){
            $response = $this->M_user->check_enrollment($id);
            $result = array(
                'status' => true,
                'message' => 'Sukses Mengambil Data!',
                'data' => $response
                );
            $this->response($result, 200); 
        } else {
            $result = array(
                'status' => false,
                'message' => 'Data Tidak ditemukan!'
            );
            $this->response($result, 200);
        }
    }
    

    public function decode()
    {
        $this->methods['users_get']['limit'] = 500; 
        $this->methods['users_post']['limit'] = 100; 
        $this->methods['users_delete']['limit'] = 50; 
        //JWT Auth middleware
        $headers = $this->input->get_request_header('Authorization');
        $kunci = $this->config->item('jwt_key');
        $token= "token";
       	if (!empty($headers)) {
        	if (preg_match('/Bearer\s(\S+)/', $headers , $matches)) {
            $token = $matches[1];
        	}
    	}
        try {
           $decoded = JWT::decode($token, $kunci, array('HS256'));
           $this->user_data = $decoded;
        } catch (Exception $e) {
            $invalid = [
                'status' => false,
                'message' => $e->getMessage(),
            ]; 
            $this->response($invalid, 401);
        }
    }
    
  
}
