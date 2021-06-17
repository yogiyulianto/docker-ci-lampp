<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Jenis_treatment extends PrivateBase {

    // constructor
    const PAGE_TITLE = 'Jenis treatment';
    const PAGE_HEADER = 'Jenis treatment';
    const PAGE_URL = 'administrator/master/jenis_treatment/';
    protected $page_limit = 10;

    public function __construct() 
    {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // load model
        $this->load->model('administrator/master/M_jenis_treatment');
    }

    public function index() 
    {
        // PAGE RULES
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_jenis_treatment->get_total_jenis_treatment();
        $config['base_url'] = base_url(self::PAGE_URL.'index');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = (int)$this->uri->segment(5);
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_jenis_treatment->get_all_jenis_treatment([ $from ,$config['per_page']]);
        // print_r($this->M_jenis_treatment->test(array("9909")));die();

        $pagination = $this->pagination->create_links();
        // render view
        return view(self::PAGE_URL . 'index', compact('rs_id','pagination'));
    }

    public function add() 
    {
        // set page rules
        $this->_set_page_rule('C');
        // render view
        return view(self::PAGE_URL . 'add');
    }

    public function add_process() 
    {
        // set page rules
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('nama', 'Nama Jenis treatment', 'trim|required');
        $this->form_validation->set_rules('satuan', 'Satuan Jenis treatment', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga Jenis treatment', 'trim|required');
        $this->form_validation->set_rules('type', 'Type Jenis treatment', 'trim|required');
        // process
        if ($this->form_validation->run() !== FALSE) {
            $jenis_treatment_id = $this->M_jenis_treatment->get_last_id();
            $params = array(
                'jenis_treatment_id' => $jenis_treatment_id,
                'nama' => $this->input->post('nama'),
                'satuan' => $this->input->post('satuan'),
                'harga' => $this->input->post('harga'),
                'type' => $this->input->post('type'),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_jenis_treatment->insert('jenis_treatment', $params)) {
                // notification success
                $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil ditambahkan!');
            } else {
                $this->notification->send(self::PAGE_URL.'add', 'error', 'Data gagal ditambahkan!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'add', 'error', 'Ada Field Yang Tidak Sesuai!');
        }
    }

    public function edit($jenis_treatment_id = '') 
    {
        // set page rules
        $this->_set_page_rule('U');
        //cek data
        if (empty($jenis_treatment_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        // get data
        $result = $this->M_jenis_treatment->get_jenis_treatment_by_id([$jenis_treatment_id]);
        //render view
        return view(self::PAGE_URL . 'edit', compact('result'));
    }

    public function edit_process() 
    {
        // set page rules
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('nama', 'Nama Jenis treatment', 'trim|required');
        $this->form_validation->set_rules('satuan', 'Satuan Jenis treatment', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga Jenis treatment', 'trim|required');
        $this->form_validation->set_rules('type', 'Type Jenis treatment', 'trim|required');
        // check data
        $jenis_treatment_id = $this->input->post('jenis_treatment_id');
        if (empty($jenis_treatment_id)) {
            // notification success
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data tidak ditemukan!');
        }
        // process
        if ($this->form_validation->run() !== FALSE) {
            $params = array(
                'nama' => $this->input->post('nama'),
                'satuan' => $this->input->post('satuan'),
                'harga' => $this->input->post('harga'),
                'type' => $this->input->post('type'),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            $where = array(
                'jenis_treatment_id' => $jenis_treatment_id
            );
            // insert
            if ($this->M_jenis_treatment->update('jenis_treatment', $params, $where)) {
                // notification success
                $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil diedit !');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit' . $jenis_treatment_id, 'error', 'Data gagal diedit!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/' . $jenis_treatment_id, 'error', 'Ada Field Yang Tidak Sesuai!');
        }
    }

    public function delete_process() 
    {
        // set page rule
        $this->_set_page_rule('D');
        // get id
        $jenis_treatment_id = $this->input->post('id', true);
        //cek data
        if (empty($jenis_treatment_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        $where = array(
            'jenis_treatment_id' => $jenis_treatment_id
        );
        //process
        if ($this->M_jenis_treatment->delete('jenis_treatment', $where)) {
            // notification success
            $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil dihapus');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $jenis_treatment_id, 'error', 'Data failed to delete !');
        }
    }

}
