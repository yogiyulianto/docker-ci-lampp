<?php

class M_role extends MY_Model {

    //generate id terakhir
    public function get_last_id($group_id) {
        $sql = "SELECT RIGHT(role_id, 3)'last_number'
            FROM com_role 
            WHERE group_id = ?
            ORDER BY role_id DESC 
            LIMIT 1";
        $query = $this->db->query($sql, $group_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['last_number']) + 1;
            if ($number > 999) {
                return false;
            }
            $zero = '';
            for ($i = strlen($number); $i < 3; $i++) {
                $zero .= '0';
            }
            return $group_id . $zero . $number;
        } else {
            // create new number
            return $group_id . '001';
        }
    }

    //get all
    public function get_all($args = array(), $limit = array()) {


        $params = array();
        $sql = "SELECT a.*,b.group_name FROM com_role a
				INNER JOIN com_group b on a.group_id = b.group_id";

        if (!empty($args['role_name'])) {
            $sql .= " WHERE a.role_name LIKE ?";
            array_push($params, $args['role_name']);
        }
        if (!empty($args['group_id'])) {
            $sql .= " AND a.group_id = ?";
            array_push($params, $args['group_id']);
        }
        if (!empty($limit['number'])) {
            $sql .= " LIMIT BY = ?";
            array_push($params, $limit['number']);
        }
        if (!empty($limit['offset'])) {
            $sql .= " , ?";
            array_push($params, $limit['offset']);
        }
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //all role
    public function get_all_groups() {
        $this->db->select('*');
        $this->db->from('com_group');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get by id
    public function get_by_id($role_id) {
        $this->db->select('com_role.*, com_group.group_name');
        $this->db->from('com_role');
        $this->db->join('com_group', 'com_role.group_id = com_group.group_id', 'inner');
        $this->db->where('com_role.role_id', $role_id);
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

}
