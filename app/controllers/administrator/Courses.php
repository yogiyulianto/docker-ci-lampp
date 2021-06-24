<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Courses extends PrivateBase {

    const PAGE_TITLE = 'Pelatihan';
    const PAGE_HEADER = 'Pelatihan';
    const PAGE_URL = 'administrator/courses/';
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
		$this->load->model('administrator/master/M_course', 'course');

        // LOAD LIBRARY
        $this->load->library('tupload');
    }
    // COURSE MASTER
    public function index() {
		// error_reporting(0);
        // PAGE RULES
        $this->_set_page_rule('R');
        // get search
        $sess_search = $this->session->userdata(self::SESSION_SEARCH);
        $search['category_id'] = $sess_search['category_id'];
        $search['teacher_id'] = $sess_search['teacher_id'];
        $search['course_st']    = $sess_search['course_st'];
        $search['sort_by']    = ($sess_search['sort_by']) ? $sess_search['sort_by'] : "title-asc";
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->course->get_total_courses($search);
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = $this->uri->segment(4,0);
        $this->pagination->initialize($config);
        // params 
        $limit = array((int)$from,$config['per_page']);
        //get data
        $data['rs_id'] = $this->course->get_all($search,$limit);
        $data['rs_search'] = $search;
        $data['pagination'] = $this->pagination->create_links();

        view(self::PAGE_URL . 'index', $data);
    }

	// ASSIGNMENT
    public function assignment($course_id){
        // PAGE RULES
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->course->get_total_assignment_by_course_id(array($course_id));
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $this->pagination->initialize($config);
        // params 
        $params = array($course_id,(int)$from,$config['per_page']);
        //get data 
        $rs_id = $this->course->get_assignment_by_course_id($params);
        $data = array(
            'rs_id' => $rs_id,
            'pagination' => $this->pagination->create_links()
        );
        view(self::PAGE_URL . 'assignment_process/index', $data);
    }

    public function assignment_detail($lesson_id){
        // PAGE RULES
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->course->get_total_enrol_by_lesson_id(array($lesson_id));
        $config['base_url'] = base_url(self::PAGE_URL.'assignment_detail/'.$lesson_id.'/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $config['uri_segment'] = 5;
        $from = $this->uri->segment(5,0);
        $this->pagination->initialize($config);
        // params 
        $params = array($lesson_id,(int)$from,$config['per_page']);
        //get data 
        $rs_id = $this->course->get_all_enrol_by_lesson_id($params);
        $data = array(
            'rs_id' => $rs_id,
            'pagination' => $this->pagination->create_links()
        );
        view(self::PAGE_URL . 'assignment_process/detail', $data);
    }
    public function assignment_detail_process($assignment_id){
        $this->_set_page_rule('U');
        //cek data
        if (empty($assignment_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        $rs_assignment = $this->course->get_detail_assignment_by_assignment_id(array($assignment_id));
        //parsing
        $data = array(
            'assignment_id' => $assignment_id,
            'rs_assignment' => $rs_assignment
        );
        //parsing and view content
        view(self::PAGE_URL.'assignment_process/detail-process', $data);
    }

    public function update_nilai_process(){
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('nilai','Nilai','trim|required');
        // get id
        $assignment_id = $this->input->post('assignment_id', TRUE);
        $lesson_id = $this->input->post('lesson_id', TRUE);
        // process
        if ($this->form_validation->run() !== false) {
            // update params
            $params = array(
                'nilai' => $this->input->post('nilai', true),
                'catatan' => $this->input->post('catatan', true),
            );
            $where = array(
                'assignment_id' => $assignment_id
            );
            // update
            if ($this->course->update('course_assignment', $params, $where)) {
                    //sukses notif
                    $this->notification->send(self::PAGE_URL.'assignment_detail/'.$lesson_id, 'success', 'Data berhasil diubah!');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'assignment_detail/'.$lesson_id, 'error', 'Ada Field Yang Tidak Sesuai. !');
            }
        }
    }
}
