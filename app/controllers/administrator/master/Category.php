<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Category extends PrivateBase {

    const PAGE_TITLE = 'Category';
    const PAGE_HEADER = 'Category';
    const PAGE_URL = 'administrator/master/category/';

    protected $page_limit = 10;
    // constructor
    public function __construct() {
        parent::__construct();
        // CONST
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD MODEL
        $this->load->model('administrator/master/M_category');
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
        $total_row = $this->M_category->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_category->get_all($from ,$config['per_page']);
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
            'rs_category' => $this->M_category->get_all_category(), 
        );
        // render view
        view(self::PAGE_URL . 'add', $data);
    }
    // add process
    public function add_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('title','Title','trim|required');
        $this->form_validation->set_rules('icon','Konten','trim|required');
        if (empty($_FILES['image']['tmp_name'])){
            $this->form_validation->set_rules('image', 'Image', 'required');
        }
        // get last di role
        $category_id = $this->M_category->get_last_id();
        // process
        if ($this->form_validation->run() !== FALSE) {
            if (!empty($_FILES['image']['tmp_name'])) {
                // upload config
                $config['upload_path'] = 'assets/images/category/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = $category_id . '_category_' . date('Ymdhis');
                $this->tupload->initialize($config);
                // process upload images
                if ($this->tupload->do_upload_image('image', 128, false)) {
                    $data_upload = $this->tupload->data();
                    $file_name = 'assets/images/category/'.$data_upload['file_name'];
                }
                $this->notification->send(self::PAGE_URL.'add', 'error',  $this->tupload->display_errors());
            }
            // update params
            $params = array(
                'category_id' => $category_id,
                'parent_id' => 001,
                'icon' => $this->input->post('icons',TRUE), 
                'title' => $this->input->post('title',TRUE), 
                'thumbnail' => (isset($file_name)) ? $file_name : '',
                'slug' => $this->slugify(html_escape($this->input->post('title',TRUE))), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_category->insert('category', $params)) {
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
    public function edit($category_id = '') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($category_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        //parsing
        $data = array(
            'rs_category' => $this->M_category->get_all_category(), 
            'result' => $this->M_category->get_by_id($category_id),
        );
        //parsing and view content
        view(self::PAGE_URL.'edit', $data);
    }

    // edit process
    public function edit_process() {
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('title','Title','trim|required');
        $this->form_validation->set_rules('icon','Icon','trim|required');
        // cek files
        if (empty($_FILES['image']['tmp_name'])){
            $this->form_validation->set_rules('image', 'Image', 'trim');
        }
        // check data
        $category_id = $this->input->post('category_id',TRUE);
        if (empty($category_id)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data not found !');
        }
        // process
        if ($this->form_validation->run() !== FALSE) {
            if (!empty($_FILES['image']['tmp_name'])) {
                // upload config
                $config['upload_path'] = 'assets/images/category/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = $category_id . '_category_' . date('Ymdhis');
                $this->tupload->initialize($config);
                // process upload images
                if ($this->tupload->do_upload_image('image', 128, false)) {
                    $data_upload = $this->tupload->data();
                    $file_name = 'assets/images/category/'.$data_upload['file_name'];
                }
                $this->notification->send(self::PAGE_URL.'add', 'error',  $this->tupload->display_errors());

                 // update params
                $params = array(
                    'category_id' => $category_id,
                    'parent_id' => 001,
                    'icon' => $this->input->post('icon',TRUE), 
                    'title' => $this->input->post('title',TRUE), 
                    'thumbnail' => (isset($file_name)) ? $file_name : $this->input->post('image',TRUE),
                    'slug' => $this->slugify(html_escape($this->input->post('title',TRUE))), 
                    'mdb' => $this->com_user('user_id'),
                    'mdb_name' => $this->com_user('user_name'),
                    'mdd' => now(),
                );
            } else {
                $params = array(
                    'category_id' => $category_id,
                    'parent_id' => 001,
                    'icon' => $this->input->post('icon',TRUE), 
                    'title' => $this->input->post('title',TRUE), 
                    'slug' => $this->slugify(html_escape($this->input->post('title',TRUE))), 
                    'mdb' => $this->com_user('user_id'),
                    'mdb_name' => $this->com_user('user_name'),
                    'mdd' => now(),
                );
            }
            // where
            $where = array(
                'category_id' => $category_id,
            );
            // insert
            if ($this->M_category->update('category', $params, $where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil diubah!');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit' . $category_id, 'error', 'Data gagal diubah!');
            }
        } else {
            print_r(validation_errors());doe;
            // default error
            $this->notification->send(self::PAGE_URL.'edit/' . $category_id, 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

    public function delete($category_id = '') {
        $this->_set_page_rule('D');
        //cek data
        if (empty($category_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        //parsing
        $data = array(
            'rs_category' => $this->M_category->get_all_category(), 
            'result' => $this->M_category->get_by_id($category_id),
        );
        //parsing and view content
        view(self::PAGE_URL . 'delete', $data);
    }

    public function delete_process() {
        $this->_set_page_rule('D');
        $category_id = $this->input->post('category_id',TRUE, true);
        //cek data
        if (empty($category_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        $where = array(
            'category_id' => $category_id
        );
        //process
        if ($this->M_category->delete('category', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil dihapus!');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $category_id, 'error', 'Data gagal dihapus!');
        }
    }
}