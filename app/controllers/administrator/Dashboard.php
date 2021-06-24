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
        $total_jenis_treatment      = $this->M_dashboard->get_total_jenis_treatment();
        $total_order                = $this->M_dashboard->get_total_order();
        $total_perawat              = $this->M_dashboard->get_total_perawat();
        $total_pasien               = $this->M_dashboard->get_total_pasien();
        $rs_last_order              = $this->M_dashboard->get_last_order();
        // print_r($rs_last_order);die;
        // render view
        return view(self::PAGE_URL.'index',compact(['total_jenis_treatment','total_order','total_perawat','total_pasien','rs_last_order']));
    }
}
