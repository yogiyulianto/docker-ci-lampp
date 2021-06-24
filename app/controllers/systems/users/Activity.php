<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Activity extends PrivateBase {

    const PAGE_TITLE = 'User Log';
    const PAGE_HEADER = 'User Log';
    const PAGE_URL = 'systems/users/activity/';
    protected $page_limit = 10;

    // constructor
    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD MODEL
        $this->load->model('settings/M_log');
    }

    public function index() {
        // PAGE RULES
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_log->count_user_log($this->com_user('user_id'));
        $config['base_url'] = base_url(self::PAGE_URL . 'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_log->get_user_log(array((int)$from,$config['per_page']));
        $data = array(
            'rs_id' => $rs_id,
            'pagination' => $this->pagination->create_links()
        );
        view(self::PAGE_URL . 'index', $data);
        // 
    }

    public function detail($user_id) {
        // PAGE RULES
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_log->count_user_log_by_id(array($this->com_user('user_id')));
        $config['base_url'] = base_url(self::PAGE_URL .'detail/'.$user_id.'/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $config['use_page_numbers'] = TRUE;  
        $from =  ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
        $this->pagination->initialize($config);
        //get data 
        $params = array($user_id,(int)$from,$config['per_page']);
        $rs_id = $this->M_log->get_user_log_by_id($params);

        $data = array(
            'rs_id' => $rs_id,
            'pagination' => $this->pagination->create_links()
        );
        view(self::PAGE_URL . 'detail', $data); 
    }

}
