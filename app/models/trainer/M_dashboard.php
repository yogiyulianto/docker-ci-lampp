<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends MY_Model {

    public function get_my_income($params){
        $sql = "SELECT SUM(a.enroll_id) as 'total' FROM course_enroll a
                JOIN course b ON a.course_id = b.course_id
                WHERE b.fasilitator_id = ? AND b.course_st = '1'";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return array();
    }

    public function get_my_course_transactions($params){
        $sql = "SELECT a.* ,b.title as 'course_name' , c.full_name as 'student_name' FROM course_enroll a 
                JOIN course b ON a.course_id = b.course_id 
                JOIN user c ON a.user_id = c.user_id 
                WHERE b.fasilitator_id = ? ORDER BY a.mdd DESC LIMIT 10";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    public function get_my_courses($params){
        $sql = "SELECT COUNT(a.course_id) as 'total' FROM course a
                WHERE a.fasilitator_id = ? AND a.course_st = '1'";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return array();
    }

    public function get_my_students($params){
        $sql = "SELECT COUNT(a.user_id) as 'total' FROM course_enroll a
                JOIN course b ON a.course_id = b.course_id
                WHERE b.fasilitator_id = ? AND b.course_st = '1'";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return array();
    }
}

/* End of file M_dashboard.php */
