<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Menu extends PrivateBase {

    const SESSION_SEARCH = 'menu_search';
    const PAGE_TITLE = 'Menu';
    const PAGE_HEADER = 'Navigation';
    const PAGE_URL = 'systems/menu/';
    protected $page_limit = 10;

    // constructor
    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        $this->load->model('systems/M_menu');
        // $this->load->model('systems/M_portal');
    }

    public function index() {
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_menu->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = $this->uri->segment(4);
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_menu->get_all_portal($config['per_page'], $from);
        $data = array(
            'rs_id' => $rs_id,
            'pagination' => $this->pagination->create_links()
        );
        view(self::PAGE_URL . 'index', $data);
    }

    public function navigation($portal_id = '')
    {
        $this->_set_page_rule('R');
        if (empty($portal_id)) {
            $this->notification->send(self::PAGE_URL, 'error', 'Data not Found !');
        }
        $rs_search = $this->session->userdata(self::SESSION_SEARCH);
        $rs_search['parent_id'] = empty($rs_search['parent_id']) ? 0 : $rs_search['parent_id'];
        $params = array($portal_id,0);
        
        $rs_parents = $this->M_menu->get_all_menu_by_parent($params);
        // get data menu
        
        $html = $this->_get_menu_by_portal($portal_id,$rs_search['parent_id'],'');
        $data = array(
            'portal_id' => $portal_id,
            'rs_parents' => $rs_parents,
            'rs_search' => $rs_search,
            'html' => $html,
        );
        view(self::PAGE_URL . 'navigation', $data);
    }

    // list navigasi by portal
    private function _get_menu_by_portal($portal_id,$parent_id, $indent) {
        $html = "";
        $params = array($portal_id,$parent_id);
        $rs_id = $this->M_menu->get_all_menu_by_parent($params);
        if ($rs_id) {
            $no = 0;
            $indent .= "--- ";
            foreach ($rs_id as $rec) {
                // url
                $url_edit = base_url('systems/menu/edit/' .$rec['portal_id'].'/'. $rec['nav_id']);
                $url_hapus = base_url('systems/menu/delete/' .$rec['portal_id'].'/'. $rec['nav_id']);
                // icon
                $icon = '';
                if (!empty($rec['nav_icon'])) {
                    $icon = '<i class="' . $rec['nav_icon'] . '"></i>';
                }
                if ($rec['active_st'] == 1) {
                    $active_st = '<small class="badge badge-success text-white"><i class="la la-check"></i></small>';
                }elseif($rec['active_st'] == 0) {
                    $active_st = '<small class="badge badge-danger text-white"><i class="la la-close"></i></small>';
                }
                if ($rec['display_st'] == 1) {
                    $display_st = '<small class="badge badge-success text-white"><i class="la la-eye"></i></small>';
                }elseif($rec['display_st'] == 0) {
                    $display_st = '<small class="badge badge-danger text-white"><i class="la la-eye-slash"></i></small>';
                }
                // parse
                $html .= "<tr>";
                $html .= "<td class='text-center'>" . $icon . "</td>";
                $html .= "<td>" . $indent . $rec['nav_title'] . "</td>";
                $html .= "<td>" . $rec['nav_url'] . "</td>";
                $html .= "<td class='text-center'>" . $active_st . "</td>";
                $html .= "<td class='text-center'>" . $display_st . "</td>";
                $html .= "<td class='text-center'>";
                $html .= "<a href='" . $url_edit . "' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Edit Menu'><i class='fas fa-pencil-alt'></i></a> &nbsp;";
                $html .= "<a href='" . $url_hapus . "' class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='Delete Menu'><i class='fas fa-trash'></i></a>";
                $html .= "</td>";
                $html .= "</tr>";
                $html .= $this->_get_menu_by_portal($portal_id,$rec['nav_id'], $indent);
                $no++;
            } 
        }
        return $html;
    }

    public function add($portal_id = '') {
        $this->_set_page_rule('C');
        if (empty($portal_id)) {
            $this->notification->send(self::PAGE_URL, 'error', 'Data not Found !');
        }
        $params = array($portal_id,0 );
        $rs_menus = $this->M_menu->get_all_menu_by_parent($params);
        $data = array(
            'portal_id' => $portal_id,
            'rs_menus' => $rs_menus,
        );
        view(self::PAGE_URL . 'add', $data);
    }

    // add process
    public function add_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('portal_id', 'portal_id', 'trim|required');
        $this->form_validation->set_rules('parent_id', 'Parent Menu', 'trim|required');
        $this->form_validation->set_rules('nav_title', 'Nav Title', 'trim|required');
        $this->form_validation->set_rules('nav_desc', 'Nav Desc', 'trim|required');
        $this->form_validation->set_rules('nav_url', 'Nav Url', 'trim|required');
        $this->form_validation->set_rules('nav_no', 'Nav Order', 'trim|required');
        $this->form_validation->set_rules('active_st', 'Active', 'trim|required');
        $this->form_validation->set_rules('display_st', 'Display', 'trim|required');
        // get last di role
        $nav_id = $this->M_menu->get_last_id();
        $portal_id = $this->input->post('portal_id');
        // process
        if ($this->form_validation->run() !== false) {
            $params = array(
                'nav_id' => $nav_id,
                'portal_id' => $portal_id,
                'parent_id' => $this->input->post('parent_id'),
                'nav_title' => $this->input->post('nav_title'),
                'nav_desc' => $this->input->post('nav_desc'),
                'nav_url' => $this->input->post('nav_url'),
                'nav_no' => $this->input->post('nav_no'),
                'active_st' => $this->input->post('active_st'),
                'display_st' => $this->input->post('display_st'),
                'nav_icon' => $this->input->post('nav_icon'),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );

            if ($this->M_menu->insert('com_menu', $params)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL.'navigation/'.$portal_id, 'success', 'Data added successfully !');
            } else {
                $this->notification->send(self::PAGE_URL.'add/'.$portal_id, 'error', 'Data failed to add !');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'add/'.$portal_id, 'error', 'Some Fields are Incorrect. !');
        }
    }

    public function edit($portal_id ='',$nav_id = '') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($nav_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not found !');
        }
        if (empty($portal_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not found !');
        }
        //parsing
        $params = array($portal_id,0 );
        $rs_menus = $this->M_menu->get_all_menu_by_parent($params);
        $data = array(
            'portal_id' => $portal_id,
            'result' => $this->M_menu->get_by_id($nav_id),
            'rs_menus' => $rs_menus,
        );
        view('systems.menu.edit', $data);
    }

    // edit process
    public function edit_process() {
        $this->_set_page_rule('U');
        $this->form_validation->set_rules('portal_id', 'portal_id', 'trim|required');
        $this->form_validation->set_rules('parent_id', 'Parent Menu', 'trim|required');
        $this->form_validation->set_rules('nav_title', 'Nav Title', 'trim|required');
        $this->form_validation->set_rules('nav_desc', 'Nav Desc', 'trim|required');
        $this->form_validation->set_rules('nav_url', 'Nav Url', 'trim|required');
        $this->form_validation->set_rules('nav_no', 'Nav Order', 'trim|required');
        $this->form_validation->set_rules('active_st', 'Active', 'trim|required');
        $this->form_validation->set_rules('display_st', 'Display', 'trim|required');
        // get last di role
        $nav_id = $this->input->post('nav_id');
        $portal_id = $this->input->post('portal_id');
        // process
        if ($this->form_validation->run() !== false) {
            $params = array(
                'portal_id' => $this->input->post('portal_id'),
                'parent_id' => $this->input->post('parent_id'),
                'nav_title' => $this->input->post('nav_title'),
                'nav_desc' => $this->input->post('nav_desc'),
                'nav_url' => $this->input->post('nav_url'),
                'nav_no' => $this->input->post('nav_no'),
                'active_st' => $this->input->post('active_st'),
                'display_st' => $this->input->post('display_st'),
                'nav_icon' => $this->input->post('nav_icon'),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );

            $where = array(
                'nav_id' => $nav_id,
            );

            if ($this->M_menu->update('com_menu', $params, $where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL.'navigation/'.$portal_id, 'success', 'Data edited successfully !');
            } else {
                $this->notification->send(self::PAGE_URL.'edit/'.$portal_id.'/'. $nav_id, 'error', 'Data failed to edit !');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/'.$portal_id.'/'. $nav_id, 'error', 'Some Fields are Incorrect. !');
        }
    }

    public function delete($portal_id = '',$nav_id = '') {
        $this->_set_page_rule('D');
        //cek data
        if (empty($portal_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not found !');
        }
        if (empty($nav_id)) {
            // default error
            $this->notification->send(self::PAGE_URL.'navigation/'.$portal_id, 'error', 'Data not found !');
        }
        $params = array($portal_id,0 );
        $rs_menus = $this->M_menu->get_all_menu_by_parent($params);
        //parsing
        $data = array(
            'portal_id' => $portal_id,
            'rs_menus' => $rs_menus,
            'result' => $this->M_menu->get_by_id($nav_id),
        );
        view(self::PAGE_URL . 'delete', $data);
    }

    public function delete_process() {
        $this->_set_page_rule('D');
        $nav_id = $this->input->post('nav_id', true);
        $portal_id = $this->input->post('portal_id');
        //cek data
        if (empty($nav_id)) {
            // default error
            $this->notification->send(self::PAGE_URL.'navigation/'.$portal_id, 'error', 'Data not found !');
        }
        $where = array(
            'nav_id' => $nav_id,
        );
        //process
        if ($this->M_menu->delete('com_menu', $where)) {
            //sukses notif
            $this->notification->send(self::PAGE_URL.'navigation/'.$portal_id, 'success', 'Data successfully deleted !');

        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'edit/'.$portal_id.'/'.$nav_id, 'error', 'Data not found !');
        }
    }

    public function search_process($portal_id) {
        $this->_set_page_rule('R');

        if ($this->input->post('search', true) == "submit") {
            $params = array(
                'parent_id' => $this->input->post('parent_id'),
            );
            $this->session->set_userdata(self::SESSION_SEARCH, $params);
        } else {
            $this->session->unset_userdata(self::SESSION_SEARCH);
        }
        redirect(self::PAGE_URL.'navigation/' . $portal_id);

    }

}
