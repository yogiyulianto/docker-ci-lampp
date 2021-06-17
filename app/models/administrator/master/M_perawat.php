<?php

class M_perawat extends MY_Model {

    //generate id terakhir
    public function generate_id($prefixdate, $params) {
        $sql = "SELECT RIGHT(user_id, 4) as 'last_number'
                FROM com_user
                WHERE user_id LIKE ?
                ORDER BY user_id DESC
                LIMIT 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['last_number']) + 1;
            if ($number > 9999) {
                return false;
            }
            $zero = '';
            for ($i = strlen($number); $i < 4; $i++) {
                $zero .= '0';
            }
            return $prefixdate . $zero . $number;
        } else {
            // create new number
            return $prefixdate . '0001';
        }
    }

    //get all roles
    public function get_user_login_all_roles($username, $password) {
        // process
        // get hash key
        $result = $this->get_user_detail_with_all_roles($username);
        if (!empty($result)) {
            // get user
            if ($this->bcrypt->check_password(md5($password), $result['user_pass'])) {
                return $result;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    // get user detail with auto role
    function get_user_detail_with_all_roles($params) {
        $sql = "SELECT a.*, b.role_id, c.*,d.*,f.portal_id
              FROM com_user a
              --  JOIN com_role_user b ON a.user_id = b.user_id
              -- LEFT JOIN com_role c ON b.role_id = c.role_id
              INNER JOIN com_role_user b ON a.user_id = b.user_id
              INNER JOIN com_role c ON b.role_id = c.role_id
			    INNER JOIN user d ON a.user_id = d.user_id
              INNER JOIN com_role_menu e ON c.role_id = e.role_id
              INNER JOIN com_menu f ON e.nav_id = f.nav_id
              WHERE a.user_name = ? 
              ORDER BY b.role_default ASC
              LIMIT 0, 1 ";
        $query = $this->db->query($sql, $params);
        // echo "<pre>"; echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }
    // get user detail with auto role
    function get_perawat_data_by_id($params) {
        $sql = "SELECT a.user_id, a.user_name, a.user_mail, c.role_name, e.perawat_id
              FROM com_user a
              --  JOIN com_role_user b ON a.user_id = b.user_id
              -- LEFT JOIN com_role c ON b.role_id = c.role_id
              INNER JOIN com_role_user b ON a.user_id = b.user_id
              INNER JOIN com_role c ON b.role_id = c.role_id
			  INNER JOIN user d ON a.user_id = d.user_id
              INNER JOIN perawat e ON a.user_id = e.user_id
              WHERE a.user_id = ? ";
        $query = $this->db->query($sql, $params);
        // echo "<pre>"; echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }
    // get user detail with auto role
    function get_data_order_by_perawat_id($params) {
        $sql = "SELECT a.*, b.full_name as pasien_name
                FROM orders a
                INNER JOIN user b ON a.pasien_id = b.user_id
                WHERE a.perawat_id = ? ";
        $query = $this->db->query($sql, $params);
        // echo "<pre>"; echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //get all
    public function get_all($rs_search, $number, $offset) {
        $this->db->select('com_user.*,user.full_name,com_role.role_name,user.user_img');
        $this->db->from('com_user');
        $this->db->join('user', 'user.user_id = com_user.user_id', 'left');
        $this->db->join('com_role_user', 'com_role_user.user_id = user.user_id', 'left');
        $this->db->join('com_role', 'com_role_user.role_id = com_role.role_id', 'left');
        if (!empty($rs_search['full_name'])) {
            $this->db->like('user.full_name', $rs_search['full_name'], 'both');
        }
        if (!empty($rs_search['user_st'])) {
            $this->db->where('com_user.user_st', $rs_search['user_st']);
        }
        $this->db->where("(com_role_user.role_id='02002')", NULL, FALSE);

        $this->db->limit($number, $offset);
        $query = $this->db->get();
        // echo $this->db->last_query();exit();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //all role
    public function get_all_role() {
        $this->db->select('*');
        $this->db->from('com_role');
        $this->db->where("(role_id='02002' OR role_id='02003')", NULL, FALSE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //all role
    public function get_all_role_without_developer() {
        $sql    = "SELECT * FROM com_role a
                    WHERE a.role_id != '01001'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get by username
    public function get_by_username($username) {
        $this->db->select('*');
        $this->db->from('com_user');
        $this->db->join('user', 'user.user_id = com_user.user_id', 'left');
        $this->db->join('com_role_user', 'com_role_user.user_id = user.user_id', 'left');
        $this->db->join('com_role', 'com_role_user.role_id = com_role.role_id', 'left');
        $this->db->where('com_user.user_name', $username);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get by id
    public function get_by_id($user_id) {
        $this->db->select('*');
        $this->db->from('com_user');
        $this->db->join('user', 'user.user_id = com_user.user_id', 'left');
        $this->db->join('com_role_user', 'com_role_user.user_id = user.user_id', 'left');
        $this->db->join('com_role', 'com_role_user.role_id = com_role.role_id', 'left');
        $this->db->where('com_user.user_id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //count all
    public function count_all() {
        $this->db->select('*');
        $this->db->from('com_user');
        $this->db->join('user', 'user.user_id = com_user.user_id', 'left');
        $this->db->join('com_role_user', 'com_role_user.user_id = user.user_id', 'left');
        $this->db->join('com_role', 'com_role_user.role_id = com_role.role_id', 'left');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }

    //cek email
    public function is_exist_email($params) {
        $query = $this->db->get_where('com_user', array('user_mail' => $params));
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return 0;
    }

    //cek username
    public function is_exist_username($params) {
        $query = $this->db->get_where('com_user', array('user_name' => $params));
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return 0;
    }

    //insert
    public function insert($table, $params) {
        return $this->db->insert($table, $params);
    }

    //delete
    public function delete($table, $where) {
        $this->db->where($where);
        return $this->db->delete($table);
    }

    //update
    public function update($table, $params, $where) {
        $this->db->set($params);
        $this->db->where($where);
        return $this->db->update($table);
    }

    function update_user_logout($user_id) {
        // update by this date
        $sql = "UPDATE com_user_login SET logout_date = NOW() WHERE user_id = ? AND DATE(login_date) = CURRENT_DATE";
        return $this->db->query($sql, $user_id);
    }

    public function get_user_last_login($user_id) {
        $sql = "SELECT logout_date FROM com_user_login WHERE user_id = ? AND logout_date IS NOT NULL ORDER BY logout_date DESC LIMIT 1";
        $query = $this->db->query($sql, $user_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['logout_date'];
        }
        return array();
    }

    // get list portal by user
    function get_list_portal_user_by_id($params) {
        $sql = "SELECT e.portal_id, e.portal_nm, e.portal_title, e.portal_icon
            FROM com_role_user a
            INNER JOIN com_role b ON a.role_id = b.role_id
            INNER JOIN com_role_menu c ON b.role_id = c.role_id
            INNER JOIN com_menu d ON c.nav_id = d.nav_id
            INNER JOIN com_portal e ON d.portal_id = e.portal_id
            WHERE a.user_id = ?
            GROUP BY e.portal_id
            ORDER BY e.portal_nm ASC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return '';
        }
    }

	// update data perawat by id
	public function update_perawat_id($data, $user_id) {

		$data = $this->db->query("UPDATE user a INNER JOIN com_user b ON a.user_id = b.user_id " 
		. "SET a.full_name = '".$data["dt"]["full_name"]."', b.user_mail = '".$data["dt"]["user_mail"]."', a.phone = '".$data["dt"]["phone"]."', a.address = '".$data["dt"]["address"]."', b.user_name = '".$data["dt"]["user_name"]."', b.user_pass = '".$data["dt"]["user_pass"]."' "
		. "WHERE a.user_id = '$user_id' ");

		return $data;
	}

	// get nota by order_id
	public function get_nota_by_id($order_id = null) {

		$data = $this->db->query("SELECT a.tanggal_order, c.full_name, d.user_mail, f.nama, a.order_st, f.harga from orders a "
		. "INNER JOIN perawat b ON a.perawat_id = b.perawat_id "
		. "INNER JOIN user c ON c.user_id = b.user_id "
		. "INNER JOIN com_user d ON d.user_id = c.user_id "
		. "INNER JOIN orders_detail e ON e.order_id = a.order_id "
		. "INNER JOIN jenis_treatment f ON f.jenis_treatment_id = e.jenis_treatment_id WHERE a.order_id = '$order_id'")->last_row();

		return $data;
	}

	// get all review by perawat_id
	public function get_all_review($perawat_id = null) {

		$data = $this->db->query("SELECT a.rating, c.full_name, e.role_name from orders a "
                        . "INNER JOIN pasien b ON a.pasien_id = b.pasien_id "
                        . "INNER JOIN user c ON b.user_id = c.user_id "
						. "INNER JOIN com_role_user d ON d.user_id = c.user_id  "
                        . "INNER JOIN com_role e ON e.role_id = d.role_id WHERE a.perawat_id = '$perawat_id' AND d.role_id = '02003'
						")->result();

		return $data;
	}

	// get history pemesanan by pasien_id
	public function get_history_by_id($perawat_id = null) {

		$data = $this->db->query("SELECT  a.order_id, c.full_name, e.role_name, a.order_st from orders a "
                        . "INNER JOIN pasien b ON a.pasien_id = b.pasien_id "
                        . "INNER JOIN user c ON b.user_id = c.user_id "
						. "INNER JOIN com_role_user d ON d.user_id = c.user_id  "
                        . "INNER JOIN com_role e ON e.role_id = d.role_id WHERE a.perawat_id = '$perawat_id' AND d.role_id = '02003' AND a.order_st = '2' ")->result();

		return $data;
	}

	// get daftar pemesanan by perawat_id
	public function get_order_by_perawat($perawat_id = null, $order_id = null) {

		if ($order_id === null){
			$data = $this->db->query("SELECT  a.order_id, a.tanggal_order, c.full_name,  a.order_st, d.user_mail, f.harga from orders a "
                        . "INNER JOIN pasien b ON a.pasien_id = b.pasien_id "
                        . "INNER JOIN user c ON b.user_id = c.user_id "
						. "INNER JOIN com_user d ON d.user_id = c.user_id "
						. "INNER JOIN orders_detail e ON e.order_id = a.order_id "
                        . "INNER JOIN jenis_treatment f ON f.jenis_treatment_id = e.jenis_treatment_id WHERE a.perawat_id = '$perawat_id' AND a.order_st = '1' ")->result();
			} else {
				$data = $this->db->query("SELECT  a.tanggal_order, c.full_name,  a.order_st, d.user_mail, f.harga, f.nama,  c.latitude, c.longitude from orders a "
				. "INNER JOIN pasien b ON a.pasien_id = b.pasien_id "
				. "INNER JOIN user c ON b.user_id = c.user_id "
				. "INNER JOIN com_user d ON d.user_id = c.user_id "
				. "INNER JOIN orders_detail e ON e.order_id = a.order_id "
				. "INNER JOIN jenis_treatment f ON f.jenis_treatment_id = e.jenis_treatment_id WHERE a.perawat_id = '$perawat_id' AND a.order_id = '$order_id' ")->last_row();
			}

		return $data;
	}

	// get data perawat
	public function get_perawat_id($perawat_id = null) {

		$data = $this->db->query("SELECT a.full_name, b.user_mail, a.phone, a.address, b.user_name, b.user_pass from user a INNER JOIN com_user b ON a.user_id = b.user_id WHERE a.user_id = '$perawat_id' ")->last_row();
		
		return $data;
	}
}
