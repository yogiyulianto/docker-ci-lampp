<?php

class M_users extends MY_Model {

   // get data user by_id
	public function get_user_id($user_id = null) {

		$data = $this->db->query("SELECT a.role_id, a.nama, a.email, a.username, a.address from com_user a  WHERE a.user_id = '$user_id'")->last_row();
		
		return $data;
	}
}
