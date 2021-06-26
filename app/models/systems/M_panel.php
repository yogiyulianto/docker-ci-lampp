<?php

class M_panel extends MY_Model {

    //get all
    public function get_all() {
        $this->db->select('*')
                ->from('com_log')
                ->join('user', 'user.user_id = com_log.mdb', 'left')
                ->order_by('com_log.mdd', 'desc')
                ->limit(10);
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
        $this->db->from('com_log')->where('mdd', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }


    public function get_user_last_login()
    {
        $sql = "SELECT * FROM ( SELECT a.*, b.full_name,b.user_img FROM com_user_login a JOIN user b on a.user_id = b.user_id ORDER BY a.login_date DESC ) as rst GROUP BY rst.user_id LIMIT 10";
        $query = $this->db->query($sql);        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

}
