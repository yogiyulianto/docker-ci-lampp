<?php

class M_dashboard extends MY_Model {

    public function get_total_jenis_treatment()
    {
        $sql = "SELECT COUNT(*) as 'total' FROM jenis_treatment";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }

    public function get_total_order()
    {
        $sql = "SELECT COUNT(*) as 'total' FROM orders";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }

    public function get_total_perawat()
    {
        $sql = "SELECT COUNT(*) as 'total' from user a 
        JOIN com_role_user b ON a.user_id = b.user_id 
        WHERE b.role_id = '02002'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }

    public function get_total_pasien()
    {
        $sql = "SELECT COUNT(*) as 'total' from user a 
        JOIN com_role_user b ON a.user_id = b.user_id 
        WHERE b.role_id = '02003'";
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
        $sql = "SELECT d.full_name as perawat_name, e.full_name as pasien_name, a.tanggal_order 
                FROM orders a
                LEFT JOIN perawat b ON a.perawat_id = b.perawat_id
                LEFT JOIN pasien c ON a.pasien_id = c.pasien_id
                LEFT JOIN user d ON b.user_id = d.user_id
                LEFT JOIN user e ON c.user_id = e.user_id
                GROUP BY a.order_id ORDER BY a.tanggal_order DESC LIMIT 5";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

}
