<?php

class M_course extends MY_Model {

	public function get_last_id() 
    {
        $sql = "SELECT RIGHT(enroll_id, 4)'last_number'
                FROM course_enroll 
                ORDER BY enroll_id DESC 
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

	// get all data course & by_id
	public function course($course_id = null) {

		if ($course_id === null){
			$data = $this->db->query("SELECT  * from course a ORDER BY course_id DESC ")->result();
			} else {
				$data = $this->db->query("SELECT  * from course a WHERE a.course_id = '$course_id' ")->last_row();
			}

		return $data;
	}

	// get course by user id
	public function courseByid($user_id = null) {

			$data = $this->db->query("SELECT b.course_id, b.title, b.slug, b.level, b.description, b.meta_keywords, b.meta_descriptions from course_enroll a INNER JOIN course b ON a.course_id = b.course_id WHERE a.user_id = '$user_id' ")->last_row();

		return $data;
	}

	// check token is true
	public function check_exist($token = null) {

		$data = $this->db->query("SELECT a.token from token a WHERE a.token = '$token' AND a.token_sts = 0")->last_row();

		return $data;
    }

	// get course assignment by course id
	public function assignment($course_id = null) {

		$data = $this->db->query("SELECT * from course_assignment a WHERE a.course_id = '$course_id' ")->result();

	return $data;
	}

	// get course assignment by assignment id
	public function assignmentByid($assignment_id = null) {

		$data = $this->db->query("SELECT * from course_assignment a WHERE a.assignment_id = '$assignment_id' ")->last_row();

	return $data;
	}

	// get course assignment by assignment id
	public function score($user_id = null) {

		$data = $this->db->query("SELECT a.course_id, b.title, b.description, b.meta_keywords, b.meta_descriptions, SUM(a.nilai) as total from course_assignment a INNER JOIN course b ON a.course_id = b.course_id WHERE a.user_id = '$user_id' GROUP BY a.course_id")->result();

	return $data;
	}
}
