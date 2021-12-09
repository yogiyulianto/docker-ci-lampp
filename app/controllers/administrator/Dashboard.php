<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Dashboard extends PrivateBase {

    const PAGE_TITLE = 'Dashboard';
    const PAGE_HEADER = 'Dashboard';
    const PAGE_URL = 'administrator/dashboard/';

    // constructor
    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // load model
        $this->load->model('administrator/M_dashboard');
    }

    public function index() {
        // set page rules
        $this->_set_page_rule('R');
        // get data
        $total_materi      = 0;
        $total_kehamilan        = 0;
        $total_konsultasi        = 0;
        $total_users       = 0;
        // render view
        return view(self::PAGE_URL.'index',compact(['total_materi','total_kehamilan','total_konsultasi','total_users']));
    }
}
