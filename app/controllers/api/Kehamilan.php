<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;
use chriskacerguis\RestServer\RestController;

class Kehamilan extends RestController {
    
    function __construct() {
        parent::__construct();
        $this->load->model('api/M_kehamilan');
        $this->load->library('tupload');
        $this->load->library('form_validation');
        $this->decode();
    }

    public function index_get()
	{
        $user = $this->user_data;
        $base_url = base_url();
        // if data exist
        if($user){
            $response = $this->M_kehamilan->get_by_id($user->user_id);
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


    function index_post(){
        $user = $this->user_data;
        $base_url = base_url();
        $this->form_validation->set_rules('tanggal_hpht','tanggal_hpht','trim|required');
        $this->form_validation->set_rules('tanggal_hpl','tanggal_hpl','trim|required');
        
        if($this->form_validation->run() !== FALSE){
            $user = $this->user_data;
            $response = $this->M_kehamilan->get_by_id($user->user_id);
            if($response){
                $params = array(
                    'tanggal_hpht' => $this->post('tanggal_hpht'),
                    'tanggal_hpl' => $this->post('tanggal_hpl'),
                    'mdb' => $user->user_id,
                    'mdb_name' => $user->full_name,
                    'mdd' => date('Y-m-d H:i:s'),
                );
                $where = array(
                    'user_id' => $user->user_id,
                );
                $update = $this->M_kehamilan->update('kehamilan', $params, $where);
                $token = "2001058095:AAEtjwOvoRrVNOCYGFPBrqrVksU-ZTINhzM";
                $url = "https://api.telegram.org/bot$token";
                $chatID = "-767612731";
                $message = '*Ada data Kehamilan masuk!!!* '.$user->full_name.' telah mengupdate data kehamilan! silahkan cek web dashboard admin untuk lihat detailnya!';

                file_get_contents($url . "/sendMessage?chat_id=" . $chatID . "&text=" . $message . "&parse_mode=markdown");
                if($update){
                    $result = array(
                        'status' => true,
                        'message' => 'Konsultasi berhasil diupdate!'
                    );
                    $this->response($result, 200); 
                } else {
                    $result = array(
                        'status' => false,
                        'message' => 'Konsultasi gagal diupdate! coba beberapa saat lagi!'
                    );
                    $this->response($result, 404); 
                }
            } else {
                // insert chat
                $params = array(
                    'user_id' => $user->user_id,
                    'tanggal_hpht' => $this->post('tanggal_hpht'),
                    'tanggal_hpl' => $this->post('tanggal_hpl'),
                    'mdb' => $user->user_id,
                    'mdb_name' => $user->full_name,
                    'mdd' => date('Y-m-d H:i:s'),
                );
                $insert = $this->M_kehamilan->insert('kehamilan', $params);
                if($insert){
                    $result = array(
                        'status' => true,
                        'message' => 'Konsultasi berhasil terkirim!'
                    );
                    $this->response($result, 200); 
                    $token = "2001058095:AAEtjwOvoRrVNOCYGFPBrqrVksU-ZTINhzM";
                    $url = "https://api.telegram.org/bot$token";
                    $chatID = "-767612731";

                    // $message = file_get_contents(base_url('api/order/botfin/' . $order_id));
                    $message = '*Ada data Kehamilan masuk!!!* '.$user->full_name.' telah menginput data kehamilan! silahkan cek web dashboard admin untuk lihat detailnya!';

                    file_get_contents($url . "/sendMessage?chat_id=" . $chatID . "&text=" . $message . "&parse_mode=markdown");
                } else {
                    $result = array(
                        'status' => false,
                        'message' => 'Konsultasi gagal dikirim! coba beberapa saat lagi!'
                    );
                    $this->response($result, 404); 
                }
            }
        } else {
            $result = array(
                'status' => false,
                'message' => 'Ada Field yang kurang!'
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
