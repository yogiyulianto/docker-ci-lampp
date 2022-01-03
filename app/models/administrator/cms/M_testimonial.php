<?php

class M_testimonial extends MY_Model {

    //get all
    public function get_all_survey() {
        $sql = "SELECT * FROM testimoni";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    public function get_survey_by_id($survey_id) {
        $this->db->select('*');
        $this->db->from('testimoni');
        $this->db->where('testimoni.id', $survey_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //count all
    public function count_all() {
        $this->db->select('*');
        $this->db->from('testimoni');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
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
}