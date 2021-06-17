<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Groups extends PrivateBase {

    // constructor
    const PAGE_TITLE = 'Groups';
    const PAGE_HEADER = 'Group';
    const PAGE_URL = 'systems/groups/';
    protected $page_limit = 10;

    public function __construct() 
    {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // load model
        $this->load->model('systems/M_group');
    }

    public function index() 
    {
        // PAGE RULES
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_group->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = $this->uri->segment(4);
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_group->get_all($config['per_page'], $from);
        $pagination = $this->pagination->create_links();
        // render view
        return view(self::PAGE_URL . 'index', compact('rs_id','pagination'));
    }

    public function add() 
    {
        // set page rules
        $this->_set_page_rule('C');
        // render view
        return view(self::PAGE_URL . 'add');
    }

    public function add_process() 
    {
        // set page rules
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
        $this->form_validation->set_rules('group_desc', 'Group Desc', 'trim|required');
        // get last di role
        $group_id = $this->M_group->get_last_id();
        // process
        if ($this->form_validation->run() !== FALSE) {
            $params = array(
                'group_id' => $group_id,
                'group_name' => $this->input->post('group_name'),
                'group_desc' => $this->input->post('group_desc'),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_group->insert('com_group', $params)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data added successfully !');
            } else {
                $this->notification->send(self::PAGE_URL.'add', 'error', 'Data failed to add !');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'add', 'error', 'Some Fields are Incorrect. !');
        }
    }

    public function edit($group_id = '') 
    {
        // set page rules
        $this->_set_page_rule('U');
        //cek data
        if (empty($group_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not Found !');
        }
        //parsing
        $result = $this->M_group->get_by_id($group_id);
        //render view
        return view(self::PAGE_URL . 'edit', compact('result'));
    }

    public function edit_process() 
    {
        // set page rules
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
        $this->form_validation->set_rules('group_desc', 'Group Desc', 'trim|required');
        // check data
        $group_id = $this->input->post('group_id');
        if (empty($group_id)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data not found !');
        }
        // process
        if ($this->form_validation->run() !== FALSE) {
            $params = array(
                'group_name' => $this->input->post('group_name'),
                'group_desc' => $this->input->post('group_desc'),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            $where = array(
                'group_id' => $group_id
            );
            // insert
            if ($this->M_group->update('com_group', $params, $where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data edited successfully !');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit' . $group_id, 'error', 'Data failed to edit !');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/' . $group_id, 'error', 'Some Fields are Incorrect. !');
        }
    }

    public function delete($group_id = '') 
    {
        // set page rules
        $this->_set_page_rule('D');
        //cek data
        if (empty($group_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not Found !');
        }
        //parsing
        $result = $this->M_group->get_by_id($group_id);
        //parsing and view content
        return view(self::PAGE_URL . 'delete', compact('result'));
    }

    public function delete_process() 
    {
        // set page rule
        $this->_set_page_rule('D');
        // init var
        $group_id = $this->input->post('group_id', true);
        //cek data
        if (empty($group_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not Found !');
        }
        $where = array(
            'group_id' => $group_id
        );
        //process
        if ($this->M_group->delete('com_group', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'success', 'Data deleted successfully');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $group_id, 'error', 'Data failed to delete !');
        }
    }

}
