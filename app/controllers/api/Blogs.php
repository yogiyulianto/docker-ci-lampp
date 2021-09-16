<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;
use chriskacerguis\RestServer\RestController;

class Blogs extends RestController {
    
    function __construct() {
        parent::__construct();
        $this->load->model('api/M_blogs');
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
        $blog_id = $this->get('blog_id');
        $search = $this->get('search');
        if(empty($blog_id)){
            if($user->enroll_st == 'premium'){
                $category = $this->M_blogs->get_all_category();
                $temp_category = array();
                $item_blog = array();
                $count = 0;
                // if search not null
                if($search){
                    $data = $this->M_blogs->search_by_title($search);
                    $count = $this->M_blogs->count_search($search);
                    if($count > 0){
                        $result = array(
                            'status' => true,
                            'message' => 'Sukses Mengambil Data!',
                            'jumlah_blog' => $count,
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
                        $data = $this->M_blogs->get_by_category($category[$i]['category_id']);
                        $count = $this->M_blogs->count_all_category();
                        $count_blog = $this->M_blogs->count_all();
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
                $category = $this->M_blogs->get_all_category();
                $temp_category = array();
                $item_blog = array();
                $count = 0;
                // if search not null
                if($search){
                    $data = $this->M_blogs->search_free_by_title($search);
                    $count = $this->M_blogs->count_free_search($search);
                    if($count > 0){
                        $result = array(
                            'status' => true,
                            'message' => 'Sukses Mengambil Data!',
                            'jumlah_blog' => $count,
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
                        $data = $this->M_blogs->get_free_by_category($category[$i]['category_id']);
                        $count = $this->M_blogs->count_all_category();
                        $count_blog = $this->M_blogs->count_all_free();
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
            }
        } else {
            $data = $this->M_blogs->get_by_id($blog_id);
            // if data exist
            if($data){
                $response = $this->M_blogs->get_by_id($data['blog_id']);
                // add + 1 views every hit api details
                $params = array(
                    'views' => $response['views'] + 1
                );
                $where = array(
                    'blog_id' => $response['blog_id']
                );
                $update_views = $this->M_blogs->update('blogs', $params, $where);
                $response = $this->M_blogs->get_by_id($data['blog_id']);
                if($update_views){
                    $response = $this->M_blogs->get_by_id($data['blog_id']);
                    $result = array(
                        'status' => true,
                        'message' => 'Sukses Mengambil Data!',
                        'data' => $response
                        );
                    $this->response($result, 200); 
                } else {
                    $result = array(
                        'status' => false,
                        'message' => 'Terjadi kesalahan! Coba lagi beberapa saat lagi!'
                    );
                    $this->response($result, 200);
                }
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

    public function all_get(){
        $user = $this->user_data;
        $base_url = base_url();
        // if data exist
        if($user){
            $response = $this->M_blogs->get_all_limit();
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
    /**
    * 
    */
    public function weekly_get()
	{
       
        $user = $this->user_data;
        $base_url = base_url();
        $week = $this->get('week');
        if(!empty($week)){
            if($user->enroll_st == 'premium'){
                $data = $this->M_blogs->get_random_weekly_blogs($week);
            } else {
                $data = $this->M_blogs->get_free_random_weekly_blogs($week);
            }
            // if data exist
            if($data){
                $response = $this->M_blogs->get_by_id($data[0]['blog_id']);
                // $response['content_refactor'] = ''
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
        } else {
            $result = array(
                'status' => false,
                'message' => 'Week harus diisi!'
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
