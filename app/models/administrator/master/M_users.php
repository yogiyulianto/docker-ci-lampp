<?php

class M_users extends MY_Model {

   // get data user by_id
	public function get_user_id($user_id = null) {

		$data = $this->db->query("SELECT a.user_name, a.user_mail, b.full_name, b.address, b.phone, b.user_img from com_user a INNER JOIN user b ON a.user_id = b.user_id WHERE a.user_id = '$user_id'")->last_row();
		
		return $data;
	}
}
