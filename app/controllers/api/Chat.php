<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;
use chriskacerguis\RestServer\RestController;

class Chat extends RestController {
    
    function __construct() {
        parent::__construct();
        $this->load->model('api/M_chat');
        $this->load->library('tupload');
        $this->load->library('form_validation');
        $this->decode();
    }
  
    /**
    * 
    */
    public function index_get()
	{
        $user = $this->user_data;
        $base_url = base_url();
        // get data
        $data = $this->M_chat->get_all($user->user_id);
        $count = $this->M_chat->count_all($user->user_id);
        // if data exist
        if($data){
            $result = array(
                'status' => true,
                'message' => 'Sukses Mengambil Data!',
                'jumlah_data' => $count,
                'data' => $data
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

    public function detail_get($chat_id = '')
	{
        $user = $this->user_data;
        $base_url = base_url();
        // get data
        $data = $this->M_chat->get_all_detail($chat_id);
        $count = $this->M_chat->count_all_detail($chat_id);
        // if data exist
        if($data){
            $result = array(
                'status' => true,
                'message' => 'Sukses Mengambil Data!',
                'jumlah_data' => $count,
                'data' => $data
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

    function create_post(){
        $this->form_validation->set_rules('message','Message','trim|required');
        $this->form_validation->set_rules('title','Title','trim|required');
        
        if($this->form_validation->run() !== FALSE){
            $user = $this->user_data;
            $chat_id = $user->user_id.hexdec(uniqid());
            // insert chat
            $params = array(
                'chat_id' => $chat_id,
                'user_id' => $user->user_id,
                'chat_st' => 'waiting',
                'title' => $this->post('title'),
                'message_date' => date('Y-m-d H:i:s'),
                'mdb' => $user->user_id,
                'mdb_name' => $user->full_name,
                'mdd' => date('Y-m-d H:i:s'),
            );
            $insert_chat = $this->M_chat->insert('chat', $params);
            if($insert_chat){
                $chat_detail_id = uniqid();
                // insert detail chat
                $params = array(
                    'chat_detail_id' => $chat_detail_id,
                    'chat_id' => $chat_id,
                    'message' => $this->post('message'),
                    'message_date' => date('Y-m-d H:i:s'),
                    'order_by' => 1,
                    'message_type' => 'question',
                    'mdb' => $user->user_id,
                    'mdb_name' => $user->full_name,
                    'mdd' => date('Y-m-d H:i:s'),
                );
                $insert_detail = $this->M_chat->insert('chat_detail', $params);
                if($insert_detail){
                    $result = array(
                        'status' => true,
                        'message' => 'Pesan berhasil terkirim!',
                        'message_value' => $this->post('message'),
                    );
                    $this->response($result, 200); 
                } else {
                    $result = array(
                        'status' => false,
                        'message' => 'Pesan gagal dikirim! coba beberapa saat lagi!'
                    );
                    $this->response($result, 404); 
                }
            } else {
                $result = array(
                    'status' => false,
                    'message' => 'Pesan gagal dikirim! coba beberapa saat lagi!'
                );
                $this->response($result, 404); 
            }
        } else {
            $result = array(
                'status' => false,
                'message' => 'Ada Field yang kurang!'
            );
            $this->response($result, 200);
        }
    }

    function response_post(){
        $this->form_validation->set_rules('message','Message','trim|required');
        $this->form_validation->set_rules('chat_id','Chat ID','trim|required');
        
        if($this->form_validation->run() !== FALSE){
            $user = $this->user_data;
            $chat_id = $this->post('chat_id');
            // insert chat
            $params = array(
                'user_id' => $user->user_id,
                'chat_st' => 'waiting',
                'message_date' => date('Y-m-d H:i:s'),
                'mdb' => $user->user_id,
                'mdb_name' => $user->full_name,
                'mdd' => date('Y-m-d H:i:s'),
            );
            $where = array(
                'chat_id' => $chat_id,
            );
            $insert_chat = $this->M_chat->update('chat', $params, $where);
            if($insert_chat){
                $last_chat = $this->M_chat->get_last_by_id($chat_id);
                $chat_detail_id = uniqid();
                // insert detail chat
                $params = array(
                    'chat_detail_id' => $chat_detail_id,
                    'chat_id' => $chat_id,
                    'message' => $this->post('message'),
                    'message_date' => date('Y-m-d H:i:s'),
                    'order_by' => $last_chat['order_by'] + 1,
                    'message_type' => 'question',
                    'mdb' => $user->user_id,
                    'mdb_name' => $user->full_name,
                    'mdd' => date('Y-m-d H:i:s'),
                );
                $insert_detail = $this->M_chat->insert('chat_detail', $params);
                if($insert_detail){
                    $result = array(
                        'status' => true,
                        'message' => 'Pesan berhasil terkirim!',
                        'message_value' => $this->post('message'),
                    );
                    $this->response($result, 200); 
                } else {
                    $result = array(
                        'status' => false,
                        'message' => 'Pesan gagal dikirim! coba beberapa saat lagi!'
                    );
                    $this->response($result, 404); 
                }
            } else {
                $result = array(
                    'status' => false,
                    'message' => 'Pesan gagal dikirim! coba beberapa saat lagi!'
                );
                $this->response($result, 404); 
            }
        } else {
            $result = array(
                'status' => false,
                'message' => 'Ada field yang kurang'
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
