<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_dashboard extends MY_model {

    public function total_portal() {
        $sql = "SELECT COUNT(*) as count_portal
		FROM com_portal";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['count_portal'];
        }
        return array();
    }

    public function total_role() {
        $sql = "SELECT COUNT(*) as count_role
		FROM com_role";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['count_role'];
        }
        return array();
    }

    public function total_menu() {
        $sql = "SELECT COUNT(*) as count_menu
		FROM com_menu WHERE active_st = 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['count_menu'];
        }
        return array();
    }

    public function total_user() {
        $sql = "SELECT COUNT(*) as count_user
		FROM com_user WHERE user_st = 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['count_user'];
        }
        return array();
    }

}
