<?php
defined('BASEPATH') or exit('No direct script access allowed');

// ------------------------------------------------------------------------
//  Aditya Putra S
//  ci-slice-v2 2020
// ------------------------------------------------------------------------

if (!function_exists('now')) {
	/**
	 * get current date time
	 *
	 * @return	string
	 */
	function now()
	{
		return date('Y-m-d H:i:s');
	}
}

if (!function_exists('dd')) {
	/**
	 * Die dump
	 *
	 * @param	any
	 * @return	void
	 */
	function dd($args = '')
	{
		if (!empty($args)) {
			print_r($args);die;
		}
	}
}

if (!function_exists('old_input')) {
	/**
	 * get current date time
	 *
	 * @return	string
	 */
	function old_input($params)
	{
		return session('old_input')[$params];
	}
}

if (!function_exists('error_form_class')) {
	/**
	 * get current date time
	 *
	 * @return	string
	 */
	function error_form_class($params)
	{
		if (empty(session('form_error')[$params])) {
			return '';
		}else {
			return 'is-invalid';
		}
	}
}

if (!function_exists('error_form')) {
	/**
	 * get current date time
	 *
	 * @return	string
	 */
	function error_form($params)
	{
		if (empty(session('form_error')[$params])) {
			return ;
		}else {
			return session('form_error')[$params];
		}
	}
}

if (!function_exists('generate_id')) {
	/**
	 * Generate microtime id
	 * 
	 * @return string         microtime
	 */
	function generate_id($len = '15')
	{
		list($usec, $sec) = explode(" ", microtime());
		$microtime = $sec . $usec;
		$microtime = str_replace(array(',', '.'), array('', ''), $microtime);
		$microtime = substr_replace($microtime, rand(10, 99), -2);
		$microtime = substr($microtime,0,$len);
		return $microtime;
	}
}

if (!function_exists('csrf_token')) {
	/**
	 * Generate csrf token on view
	 * 
	 * @return string         csrf
	 */
	function csrf_token()
	{
		$ci =& get_instance();
		$csrf = '<input type="hidden" name="'.$ci->security->get_csrf_token_name() .'" value="'. $ci->security->get_csrf_hash() .'">';
		return $csrf;
	}
}

if (!function_exists('set_select')) {
	/**
	 * Generate set_select on view
	 * 
	 * @return string   
	 */
	function set_select($value, $condition) {
		if($value == $condition)
			return "selected";
		return "";
	}
}

if (!function_exists('set_select_disable')) {
	/**
	 * Generate set_select_disable on view
	 * 
	 * @return string   
	 */
	function set_select_disable($value, $condition) {
		if($value == $condition)
			return "selected";
		return "disabled";
	}
}

if (!function_exists('set_checkbox')) {
	/**
	 * Generate set_checkbox on view
	 * 
	 * @return string   
	 */
	function set_checkbox($value) {
		if($value == 1)
			return "checked";
		return "";
	}
}

if (!function_exists('image_url')) {
	/**
	 * Generate image_url on view
	 * 
	 * @return string   
	 */
	function image_url($value) {
		return base_url('assets/images/'.$value);
	}
}

if (!function_exists('get_client_ip')) {
	/**
	 * Generate image_url on view
	 * 
	 * @return string   
	 */
	function get_client_ip() {
		$ci =& get_instance();
		$ip_address = $ci->input->ip_address();;
		// return
		return $ip_address;
	}
}

if (!function_exists('get_preferences')) {
	/**
	 * Generate image_url on view
	 * 
	 * @return string   
	 */
	function get_preferences($name)
    {
		$ci =& get_instance();

        $val  = '';
        $name = trim($name);
            // is not auto loaded
        $ci->db->select('pref_value');
        $ci->db->where('pref_nm', $name);
        $result = $ci->db->get('com_preferences')->row_array();
        if ($result) {
            $pref_value = $result['pref_value'];
        }

        return $pref_value;
    }
}

if (!function_exists('asset')) {
	/**
	 * asset url
	 * 
	 * @return string   
	 */
	function asset($value) {
		return base_url('assets/'.$value);
	}
}

if(!function_exists('url')){
	/**
	 * base url 
	 * 
	 * @return string   
	 */
	function url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->base_url($uri, $protocol);
	}
}





