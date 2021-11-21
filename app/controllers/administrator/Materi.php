<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Materi extends PrivateBase {

    const PAGE_TITLE = 'Materi';
    const PAGE_HEADER = 'Materi';
    const PAGE_URL = 'administrator/materi/';

    protected $page_limit = 10;
    // constructor
    public function __construct() {
        parent::__construct();
        // CONST
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD MODEL
        $this->load->model('administrator/M_materi');
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
        $total_row = $this->M_materi->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_materi->get_all($from ,$config['per_page']);
        $data = array(
            'rs_id' => $rs_id,
            'pagination' => $this->pagination->create_links()
        );
        view(self::PAGE_URL . 'index', $data);
        // 
    }
    public function add() {
        $this->_set_page_rule('C');
        $data = array(
            'rs_category' => $this->M_materi->get_all_category(), 
        );
        // render view
        view(self::PAGE_URL . 'add', $data);
    }
    // add process
    public function add_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('title','Title','trim|required');
        $this->form_validation->set_rules('subtitle','Subtitle','trim|required');
        $this->form_validation->set_rules('content','Konten','trim|required');
        $this->form_validation->set_rules('id_kategori','Kategori','trim|required');
        // process
        if ($this->form_validation->run() !== FALSE) {
            if(!empty($_FILES['img']['tmp_name'])) {
                // upload config
                $config['upload_path'] = 'assets/images/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = 'images_' . date('Ymdhis');
                $this->tupload->initialize($config);
                // process upload images
                if ($this->tupload->do_upload_image('img', 128, false)) {
                    $data_upload = $this->tupload->data();
                    $file_name = base_url() . 'assets/images/'.$data_upload['file_name'];
                }
                $this->notification->send(self::PAGE_URL.'add', 'error',  $this->tupload->display_errors());
            }
            // update params
            $params = array(
                'title' => $this->input->post('title',TRUE), 
                'subtitle' => $this->input->post('subtitle',TRUE), 
                'description' => $this->input->post('content',TRUE), 
                'id_kategori' => $this->input->post('id_kategori',TRUE), 
                'image_url' => (isset($file_name)) ? $file_name : '',
                'order_no' => $this->input->post('order_no',TRUE), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_materi->insert('materi', $params)) {
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
            'result' => $this->M_materi->get_by_id($id),
            'rs_category' => $this->M_materi->get_all_category(),
        );
        //parsing and view content
        view(self::PAGE_URL.'edit', $data);
    }

    // edit process
    public function edit_process() {
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('title','Title','trim|required');
        $this->form_validation->set_rules('subtitle','Subtitle','trim|required');
        $this->form_validation->set_rules('content','Konten','trim');
        $this->form_validation->set_rules('id_kategori','Kategori','trim|required');
        // check data
        $id = $this->input->post('id',TRUE);
        if (empty($id)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data not found !');
        }
        // process
        if ($this->form_validation->run() !== FALSE) {
            if(!empty($_FILES['img']['tmp_name'])) {
                // upload config
                $config['upload_path'] = 'assets/images/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = 'images_' . date('Ymdhis');
                $this->tupload->initialize($config);
                // process upload images
                if ($this->tupload->do_upload_image('img', 128, false)) {
                    $data_upload = $this->tupload->data();
                    $file_name = base_url() . 'assets/images/'.$data_upload['file_name'];
                }
                $this->notification->send(self::PAGE_URL.'add', 'error',  $this->tupload->display_errors());
            }
            // update params
            $params = array(
                'title' => $this->input->post('title',TRUE), 
                'subtitle' => $this->input->post('subtitle',TRUE), 
                'description' => $this->input->post('content',TRUE),
                'id_kategori' => $this->input->post('id_kategori',TRUE), 
                'image_url' => (isset($file_name)) ? $file_name : '',
                'order_no' => $this->input->post('order_no',TRUE), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // where
            $where = array(
                'id' => $id,
            );
            // insert
            if ($this->M_materi->update('materi', $params, $where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil diubah!');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit' . $blog_id, 'error', 'Data gagal diubah!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/' . $blog_id, 'error', 'Ada Field Yang Tidak Sesuai. !');
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
            'result' => $this->M_materi->get_by_id($id),
            'rs_category' => $this->M_materi->get_all_category(),
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
        if ($this->M_materi->delete('materi', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil dihapus!');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $blog_id, 'error', 'Data gagal dihapus!');
        }
    }
}