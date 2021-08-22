<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Faqs extends PrivateBase {

    const PAGE_TITLE = 'Faqs';
    const PAGE_HEADER = 'Faqs';
    const PAGE_URL = 'administrator/master/faqs/';

    protected $page_limit = 10;
    // constructor
    public function __construct() {
        parent::__construct();
        // CONST
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD MODEL
        $this->load->model('administrator/master/M_faqs');
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
        $total_row = $this->M_faqs->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_faqs->get_all($from ,$config['per_page']);
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
            'rs_category' => $this->M_faqs->get_all_category(), 
        );
        // render view
        view(self::PAGE_URL . 'add', $data);
    }
    // add process
    public function add_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('judul','Judul','trim|required');
        $this->form_validation->set_rules('isi','Isi','trim|required');
        $this->form_validation->set_rules('stat','Status','trim|required');
        // get last di role
        $chat_id = generate_id();
        // process
        if ($this->form_validation->run() !== FALSE) {
            // update params
            $params = array(
                'judul' => $this->input->post('judul',TRUE), 
                'isi' => $this->input->post('isi',TRUE), 
                'stat' => $this->input->post('stat',TRUE),
            );
            // insert
            if ($this->M_faqs->insert('faq', $params)) {
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
    public function edit($chat_id = '') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($chat_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        //parsing
        $data = array(
            'rs_category' => $this->M_faqs->get_all_category(), 
            'result' => $this->M_faqs->get_by_id($chat_id),
        );
        //parsing and view content
        view(self::PAGE_URL.'edit', $data);
    }

    // edit process
    public function edit_process() {
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('judul','Judul','trim|required');
        $this->form_validation->set_rules('isi','Isi','trim|required');
        $this->form_validation->set_rules('stat','Status','trim|required');
        // check data
        $id_faq = $this->input->post('id_faq',TRUE);
        if (empty($id_faq)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data not found !');
        }
        // process
        if ($this->form_validation->run() !== FALSE) {
            // update params
            $params = array(
                'judul' => $this->input->post('judul',TRUE), 
                'isi' => $this->input->post('isi',TRUE), 
                'stat' => $this->input->post('stat',TRUE),
            );
            // where
            $where = array(
                'id_faq' => $id_faq,
            );
            // insert
            if ($this->M_faqs->update('faq', $params, $where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil diubah!');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit' . $id_faq, 'error', 'Data gagal diubah!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/' . $id_faq, 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

    public function delete($chat_id = '') {
        $this->_set_page_rule('D');
        //cek data
        if (empty($chat_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        //parsing
        $data = array(
            'rs_category' => $this->M_faqs->get_all_category(), 
            'result' => $this->M_faqs->get_by_id($chat_id),
        );
        //parsing and view content
        view(self::PAGE_URL . 'delete', $data);
    }

    public function delete_process() {
        $this->_set_page_rule('D');
        $id_faq = $this->input->post('id_faq',TRUE, true);
        //cek data
        if (empty($id_faq)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        $where = array(
            'id_faq' => $id_faq
        );
        //process
        if ($this->M_faqs->delete('faq', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil dihapus!');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $id_faq, 'error', 'Data gagal dihapus!');
        }
    }
}