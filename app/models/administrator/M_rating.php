<?php

class M_rating extends MY_Model {

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
        $sql = "SELECT LEFT(blog_id, 1) as 'last_number'
                FROM blogs 
                ORDER BY blog_id DESC 
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
        $sql = "SELECT a.*, b.title as 'category_title' FROM blogs a JOIN category b ON a.category_id = b.category_id LIMIT $from ,$page";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }
    //get all
    public function get_all_rating($base_url) {
        $sql = "SELECT a.rating, a.review, b.full_name as name , concat('$base_url', b.user_img) as user_img, d.title as course_title FROM rating a
                JOIN user b ON a.user_id = b.user_id
                JOIN course_enroll c ON a.user_id = c.user_id
                JOIN course d ON c.`course_id` = d.course_id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get by id
    public function get_by_id($blog_id) {
        $this->db->select('*');
        $this->db->from('blogs');
        $this->db->where('blogs.blog_id', $blog_id);
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
        $this->db->from('blogs');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }

    // get all parent
    public function get_all_category() {
        $this->db->select('*');
        $this->db->from('category');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }


}
