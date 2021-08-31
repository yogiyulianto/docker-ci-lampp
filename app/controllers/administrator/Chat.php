<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Chat extends PrivateBase {

    const PAGE_TITLE = 'Chat';
    const PAGE_HEADER = 'Chat';
    const PAGE_URL = 'administrator/chat/';

    protected $page_limit = 10;
    // constructor
    public function __construct() {
        parent::__construct();
        // CONST
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD MODEL
        $this->load->model('administrator/M_chat');
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
        $total_row = $this->M_chat->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_chat->get_all($from ,$config['per_page']);
        $data = array(
            'rs_id' => $rs_id,
            'pagination' => $this->pagination->create_links()
        );
        view(self::PAGE_URL . 'index', $data);
        // 
    }
    
    public function detail($chat_id) {
        $this->_set_page_rule('C');
        // get data & parse
        $data = array(
            'rs_id' => $this->M_chat->get_by_id($chat_id), 
            'chat_id' => $chat_id, 
        );
        // render view
        view(self::PAGE_URL . 'detail', $data);
    }

    // add process
    public function add_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('message','Message','trim|required');
        // get last di role
        $chat_id = $this->input->post('chat_id');
        // process
        if ($this->form_validation->run() !== FALSE) {
            $params = array(
                'dokter_id' => $this->com_user('user_id'),
                'chat_st' => 'process',
                'mdb' => $this->com_user('user_id'),
                'mdd' => date('Y-m-d H:i:s'),
            );
            $where = array(
                'chat_id' => $chat_id,
            );
            $update_chat = $this->M_chat->update('chat', $params, $where);
            // insert
            if ($update_chat) {
                $last_chat = $this->M_chat->get_last_by_id($chat_id);
                $chat_detail_id = uniqid();
                // insert detail chat
                $params = array(
                    'chat_detail_id' => $chat_detail_id,
                    'chat_id' => $chat_id,
                    'message' => $this->input->post('message'),
                    'message_date' => date('Y-m-d H:i:s'),
                    'order_by' => $last_chat['order_by'] + 1,
                    'message_type' => 'answer',
                    'mdb' => $this->com_user('user_id'),
                    'mdb_name' => $this->com_user('user_name'),
                    'mdd' => date('Y-m-d H:i:s'),
                );
                $insert_detail = $this->M_chat->insert('chat_detail', $params);
                if($insert_detail){
                    //sukses notif
                    $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil ditambahkan!');
                } else {
                    $this->notification->send(self::PAGE_URL.'add', 'error', 'Data gagal ditambahkan!');
                }
            } else {
                $this->notification->send(self::PAGE_URL.'add', 'error', 'Data gagal ditambahkan!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'add', 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }
    

    // edit process
    public function finish_process($chat_id) {
        $this->_set_page_rule('U');
        // cek input
        $params = array(
            'chat_st' => 'finish',
            'mdb' => $this->com_user('user_id'),
            'mdd' => date('Y-m-d H:i:s'),
        );
        $where = array(
            'chat_id' => $chat_id,
        );
        $update_chat = $this->M_chat->update('chat', $params, $where);
        if($update_chat){
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil diubah!');
        } else {
            $this->notification->send(self::PAGE_URL.'add', 'error', 'Data gagal diubah!');
        }
    }
}