<?php

class M_user extends MY_Model {

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
        // print_r($result);die;
        if (!empty($result)) {
            // get user
            if (md5($password) === $result['user_pass']) {
                return $result;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    //get all roles
    public function get_user_login_all_roles_api($username, $password) {
        // process
        // get hash key
        $result = $this->get_user_role($username, '2004');
        // print_r($result);die;
        if (!empty($result)) {
            // get user
            if (md5($password) === $result['user_pass']) {
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
    function get_user($params) {
        $sql = "SELECT *
              FROM register WHERE hash = '$params'
              LIMIT 0, 1 ";
        $query = $this->db->query($sql);
        // echo "<pre>"; echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }
    function get_user_role($params) {
        $sql = "SELECT a.*, b.role_id, c.*, d.* FROM com_user a 
        INNER JOIN com_role_user b ON a.user_id = b.user_id 
        LEFT JOIN com_role c ON b.role_id = c.role_id 
        LEFT JOIN user d ON d.user_id = a.user_id 
        WHERE a.user_name = ? ORDER BY b.role_default ASC
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
    function get_user_role_api($params) {
        $sql = "SELECT a.*, b.role_id, c.*, d.* FROM com_user a 
        INNER JOIN com_role_user b ON a.user_id = b.user_id 
        LEFT JOIN com_role c ON b.role_id = c.role_id 
        LEFT JOIN user d ON d.user_id = a.user_id 
        WHERE a.user_name = ? AND a.user_id = '1' ORDER BY b.role_default ASC
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

    function check_user_enroll($params) {
        $sql = "SELECT * FROM user_enroll a
                WHERE user_id = ? AND now() BETWEEN start_date AND end_date";
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
    
}
