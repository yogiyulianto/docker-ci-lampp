<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Testimonials extends PrivateBase {

    const PAGE_TITLE = 'Testimonial';
    const PAGE_HEADER = 'Testimonial';
    const PAGE_URL = 'administrator/cms/testimonials/';
    protected $page_limit = 10;

    // constructor
    public function __construct() {
        parent::__construct();
        // CONST
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        $this->load->model('administrator/cms/M_testimonial');
    }

    public function index() {
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_testimonial->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = $this->uri->segment(4);
        $this->pagination->initialize($config);
        //get data
        $survey = $this->M_testimonial->get_all_survey();
        $data = array('survey' => $survey);
        view(self::PAGE_URL . 'index', $data);
    }

    public function add(){
        $this->_set_page_rule('C');
        view(self::PAGE_URL . 'add');
    }

    // add process
    public function add_Survey() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('name','Nama','trim|required');
        $this->form_validation->set_rules('age','umur','trim|required');
        $this->form_validation->set_rules('description','Deskripsi','trim|required');
        $this->form_validation->set_rules('address','Alamat','trim|required');
        $this->form_validation->set_rules('datetime','Tanggal Survey','trim|required');
        $this->form_validation->set_rules('image','Foto Profile','trim|required');
        // process
        if ($this->form_validation->run() !== FALSE) {
            // update params
            $params = array(
                'name' => $this->input->post('name',TRUE), 
                'age' => $this->input->post('age',TRUE), 
                'description' => $this->input->post('description', TRUE), 
                'address' => $this->input->post('address',TRUE), 
                'datetime' => $this->input->post('datetime',TRUE), 
                'image' => $this->input->post('image',TRUE), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_testimonial->insert('testimoni', $params)) {
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

    public function edit($survey_id = ' ') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($survey_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not found!');
        }
        $result = $this->M_testimonial->get_survey_by_id($survey_id);
        $data = array('survey' => $result);

        view(self::PAGE_URL . 'edit', $data);
    }

    // add process
    public function edit_Survey() {
        // cek input
        $this->form_validation->set_rules('name','Nama','trim|required');
        $this->form_validation->set_rules('age','umur','trim|required');
        $this->form_validation->set_rules('description','Deskripsi','trim|required');
        $this->form_validation->set_rules('address','Alamat','trim|required');
        $this->form_validation->set_rules('datetime','Tanggal Survey','trim|required');
        $this->form_validation->set_rules('image','Foto Profile','trim|required');
        // check data
        if (empty($this->input->post('id'))) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'error', 'Data Not Found !');
        }
        $survey_id = $this->input->post('id');
        // process
        if ($this->form_validation->run() !== FALSE) {
            // update params
            $params = array(
                'name' => $this->input->post('name',TRUE), 
                'age' => $this->input->post('age',TRUE), 
                'description' => $this->input->post('description', TRUE), 
                'address' => $this->input->post('address',TRUE), 
                'datetime' => $this->input->post('datetime',TRUE), 
                'image' => $this->input->post('image',TRUE), 
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            $where = array(
                'id' => $survey_id,
            );
            // insert
            if ($this->M_testimonial->update('testimoni', $params, $where)) {
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

    public function delete($survey_id = '') {
        $this->_set_page_rule('D');
        //cek data
        if (empty($survey_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data Not Found !');
        }
        //parsing
        $data = array(
            'result' => $this->M_testimonial->get_survey_by_id($survey_id),
        );
        view(self::PAGE_URL . 'delete', $data);
    }

    public function delete_survey() {
        $survey_id = $this->input->post('id', true);
        //cek data
        if (empty($survey_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data Not Found !');
        }
        $where = array(
            'id' => $survey_id,
        );
        //process
        if ($this->M_users->delete('testimoni', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL, 'success', 'Data successfully deleted');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data failed to delete !');
        }
    }
}