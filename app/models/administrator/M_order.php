<?php

class M_order extends MY_Model {

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

    //get_all_order
    public function get_all_order($params) 
    {
        $sql = "SELECT c.full_name as pasien_name, e.full_name as perawat_name, a.*, d.jumlah, d.treatment  from orders a
                LEFT JOIN pasien b on a.pasien_id = b.user_id
                LEFT JOIN user c on b.user_id = c.user_id
                LEFT JOIN perawat d on a.perawat_id = d.user_id
                LEFT JOIN user e on e.user_id = d.user_id
                LEFT JOIN (SELECT a.order_id,SUM(c.harga) as jumlah, GROUP_CONCAT(c.nama) as 'treatment' 
                FROM orders_detail a
                JOIN orders b on a.order_id = b.order_id
                JOIN jenis_treatment c on a.jenis_treatment_id = c.jenis_treatment_id
                ORDER BY a.order_id) d ON d.order_id = a.order_id 
                ORDER BY a.order_id ASC LIMIT ?,?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    public function test($params)
    {
        return $this->db->query("SELECT * FROM orders where order_id = ? ",$params)->row();
    }

    //get_order_by_id
    public function get_order_by_id($params) 
    {
        $sql = "SELECT * FROM orders WHERE order_id = ?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }
    // get list perawat
    public function get_list_perawat() 
    {
        $sql = "SELECT b.user_id, b.full_name from com_user a
                JOIN user b ON a.user_id = b.user_id
                JOIN perawat c ON a.user_id = c.user_id
                WHERE user_st = 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get_total_data
    public function get_total_order() 
    {
        $sql = "SELECT COUNT(*) as total from orders a
                LEFT JOIN pasien b on a.pasien_id = b.user_id
                LEFT JOIN user c on b.user_id = c.user_id
                LEFT JOIN perawat d on a.perawat_id = d.user_id
                LEFT JOIN user e on e.user_id = d.user_id
                LEFT JOIN (SELECT a.order_id,SUM(c.harga) as jumlah, GROUP_CONCAT(c.nama) as 'treatment' 
                FROM orders_detail a
                JOIN orders b on a.order_id = b.order_id
                JOIN jenis_treatment c on a.jenis_treatment_id = c.jenis_treatment_id
                ORDER BY a.order_id) d ON d.order_id = a.order_id 
                ORDER BY a.order_id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }
    //get_total_data
    public function get_last_id() 
    {
        $sql = "SELECT RIGHT(order_id, 4)'last_number'
                FROM orders 
                ORDER BY order_id DESC 
                LIMIT 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['last_number']) + 1;
            if ($number >= 99999) {
                return false;
            }
            $zero = '';
            for ($i = strlen($number); $i < 4; $i++) {
                $zero .= '0';
            }
            return '1' . $zero . $number;
        } else {
            // create new number
            return '10001';
        }
    }

}
