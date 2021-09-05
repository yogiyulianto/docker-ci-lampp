<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Webinar extends PrivateBase {

    const PAGE_TITLE = 'Webinar';
    const PAGE_HEADER = 'Webinar';
    const PAGE_URL = 'administrator/content/webinar/';

    protected $page_limit = 10;
    // constructor
    public function __construct() {
        parent::__construct();
        // CONST
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD MODEL
        $this->load->model('administrator/M_webinar');
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
        $total_row = $this->M_webinar->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_webinar->get_all($from ,$config['per_page']);
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
            'rs_category' => $this->M_webinar->get_all_category(), 
        );
        // render view
        view(self::PAGE_URL . 'add', $data);
    }
    // add process
    public function add_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('title','Title','trim|required');
        $this->form_validation->set_rules('description','Deskripsi','trim|required');
        $this->form_validation->set_rules('link','Link','trim|required');
        $this->form_validation->set_rules('jadwal','Jadwal','trim|required');
        $this->form_validation->set_rules('webinar_st','Status webinar','trim|required');
        $this->form_validation->set_rules('pricing_st','Kategori webinar','trim|required');
        if (empty($_FILES['image']['tmp_name'])){
            $this->form_validation->set_rules('image', 'Image', 'required');
        }
        // get last di role
        $webinar_id = time().'-'.mt_rand();
        // process
        if ($this->form_validation->run() !== FALSE) {
            if (!empty($_FILES['image']['tmp_name'])) {
                // upload config
                $config['upload_path'] = 'assets/images/webinar/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = $webinar_id . '_webinar_' . date('Ymdhis');
                $this->tupload->initialize($config);
                // process upload images
                if ($this->tupload->do_upload_image('image', 128, false)) {
                    $data_upload = $this->tupload->data();
                    $file_name = 'assets/images/webinar/'.$data_upload['file_name'];
                }
                $this->notification->send(self::PAGE_URL.'add', 'error',  $this->tupload->display_errors());
            }
            // update params
            $params = array(
                'webinar_id' => $webinar_id,
                'title' => $this->input->post('title',TRUE), 
                'description' => $this->input->post('description'),  
                'image' => (isset($file_name)) ? $file_name : '',
                'link' => $this->input->post('link',TRUE), 
                'jadwal' => $this->input->post('jadwal',TRUE),
                'webinar_st' => $this->input->post('webinar_st',TRUE), 
                'pricing_st' => $this->input->post('pricing_st',TRUE), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_webinar->insert('webinar', $params)) {
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
    public function edit($webinar_id = '') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($webinar_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        //parsing
        $data = array(
            'rs_category' => $this->M_webinar->get_all_category(), 
            'result' => $this->M_webinar->get_by_id($webinar_id),
        );
        //parsing and view content
        view(self::PAGE_URL.'edit', $data);
    }

    // edit process
    public function edit_process() {
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('title','Title','trim|required');
        $this->form_validation->set_rules('description','Deskripsi','trim|required');
        $this->form_validation->set_rules('link','Link','trim|required');
        $this->form_validation->set_rules('jadwal','Jadwal','trim|required');
        $this->form_validation->set_rules('webinar_st','Status webinar','trim|required');
        $this->form_validation->set_rules('pricing_st','Kategori webinar','trim|required');
        if (empty($_FILES['image']['tmp_name'])){
            $this->form_validation->set_rules('image', 'Image', 'required');
        }
        // check data
        $webinar_id = $this->input->post('webinar_id',TRUE);
        if (empty($webinar_id)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data not found !');
        }
        // process
        if ($this->form_validation->run() !== FALSE) {
            if (!empty($_FILES['image']['tmp_name'])) {
                // upload config
                $config['upload_path'] = 'assets/images/webinar/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = $webinar_id . '_webinar_' . date('Ymdhis');
                $this->tupload->initialize($config);
                // process upload images
                if ($this->tupload->do_upload_image('image', 128, false)) {
                    $data_upload = $this->tupload->data();
                    $file_name = 'assets/images/webinar/'.$data_upload['file_name'];
                }
                $this->notification->send(self::PAGE_URL.'add', 'error',  $this->tupload->display_errors());
            }
            // update params
            $params = array(
                'title' => $this->input->post('title',TRUE), 
                'description' => $this->input->post('description'),  
                'image' => (isset($file_name)) ? $file_name : '',
                'link' => $this->input->post('link',TRUE), 
                'jadwal' => $this->input->post('jadwal',TRUE),
                'webinar_st' => $this->input->post('webinar_st',TRUE), 
                'pricing_st' => $this->input->post('pricing_st',TRUE), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // where
            $where = array(
                'webinar_id' => $webinar_id,
            );
            // insert
            if ($this->M_webinar->update('webinar', $params, $where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil diubah!');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit' . $webinar_id, 'error', 'Data gagal diubah!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/' . $webinar_id, 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

    public function delete($webinar_id = '') {
        $this->_set_page_rule('D');
        //cek data
        if (empty($webinar_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        //parsing
        $data = array(
            'rs_category' => $this->M_webinar->get_all_category(), 
            'result' => $this->M_webinar->get_by_id($webinar_id),
        );
        //parsing and view content
        view(self::PAGE_URL . 'delete', $data);
    }

    public function delete_process() {
        $this->_set_page_rule('D');
        $webinar_id = $this->input->post('webinar_id',TRUE, true);
        //cek data
        if (empty($webinar_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        $where = array(
            'webinar_id' => $webinar_id
        );
        //process
        if ($this->M_webinar->delete('webinar', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil dihapus!');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $webinar_id, 'error', 'Data gagal dihapus!');
        }
    }
}