<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Blog extends PrivateBase {

    const PAGE_TITLE = 'Blog';
    const PAGE_HEADER = 'Blogs';
    const PAGE_URL = 'administrator/content/blog/';

    protected $page_limit = 10;
    // constructor
    public function __construct() {
        parent::__construct();
        // CONST
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD MODEL
        $this->load->model('administrator/M_blog');
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
        $total_row = $this->M_blog->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_blog->get_all($from ,$config['per_page']);
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
            'rs_category' => $this->M_blog->get_all_category(), 
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
        $this->form_validation->set_rules('blog_st','Status Blog','trim|required');
        $this->form_validation->set_rules('is_weekly_content','Is Weekly Content','trim|required');
        $this->form_validation->set_rules('weekly_content','Weekly Content','trim');
        if (empty($_FILES['image']['tmp_name'])){
            $this->form_validation->set_rules('image', 'Image', 'required');
        }
        // get last di role
        $blog_id = generate_id();
        // process
        if ($this->form_validation->run() !== FALSE) {
            if (!empty($_FILES['image']['tmp_name'])) {
                // upload config
                $config['upload_path'] = 'assets/images/blog/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = $blog_id . '_blog_' . date('Ymdhis');
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
                'blog_id' => $blog_id,
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
                'pricing_st' => $this->input->post('pricing_st',TRUE), 
                'is_weekly_content' => $this->input->post('is_weekly_content',TRUE), 
                'weekly_content' => $this->input->post('weekly_content',TRUE), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_blog->insert('blogs', $params)) {
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
    public function edit($blog_id = '') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($blog_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        //parsing
        $data = array(
            'rs_category' => $this->M_blog->get_all_category(), 
            'result' => $this->M_blog->get_by_id($blog_id),
        );
        //parsing and view content
        view(self::PAGE_URL.'edit', $data);
    }

    // edit process
    public function edit_process() {
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('category_id','Kategori Pelatihan','trim|required');
        $this->form_validation->set_rules('title','Title','trim|required');
        $this->form_validation->set_rules('content','Konten','trim|required');
        $this->form_validation->set_rules('meta_title','Meta Title','trim|required');
        $this->form_validation->set_rules('meta_keywords','Meta Keywords','trim|required');
        $this->form_validation->set_rules('meta_description','Meta Description','trim|required');
        $this->form_validation->set_rules('blog_st','Status Blog','trim|required');
        $this->form_validation->set_rules('is_weekly_content','Is Weekly Content','trim|required');
        $this->form_validation->set_rules('weekly_content','Weekly Content','trim');
        if (empty($_FILES['image']['tmp_name'])){
            $this->form_validation->set_rules('image', 'Image', 'required');
        }
        // check data
        $blog_id = $this->input->post('blog_id',TRUE);
        if (empty($blog_id)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data not found !');
        }
        // process
        if ($this->form_validation->run() !== FALSE) {
            if (!empty($_FILES['image']['tmp_name'])) {
                // upload config
                $config['upload_path'] = 'assets/images/blog/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = $blog_id . '_blog_' . date('Ymdhis');
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
                'blog_id' => $blog_id,
                'category_id' => $this->input->post('category_id',TRUE), 
                'title' => $this->input->post('title',TRUE), 
                'user_id' => $this->com_user('user_id'), 
                'content' => $this->input->post('content',TRUE), 
                'image' => (isset($file_name)) ? $file_name : $this->input->post('image',TRUE),
                'meta_title' => $this->input->post('meta_title',TRUE), 
                'meta_description' => $this->input->post('meta_description',TRUE),
                'meta_keywords' => $this->input->post('meta_keywords',TRUE), 
                'blog_st' => $this->input->post('blog_st',TRUE), 
                'pricing_st' => $this->input->post('pricing_st',TRUE), 
                'is_weekly_content' => $this->input->post('is_weekly_content',TRUE), 
                'weekly_content' => $this->input->post('weekly_content',TRUE), 
                'slug' => slugify(html_escape($this->input->post('title',TRUE))), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // where
            $where = array(
                'blog_id' => $blog_id,
            );
            // insert
            if ($this->M_blog->update('blogs', $params, $where)) {
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

    public function delete($blog_id = '') {
        $this->_set_page_rule('D');
        //cek data
        if (empty($blog_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        //parsing
        $data = array(
            'rs_category' => $this->M_blog->get_all_category(), 
            'result' => $this->M_blog->get_by_id($blog_id),
        );
        //parsing and view content
        view(self::PAGE_URL . 'delete', $data);
    }

    public function delete_process() {
        $this->_set_page_rule('D');
        $blog_id = $this->input->post('blog_id',TRUE, true);
        //cek data
        if (empty($blog_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        $where = array(
            'blog_id' => $blog_id
        );
        //process
        if ($this->M_blog->delete('blogs', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil dihapus!');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $blog_id, 'error', 'Data gagal dihapus!');
        }
    }
}