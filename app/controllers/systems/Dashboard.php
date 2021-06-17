<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Dashboard extends PrivateBase {

    const PAGE_TITLE = 'Dashboard';
    const PAGE_HEADER = 'Dashboard';
    const PAGE_URL = 'systems/dashboard/';

    // constructor
    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD MODEL
        $this->load->model('systems/M_dashboard');
        $this->load->model('systems/M_panel');
    }

    public function index() 
    {
        // set page rules
        $this->_set_page_rule('R');
        // parse data
        $total_portal = $this->M_dashboard->total_portal();
        $total_role = $this->M_dashboard->total_role();
        $total_menu = $this->M_dashboard->total_menu();
        $total_user = $this->M_dashboard->total_user();
        $rs_activity_log = $this->M_panel->get_all();
        $rs_login_log = $this->M_panel->get_user_last_login();
        // render view
        return view(self::PAGE_URL.'index', compact(['total_portal','total_role','total_menu','total_user','rs_activity_log','rs_login_log',]));
    }
}
