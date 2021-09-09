<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/LoginBase.php' );

class Auth extends LoginBase{

	const PAGE_URL = 'auth/';
	
    public function __construct(){        
		parent::__construct();
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        //load models
		$this->load->model('systems/M_user');
		$this->load->model('systems/M_site');
		$this->load->model('systems/M_account');
		$this->load->model('systems/M_email');
		$this->load->library('notification');
		$this->_display_logo();
    }

	// login
    public function login(){
		// set page title
		$data['PAGE_TITLE'] = 'Login';
		// render view
		return view('auth.login', $data);
    }
    
    // login process
    public function login_process() {
        // cek input
        $this->form_validation->set_rules('username', 'Identity', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		// params
		$username = trim($this->input->post('username', true));
		$password = trim($this->input->post('password', true));
		$remember = trim($this->input->post('remember', true));
		
        // process
        if ($this->form_validation->run() !== FALSE) {
    	    // get user detail
			$result = $this->M_user->get_user_login_all_roles($username, $password);
            //cek
            if (!empty($result)) {
				// cek login attempt ( username dan ip yang sama dalam 1 jam terakhir )
				$total_attempt = $this->db->where('user_name', $username)->get('com_user')->row()->attempts;
				if ($total_attempt >= 3){
					$this->notification->send(self::PAGE_URL.'login','error', "You're tried logging in a few times, try again later.");
				}else{
					$this->M_user->update('com_user', array('attempts' => $total_attempt + 1),array('user_name' => $username ));
				}
                // cek lock status
                if ($result['user_st'] == 2) {
                    // default error
                    $this->notification->send(self::PAGE_URL.'login','error', 'Akun anda terkunci !');
                }elseif($result['user_st'] == 0){
                    $this->notification->send(self::PAGE_URL.'login','error', 'Akun anda belum di aktifkan !');
                }
				// set session 4 jam
				if ($remember == 'on') {
					$this->session->sess_expiration = (3600*24*7);
				}else {
					$this->session->sess_expiration = (3600*4);
				}
                $this->session->set_userdata('com_user', array(
					'user_id' => $result['user_id'],
					'user_mail' => $result['user_mail'],
					'user_name' => $result['user_name'],
					'full_name' => $result['full_name'],
					'role_id' => $result['role_id'],
					'portal_id' => $result['portal_id'],
					'default_page' => $result['default_page'],
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
                // redirect
				redirect($result['default_page']);
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'login','error', 'Isian username atau password salah!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'login','error', 'Isian tidak lengkap!');
        }
    }

	// logout process
    public function logout_process(){
		$user_id = $this->session->userdata('com_user');
		$this->M_user->update_user_logout($user_id['user_id']);
		$this->session->unset_userdata('com_user');
        $this->notification->send(self::PAGE_URL.'login','success', "Anda berhasil keluar !");
	}

	// forgot password
	public function forgot_password() {
		// set page title
		$data['PAGE_TITLE'] = 'Login';
		// render view
		view('auth.forgot_password',$data);
	}
	
	// forgot password process
	public function forgot_password_process() {
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
						// default success
						$this->notification->send(self::PAGE_URL.'forgot_password',"success", "A password reset link has been send.");
				} else {
					// default error
					$this->notification->send(self::PAGE_URL.'forgot_password',"error", "Sorry, your request failed to process.");
				}
			} else {
				// default error
				$this->notification->send(self::PAGE_URL.'forgot_password',"success", "A password reset link has been send.");
			}
		} else {
			// default error
			$this->notification->send(self::PAGE_URL.'forgot_password',"error", "Fill in your email.");
		}
	}
	
	// proses reset
	public function reset_password($id_encoded = '') {
		// get request
		$result = $this->M_account->get_reset_data_by_id(array($id_encoded));
		if (empty($result)) {
			// default error
			$this->notification->send(self::PAGE_URL.'login' ,"error", "Permintaan reset password anda sudah kadaluarsa!");
		} else {
			// get detail
			$detail = $this->M_account->get_users_by_email(array($result['email']));
			if (empty($detail)) {
				// default error
				$this->notification->send(self::PAGE_URL.'login' ,"error", "Maaf, permintaan anda tidak dapat diproses. User Account yang anda minta tidak terdaftar!");
			} else {
				// generate new password
				$new_password = $this->M_account->rand_password();
				$password = $this->bcrypt->hash_password(md5($new_password));
				// params
				$params = array(
					'user_pass' => $password,
				);
				$where = array(
					'user_id' => $detail['user_id'],
				);
				if ($this->M_account->update_user($params, $where)) {
					// update request
					$params = array(
						'request_st' => 'done',
						'response_by' => 'BY EMAIL',
						'response_date' => date('Y-m-d H:i:s'),
					);
					$where = array(
						'data_id' => $result['data_id'],
					);
					$this->M_account->update_reset($params, $where);
					// send email
					$this->email_reset_password($result['email'],$result['full_name'],$new_password);
					$this->notification->send(self::PAGE_URL.'login' ,"success", "Password Has been send!");
					// notification
				} else {
					// default error
					$this->notification->send(self::PAGE_URL.'login' ,"error", "Sorry, data cannot be processed. Repeat the reset and activation on your email!");
				}
				$this->notification->send(self::PAGE_URL.'login' ,"error", "Sorry, data cannot be processed. Repeat the reset and activation on your email!");
			}
			$this->notification->send(self::PAGE_URL .'login',"error", "Sorry, data cannot be processed. Repeat the reset and activation on your email!");
		}

	}

	// change portal
	public function change_portal($portal_id = '') {
        // get user login
		$session = $this->session->userdata('com_user');
        if (!empty($session)) {
            $result = $this->M_account->get_user_account_by_portal(array($session['user_id'], $portal_id));
            if (!empty($result)) {
                // set session
                $this->session->set_userdata('com_user', array(
                    'user_id' => $session['user_id'],
                    'user_name' => $session['user_name'],
                    'role_id' => $session['role_id'],
                    'portal_id' => $portal_id,
					'default_page' => $result['default_page'],
                ));
                // default redirect
                redirect($result['default_page']);
            }
        }
        // tidak ada session = tidak memiliki authority
        redirect(self::PAGE_URL.'logout_process');
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

	function activation($request_key){
        // set page title
		$data = $this->M_user->get_user($request_key);
		$params = array(
			'user_st' => 1
		);
		$where = array(
			'user_id' => $data['user_id']
		);
		$this->M_user->update('com_user', $params, $where);
		// render view
		view('auth/activation');
    }

}
