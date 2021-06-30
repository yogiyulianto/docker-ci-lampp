<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Dashboard extends PrivateBase {

    const PAGE_TITLE = 'Dashboard';
    const PAGE_HEADER = 'Dashboard';
    const PAGE_URL = 'trainer/dashboard/';

    // constructor
    public function __construct() {
        parent::__construct();
        // CONST
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        $this->load->model('trainer/M_dashboard');
    }

    public function index() {
        // $this->_set_page_rule('R');
        // render view
        $data['total_income'] = $this->M_dashboard->get_my_income(array($this->com_user('user_id')));
        $data['total_students'] = $this->M_dashboard->get_my_students(array($this->com_user('user_id')));
        $data['total_courses'] = $this->M_dashboard->get_my_courses(array($this->com_user('user_id')));
        $data['rs_transactions'] = $this->M_dashboard->get_my_course_transactions(array($this->com_user('user_id')));
        view(self::PAGE_URL.'index',$data);
    }
}
