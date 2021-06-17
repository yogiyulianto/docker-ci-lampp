<?php

class M_log extends MY_Model {

    //get all
    public function get_all($user_id, $number, $offset) {
        $this->db->select('*')
                ->from('com_log')
                ->join('user', 'com_log.mdb = user.user_id')
                ->where('com_log.mdb', $user_id)
                ->order_by('com_log.mdd', 'desc')
                ->limit($number, $offset);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //count all
    public function count_all($user_id) {
        $this->db->select('*');
        $this->db->from('com_log')->where('mdb', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }

    public function get_user_log($params) {
        $sql = "SELECT b.full_name,logs.mdb,logs.mdd,COUNT(IF(logs.action_type = 'U', 1, NULL)) as 'update',COUNT(IF(logs.action_type = 'C', 1, NULL)) as 'create',COUNT(IF(logs.action_type = 'D', 1, NULL)) as 'delete'
        FROM (SELECT * FROM com_log ORDER BY `mdd` DESC) AS logs
        JOIN user b ON logs.mdb = b.user_id 
        GROUP BY logs.mdb ORDER BY b.full_name ASC LIMIT ?,?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    public function count_user_log() {
        $sql = "SELECT count(*)
        FROM com_log
        GROUP BY mdb";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return array();
    }

    public function get_user_log_by_id($params) {
        $sql = "SELECT * FROM com_log a JOIN user b ON a.mdb = b.user_id WHERE a.mdb = ? ORDER BY a.mdd DESC LIMIT ?,?";
        $query = $this->db->query($sql,$params);        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    public function count_user_log_by_id($params) {
        $sql = "SELECT COUNT(*) AS total FROM com_log a JOIN user b ON a.mdb = b.user_id WHERE a.mdb = ? ORDER BY a.mdd DESC";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['total'];
        }
        return array();
    }


}
