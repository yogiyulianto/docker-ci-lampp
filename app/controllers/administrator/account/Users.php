<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Users extends PrivateBase {

    const SESSION_SEARCH = 'search_users';
    const PAGE_TITLE = 'Users';
    const PAGE_HEADER = 'Users';
    const PAGE_URL = 'administrator/account/users/';
    protected $page_limit = 100;

    // constructor
    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        $this->load->model('administrator/account/M_users');
    }

    public function index() {
        $this->_set_page_rule('R');
        $this->load->library('pagination');
        //create pagination
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_users->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = $this->uri->segment(4);
        $this->pagination->initialize($config);

        $rs_search = $this->session->userdata(self::SESSION_SEARCH);
        $result = $this->M_users->get_all($rs_search, $config['per_page'], $from);

        $data = array(
            'rs_search' => $rs_search,
            'rs_id' => $result,
            'pagination' => $this->pagination->create_links(),
        );
        view(self::PAGE_URL . 'index', $data);
    }

    public function add() {
        $this->_set_page_rule('C');
        $all_role = $this->M_users->get_all_role();
        $data = array(
            'rs_roles' => $all_role,
        );
        view(self::PAGE_URL . 'add', $data);
    }

    // add process
    public function add_process() {
        // cek input
        $this->form_validation->set_rules('user_mail', 'User Email', 'trim|required|valid_email|max_length[50]');
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('user_pass', 'Password', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('user_st', 'Status', 'trim|required|max_length[1]');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[255]');
        // check email
        $email = trim($this->input->post('user_mail'));
        if ($this->M_users->is_exist_email($email)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL . 'add', 'error', 'Email has been registered');
        }
        // check username
        $username = trim($this->input->post('user_name'));
        if ($this->M_users->is_exist_username($username)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL . 'add', 'error', 'Username has been registered');
        }
        // process
        if ($this->form_validation->run() !== false) {
            $user_pass = $this->input->post('user_pass', true);
            $password = $this->bcrypt->hash_password(md5($user_pass));
            // generate user_id
            $prefix = date('ymd');
            $params_prefix = $prefix . '%';
            $user_id = $this->M_users->generate_id($prefix, $params_prefix);
            $params = array(
                'user_id' => $user_id,
                'user_name' => $this->input->post('user_name'),
                'user_pass' => $password,
                'user_key' => $password,
                'user_st' => $this->input->post('user_st'),
                'user_mail' => $this->input->post('user_mail'),
                'mdb' => $this->session->userdata('user_name'),
                'mdd' => date('Y-m-d H:i:s'),
            );
            // insert
            if ($this->M_users->insert('com_user', $params)) {
                // insert to users
                $params = array(
                    'user_id' => $user_id,
                    'full_name' => $this->input->post('full_name'),
                    'phone' => $this->input->post('phone'),
                    'address' => $this->input->post('address'),
                );
                $this->M_users->insert('user', $params);
                // insert hak akses
                $params = array(
                    'user_id' => $user_id,
                    'role_id' => '2004',
                );
                $this->M_users->insert('com_role_user', $params);
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

    public function edit($user_id = '') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($user_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not found!');
        }
        // get all role
        $all_role = $this->M_users->get_all_role();
        //parsing
        $data = array(
            'result' => $this->M_users->get_by_id($user_id),
            'rs_roles' => $all_role,
        );
        //parsing and view content
        view(self::PAGE_URL . 'edit', $data);
    }

    // edit process
    public function edit_process() {
        // cek input
        $this->form_validation->set_rules('user_mail', 'User Email', 'trim|required|valid_email|max_length[50]');
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('user_st', 'Status', 'trim|required|max_length[1]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[255]');
        // check data
        if (empty($this->input->post('user_id'))) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'error', 'Data Not Found !');
        }
        $user_id = $this->input->post('user_id');
        // process
        if ($this->form_validation->run() !== false) {
            //with password or no
            $user_pass = $this->input->post('user_pass', true);
            $user_pass_conf = $this->input->post('user_pass_conf', true);
            if (!empty($user_pass)) {
                if ($user_pass !== $user_pass_conf) {
                    $this->notification->send(self::PAGE_URL, 'error', 'Password not match !');
                }
                $password = $this->bcrypt->hash_password(md5($user_pass));
                // parameter
                $params = array(
                    'user_name' => $this->input->post('user_name'),
                    'user_pass' => $password,
                    'user_key' => $password,
                    'user_st' => $this->input->post('user_st'),
                    'user_mail' => $this->input->post('user_mail'),
                    'mdb' => $this->session->userdata('user_name'),
                    'mdd' => date('Y-m-d H:i:s'),
                );
            } else {
                $params = array(
                    'user_name' => $this->input->post('user_name'),
                    'user_st' => $this->input->post('user_st'),
                    'user_mail' => $this->input->post('user_mail'),
                );
            }
            $where = array(
                'user_id' => $user_id,
            );
            // insert
            if ($this->M_users->update('com_user', $params, $where)) {
                // insert to users
                $params = array(
                    'full_name' => $this->input->post('full_name'),
                    'address' => $this->input->post('address'),
                    'phone' => $this->input->post('phone'),
                );
                $this->M_users->update('user', $params, $where);
                //sukses notif\
                $this->notification->send(self::PAGE_URL, 'success', 'Data edited successfully !');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit/'.$user_id, 'error', 'Data failed to edit !');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/'.$user_id, 'error', 'Some Fields are Incorrect. !');
        }
    }

    public function delete($user_id = '') {
        $this->_set_page_rule('D');
        //cek data
        if (empty($user_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data Not Found !');
        }
        //parsing
        $data = array(
            'result' => $this->M_users->get_by_id($user_id),
        );
        view(self::PAGE_URL . 'delete', $data);
    }

    public function delete_process() {
        $user_id = $this->input->post('user_id', true);
        //cek data
        if (empty($user_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data Not Found !');
        }
        $where = array(
            'user_id' => $user_id,
        );
        //process
        if ($this->M_users->delete('com_user', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'success', 'Data successfully deleted');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data failed to delete !');
        }
    }

    public function search_process() {
        $this->_set_page_rule('R');
        if ($this->input->post('search', true) == "submit") {
            $params = array(
                'full_name' => $this->input->post('full_name', true),
                'user_st' => $this->input->post('user_st', true),
            );
            $this->session->set_userdata(self::SESSION_SEARCH, $params);
        } else {
            $this->session->unset_userdata(self::SESSION_SEARCH);
        }
        redirect(self::PAGE_URL);
    }

    public function activate_user($user_id) {
        $this->_set_page_rule('U');
        $params = array('user_st' => 1);
        $where = array('user_id' => $user_id);
        if ($this->M_users->update('com_user', $params, $where)) {
            //sukses notification
            $this->notification->send(self::PAGE_URL, 'success', 'Data successfully activate');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data failed to activate !');
        }
    }

    public function deactivate_user($user_id) {
        $this->_set_page_rule('U');
        $params = array('user_st' => 0);
        $where = array('user_id' => $user_id);
        if ($this->M_users->update('com_user', $params, $where)) {
            //sukses notification
            $this->notification->send(self::PAGE_URL, 'success', 'Data successfully lock');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data failed to lock !');
        }
    }

}
