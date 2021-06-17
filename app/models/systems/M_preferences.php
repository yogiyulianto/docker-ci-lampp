<?php

class M_preferences extends MY_Model {

    public function get_all_group()
    {
        $sql = "SELECT pref_group FROM com_preferences GROUP BY pref_group";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    public function get_pref_by_group_id($params){
        $sql = "SELECT * FROM com_preferences WHERE pref_group = ?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    public function get_all_pref($params){
        $sql = "SELECT * FROM com_preferences ORDER BY pref_group ASC LIMIT  ? ,?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    public function get_pref_by_id($params){
        $sql = "SELECT * FROM com_preferences WHERE pref_id = ?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    public function get_total_pref(){
        $sql = "SELECT COUNT('pref_id') as total FROM com_preferences";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }
}
