<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
use \Firebase\JWT\JWT;

class Auth extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // load model
        $this->load->model('systems/M_user');
		$this->load->model('systems/M_site');
		$this->load->model('systems/M_account');
		$this->load->model('systems/M_email');
        $this->load->model('systems/M_user');

        $this->load->library('form_validation');
    }

    // get data user by_id
	public function index_get(){
        $key = $this->config->item('jwt_key');
        $date = new DateTime();
        $iat = $date->getTimestamp();
        $exp = $date->getTimestamp() + 60*60*24*30*12*100;

        $token = array(
            "username" => 'yogi',
            "user_id" => '1001',
            "iat" => $iat,
            "exp" => $exp
        );

        $jwt = JWT::encode($token, $key);
        $message = "Data ditemukan!";
        $response = array(
            'status' => true,
            'message' => $jwt
        );

        $this->response($response, 200);
    }

    public function login_post(){
        $this->form_validation->set_rules('username', 'Username', 'trim');
		$this->form_validation->set_rules('password', 'Password', 'trim');
		$username = $this->post('username');
		$password = $this->post('password');
        // process
        if ($this->form_validation->run() != FALSE) {
    	    // get user detail
			$result = $this->M_user->get_user_login_all_roles_api($username, $password);
            //cek
            if (!empty($result)) {
				// cek login attempt ( username dan ip yang sama dalam 1 jam terakhir )
				$total_attempt = $this->db->where('user_name', $username)->get('com_user')->row()->attempts;

                if($result['user_st'] == 0){
                    $message = "Akun anda belum di aktifkan!";
                    $response = array(
                        'status' => false,
                        'message' => $message
                    );
                    $this->response($response, 404);
                }
				$this->M_user->update('com_user', array('attempts' => $total_attempt + 1),array('user_name' => $username ));
                $this->session->set_userdata('com_user', array(
                    'user_id' => $result['user_id'],
                    'user_mail' => $result['user_mail'],
                    'user_name' => $result['user_name'],
                    'full_name' => $result['full_name'],
                    'role_id' => $result['role_id'],
                    'portal_id' => 30,
                    'default_page' => 'peserta/dashboard',
                ));
                // set cookie 
                $session_params = array(
                    'log_id' => generate_id(),
                    'user_id' => $result['user_id'], 
                    'login_date' => now(),
                    'ip_address' => get_client_ip(),
                );
                // insert login time
                $this->M_user->insert('com_user_login',$session_params);
                // update user attempt
                $this->M_user->update('com_user', array('attempts'=> 0),array('user_id'=> $result['user_id']));
                $message = "Anda berhasil login!";

                $key = $this->config->item('jwt_key');
                $date = new DateTime();
                $iat = $date->getTimestamp();
                $exp = $date->getTimestamp() + 60*60*24*30*12*100;
                
                // print_r($result);die;
                $token = array(
                    'user_id' => $result['user_id'],
                    'user_mail' => $result['user_mail'],
                    'user_name' => $result['user_name'],
                    'full_name' => $result['full_name'],
                    'role_id' => $result['role_id'],
                    "iat" => $iat,
                    "exp" => $exp
                );
            
                $jwt = JWT::encode($token, $key);
                $data_response = array(
                    'user_id' => $result['user_id'],
                    'user_mail' => $result['user_mail'],
                    'user_name' => $result['user_name'],
                    'full_name' => $result['full_name'],
                    'role_id' => $result['role_id'],
                    'token' => $jwt
                );

                $response = array(
                    'status' => true,
                    'message' => $message,
                    'data' => $data_response
                );
                $this->response($response, 200);
                // cek lock status
                if ($result['user_st'] == 2) {
                    // default error
                    $message = "Akun anda terkunci !";
                    $response = array(
                        'status' => false,
                        'message' => $message
                    );
                    $this->response($response, 404);
                }elseif($result['user_st'] == 0){
                    // default error
                    $message = "Akun anda belum di aktifkan !";
                    $response = array(
                        'status' => false,
                        'message' => $message
                    );
                    $this->response($response, 404);
                }
				
            } else {
                $message = "Isian username atau password salah!";
                $response = array(
                    'status' => false,
                    'message' => $message
                );
                $this->response($response, 404);
            }
        } else {
            $message = $this->form_validation->error_array();
            $response = array(
                'status' => false,
                'message' => $message
            );
            $this->response($response, 404);
        }
    }


    public function register_post(){
        
		$email = $this->post('email');
        if ($this->M_user->is_exist_email($email)) {
            $message = "Email has been registered";
            $response = array(
                'status' => false,
                'message' => $message
            );
            $this->response($response, 404);
        }
        // check username
        $username = $this->post('email');
        if ($this->M_user->is_exist_username($username)) {
            $message = "Username has been registered";
            $response = array(
                'status' => false,
                'message' => $message
            );
            $this->response($response, 404);
        }

		$user_pass = $this->post('password');
        $password = md5($user_pass);
    	// generate user_id
        $prefix = date('ymd');
        $params_prefix = $prefix . '%';
    	$user_id = $this->M_user->generate_id($prefix, $params_prefix);
		$role_id = '2004';
		$full_name = $this->post('name');
		$adress = $this->post('address');
		$phone = $this->post('phone');

        // process
        if ($email && $username && $user_pass && $role_id) { 
            $params = array(
                'user_id' => $user_id,
                'user_name' => $username,
                'user_pass' => $password,
                'user_key' => $password,
                'user_st' => '1',
                'user_mail' => $email,
                'mdb' => $this->session->userdata('user_name'),
                'mdd' => date('Y-m-d H:i:s'),
            );
            // insert
            if ($this->M_user->insert('com_user', $params)) {
                // insert to users
                $params = array(
                    'user_id' => $user_id,
                    'full_name' => $full_name,
                    'address' => $adress,
                    'phone' => $phone,
                );
                $this->M_user->insert('user', $params);
                // insert hak akses
                $params = array(
                    'user_id' => $user_id,
                    'role_id' => $role_id,
                );
                $params_activate = array(
                    'user_id' => $user_id,
                    'hash' => md5($user_id)
                );
                $this->M_user->insert('register', $params_activate);
                $this->M_user->insert('com_role_user', $params);
                //sukses notif
                $message = "User berhasil ditambahkan!";
                $response = array(
                    'status' => true,
                    'message' => $message,
                    'data' => $params
                );
                $this->response($response, 200);
            } else {
                $message = "Data Failed to Add";
                $response = array(
                    'status' => false,
                    'message' => $message
                );
                $this->response($response, 404);
            }
        } else {
            $message = "Some Fields are Incorrect. !";
            $response = array(
                'status' => false,
                'message' => $message
            );
            $this->response($response, 404);
        }
    }
    // logout process
    public function logout_post(){
		// params
		$user_id = $this->post('user_id');
        if ($user_id) {
            $message = 'Anda berhasil logout';
            $this->M_user->update_user_logout($user_id);
            $response = array(
                'status' => true,
                'message' => $message,
                'user_id' => $user_id
            );
            $this->response($response, 200);
        } else {
            $message = "Some Fields are Incorrect. !";
            $response = array(
                'status' => false,
                'message' => $message
            );
            $this->response($response, 404);
        }
	}

    // forgot password process
	public function forgot_password_post() {
		// cek input
		$this->form_validation->set_rules('user_mail', 'Email', 'trim|required|max_length[50]');
		// process
		if ($this->form_validation->run() !== FALSE) {
			// params
			$user_mail = trim($this->post('user_mail', TRUE));
			// get user by mail
			$result = $this->M_account->get_users_by_email($user_mail);
			if ($result) {
				// reset password
				$time = microtime(true);
				$data_id = str_replace('.', '', $time);
				$request_key = $this->M_account->rand_password(50);
				$params = array(
					'data_id' => $data_id,
					'email' => $user_mail,
					'full_name' => $result['full_name'],
					'phone' => $result['phone'],
					'request_st' => 'waiting',
					'request_date' => date('Y-m-d H:i:s'),
					'request_key' => $request_key,
				);
				// insert
				if ($this->M_account->insert_reset($params)) {
                    $this->email_forgot_password($user_mail,$result['full_name'],$request_key);
                    $message = 'A password reset link has been send.';
                    $response = array(
                        'status' => true,
                        'message' => $message,
                    );
                    $this->response($response, 200);
				} else {
                    $message = 'Sorry, your request failed to process.';
                    $response = array(
                        'status' => true,
                        'message' => $message,
                    );
                    $this->response($response, 404);
				}
			} else {
                $message = 'A password reset link has been send.';
                $response = array(
                    'status' => true,
                    'message' => $message,
                );
                $this->response($response, 200);
			}
		} else {
			$message = 'Email is empty!';
            $response = array(
                'status' => true,
                'message' => $message,
            );
            $this->response($response, 404);
		}
	}

    // email forgot password
	private function email_forgot_password($email,$full_name,$request_key){
		// config
		$email_params['to'] = $email;
		$email_params['cc'] = array();
		$email_params['subject'] = 'Reset Password';
		$email_params['message']['title'] = 'Request to reset the password';
		$email_params['message']['greetings'] = 'Hi ' . $full_name . ',';
		$email_params['message']['intro'] = 'You want to reset the password on this application. Use the following link and follow the next steps:';
		$email_params['message']['actions']['link'] = base_url('auth/reset_password/' . md5($request_key));
		$email_params['message']['actions']['title'] = 'Yes, I will reset the password.';
		$email_params['attachments'] = array();
		// set email parameters
		$this->M_email->set_mail($email_params);
		// send
		return $this->M_email->send_mail('01');
		
	}

	// email reset password
	private function email_reset_password($email,$full_name,$new_password){
		// config
		$email_params['to'] = $email;
		$email_params['cc'] = array();
		$email_params['subject'] = 'Reset Password';
		$email_params['message']['title'] = 'Password has been changed';
		$email_params['message']['greetings'] = 'Hi ' . $full_name. ',';
		$email_params['message']['intro'] = 'You have successfully reset the password on your user account. Here is your new password: ';
		// new password
		$message = '<table cellspacing="0" cellpadding="0" border="0">';
		$message .= '<tbody>';
		$message .= '<tr>';
		$message .= '<td style="width: 100px;">Password</td>';
		$message .= '<td><b>' . $new_password . '</b></td>';
		$message .= '</tr>';
		$message .= '</tbody>';
		$message .= '</table>';
		// email params
		$email_params['message']['details'] = 'You have successfully reset the password on your user account. Here is your new password: </br>';
		$email_params['message']['details'] .= $message;
		$email_params['attachments'] = array();
		// set email parameters
		$this->M_email->set_mail($email_params);
		// send
		return $this->M_email->send_mail('01');
	}

    // email forgot password
	private function email_register($email,$full_name,$request_key){
		// config
		$email_params['to'] = $email;
		$email_params['cc'] = array();
		$email_params['subject'] = 'Activate Account!';
		$email_params['message']['title'] = 'Request to activate account!';
		$email_params['message']['greetings'] = 'Hi ' . $full_name . ',';
		$email_params['message']['intro'] = 'You want to reset the password on this application. Use the following link and follow the next steps:';
		$email_params['message']['actions']['link'] = base_url('auth/activation/' . $request_key);
		$email_params['message']['actions']['title'] = 'Yes, I will activate account.';
		$email_params['attachments'] = array();
		// set email parameters
		$this->M_email->set_mail($email_params);
		// send
		return $this->M_email->send_mail('01');
		
	}
}
