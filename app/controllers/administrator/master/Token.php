<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Token extends PrivateBase {

    const SESSION_SEARCH = 'search_token';
    const PAGE_TITLE = 'Token';
    const PAGE_HEADER = 'Token';
    const PAGE_URL = 'administrator/master/token/';
    protected $page_limit = 10;

    // constructor
    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
		$this->load->model('administrator/master/M_token', 'token');
    }

    public function index() {
        $this->_set_page_rule('R');
        $this->load->library('pagination');
        //create pagination
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->token->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = $this->uri->segment(4);
        $this->pagination->initialize($config);
        $rs_search = $this->session->userdata(self::SESSION_SEARCH);
        $result = $this->token->get_all($rs_search, $config['per_page'], $from);
        $data = array(
            'rs_search' => $rs_search,
            'rs_id' => $result,
            'pagination' => $this->pagination->create_links(),
        );
		// echo'<pre>';
		// print_r($data);
		// exit();
        view(self::PAGE_URL . 'index', $data);
    }

    public function add() {
        $this->_set_page_rule('C');
        $all_role = $this->token->get_all_role();
        $data = array(
            'rs_roles' => $all_role,
        );
		$data['unix'] =  $this->token->gencode(5);
        view(self::PAGE_URL . 'add', $data);
    }

    // add process
    public function add_process() {
		
        // cek input
        $this->form_validation->set_rules('token', 'Token', 'trim|required');
        $this->form_validation->set_rules('expired_at', 'Tanggal Kadaluarsa', 'trim|required');
        // process
        if ($this->form_validation->run() !== false) {
            $token = $this->input->post('token');
            $expired_at = $this->input->post('expired_at');

			$params = array(
                'token' => $token,
                'expired_at' => $expired_at,
				'token_sts' => $this->input->post('token_sts'),
                'mdb_name' => $this->session->userdata['com_user']['user_name'],
                'mdb' => $this->session->userdata['com_user']['user_id'],
                'mdd' => date('Y-m-d H:i:s'),
            );
            // insert
            if ($this->token->insert('token', $params)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data added successfully !');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL . 'add', 'error', 'Data Failed to Add');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL . 'add', 'error', 'Some Fields are Incorrect. !');
        }
    }

    public function edit($token_id = '') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($token_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not found!');
        }
        //get data
        $result = $this->token->getByid([$token_id]);

		view(self::PAGE_URL . 'edit', compact('result'));
    }

    // edit process
    public function edit_process() {
        // cek input
        $this->form_validation->set_rules('token', 'Token', 'trim|required');
        $this->form_validation->set_rules('expired_at', 'Tanggal Kadaluarsa', 'trim|required');
        // check data
        if (empty($this->input->post('token_id'))) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'error', 'Data Not Found !');
        }
        $token_id = $this->input->post('token_id');
        // process
        if ($this->form_validation->run() !== false) {
			$token = $this->input->post('token');
            $expired_at = $this->input->post('expired_at');

			$params = array(
                'token' => $token,
                'expired_at' => $expired_at,
				'token_sts' => $this->input->post('token_sts'),
                'mdb_name' => $this->session->userdata['com_user']['user_name'],
                'mdb' => $this->session->userdata['com_user']['user_id'],
                'mdd' => date('Y-m-d H:i:s'),
            );
            $where = array(
                'token_id' => $token_id,
            );
            if ($this->token->update('token', $params, $where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data edited successfully !');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit/'.$token_id, 'error', 'Data failed to edit !');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/'.$token_id, 'error', 'Some Fields are Incorrect. !');
        }
    }

	public function delete() {
		$this->_set_page_rule('D');
        if ($_GET['token_id'] != null) {
			$where = array(
				'token_id' => $_GET['token_id'],
			);
			if ($this->token->delete('token', $where)) {
				//sukses notif
				$this->notification->send(self::PAGE_URL, 'success', 'Data successfully deleted');
			} else {
				//default error
				$this->notification->send(self::PAGE_URL, 'error', 'Data failed to delete !');
			}
        } else {
            $this->notification->send(self::PAGE_URL, 'error', 'Data Not Found !');
        }
    }

    public function search_process() {
        $this->_set_page_rule('R');
        if ($this->input->post('search', true) == "submit") {
            $params = array(
                'token' => $this->input->post('token', true),
                'token_sts' => $this->input->post('token_sts', true),
            );
            $this->session->set_userdata(self::SESSION_SEARCH, $params);
        } else {
            $this->session->unset_userdata(self::SESSION_SEARCH);
        }
        redirect(self::PAGE_URL);
    }


}
