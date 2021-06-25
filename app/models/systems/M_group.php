<?php

class M_group extends MY_Model {

    //generate id terakhir
    public function get_last_id() {
        $sql = "SELECT group_id'last_number' FROM com_group ORDER BY group_id DESC LIMIT 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['last_number']) + 1;
            if ($number >= 99) {
                return false;
            }
            $zero = '';
            for ($i = strlen($number); $i < 2; $i++) {
                $zero .= '0';
            }
            return $zero . $number;
        } else {
            // create new number
            return '01';
        }
    }

    //get all
    public function get_all($number, $offset) {
        $this->db->select('*');
        $this->db->from('com_group');
        $this->db->limit($number, $offset);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get by id
    public function get_by_id($group_id) {
        $this->db->select('*');
        $this->db->from('com_group');
        $this->db->where('com_group.group_id', $group_id);
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

}
