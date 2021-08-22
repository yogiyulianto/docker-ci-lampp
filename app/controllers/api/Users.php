<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;
use chriskacerguis\RestServer\RestController;

class Users extends RestController {
    
    function __construct() {
        parent::__construct();
        $this->load->model('api/M_user');
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
        $data = $this->M_user->get_user_detail_with_all_roles(array($user->user_name));
        
        // if data exist
        if($data){
            $result = array(
                'status' => true,
                'message' => 'Sukses Mengambil Data!',
                'data' => $data
                );
            $this->response($result, 200); 
        } else {
            $result = array(
				'status' => false,
				'message' => 'Gagal Mengambil Data, Coba Lagi Nanti!'
			);
			$this->response($result, 200);
        }
        
    }

    public function change_photo_post()
	{
        if($_FILES['photo']){
            $user = $this->user_data;

            $config['upload_path'] = 'uploads/profile/photo/';
            $config['allowed_types'] = '*';
            $config['file_name'] = 'photo_' . $user->user_id . '_' . date('Ymdhis');
            
            $this->tupload->initialize($config);

            // process upload images
            $this->tupload->do_upload_image('photo', 128, false);
            $data = $this->tupload->data();
            $path = 'uploads/profile/photo/' . $data['file_name'];
            $type = $_FILES['photo']['type'];

            $params = array(
                'profile_picture' => $path,
                'profile_background' => $path,
            );
            $where = array(
                'employee_id' => $user->user_id
            );

            $result = $this->Users_model->update('xin_employees', $params, $where);
            if($result && $data){
                $params = array(
                    'profile_picture' => base_url() . $path,
                );
                $response = array(
                    'status' => true,
                    'message' => 'Data berhasil diubah!',
                    'data' => $params
                    );
                $this->response($response, 200); 
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'Data gagal diubah!',
                    );
                $this->response($response, 404); 
            }    
        } else {
            $response = array(
                'status' => false,
                'message' => 'Field Photo is required!',
                );
            $this->response($response, 404); 
        }  
    }

    public function change_password_post(){
         // validation
         $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
         $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
         $this->form_validation->set_rules('retype_new_password', 'Retype New Password', 'trim|required');
         // get data
         $old_password = $this->post('old_password');
         $new_password = $this->post('new_password');
         $retype_new_password = $this->post('retype_new_password');
         $user = $this->user_data;
         
         $data = $this->Users_model->get_data_user_id(array($user->user_id));
        //  print_r($data);die;
         // check data
         if($this->form_validation->run() !== FALSE){
             // check old password
             if($data['password'] === md5($old_password)){
                 // check new
                 if($new_password === $retype_new_password){
                    $params = array(
                        'password' => md5($new_password),
                    );
                    $where = array(
                        'employee_id' => $user->user_id
                    );
                    //proses
                    $result = $this->Users_model->update('xin_employees', $params, $where);
                    if($result){
                        $response = array(
                            'status' => true,
                            'message' => 'Password berhasil diubah!'
                            );
                        $this->response($response, 200); 
                    } else {
                        $response = array(
                            'status' => false,
                            'message' => 'Password gagal diubah!',
                            );
                        $this->response($response, 404); 
                    }  
                 } else {
                    $response = array(
                        'status' => false,
                        'message' => 'Password baru tidak sama!',
                        );
                    $this->response($response, 404); 
                 }
             } else {
                $response = array(
                    'status' => false,
                    'message' => 'Password lama salah!',
                    );
                $this->response($response, 404); 
             }  
         } else {
             $response = array(
                 'status' => false,
                 'message' => $this->form_validation->error_array()
             );
             $this->response($response, 200);
         }
    }

    public function pelanggaran_get()
	{
       
        $user = $this->user_data;
        $data = $this->Users_model->get_pelanggaran_by_id(array($user->user_id));
        
        // if data exist
        if($data){
            $result = array(
                'status' => true,
                'message' => 'Sukses Mengambil Data!',
                'data' => $data
                );
            $this->response($result, 200); 
        } else {
            $result = array(
				'status' => false,
				'message' => 'Gagal Mengambil Data, Coba Lagi Nanti!'
			);
			$this->response($result, 200);
        }
        
    }

    public function update_post(){
        // validation
        $this->form_validation->set_rules('employee_id', 'Employee ID', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('no_reg', 'Nomer Registrasi/NIK', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('no_hp', 'Nomer Handphone', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        // get data
        $name = $this->post('name');
        $no_reg = $this->post('no_reg');
        $gender = $this->post('gender');
        $no_hp = $this->post('no_hp');
        $address = $this->post('address');
        $employee_id = $this->post('employee_id');
        // check data
        if($this->form_validation->run() !== FALSE){
            $params = array(
                'first_name' => $name,
                'nik' => $no_reg,
                'contact_no' => $no_hp,
                'gender' => $gender,
                'address' => $address,
            );
            $where = array(
                'employee_id' => $employee_id
            );

            $result = $this->Users_model->update('xin_employees', $params, $where);
            if($result){
                $response = array(
                    'status' => true,
                    'message' => 'Data berhasil diubah!',
                    'data' => $params
                    );
                $this->response($response, 200); 
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'Data gagal diubah!',
                    );
                $this->response($response, 404); 
            }    
        } else {
            $response = array(
				'status' => false,
				'message' => $this->form_validation->error_array()
			);
			$this->response($response, 200);
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
