<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Audio extends PrivateBase {

    const PAGE_TITLE = 'Audio';
    const PAGE_HEADER = 'Audio';
    const PAGE_URL = 'administrator/content/audio/';

    protected $page_limit = 10;
    // constructor
    public function __construct() {
        parent::__construct();
        // CONST
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD MODEL
        $this->load->model('administrator/M_audio');
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
        $total_row = $this->M_audio->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_audio->get_all($from ,$config['per_page']);
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
            'rs_category' => $this->M_audio->get_all_category(), 
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
        $this->form_validation->set_rules('audio_st','Status audio','trim|required');
        if (empty($_FILES['image']['tmp_name'])){
            $this->form_validation->set_rules('image', 'Image', 'required');
        }
        // get last di role
        $audio_id = generate_id().date('His');
        // process
        if ($this->form_validation->run() !== FALSE) {
            if (!empty($_FILES['image']['tmp_name'])) {
                // upload config
                $config['upload_path'] = 'assets/images/audio/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = $audio_id . '_audio_' . date('Ymdhis');
                $this->tupload->initialize($config);
                // process upload images
                if ($this->tupload->do_upload_image('image', 128, false)) {
                    $data_upload = $this->tupload->data();
                    $file_name = 'assets/images/audio/'.$data_upload['file_name'];
                }
                $this->notification->send(self::PAGE_URL.'add', 'error',  $this->tupload->display_errors());
            }

            if (!empty($_FILES['audio']['tmp_name'])) {
                // upload config
                $config_audio['upload_path'] = 'assets/audio/';
                $config_audio['allowed_types'] = 'mp3';
                $config_audio['file_name'] = $audio_id . '_audio_' . date('Ymdhis');
                $this->load->library('upload', $config_audio);
                // process upload images
                if ($this->upload->do_upload('audio')) {
                    $data_upload_audio = $this->upload->data();
                    $file_name_audio = 'assets/audio/'.$data_upload_audio['file_name'];
                }
                $this->notification->send(self::PAGE_URL.'add', 'error',  $this->upload->display_errors());
            }
            // update params
            $params = array(
                'audio_id' => $audio_id,
                'category_id' => $this->input->post('category_id',TRUE), 
                'title' => $this->input->post('title',TRUE), 
                'image' => (isset($file_name)) ? $file_name : '',
                'path' => (isset($file_name_audio)) ? $file_name_audio : '',
                'views' => 0, 
                'slug' => $this->slugify(html_escape($this->input->post('title',TRUE))), 
                'audio_st' => $this->input->post('audio_st',TRUE), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_audio->insert('audio', $params)) {
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
    public function edit($audio_id = '') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($audio_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        //parsing
        $data = array(
            'rs_category' => $this->M_audio->get_all_category(), 
            'result' => $this->M_audio->get_by_id($audio_id),
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
        $this->form_validation->set_rules('audio_st','Status audio','trim|required');
        if (empty($_FILES['image']['tmp_name'])){
            $this->form_validation->set_rules('image', 'Image', 'trim');
            $this->form_validation->set_rules('audio', 'audio', 'trim');
        }
        // check data
        $audio_id = $this->input->post('audio_id',TRUE);
        if (empty($audio_id)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data not found !');
        }
        // process
        if ($this->form_validation->run() !== FALSE) {
            // update params
            $params = array(
                'audio_id' => $audio_id,
                'category_id' => $this->input->post('category_id',TRUE), 
                'title' => $this->input->post('title',TRUE), 
                'views' => 0, 
                'slug' => $this->slugify(html_escape($this->input->post('title',TRUE))), 
                'audio_st' => $this->input->post('audio_st',TRUE), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            if (!empty($_FILES['image']['tmp_name'])) {
                // upload config
                $config['upload_path'] = 'assets/images/audio/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = $audio_id . '_audio_' . date('Ymdhis');
                $this->tupload->initialize($config);
                // process upload images
                if ($this->tupload->do_upload_image('image', 128, false)) {
                    $data_upload = $this->tupload->data();
                    $file_name = 'assets/images/audio/'.$data_upload['file_name'];
                }
                $params['image'] = $file_name;
                $this->notification->send(self::PAGE_URL.'add', 'error',  $this->tupload->display_errors());
            }

            if (!empty($_FILES['audio']['tmp_name'])) {
                // upload config
                $config_audio['upload_path'] = 'assets/audio/';
                $config_audio['allowed_types'] = '*';
                $config_audio['file_name'] = $audio_id . '_audio_' . date('Ymdhis');
                $this->load->library('upload', $config_audio);
                // process upload images
                if ($this->upload->do_upload('audio')) {
                    $data_upload_audio = $this->upload->data();
                    $file_name_audio = 'assets/audio/'.$data_upload_audio['file_name'];
                }
                $params['path'] = $file_name_audio;
                $this->notification->send(self::PAGE_URL.'add', 'error',  $this->upload->display_errors());
            }
            // print_r($params);die;
            // where
            $where = array(
                'audio_id' => $audio_id,
            );
            // insert
            if ($this->M_audio->update('audio', $params, $where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil diubah!');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit' . $audio_id, 'error', 'Data gagal diubah!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/' . $audio_id, 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

    public function delete($audio_id = '') {
        $this->_set_page_rule('D');
        //cek data
        if (empty($audio_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        //parsing
        $data = array(
            'rs_category' => $this->M_audio->get_all_category(), 
            'result' => $this->M_audio->get_by_id($audio_id),
        );
        //parsing and view content
        view(self::PAGE_URL . 'delete', $data);
    }

    public function delete_process() {
        $this->_set_page_rule('D');
        $audio_id = $this->input->post('audio_id',TRUE, true);
        //cek data
        if (empty($audio_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        $where = array(
            'audio_id' => $audio_id
        );
        //process
        if ($this->M_audio->delete('audio', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil dihapus!');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $audio_id, 'error', 'Data gagal dihapus!');
        }
    }
}