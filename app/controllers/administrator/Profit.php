<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Profit extends PrivateBase {

    // constructor
    const SESSION_SEARCH = 'profit_search';
    const PAGE_TITLE = 'Profit';
    const PAGE_HEADER = 'Profit';
    const PAGE_URL = 'administrator/profit/';
    protected $page_limit = 10;

    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        $this->load->model('systems/M_group');
        $this->load->model('administrator/M_profit');
    }

    public function index() {
        $this->_set_page_rule('R');
        //get data
        $rs_search = $this->session->userdata(self::SESSION_SEARCH);
        $rs_id = $this->M_profit->get_all();
        $data = array(
            'rs_id' => $rs_id,
        );
        view(self::PAGE_URL . 'index', $data);
    }

}
