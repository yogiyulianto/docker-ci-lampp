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
        $this->form_validation->set_rules('category_id','Kategori Pelatihan','trim|required');
        $this->form_validation->set_rules('title','Title','trim|required');
        $this->form_validation->set_rules('content','Konten','trim|required');
        $this->form_validation->set_rules('meta_title','Meta Title','trim|required');
        $this->form_validation->set_rules('meta_keywords','Meta Keywords','trim|required');
        $this->form_validation->set_rules('meta_description','Meta Description','trim|required');
        $this->form_validation->set_rules('faqs_st','Status faqs','trim|required');
        if (empty($_FILES['image']['tmp_name'])){
            $this->form_validation->set_rules('image', 'Image', 'required');
        }
        // get last di role
        $chat_id = generate_id();
        // process
        if ($this->form_validation->run() !== FALSE) {
            if (!empty($_FILES['image']['tmp_name'])) {
                // upload config
                $config['upload_path'] = 'assets/images/blog/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = $chat_id . '_blog_' . date('Ymdhis');
                $this->tupload->initialize($config);
                // process upload images
                if ($this->tupload->do_upload_image('image', 128, false)) {
                    $data_upload = $this->tupload->data();
                    $file_name = 'assets/images/blog/'.$data_upload['file_name'];
                }
                $this->notification->send(self::PAGE_URL.'add', 'error',  $this->tupload->display_errors());
            }
            // update params
            $params = array(
                'chat_id' => $chat_id,
                'category_id' => $this->input->post('category_id',TRUE), 
                'title' => $this->input->post('title',TRUE), 
                'user_id' => $this->com_user('user_id'), 
                'content' => $this->input->post('content',TRUE), 
                'image' => (isset($file_name)) ? $file_name : '',
                'views' => 0, 
                'meta_title' => $this->input->post('meta_title',TRUE), 
                'meta_description' => $this->input->post('meta_description',TRUE),
                'meta_keywords' => $this->input->post('meta_keywords',TRUE), 
                'slug' => $this->slugify(html_escape($this->input->post('title',TRUE))), 
                'blog_st' => $this->input->post('blog_st',TRUE), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_faqs->insert('chat', $params)) {
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
        $this->form_validation->set_rules('answer','Jawaban','trim|required');
        // check data
        $chat_id = $this->input->post('chat_id',TRUE);
        if (empty($chat_id)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data not found !');
        }
        // process
        if ($this->form_validation->run() !== FALSE) {
            // update params
            $params = array(
                'answer' => $this->input->post('answer'),
                'answer_date' => date('Y-m-d H:i:s'), 
                'chat_st' => 'answered', 
                'dokter_id' => $this->com_user('user_id'), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // where
            $where = array(
                'chat_id' => $chat_id,
            );
            // insert
            if ($this->M_faqs->update('chat', $params, $where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil diubah!');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit' . $chat_id, 'error', 'Data gagal diubah!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/' . $chat_id, 'error', 'Ada Field Yang Tidak Sesuai. !');
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
        $chat_id = $this->input->post('chat_id',TRUE, true);
        //cek data
        if (empty($chat_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        $where = array(
            'chat_id' => $chat_id
        );
        //process
        if ($this->M_faqs->delete('chat', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil dihapus!');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $chat_id, 'error', 'Data gagal dihapus!');
        }
    }
}