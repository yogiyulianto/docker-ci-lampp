<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Roles extends PrivateBase {

    // constructor
    const SESSION_SEARCH = 'roles_search';
    const PAGE_TITLE = 'Roles';
    const PAGE_HEADER = 'Role';
    const PAGE_URL = 'systems/roles/';
    protected $page_limit = 10;

    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        $this->load->model('systems/M_group');
        $this->load->model('systems/M_role');
    }

    public function index() {
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_role->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = $this->uri->segment(4);
        $this->pagination->initialize($config);
        //get data
        $rs_search = $this->session->userdata(self::SESSION_SEARCH);
        $rs_id = $this->M_role->get_all($rs_search, $config['per_page'], $from);
        $rs_groups = $this->M_role->get_all_groups();
        $data = array(
            'rs_search' => $rs_search,
            'rs_id' => $rs_id,
            'rs_groups' => $rs_groups,
            'pagination' => $this->pagination->create_links(),
        );
        view(self::PAGE_URL . 'index', $data);
    }

    public function add() {
        $this->_set_page_rule('C');
        $rs_groups = $this->M_role->get_all_groups();
        $data = array(
            'rs_groups' => $rs_groups,
        );
        view(self::PAGE_URL . 'add', $data);
    }

    public function add_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('group_id', 'Group ID', 'trim|required');
        $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required');
        $this->form_validation->set_rules('role_desc', 'Role Desc', 'trim');
        $this->form_validation->set_rules('default_page', 'Default Page', 'trim|required');

        // get last di role
        $group_id = $this->input->post('group_id');
        $role_id = $this->M_role->get_last_id($group_id);
        // process
        if ($this->form_validation->run() !== false) {
            $params = array(
                'group_id' => $group_id,
                'role_id' => $role_id,
                'role_name' => $this->input->post('role_name'),
                'role_desc' => $this->input->post('role_desc'),
                'default_page' => $this->input->post('default_page'),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_role->insert('com_role', $params)) {
                //sukses notif

                $this->notification->send(self::PAGE_URL.'', 'success', 'Data added successfully !');
            } else {
                $this->notification->send(self::PAGE_URL.'add', 'error', 'Data failed to add !');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'add', 'error', 'Some Fields are Incorrect. !');
        }
    }

    public function edit($role_id = '') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($role_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not Found !');
        }

        $rs_groups = $this->M_role->get_all_groups();
        //parsing
        $data = [
            'rs_groups' => $rs_groups,
            'result' => $this->M_role->get_by_id($role_id),
        ];
        //parsing and view content
        view(self::PAGE_URL . 'edit', $data);
    }
    
    public function edit_process() {
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('group_id', 'Group ID', 'trim|required');
        $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required');
        $this->form_validation->set_rules('default_page', 'Role Desc', 'trim|required');
        // check data
        $role_id = $this->input->post('role_id');
        if (empty($role_id)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data not found !');
        }
        // process
        if ($this->form_validation->run() !== false) {
            $params = array(
                'group_id' => $this->input->post('group_id'),
                'role_name' => $this->input->post('role_name'),
                'role_desc' => $this->input->post('role_desc'),
                'default_page' => $this->input->post('default_page'),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            $where = array(
                'role_id' => $role_id,
            );
            // insert
            if ($this->M_group->update('com_role', $params, $where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data edited successfully !');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit/' . $role_id, 'error', 'Data failed to edit !');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/' . $role_id, 'error', 'Some Fields are Incorrect. !');
        }
    }

    public function delete($role_id = '') {
        $this->_set_page_rule('D');

        //cek data
        if (empty($role_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not Found !');
        }

        //parsing
        $data = [
            'rs_groups' => $this->M_role->get_all_groups(),
            'result' => $this->M_role->get_by_id($role_id),
        ];
        //parsing and view content
        view(self::PAGE_URL . 'delete', $data);
    }

    public function delete_process() {
        $this->_set_page_rule('D');
        $role_id = $this->input->post('role_id', true);
        //cek data
        if (empty($role_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not Found !');
        }
        $where = array(
            'role_id' => $role_id,
        );
        //process
        if ($this->M_group->delete('com_role', $where)) {
            //sukses notif

            $this->notification->send(self::PAGE_URL, 'success', 'Data deleted successfully');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $role_id, 'error', 'Data failed to delete !');
        }
    }

    public function search_process() {
        if ($this->input->post('search', true) == "submit") {
            $params = array(
                'role_name' => $this->input->post('role_name', true),
                'group_id' => $this->input->post('group_id', true),
            );
            $this->session->set_userdata(self::SESSION_SEARCH, $params);
        } else {
            $this->session->unset_userdata(self::SESSION_SEARCH);
        }
        redirect(self::PAGE_URL);
    }

}
