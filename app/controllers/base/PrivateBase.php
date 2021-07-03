<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PrivateBase extends CI_Controller
{
    protected $portal_id;
    protected $com_user;
    protected $nav_id = 0;
    protected $parent_id = 0;
    protected $parent_selected = 0;
    protected $role_tp = array();
    protected $asset_url = 'assets/themes/atlantis/';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('systems/M_user');
        $this->load->model('systems/M_site');
        $this->load->library(array('slice', 'session'));
        //display page with slice
        $this->_display_page();
        // display current page
        $this->_display_current_page();
        // display nav
        $this->_display_sidebar_navigation();
        // check security
        $this->_check_authority();
        // display top navigation
        $this->_load_notification();
        // display setting menu
        $this->_display_settings_menu();
        // display list portal
        $this->_display_list_portal();
    }
    public function _display_logo()
    {
        $params = array(
            'pref_group' => 'logo',
            'pref_nm' => 'logo',
        );
        $logo = $this->M_site->get_com_reference_by_pref_nm($params);
        $this->slice->with('logo', $logo);
    }
    public function _display_page()
    {
        if (empty($this->session->userdata('com_user'))) {
            // default error
            $this->notification->send('login', 'error', 'Silahkan Login Terlebih Dahulu !');
        } else {
            // get user data
            $session = $this->session->userdata('com_user');
            // set default portal id
            $this->portal_id = $session['portal_id'];
            // get detail user_data
            $detail_user = $this->M_user->get_user_detail_with_all_roles($session['user_name']);
            //parse variabel default user data
            $this->slice->with('com_user', $detail_user);
            $this->slice->with('site_name', 'CISLICE v2.0');
            $this->slice->with('user_last_login', $this->M_user->get_user_last_login($session['user_id']));
            $this->slice->with('asset_url',$this->_asset_url());

            $this->config->set_item('css_dir', $this->asset_url); 
            $this->config->set_item('js_dir', $this->asset_url);
        }
    }
    private function _display_current_page()
    {
        // get current page (segment 1 : folder, segment 2 : sub folder, segment 3 : controller)
        $url_menu = $this->uri->segment(1) . '/' . $this->uri->segment(2);
        if (is_dir(APPPATH . 'controllers' . '/' . $this->uri->segment(1) . '/' . $this->uri->segment(2))) {
            $url_menu .= '/' . $this->uri->segment(3);
        }
        $url_menu = trim($url_menu, '/');
        $url_menu = (empty($url_menu)) ? $this->com_user('default_page') : $url_menu;
        $result = $this->M_site->get_current_page($url_menu);
        
        if (!empty($result)) {
            $this->slice->with("page", $result);
            $this->nav_id = $result['nav_id'];
            $this->parent_id = $result['parent_id'];
            // change portal
            if ($this->portal_id <> $result['portal_id']) {
                $com_user = $this->session->userdata('com_user');
                // set session
                $this->session->set_userdata('com_user', array(
                    'user_id' => $com_user['user_id'],
                    'user_name' => $com_user['user_name'],
                    'role_id' => $com_user['role_id'],
                    'portal_id' => $com_user['portal_id'],
                    'default_page' => $com_user['default_page'],
                ));
                // change portal id
                $this->portal_id = $com_user['portal_id'];
            }
        }
        
    }

    // sidebar navigation
    protected function _display_sidebar_navigation()
    {
        $html = "";
        // get data
        $params = array($this->portal_id,$this->com_user('user_id'), 0);
        
        $rs_id = $this->M_site->get_navigation_user_by_parent($params);
        $html .= '<ul class="nav nav-primary">'; 
        $html .= '<li class="nav-section">';
        $html .= '<span class="sidebar-mini-icon">';
        $html .= '<i class="fa fa-ellipsis-h"></i>';
        $html .= '</span>';
	    $html .= '<h4 class="text-section">'.$rs_id[0]['portal_nm'].'</h4>';
	    $html .= '</li>';
        if (!empty($rs_id)) {
            foreach ($rs_id as $rec) {
                // check selected
                $parent_selected = $this->_get_parent_group($this->parent_id, $this->parent_selected);
                if ($parent_selected == 0) {
                    $parent_selected = $this->nav_id;
                }
                // get child navigation
                $child = $this->_get_child_navigation($rec['nav_id']);
                if (!empty($child)) {
                    $url_parent = '#'.strtolower(str_replace(' ', '', $rec['nav_id']));
                    $parent_class_caret = '';
                    $data_toggle = 'collapse';
                    $collapsed = 'collapsed';
                    $data_target = strtolower(str_replace(' ', '', $rec['nav_id']));
                    $menu_arrow = '<span class="caret"></span>';
                    $has_sub = 'active';
                } else {
                    $parent_class_caret = '';
                    $url_parent = base_url($rec['nav_url']);
                    $data_toggle = '';
                    $collapsed = '';
                    $data_target = strtolower(str_replace(' ', '', $rec['nav_id']));
                    $menu_arrow = '';
                    $has_sub = '';
                }
                
                // selected
                $selected = ($rec['nav_id'] == $parent_selected) ? ' active ' : '';
                // parse
                $html .= '<li class="nav-item '.$selected.'">';
                $html .=    '<a data-toggle="'.$data_toggle.'" href="'.$url_parent.'">';
                $html .=        '<i class="'.$rec['nav_icon'].'"></i>';
                $html .=        '<p>'.$rec['nav_title'].'</p>';
                $html .=        $menu_arrow; 
                $html .=    '</a>';
                $html .=    '<div class="collapse" id="'.$data_target.'">';
                $html .=    $child;
                $html .=    '</div>';
                $html .= '</li>';
            }
        }
        $html .= '</ul>';
        // output
        return $this->slice->with('list_sidebar_nav',$html);
    }
    // utility to get parent selected
    public function _get_parent_group($int_nav, $int_limit)
    {
        $selected_parent = 0;
        $result = $this->M_site->get_menu_by_id($int_nav);
        if (!empty($result)) {
            if ($result['parent_id'] == $int_limit) {
                $selected_parent = $result['nav_id'];
            } else {
                return self::_get_parent_group($result['parent_id'], $int_limit);
            }
        } else {
            $selected_parent = 0;
        }
        return $selected_parent;
    }
    // get child
    protected function _get_child_navigation($parent_id)
    {
        $html = '';
        // get parent selected
        $parent_selected = self::_get_parent_group($this->parent_id, $parent_id);
        if ($parent_selected == 0) {
            $parent_selected = $this->nav_id;
        }
        $params = array($this->portal_id,$this->com_user('user_id'), $parent_id);
        $rs_id = $this->M_site->get_navigation_user_by_parent($params);
        if (!empty($rs_id)) {
            
            $html .=    '<ul class="nav nav-collapse">';
            foreach ($rs_id as $rec) {
                // get child navigation
                $child = $this->_get_child_navigation($rec['nav_id']);
                if (!empty($child)) {
                    $url_parent = 'javascript:void(0)';
                } else {
                    $url_parent = site_url($rec['nav_url']);
                }
                // selected
                $selected = ($rec['nav_id'] == $parent_selected) ? ' active' : '';
                // parse
                $html .= '<li class="' . $selected . '" >';
                $html .= '<a href="' . $url_parent . '" title="' . $rec['nav_desc'] . '">';
                $html .=    '<span class="sub-item">'.$rec['nav_title'].'</span>';
                $html .= '</a>';
                $html .= $child;
                $html .= '</li>';
            }
            $html .=    '</ul>';
            
        }
        // return
        return $html;
    }
    public function com_user($params)
    {
        $com_user = $this->session->userdata('com_user');
        return $com_user[$params];
    }
    
    protected function _check_authority()
    {
        // default rule tp
        $this->role_tp = array("C" => "0", "R" => "0", "U" => "0", "D" => "0");
        // check
        if (!empty($this->com_user('user_id'))) {
            // user authority
            $params = array($this->com_user('user_id'), $this->nav_id);
            $role_tp = $this->M_site->get_user_authority_by_nav($params);
            // get rule tp
            $i = 0;
            foreach ($this->role_tp as $rule => $val) {
                $N = substr($role_tp, $i, 1);
                $this->role_tp[$rule] = $N;
                $i++;
            }
        } else {
            // tidak memiliki authority
            redirect('errors/my401');
        }
    }
    // set rule per pages
    protected function _set_page_rule($rule)
    {
        if (!isset($this->role_tp[$rule]) or $this->role_tp[$rule] != "1") {
            // redirect to forbiden access
            redirect('errors/my401');
        }
    }
    protected function _load_notification()
    {
        // get all
        $notification_data = $this->M_site->get_notification_all();
        // params
        $params = array('role_id' => $this->com_user('role_id'));
        //
        $notification_data_by_role = $this->M_site->get_notification_by_role($params);
        // $this->slice->with('notification',$notification_data);
    }
    protected function _display_settings_menu()
    {
        $params = array($this->portal_id,$this->com_user('user_id'), 1000000012);
        $rs_id = $this->M_site->get_navigation_user_by_parent($params);
        $this->slice->with('list_settings_menu', $rs_id);
    }

    protected function _display_list_portal() {
        $list_portal = $this->M_user->get_list_portal_user_by_id($this->com_user('user_id'));
        $this->slice->with("list_portal", $list_portal);
    }
    protected function _asset_url()
    {
        // set assets url
        return base_url($this->asset_url);
    }

    protected function slugify($text, string $divider = '-')
    {
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
    }

}


/* End of file PrivateBase.php */
