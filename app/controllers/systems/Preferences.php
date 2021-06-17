<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Preferences extends PrivateBase
{

    // constructor
    const SESSION_SEARCH = 'preferences';
    const PAGE_HEADER = 'Preferences';
    const PAGE_TITLE = 'Preferences';
    const PAGE_URL = 'systems/preferences/';
    protected $page_limit = 10;

    public function __construct()
    {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        $this->load->model('systems/M_preferences');
    }

    public function index()
    {
        $this->_set_page_rule('R');
        // get data
        $rs_groups = $this->M_preferences->get_all_group();
        $rs_prefs  = array();
        foreach ($rs_groups as $key => $value) {
            $rs_pref = $this->M_preferences->get_pref_by_group_id(array($value['pref_group']));
            $rs_prefs[$value['pref_group']] = $rs_pref;
        }
        // rs_group
        $data = array(
            'rs_groups' => $rs_groups,
            'rs_prefs' => $rs_prefs,
        );
        // print_r($data);die();
        view(self::PAGE_URL . 'index', $data);
    }

    public function update_process(){
        $this->_set_page_rule('U');
        // get_data
        $this->db->trans_start();
        foreach ($this->input->post() as $key => $value) {
            $params = array(
                'pref_value' => $value,
                'mdb'        => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd'        => now()
            );
            $where = array(
                'pref_nm' => $key
            );
            $this->M_preferences->update('com_preferences', $params, $where);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() != false) {
            $this->notification->send(self::PAGE_URL, 'success', 'Data updated successfully');
        }
        $this->notification->send(self::PAGE_URL, 'error', 'Data failed to update');
    }

    public function master() {
        // PAGE RULES
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_preferences->get_total_pref();
        $config['base_url'] = base_url(self::PAGE_URL.'index');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_preferences->get_all_pref(array($from,$config['per_page']));
        $data = array(
            'rs_id' => $rs_id,
            'pagination' => $this->pagination->create_links()
        );

        view(self::PAGE_URL . 'master', $data);
        // 
    }

    public function add() {
        $this->_set_page_rule('C');
        $data['rs_pref_type'] = array('input');
        view(self::PAGE_URL . 'add',$data);
    }

    public function add_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('pref_group', 'Pref Group', 'trim|required');
        $this->form_validation->set_rules('pref_nm', 'Pref Name', 'trim|required');
        $this->form_validation->set_rules('pref_type', 'Pref Type', 'trim|required');
        $this->form_validation->set_rules('pref_label', 'Pref Label', 'trim|required');
        // process
        if ($this->form_validation->run() !== FALSE) {
            $params = array(
                'pref_group' => $this->input->post('pref_group',TRUE),
                'pref_nm' => $this->input->post('pref_nm',TRUE),
                'pref_type' => $this->input->post('pref_type',TRUE),
                'pref_label' => $this->input->post('pref_label',TRUE),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->M_preferences->insert('com_preferences', $params)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL, 'success', 'Data added successfully !');
            } else {
                $this->notification->send(self::PAGE_URL.'add', 'error', 'Data failed to add !');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'add', 'error', 'Some Fields are Incorrect. !');
        }
    }

    public function edit($pref_id = '') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($pref_id)) {
            // send notification
            $this->notification->send(self::PAGE_URL.'master', 'error', 'Data not Found !');
        }
        //assign data
        $data['result'] = $this->M_preferences->get_pref_by_id(array($pref_id));
        $data['rs_pref_type'] = array('input');
        // render view
        view(self::PAGE_URL.'edit',$data);
    }

    public function edit_process() {
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('pref_group', 'Pref Group', 'trim|required');
        $this->form_validation->set_rules('pref_nm', 'Pref Name', 'trim|required');
        $this->form_validation->set_rules('pref_type', 'Pref Type', 'trim|required');
        $this->form_validation->set_rules('pref_label', 'Pref Label', 'trim|required');
        // check data
        $pref_id = $this->input->post('pref_id',TRUE);
        if (empty($pref_id)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data not found !');
        }
        // process
        if ($this->form_validation->run() !== FALSE) {
            $params = array(
                'pref_group' => $this->input->post('pref_group',TRUE),
                'pref_nm' => $this->input->post('pref_nm',TRUE),
                'pref_type' => $this->input->post('pref_type',TRUE),
                'pref_label' => $this->input->post('pref_label',TRUE),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            $where = array(
                'pref_id' => $pref_id
            );
            // insert
            if ($this->M_preferences->update('com_preferences', $params, $where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL.'master', 'success', 'Data edited successfully !');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'master'.'edit' . $pref_id, 'error', 'Data failed to edit !');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/' . $pref_id, 'error', 'Some Fields are Incorrect. !');
        }
    }

    public function delete($pref_id = '') {
        $this->_set_page_rule('D');
        //cek data
        if (empty($pref_id)) {
            // send notification
            $this->notification->send(self::PAGE_URL.'master', 'error', 'Data not Found !');
        }
        //assign data
        $data['result'] = $this->M_preferences->get_pref_by_id(array($pref_id));
        $data['rs_pref_type'] = array('input');
        //parsing and view content
        view(self::PAGE_URL . 'delete', $data);
    }

    public function delete_process() {
        $this->_set_page_rule('D');

        $pref_id = $this->input->post('pref_id', true);
        //cek data
        if (empty($pref_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not Found !');
        }
        $where = array(
            'pref_id' => $pref_id
        );
        //process
        if ($this->M_preferences->delete('com_preferences', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'master', 'success', 'Data deleted successfully');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $pref_id, 'error', 'Data failed to delete !');
        }
    }

    
}