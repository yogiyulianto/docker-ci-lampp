<?php

class M_subscribe extends MY_Model {

    //generate id terakhir
    public function generate_id($prefixdate) {
        $sql = "SELECT RIGHT(order_id, 4) as 'last_number'
                FROM orders
                ORDER BY order_id DESC
                LIMIT 1";
        $query = $this->db->query($sql);
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
    //generate id terakhir
    public function generate_order_detail_id($prefix) {
        $sql = "SELECT RIGHT(order_detail_id, 4) as 'last_number'
                FROM orders_detail
                WHERE order_id = '$prefix'
                ORDER BY order_detail_id DESC
                LIMIT 1";
        $query = $this->db->query($sql);
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
            return $prefix . $zero . $number;
        } else {
            // create new number
            return $prefix . '0001';
        }
    }
    

    //insert
    public function insert($table, $params) {
        return $this->db->insert($table, $params);
    }

    //update
    public function update($table, $params, $where) {
        $this->db->set($params);
        $this->db->where($where);
        return $this->db->update($table);
    }


    //generate id terakhir
    function get_last_id() {
        $sql = "SELECT LEFT(webinar_id, 1) as 'last_number'
                FROM webinar 
                ORDER BY webinar_id DESC 
                LIMIT 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['last_number']) + 1;
            if ($number >= 10) {
                return false;
            }
            $zero = '';
            for ($i = strlen($number); $i < 2; $i++) {
                $zero .= '0';
            }
            return $number . $zero;
        } else {
            // create new number
            return '10';
        }
    }

    //get all
    public function get_all($from ,$page) {
        $sql = "SELECT * FROM user_enroll a
                INNER JOIN user b ON a.user_id = b.user_id 
                INNER JOIN com_user c ON a.user_id = c.user_id
                LIMIT $from ,$page";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }
    //get all
    public function get_all_webinar($base_url) {
        $sql = "SELECT a.webinar_id, a.title as webinar_title, 
        a.slug, a.content, concat('$base_url', a.image) as image,
        FROM webinar a
        WHERE webinar_st != 'draft'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get by id
    public function get_by_id($id) {
        $sql = "SELECT * FROM user_enroll a
                INNER JOIN user b ON a.user_id = b.user_id 
                INNER JOIN com_user c ON a.user_id = c.user_id
                WHERE a.id = '$id'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //count all
    public function count_all() {
        $sql = "SELECT count(*) as total FROM user_enroll a
                INNER JOIN user b ON a.user_id = b.user_id 
                INNER JOIN com_user c ON a.user_id = c.user_id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }

    // get all parent
    public function get_all_category() {
        $this->db->select('*');
        $this->db->from('category_webinar');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }
    // get all parent
    public function get_all_user() {
        $this->db->select('*');
        $this->db->from('user a');
        $this->db->join('com_role_user b', 'a.user_id = b.user_id', 'inner');
        $this->db->where('b.role_id', '2006');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }


}
