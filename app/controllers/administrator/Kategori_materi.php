<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Kategori_materi extends PrivateBase {

    const PAGE_TITLE = 'Kategori Materi';
    const PAGE_HEADER = 'Kategori Materi';
    const PAGE_URL = 'administrator/kategori_materi/';

    protected $page_limit = 10;
    // constructor
    public function __construct() {
        parent::__construct();
        // CONST
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD MODEL
        $this->load->model('administrator/M_kategori_materi');
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
        $total_row = $this->M_kategori_materi->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_kategori_materi->get_all($from ,$config['per_page']);
        $data = array(
            'rs_id' => $rs_id,
            'pagination' => $this->pagination->create_links()
        );
        view(self::PAGE_URL . 'index', $data);
        // 
    }
    public function add() {
        $this->_set_page_rule('C');
        // render view
        view(self::PAGE_URL . 'add');
    }
    // add process
    public function add_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('deskripsi','Deskripsi','trim|required');
        // process
        if ($this->form_validation->run() !== FALSE) {
            // update params
            $params = array(
                'deskripsi' => $this->input->post('deskripsi',TRUE), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_kategori_materi->insert('kategori_materi', $params)) {
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
    public function edit($id_kategori = '') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($id_kategori)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        //parsing
        $data = array(
            'result' => $this->M_kategori_materi->get_by_id($id_kategori),
        );
        //parsing and view content
        view(self::PAGE_URL.'edit', $data);
    }

    // edit process
    public function edit_process() {
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('deskripsi','Deskripsi','trim|required');
        // check data
        $id_kategori = $this->input->post('id_kategori',TRUE);
        if (empty($id_kategori)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data not found !');
        }
        // process
        if ($this->form_validation->run() !== FALSE) {
            // update params
            $params = array(
                'deskripsi' => $this->input->post('deskripsi',TRUE), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // where
            $where = array(
                'id_kategori' => $id_kategori,
            );
            // insert
            if ($this->M_kategori_materi->update('kategori_materi', $params, $where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil diubah!');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit' . $id_kategori, 'error', 'Data gagal diubah!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/' . $id_kategori, 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

    public function delete($id_kategori = '') {
        $this->_set_page_rule('D');
        //cek data
        if (empty($id_kategori)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        //parsing
        $data = array(
            'result' => $this->M_kategori_materi->get_by_id($id_kategori),
        );
        //parsing and view content
        view(self::PAGE_URL . 'delete', $data);
    }

    public function delete_process() {
        $this->_set_page_rule('D');
        $id_kategori = $this->input->post('id_kategori',TRUE, true);
        //cek data
        if (empty($id_kategori)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        $where = array(
            'id_kategori' => $id_kategori
        );
        //process
        if ($this->M_kategori_materi->delete('kategori_materi', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil dihapus!');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $id_kategori, 'error', 'Data gagal dihapus!');
        }
    }
}