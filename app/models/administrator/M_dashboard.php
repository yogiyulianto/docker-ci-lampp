<?php

class M_dashboard extends MY_Model {

    public function get_total_materi()
    {
        $sql = "SELECT COUNT(*) as 'total' FROM materi";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }

    public function get_total_kehamilan()
    {
        $sql = "SELECT COUNT(*) as 'total' FROM kehamilan";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }
    public function get_total_konsultasi()
    {
        $sql = "SELECT COUNT(*) as 'total' FROM konsultasi";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }


    public function get_total_users()
    {
        $sql = "SELECT COUNT(*) as 'total' from user a 
        JOIN com_role_user b ON a.user_id = b.user_id 
        WHERE b.role_id = '2004'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }

    public function get_last_order()
    {
        $sql = "SELECT COUNT(*) as 'total' FROM course";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

}
