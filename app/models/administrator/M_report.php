<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_report extends MY_Model {

    //get_all_peminjaman
    public function get_all_peminjaman($params) 
    {
        $sql = "SELECT a.*,b.full_name as 'peminjam',c.full_name as 'penanggungjawab' 
                FROM peminjaman a 
                LEFT JOIN user b ON a.peminjam_user_id = b.user_id
                LEFT JOIN user c ON a.penggunaan_penanggungjawab_id = c.user_id
                WHERE a.peminjaman_st != 'draft' AND ( MONTH(a.penggunaan_tgl_mulai) = ? OR MONTH(a.penggunaan_tgl_selesai) = ?)
                ORDER BY a.mdd 
                LIMIT ?,?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get_all_peminjaman
    public function get_list_peminjaman($params) 
    {
        $sql = "SELECT a.*,b.full_name as 'peminjam',c.full_name as 'penanggungjawab' 
                FROM peminjaman a 
                LEFT JOIN user b ON a.peminjam_user_id = b.user_id
                LEFT JOIN user c ON a.penggunaan_penanggungjawab_id = c.user_id
                WHERE a.peminjaman_st != 'draft' AND ( MONTH(a.penggunaan_tgl_mulai) = ? OR MONTH(a.penggunaan_tgl_selesai) = ?)
                ORDER BY a.mdd";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    // get_peminjaman_by_id
    public function get_peminjaman_by_id($params) 
    {
        $sql = "SELECT a.*,b.full_name as 'penanggungjawab' FROM peminjaman a 
                LEFT JOIN user b ON a.penggunaan_penanggungjawab_id = b.user_id
                WHERE peminjaman_id = ? ";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get data perangkat by peminjaman_id
    public function get_perangkat_by_peminjaman_id($params) 
    {
        $sql = "SELECT a.perangkat_id,b.perangkat_nama,b.perangkat_kode,(SELECT b.status FROM perangkat_status b WHERE a.perangkat_id = b.perangkat_id ORDER BY mdd DESC LIMIT 1) as 'status' FROM peminjaman_perangkat a 
                JOIN perangkat b ON a.perangkat_id = b.perangkat_id
                WHERE a.peminjaman_id = ? ";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get data perangkat by peminjaman_id
    public function get_returned_perangkat_by_peminjaman_id($params) 
    {
        $sql = "SELECT a.perangkat_id,a.perangkat_kode, a.perangkat_nama, b.returned_st as 'status'
                FROM perangkat a 
                JOIN peminjaman_perangkat b ON a.perangkat_id = b.perangkat_id";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get data perangkat by peminjaman_id
    public function get_pemakai_by_peminjaman_id($params) 
    {
        $sql = "SELECT a.peminjaman_user_id,b.* FROM peminjaman_pemakai a 
                JOIN pegawai b ON a.peminjaman_user_id = b.user_id
                WHERE a.peminjaman_id = ? ";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get_all_peminjaman
    public function get_total_peminjaman($params) 
    {
        $sql = "SELECT count(*) as 'total' FROM peminjaman a 
                LEFT JOIN user b ON a.peminjam_user_id = b.user_id
                LEFT JOIN user c ON a.penggunaan_penanggungjawab_id = c.user_id
                WHERE a.peminjaman_st != 'draft' AND ( MONTH(a.penggunaan_tgl_mulai) = ? OR MONTH(a.penggunaan_tgl_selesai) = ?)";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }


}

/* End of file M_report.php */
