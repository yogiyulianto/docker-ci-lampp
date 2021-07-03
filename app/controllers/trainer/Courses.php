<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Courses extends PrivateBase {

    const PAGE_TITLE = 'Pelatihan';
    const PAGE_HEADER = 'Pelatihan';
    const PAGE_URL = 'trainer/courses/';
    const SESSION_SEARCH = 'search_courses_admin';

    protected $page_limit = 10;
    // constructor
    public function __construct() {
        parent::__construct();
        // CONST
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD MODEL
        $this->load->model('administrator/master/M_course');
        // LOAD LIBRARY
        $this->load->library('tupload');
    }
    // COURSE MASTER
    public function index() {
        // PAGE RULES
        $this->_set_page_rule('R');
        // get search
        $sess_search = $this->session->userdata(self::SESSION_SEARCH);
        // $search['category_id'] = $sess_search['category_id'];
        $search['fasilitator_id'] = $this->com_user('user_id');
        $search['course_st']    = $sess_search['course_st'];
        $search['sort_by']    = ($sess_search['sort_by']) ? $sess_search['sort_by'] : "mdd-desc";
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_course->get_total_courses($search);
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = $this->uri->segment(4,0);
        $this->pagination->initialize($config);
        // params 
        $limit = array((int)$from,$config['per_page']);
        //get data
        $data['rs_id'] = $this->M_course->get_all($search,$limit);
        // $data['rs_category'] = $this->M_course->get_all_category();
        //$data['rs_teacher'] = $this->M_course->get_all_teacher();
        $data['rs_search'] = $search;
        $data['pagination'] = $this->pagination->create_links();

        view(self::PAGE_URL . 'index', $data);
    }

    public function search_process()
    {
        $this->_set_page_rule('R');
        if ($this->input->post('search', true) == "submit") {
            $params = array(
                'category_id' => $this->input->post('category_id',TRUE),
                'fasilitator_id' => $this->input->post('fasilitator_id',TRUE),
                'course_st'    => $this->input->post('course_st',TRUE),
                'sort_by'    => $this->input->post('sort_by',TRUE),
            );
            $this->session->set_userdata(self::SESSION_SEARCH, $params);
        } else {
            $this->session->unset_userdata(self::SESSION_SEARCH);
        }
        redirect(self::PAGE_URL);
    }

}
