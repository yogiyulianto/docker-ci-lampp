<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
// require(APPPATH.'/libraries/RestController.php');  

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
    }

    public function login_post(){
        // cek input
        $this->form_validation->set_rules('username', 'Identity', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		// params
		$username = trim($this->input->post('username', true));
		$password = trim($this->input->post('password', true));
        // process
        if ($this->form_validation->run() !== FALSE) {
    	    // get user detail
			$result = $this->M_user->get_user_login_all_roles($username, $password);
			// echo'<pre>';
			// print_r($result);
			// exit();
            //cek
            if (!empty($result)) {
				// cek login attempt ( username dan ip yang sama dalam 1 jam terakhir )
				$total_attempt = $this->db->where('username', $username)->get('com_user')->row()->attempts;
				if ($total_attempt >= 3){
                    $message = "You're tried logging in a few times, try again later.";
                    $response = array(
                        'status' => false,
                        'message' => $message
                    );
                    $this->response($response, 404);
				}else{
					$this->M_user->update('com_user', array('attempts' => $total_attempt + 1),array('username' => $username ));
                    $this->session->set_userdata('com_user', array(
                        'user_id' => $result['user_id'],
                        'email' => $result['email'],
                        'username' => $result['username'],
                        'nama' => $result['nama'],
                        'role_id' => $result['role_id'],
                        'portal_id' => $result['portal_id'],
                        // 'default_page' => $result['default_page'],
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
                    $response = array(
                        'status' => true,
                        'message' => $message,
                        'data' => $session_params
                    );
                    $this->response($response, 200);
				}
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
            $message = "Isian tidak lengkap!";
            $response = array(
                'status' => false,
                'message' => $message
            );
            $this->response($response, 404);
        }
    }

    public function register_post(){
        // cek input
        $this->form_validation->set_rules('email', 'User Email', 'trim|required|valid_email|max_length[50]');
        $this->form_validation->set_rules('username', 'User Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('nama', 'Full Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        // $this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[255]');
        // check email
        $email = trim($this->input->post('email'));
        if ($this->M_user->is_exist_email($email)) {
            $message = "Email has been registered";
            $response = array(
                'status' => false,
                'message' => $message
            );
            $this->response($response, 404);
        }
        // check username
        $username = trim($this->input->post('username'));
        if ($this->M_user->is_exist_username($username)) {
            $message = "Username has been registered";
            $response = array(
                'status' => false,
                'message' => $message
            );
            $this->response($response, 404);
        }
        // process
        if ($this->form_validation->run() !== false) {
            $user_pass = $this->input->post('password', true);
            $password = $this->bcrypt->hash_password(md5($user_pass));
            // generate user_id
            $prefix = date('ymd');
            $params_prefix = $prefix . '%';
            $user_id = $this->M_user->generate_id($prefix, $params_prefix);
            $params = array(
                'user_id' => $user_id,
                'role_id' => $this->input->post('role_id'),
				'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'password' => $password,
                'user_st' => '1',
                'mdb' => $this->session->userdata('username'),
                'mdd' => date('Y-m-d H:i:s'),
            );
            // insert
            if ($this->M_user->insert('com_user', $params)) {
                // insert to users
                // $params = array(
                //     'user_id' => $user_id,
                //     'nama' => $this->input->post('nama'),
                //     // 'phone' => $this->input->post('phone'),
                //     'address' => $this->input->post('address'),
                // );
                // $this->M_user->insert('user', $params);
                // insert hak akses
                $params = array(
                    'user_id' => $user_id,
                    'role_id' => $this->input->post('role_id'),
                );
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
        // cek input
        $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
		// params
		$user_id = trim($this->input->post('user_id', true));
        if ($this->form_validation->run() !== false) {
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
			$user_mail = trim($this->input->post('user_mail', TRUE));
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
}
