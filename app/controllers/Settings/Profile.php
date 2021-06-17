<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Profile extends PrivateBase {

    const PAGE_TITLE = 'Profile';
    const PAGE_HEADER = 'Profile';
    const PAGE_URL = 'settings/profile/';

    // constructor
    public function __construct() 
    {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // load model
        $this->load->model('systems/M_user');
        $this->load->model('settings/M_log');
        // load library
        $this->load->library('tupload');
    }

    public function index() 
    {
        // get data
        $result = $this->M_user->get_by_id($this->com_user('user_id'));
        // render view
        view('settings.profile.profile', compact('result'));
    }

    public function edit_process() 
    {
        // init var
        $user_id = $this->com_user('user_id');
        // // validasi rules
        $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('gender_st', 'Gender', 'trim|required|max_length[2]');
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('user_mail', 'User Email', 'trim|required|valid_email|max_length[50]');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|max_length[50]');
        // check data
        if (empty($user_id)) {
            $this->notification->send(self::PAGE_URL, 'error', 'Data Not Found !');
        }
        
        if ($this->form_validation->run() !== false) {
                // parameter
            $params = array(
                'user_name' => $this->input->post('user_name'),
                'user_mail' => $this->input->post('user_mail'),
                'mdb' => $user_id,
                'mdd' => date('Y-m-d H:i:s'),
            );
            $where = array(
                'user_id' => $user_id,
            );
            // insert
            if ($this->M_user->update('com_user', $params, $where)) {
                // insert to users
                $params = array(
                    'full_name' => $this->input->post('full_name'),
                    'address' => $this->input->post('address'),
                    'phone' => $this->input->post('phone'),
                    'gender_st' => $this->input->post('gender_st'),
                );
                $this->M_user->update('user', $params, $where);
                // insert hak akses
                $this->notification->send(self::PAGE_URL, 'success', 'Data edited successfully !');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL, 'error', 'Data failed to edit !');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data failed to edit !');
        }
    }

    public function edit_img_process() {
        // set page rules
        $com_user = $this->session->userdata('com_user');
        // page
        $user_id = $com_user['user_id'];
        $this->form_validation->set_rules('page', 'Halaman', 'trim|required');
        // process
        if ($this->form_validation->run() !== false) {
            // upload
            if (!empty($_FILES['user_img_upload']['tmp_name'])) {
                // upload config
                $config['upload_path'] = 'assets/images/users/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = $user_id . '_' . date('Ymdhis');
                // --
                $this->tupload->initialize($config);
                // process upload images
                if ($this->tupload->do_upload_image('user_img_upload', 128, false)) {
                    $data = $this->tupload->data();
                    $params = array(
                        'user_img' => 'assets/images/users/' . $data['file_name'],
                    );
                    $where = array(
                        'user_id' => $user_id,
                    );
                    $this->M_user->update('user', $params, $where);
                    // hapus foto lama
                    $this->notification->send(self::PAGE_URL, "success", "Foto profil berhasil diupdate.");
                } else {
                    // jika gagal
                    $this->notification->send(self::PAGE_URL, "error", "Foto profil gagal disimpan.");
                }
            } else {
                $this->notification->send(self::PAGE_URL, "error", "Foto profil gagal disimpan.");
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL, "error", "Data gagal diubah");
        }
    }

    public function change_password(){
        // get data
        $result = $this->M_user->get_by_id($this->com_user('user_id'));
        // parse to view
        return view('settings.profile.change_password',compact('result'));
    }
    public function change_password_process()
    {
        // init var
        $user_id = $this->com_user('user_id');
        // // validasi rules
        $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('new_password_conf', 'New Confirmation Password', 'trim|required|matches[new_password]|min_length[8]');
        if ($this->form_validation->run() !== false) {
            // init var
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');
            $new_password_conf = $this->input->post('new_password_conf');
            // cek current password
            $result = $this->M_user->get_user_detail_with_all_roles($this->com_user('user_name'));
            if ($this->bcrypt->check_password(md5($current_password), $result['user_pass']) == 1) {
                $password = $this->bcrypt->hash_password(md5($new_password));
                $params = array(
                    'user_pass' => $password, 
                );
                $where = array(
                    'user_id' => $user_id, 
                );
                if ($this->M_user->update('com_user', $params, $where)) {
                    $this->notification->send(self::PAGE_URL.'change_password', 'success', 'Password Updated Successfully !');
                }
                $this->notification->send(self::PAGE_URL.'change_password', 'error', 'Password Updated Successfully !');
            }
            $this->notification->send(self::PAGE_URL.'change_password', 'error', 'Current Password Not Match !');
        }
        $this->notification->send(self::PAGE_URL.'change_password', 'error', 'Data failed to edit !');
    }

    public function activity()
    {
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_log->count_all($this->com_user('user_id'));
        $config['base_url'] = base_url('settings/profile/activity/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = 10;
        $from = $this->uri->segment(4);
        $this->pagination->initialize($config);
        //get data 
        $result = $this->M_user->get_by_id($this->com_user('user_id'));
        $rs_id = $this->M_log->get_all($this->com_user('user_id'), $config['per_page'], $from);
        $pagination = $this->pagination->create_links();
        // render view
        return view('settings.profile.activity',compact('result','rs_id','pagination'));
    }

}
