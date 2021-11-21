<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;
use chriskacerguis\RestServer\RestController;

class Materi extends RestController {
    
    function __construct() {
        parent::__construct();
        $this->load->model('api/M_materi');
        $this->load->library('tupload');
        $this->load->library('form_validation');
        $this->decode();
    }
  
    /**
    * 
    */
    public function index_get()
	{
        $id_kategori = $this->get('id_kategori');
        $user = $this->user_data;
        $base_url = base_url();
        if($id_kategori){
            if($user){
                $response = $this->M_materi->get_all_by_category($id_kategori);
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
        }else{
            if($user){
                $response = $this->M_materi->get_all();
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
        
    }

    public function category_get()
	{
        $user = $this->user_data;
        $base_url = base_url();
        // if data exist
        if($user){
            $response = $this->M_materi->get_category();
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
