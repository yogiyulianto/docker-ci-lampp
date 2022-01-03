<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Sensor extends PrivateBase {

    // constructor
    const SESSION_SEARCH = 'sensor_search';
    const PAGE_TITLE = 'Sensor';
    const PAGE_HEADER = 'Sensor';
    const PAGE_URL = 'administrator/sensor/';
    protected $page_limit = 10;

    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        $this->load->model('systems/M_group');
        $this->load->model('administrator/M_sensor');
    }

    public function index() {
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_sensor->count_all_suhu();
        $config['base_url'] = base_url(self::PAGE_URL.'index');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = $this->uri->segment(4);
        $this->pagination->initialize($config);
        //get data
        $suhu = $this->M_sensor->get_all_suhu();
        $ph = $this->M_sensor->get_all_ph();
        $ketinggian = $this->M_sensor->get_all_ketinggian();
        $data = array(
            'suhu' => $suhu,
            'ph' => $ph,
            'ketinggian' => $ketinggian,
        );
        view(self::PAGE_URL . 'index', $data);
    }

}
