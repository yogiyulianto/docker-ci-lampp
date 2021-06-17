<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Permissions extends PrivateBase {

    const SESSION_SEARCH = 'permission_portal_search';
    const SESSION_SEARCH_ROLE = 'permission_roles_search';
    const PAGE_TITLE = 'Permissions';
    const PAGE_HEADER = 'Permissions';
    const PAGE_URL = 'systems/permissions/';
    protected $page_limit = 10;

    // constructor
    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        $this->load->model('systems/M_group');
        $this->load->model('systems/M_role');
        $this->load->model('systems/M_menu');
        $this->load->model('systems/M_portal');
    }

    public function index() {
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_role->count_all();
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = $this->uri->segment(4);
        $this->pagination->initialize($config);
        //get data 
        $rs_search = $this->session->userdata(self::SESSION_SEARCH_ROLE);
        $rs_id = $this->M_role->get_all($rs_search, $config['per_page'], $from);
        $rs_groups = $this->M_role->get_all_groups();

        $data = array(
            'rs_search' => $rs_search,
            'rs_id' => $rs_id,
            'rs_groups' => $rs_groups,
            'pagination' => $this->pagination->create_links(),
        );
        view(self::PAGE_URL . 'index', $data);
    }

    public function access_update($role_id = '') {
        $this->_set_page_rule('U');
        // get detail role
        if (empty($role_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data not Found !');
        }
        $result = $this->M_menu->get_detail_role_by_id($role_id);
        if (empty($result)) {
            // default error
            $this->sent_notification(self::PAGE_URL, 'error', "Data Not Found!");
        }
        // get_list_portal
        $rs_portal = $this->M_menu->get_all_portal();
        // set default_portal for filtering
        $default_portal_id = (!empty($rs_portal)) ? $rs_portal[0]["portal_id"] : "";
        $search = $this->session->userdata(self::SESSION_SEARCH);
        if (!empty($search)) {
            $default_portal_id = $search["portal_id"];
        }
        // set default_portal for filtering
        // get data menu
        $list_menu = $this->_display_menu($default_portal_id,$role_id, 0, "");

        $data = array(
            'result' => $result,
            'detail' => $result,
            'list_menu' => $list_menu,
            'rs_portal' => $rs_portal,
            'default_portal_id' => $default_portal_id
        );
        view(self::PAGE_URL . 'access_update', $data);
    }

    private function _display_menu($portal_id,$role_id, $parent_id , $indent) {
        $html = "";
        // get data
        $params = array($role_id,$portal_id, $parent_id);
        // print_r($params);die();
        $rs_id = $this->M_menu->get_all_menu_selected_by_parent($params);
        if (!empty($rs_id)) {
            $no = 0;
            $indent .= "--- ";
            foreach ($rs_id as $rec) {
                $role_tp = array("C" => "0", "R" => "0", "U" => "0", "D" => "0");
                $i = 0;
                foreach ($role_tp as $rule => $val) {
                    $N = substr($rec['role_tp'], $i, 1);
                    $role_tp[$rule] = $N;
                    $i++;
                }
                $checked = "";
                if (array_sum($role_tp) > 0) {
                    $checked = "checked='true'";
                }
                // parse
                $html .= "<tr>";
                $html .= "<td class='text-center'>";
                $html .= '<div class="checkbox"><input type="checkbox" id="' . $rec['nav_id'] . '" class="checked-all r-menu" value="' . $rec['nav_id'] . '" ' . $checked . '><label for="' . $rec['nav_id'] . '"></label> </div>';
                $html .= "</td>";
                $html .= "<td><label for='" . $rec['nav_id'] . "'>" . $indent . $rec['nav_title'] . ' ( ' . $rec['nav_desc'] . ' ) ' . "</label></td>";
                $html .= "";
                $html .= '<td class="text-center"><div class="checkbox"><input type="checkbox" id="c-' . $rec['nav_id'] . '" class="r' . $rec['nav_id'] . ' r-menu" name="rules[' . $rec['nav_id'] . '][C]" value="1" ' . ($role_tp['C'] == "1" ? 'checked ="true"' : "") . '><label for="c-' . $rec['nav_id'] . '"></label></div></td>';
                $html .= '<td class="text-center"><div class="checkbox"><input type="checkbox" id="r-' . $rec['nav_id'] . '" class="r' . $rec['nav_id'] . ' r-menu" name="rules[' . $rec['nav_id'] . '][R]" value="1" ' . ($role_tp['R'] == "1" ? 'checked ="true"' : "") . '><label for="r-' . $rec['nav_id'] . '"></label></div></td>';
                $html .= '<td class="text-center"><div class="checkbox"><input type="checkbox" id="u-' . $rec['nav_id'] . '" class="r' . $rec['nav_id'] . ' r-menu" name="rules[' . $rec['nav_id'] . '][U]" value="1" ' . ($role_tp['U'] == "1" ? 'checked ="true"' : "") . '><label for="u-' . $rec['nav_id'] . '"></label></div></td>';
                $html .= '<td class="text-center"><div class="checkbox"><input type="checkbox" id="d-' . $rec['nav_id'] . '" class="r' . $rec['nav_id'] . ' r-menu" name="rules[' . $rec['nav_id'] . '][D]" value="1" ' . ($role_tp['D'] == "1" ? 'checked ="true"' : "") . '><label for="d-' . $rec['nav_id'] . '"></label></div></td>';
                $html .= "</tr>";
                $html .= $this->_display_menu($rec['portal_id'],$role_id, $rec['nav_id'], $indent);
                $no++;
            }
        }
        return $html;
    }

    // search process
    public function search_process() {
        $this->_set_page_rule('R');
        if ($this->input->post('search', true) == "submit") {
            $params = array(
                'role_name' => $this->input->post('role_name', true),
                'group_id' => $this->input->post('group_id', true),
            );
            $this->session->set_userdata(self::SESSION_SEARCH_ROLE, $params);
        } else {
            $this->session->unset_userdata(self::SESSION_SEARCH_ROLE);
        }
        redirect(self::PAGE_URL);
    }

    public function filter_portal_process($role_id = "") {
        $this->_set_page_rule('R');
        $portal_id = $this->input->post('portal_id', TRUE);
        // session
        if ($this->input->post('search') == "submit") {
            if (!empty($portal_id)) {
                $params = array(
                    "portal_id" => $portal_id,
                );
                // set session
                $this->session->set_userdata(self::SESSION_SEARCH, $params);
            }
        } else {
            // unset session
            $this->session->unset_userdata(self::SESSION_SEARCH);
        }
        // redirect
        redirect(self::PAGE_URL.'access_update/' . $role_id);
    }

    // process update
    public function process() {
        $this->_set_page_rule('R');
        $role_id = $this->input->post('role_id');
        // cek input
        $this->form_validation->set_rules('role_id', 'Role ID', 'trim|required');
        // process
        if ($this->form_validation->run() !== FALSE) {
            // delete
            $params = array(
                $this->input->post('role_id', TRUE),
            );
            $this->M_menu->delete_role_menu($params);
            // insert
            $rules = $this->input->post('rules');
            if (is_array($rules)) {
                foreach ($rules as $nav => $rule) {
                    // get rule tipe
                    $role_tp = array("C" => "0", "R" => "0", "U" => "0", "D" => "0");
                    $i = 0;
                    foreach ($role_tp as $tp => $val) {
                        if (isset($rule[$tp])) {
                            $role_tp[$tp] = $rule[$tp];
                        }
                        $i++;
                    }
                    $result = implode("", $role_tp);
                    // insert
                    $params = array($this->input->post('role_id'), $nav, $result);
                    $this->M_menu->insert_role_menu($params);
                }
            }
            $this->notification->send(self::PAGE_URL.'access_update/' . $role_id, "success", "Data successfully updated");
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'access_update/' . $role_id, "error", "Data failed to update");
        }
        // default redirect
        $this->notification->send(self::PAGE_URL.'access_update/' . $role_id, "error", "Data failed to update");
    }

}
