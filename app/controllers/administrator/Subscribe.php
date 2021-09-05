<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Subscribe extends PrivateBase {

    const PAGE_TITLE = 'Subscribe';
    const PAGE_HEADER = 'Subscribe';
    const PAGE_URL = 'administrator/subscribe/';

    protected $page_limit = 10;
    // constructor
    public function __construct() {
        parent::__construct();
        // CONST
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD MODEL
        $this->load->model('administrator/M_subscribe');
        // LOAD LIBRARY
        $this->load->library('tupload');
    }

    public function index() {
        // PAGE RULES
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_subscribe->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_subscribe->get_all($from ,$config['per_page']);
        // print_r($rs_id);die;
        $data = array(
            'rs_id' => $rs_id,
            'pagination' => $this->pagination->create_links()
        );
        view(self::PAGE_URL . 'index', $data);
        // 
    }
    public function add() {
        $this->_set_page_rule('C');
        // get data & parse
        $data = array(
            'rs_user' => $this->M_subscribe->get_all_user(), 
        );
        // render view
        view(self::PAGE_URL . 'add', $data);
    }
    // add process
    public function add_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('start_date','Start Date','trim|required');
        $this->form_validation->set_rules('end_date','End Date','trim|required');
        $this->form_validation->set_rules('payment_st','Payment st','trim|required');
        // process
        if ($this->form_validation->run() !== FALSE) {
            // update params
            $params = array(
                'user_id' => $this->input->post('user_id',TRUE), 
                'enroll_date' => date('Y-m-d H:i:s'), 
                'start_date' => $this->input->post('start_date',TRUE), 
                'end_date' => $this->input->post('end_date', TRUE),  
                'payment_st' => $this->input->post('payment_st',TRUE), 
            );
            // insert
            if ($this->M_subscribe->insert('user_enroll', $params)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil ditambahkan!');
            } else {
                $this->notification->send(self::PAGE_URL.'add', 'error', 'Data gagal ditambahkan!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'add', 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }
    public function edit($id = '') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        //parsing
        $data = array(
            'rs_category' => $this->M_subscribe->get_all_category(), 
            'result' => $this->M_subscribe->get_by_id($id),
        );
        //parsing and view content
        view(self::PAGE_URL.'edit', $data);
    }

    // edit process
    public function edit_process() {
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('start_date','Start Date','trim|required');
        $this->form_validation->set_rules('end_date','End Date','trim|required');
        $this->form_validation->set_rules('payment_st','Payment st','trim|required');
        // check data
        $id = $this->input->post('id',TRUE);
        if (empty($id)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data not found !');
        }
        // process
        if ($this->form_validation->run() !== FALSE) {
            // update params
            $params = array(
                'start_date' => $this->input->post('start_date',TRUE), 
                'end_date' => $this->input->post('end_date'),  
                'payment_st' => $this->input->post('payment_st',TRUE), 
            );
            // where
            $where = array(
                'id' => $id,
            );
            // insert
            if ($this->M_subscribe->update('user_enroll', $params, $where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil diubah!');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit' . $id, 'error', 'Data gagal diubah!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/' . $id, 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

    public function delete($id = '') {
        $this->_set_page_rule('D');
        //cek data
        if (empty($id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        //parsing
        $data = array(
            'rs_category' => $this->M_subscribe->get_all_category(), 
            'result' => $this->M_subscribe->get_by_id($id),
        );
        //parsing and view content
        view(self::PAGE_URL . 'delete', $data);
    }

    public function delete_process() {
        $this->_set_page_rule('D');
        $id = $this->input->post('id',TRUE, true);
        //cek data
        if (empty($id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        $where = array(
            'id' => $id
        );
        //process
        if ($this->M_subscribe->delete('user_enroll', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil dihapus!');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $webinar_id, 'error', 'Data gagal dihapus!');
        }
    }
}