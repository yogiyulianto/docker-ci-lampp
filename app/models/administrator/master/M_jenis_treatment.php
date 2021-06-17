<?php

class M_jenis_treatment extends MY_Model {

    //get_all_jenis_treatment
    public function get_all_jenis_treatment($params) 
    {
        $sql = "SELECT * FROM jenis_treatment ORDER BY nama ASC LIMIT ?,?";
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
        return $this->db->query("SELECT * FROM jenis_treatment where jenis_treatment_id = ? ",$params)->row();
    }

    //get_jenis_treatment_by_id
    public function get_jenis_treatment_by_id($params) 
    {
        $sql = "SELECT * FROM jenis_treatment WHERE jenis_treatment_id = ?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get_total_data
    public function get_total_jenis_treatment() 
    {
        $sql = "SELECT count(*) as 'total' FROM jenis_treatment";
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
        $sql = "SELECT RIGHT(jenis_treatment_id, 4)'last_number'
                FROM jenis_treatment 
                ORDER BY jenis_treatment_id DESC 
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
