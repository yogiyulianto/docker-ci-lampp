<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Portal extends PrivateBase {

    const PAGE_TITLE = 'App Portal';
    const PAGE_HEADER = 'Portal';
    const PAGE_URL = 'systems/portal/';
    protected $page_limit = 10;

    // constructor
    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD MODEL
        $this->load->model('systems/M_portal');
    }

    public function index() {
        // PAGE RULES
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_portal->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = $this->uri->segment(4);
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_portal->get_all($config['per_page'], $from);
        $data = array(
            'rs_id' => $rs_id,
            'pagination' => $this->pagination->create_links()
        );
        view(self::PAGE_URL . 'index', $data);
        // 
    }
    public function add() {
        $this->_set_page_rule('C');
        view(self::PAGE_URL . 'add');
    }
    // add process
    public function add_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('portal_nm','Portal Name','trim|required');
        $this->form_validation->set_rules('portal_title','Portal Title','trim|required');
        $this->form_validation->set_rules('portal_icon','Portal Icon','trim|required');
        $this->form_validation->set_rules('site_title','Site Title','trim|required');
        $this->form_validation->set_rules('site_desc','Site Desc','trim|required');
        $this->form_validation->set_rules('meta_desc','Meta Desc','trim');
        $this->form_validation->set_rules('meta_keyword','Meta Keyword','trim');
        // get last di role
        $portal_id = $this->M_portal->get_last_id();
        // process
        if ($this->form_validation->run() !== FALSE) {
            $params = array(
                'portal_id' => $portal_id,
                'portal_nm' => $this->input->post('portal_nm'), 
                'portal_title' => $this->input->post('portal_title'), 
                'portal_icon' => $this->input->post('portal_icon'), 
                'site_title' => $this->input->post('site_title'), 
                'site_desc' => $this->input->post('site_desc'), 
                'meta_desc' => $this->input->post('meta_desc'), 
                'meta_keyword' => $this->input->post('meta_keyword'), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_portal->insert('com_portal', $params)) {
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
    public function edit($portal_id = '') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($portal_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not Found !');
        }
        //parsing
        $data = array(
            'result' => $this->M_portal->get_by_id($portal_id),
        );
        //parsing and view content
        view(self::PAGE_URL.'edit', $data);
    }

    // edit process
    public function edit_process() {
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('portal_nm','Portal Name','trim|required');
        $this->form_validation->set_rules('portal_title','Portal Title','trim|required');
        $this->form_validation->set_rules('portal_icon','Portal Icon','trim|required');
        $this->form_validation->set_rules('site_title','Site Title','trim|required');
        $this->form_validation->set_rules('site_desc','Site Desc','trim|required');
        $this->form_validation->set_rules('meta_desc','Meta Desc','trim');
        $this->form_validation->set_rules('meta_keyword','Meta Keyword','trim');
        // check data
        $portal_id = $this->input->post('portal_id');
        if (empty($portal_id)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data not found !');
        }
        // process
        if ($this->form_validation->run() !== FALSE) {
            $params = array(
                'portal_nm' => $this->input->post('portal_nm'), 
                'portal_title' => $this->input->post('portal_title'), 
                'portal_icon' => $this->input->post('portal_icon'), 
                'site_title' => $this->input->post('site_title'), 
                'site_desc' => $this->input->post('site_desc'), 
                'meta_desc' => $this->input->post('meta_desc'), 
                'meta_keyword' => $this->input->post('meta_keyword'), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            $where = array(
                'portal_id' => $portal_id
            );
            // insert
            if ($this->M_portal->update('com_portal', $params, $where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data edited successfully !');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit' . $portal_id, 'error', 'Data failed to edit !');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/' . $portal_id, 'error', 'Some Fields are Incorrect. !');
        }
    }

    public function delete($portal_id = '') {
        $this->_set_page_rule('D');
        //cek data
        if (empty($portal_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not Found !');
        }
        //parsing
        $data = array(
            'result' => $this->M_portal->get_by_id($portal_id),
        );
        //parsing and view content
        view(self::PAGE_URL . 'delete', $data);
    }

    public function delete_process() {
        $this->_set_page_rule('D');
        $portal_id = $this->input->post('portal_id', true);
        //cek data
        if (empty($portal_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not Found !');
        }
        $where = array(
            'portal_id' => $portal_id
        );
        //process
        if ($this->M_portal->delete('com_portal', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'success', 'Data deleted successfully');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $portal_id, 'error', 'Data failed to delete !');
        }
    }


}
