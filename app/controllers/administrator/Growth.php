<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Growth extends PrivateBase {

    // constructor
    const SESSION_SEARCH = 'growth_search';
    const PAGE_TITLE = 'Perkembangan';
    const PAGE_HEADER = 'Perkembangan';
    const PAGE_URL = 'administrator/growth/';
    protected $page_limit = 10;

    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        $this->load->model('systems/M_group');
        $this->load->model('administrator/M_growth');
    }

    public function index() {
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_growth->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = $this->uri->segment(3);
        if(empty($from)){
            $from = 0;
        }
        $this->pagination->initialize($config);
        //get data
        $rs_search = $this->session->userdata(self::SESSION_SEARCH);
        $rs_id = $this->M_growth->get_all($config['per_page'], $from);
        $data = array(
            'rs_search' => $rs_search,
            'rs_id' => $rs_id,
            'pagination' => $this->pagination->create_links(),
        );
        view(self::PAGE_URL . 'index', $data);
    }

    public function add(){
        $this->_set_page_rule('C');
        $data = array(
            'kolam' => $this->M_growth->get_all_kolam(),
        );
        view(self::PAGE_URL . 'add', $data);
    }

    // add process
    public function add_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('device_id','Kolam','trim|required');
        $this->form_validation->set_rules('total_kg','Total KG','trim|required');
        $this->form_validation->set_rules('fish_count','Total Ikan','trim|required');
        $this->form_validation->set_rules('pembesaran_st','Pembesaran Status','trim|required');
        // process
        if ($this->form_validation->run() !== FALSE) {
            // update params
            $params = array(
                'device_id' => $this->input->post('device_id',TRUE), 
                'total_kg' => $this->input->post('total_kg',TRUE), 
                'fish_count' => $this->input->post('fish_count', TRUE), 
                'pembesaran_st' => $this->input->post('pembesaran_st',TRUE), 
                'date_sampling' => now(), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_growth->insert('sampling', $params)) {
                if($this->input->post('pembesaran_st',TRUE) == 'finish'){
                    // default error
                    $this->notification->send(self::PAGE_URL.'add_history', 'success', 'Data Berhasil ditambakhkan! Silahkan isi data panen!');
                }
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil ditambahkan!');
            } else {
                $this->notification->send(self::PAGE_URL.'add', 'error', 'Data gagal ditambahkan!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'add', 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

    public function add_history(){
        $this->_set_page_rule('C');
        $data = array(
            'kolam' => $this->M_growth->get_all_kolam(),
        );
        view(self::PAGE_URL . 'add_history', $data);
    }

    public function add_history_process(){
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('device_id','Kolam','trim|required');
        $this->form_validation->set_rules('total_kg','Total KG','trim|required');
        $this->form_validation->set_rules('total_feed','Total Feed','trim|required');
        $this->form_validation->set_rules('time_growth','Time Growth','trim|required');
        // process
        if ($this->form_validation->run() !== FALSE) {
            // update params
            $params = array(
                'device_id' => $this->input->post('device_id',TRUE), 
                'total_kg' => $this->input->post('total_kg',TRUE), 
                'total_feed' => $this->input->post('total_feed', TRUE), 
                'time_growth' => $this->input->post('time_growth',TRUE), 
                'datetime' => now(), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_growth->insert('history_harvest', $params)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil ditambahkan!');
            } else {
                $this->notification->send(self::PAGE_URL.'add', 'error', 'Data gagal ditambahkan!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'add', 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

}
