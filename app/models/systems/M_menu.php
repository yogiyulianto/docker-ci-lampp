<?php

class M_menu extends MY_Model {

    function get_last_id() {
        $sql = "SELECT RIGHT(nav_id, 8) AS 'last_number'
                FROM com_menu 
                ORDER BY nav_id DESC 
                LIMIT 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['last_number']) + 1;
            if ($number > 99999999) {
                return false;
            }
            $zero = '';
            for ($i = strlen($number); $i < 8; $i++) {
                $zero .= '0';
            }
            return '10' . $zero . $number;
        } else {
            // create new number
            return '10' . '00000001';
        }
    }

    //get all
    public function get_all_portal() {
        $sql = "SELECT a.*, COUNT(b.nav_id) as 'total_nav' 
		FROM com_portal a
		LEFT JOIN com_menu b ON a.portal_id = b.portal_id
		GROUP BY a.portal_id
		ORDER BY a.portal_id ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get all
    public function total_all_portal() {
        $sql = "SELECT COUNT(a.*) as 'total'
		FROM com_portal a
		LEFT JOIN com_menu b ON a.portal_id = b.portal_id
		GROUP BY a.portal_id
		ORDER BY a.portal_id ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get by id
    public function get_by_id($nav_id) {
        $this->db->select('*');
        $this->db->from('com_menu');
        $this->db->where('com_menu.nav_id', $nav_id);
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
        $this->db->from('com_group');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }

    public function get_all_menu_selected_by_parent($params) {
        $sql = "SELECT a.*, b.role_id, b.role_tp
                FROM com_menu a
                LEFT JOIN (SELECT * FROM com_role_menu WHERE role_id = ?) b ON a.nav_id = b.nav_id
                WHERE portal_id = ? AND parent_id = ?
                ORDER BY nav_no ASC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_all_menu_by_parent($params) {
        $sql = "SELECT * FROM com_menu
                WHERE portal_id = ? AND parent_id = ? 
                ORDER BY nav_no ASC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_detail_role_by_id($role_id) {
        $sql = "SELECT b.group_name, a.* 
                FROM com_role a
                INNER JOIN com_group b ON a.group_id = b.group_id
                WHERE role_id = ?";
        $query = $this->db->query($sql, $role_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // insert role menu
    function insert_role_menu($params) {
        $sql = "INSERT INTO com_role_menu (role_id, nav_id, role_tp) VALUES (?, ?, ?)";
        return $this->db->query($sql, $params);
    }

    // delete role menu
    function delete_role_menu($params) {
        $sql = "DELETE a.* FROM com_role_menu a
                INNER JOIN com_menu b ON a.nav_id = b.nav_id
                WHERE role_id = ? ";
        return $this->db->query($sql, $params);
    }

}
