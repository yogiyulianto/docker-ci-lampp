<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;
use chriskacerguis\RestServer\RestController;

class Video extends RestController {
    
    function __construct() {
        parent::__construct();
        $this->load->model('api/M_video');
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
        $video_id = $this->get('video_id');
        $search = $this->get('search');

        if(empty($video_id)){
            // $data = $this->M_video->get_all();
            $category = $this->M_video->get_all_category();
            $temp_category = array();
            $item_blog = array();
            $count = 0;
            // if search not null
            if($search){
                $data = $this->M_video->search_by_title($search);
                $count = $this->M_video->count_search($search);
                if($count > 0){
                    $result = array(
                        'status' => true,
                        'message' => 'Sukses Mengambil Data!',
                        'jumlah_video' => $count,
                        'data' => $data
                        );
                    $this->response($result, 200); 
                } else {
                    $result = array(
                        'status' => true,
                        'message' => 'Data tidak ditemukan!',
                        'jumlah_blog' => $count,
                        'data' => $data
                        );
                    $this->response($result, 200); 
                }
            // if search null
            } else {
                for($i = 0; $i < count($category);$i++){
                    $data = $this->M_video->get_by_category($category[$i]['category_id']);
                    $count = $this->M_video->count_all_category();
                    $count_blog = $this->M_video->count_all();
                    $tmp = array(
                        'category_title' => $category[$i]['title'],
                    );
                    if($data){
                        $tmp['content'] = $data;
                        $tmp2[$i] = $tmp;
                        $temp_category[$i] = $tmp2;
                        $item_blog =  $temp_category[$i];
                    } else {
                        $tmp['content'] = [];
                        $tmp2[$i] = $tmp;
                        $temp_category[$i] = $tmp2;
                        $item_blog =  $temp_category[$i];
                    }
                }

                // if data exist
                if($item_blog){
                    $result = array(
                        'status' => true,
                        'message' => 'Sukses Mengambil Data!',
                        'jumlah_category' => $count,
                        'jumlah_blog' => $count_blog,
                        'data' => $item_blog
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
        } else {
            $data = $this->M_video->get_by_id($video_id);
            // if data exist
            if($data){
                $result = array(
                    'status' => true,
                    'message' => 'Sukses Mengambil Data!',
                    'jumlah_data' => 1,
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
