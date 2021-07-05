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

	//get_total_courses
    public function get_total_courses($args = array()) {
        $params = array();
        $sql =  "SELECT COUNT(a.course_id) as 'total'
                FROM course a ";
                
                if ($args['fasilitator_id'] != "") {
                    $sql .= " WHERE a.fasilitator_id LIKE ?";
                    array_push($params, "%{$args['fasilitator_id']}%");
                }
                if ($args['course_st'] != "") {
                    $sql .= " AND a.course_st LIKE ?";
                    array_push($params, "%{$args['course_st']}%");
                }
                $sql .= " ORDER BY a.title ASC";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }

	 //get all
	 public function get_all($args = array(),$limit = array()) {
        $params = array();
        $sql =  "SELECT a.*, d.full_name as teacher_name , (SELECT count(c.user_id) as 'total_enrolled' FROM course_enroll c WHERE c.course_id = a.course_id) as 'enrolled_users' 
                FROM course a 
                JOIN user d on a.fasilitator_id = d.user_id";

                if ($args['fasilitator_id'] != "") {
                    $sql .= " AND a.fasilitator_id LIKE ?";
                    array_push($params, "%{$args['fasilitator_id']}%");
                }
                if ($args['course_st'] != "") {
                    $sql .= " AND a.course_st LIKE ?";
                    array_push($params, "%{$args['course_st']}%");
                }
                if ($args['sort_by'] != "mdd-desc") {
                    $sort = explode('-',$args['sort_by']);
                    $sql .= " ORDER BY a.". $sort[0] ." ".$sort[1];
                }
                if (!empty($limit)) {
                    $sql .= " LIMIT ?,?";
                    $params = array_merge($params, $limit);
                }
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

	 //get_total_student_enrol_in_a_courses
     public function get_total_assignment_by_course_id($params) {
        
        $sql =  "SELECT COUNT(rst.lesson_id) AS total
                FROM(SELECT a.lesson_id
                FROM course_lesson a
                JOIN course_section b on a.section_id  
                JOIN course c ON a.course_id = c.course_id
                WHERE a.lesson_type = 'video' AND a.course_id = ?
                GROUP BY a.lesson_id 
                ORDER BY a.course_id) rst";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }

	//get all
    public function get_assignment_by_course_id($params) {
        $sql = "SELECT a.lesson_id,a.lesson_type, a.title as lesson_title, a.assignment_type ,
                a.course_id, 
                b.title as section_titlle, c.title as course_title
                from course_lesson a
                JOIN course_section b on a.section_id  
                JOIN course c ON a.course_id = c.course_id
                WHERE a.lesson_type = 'video' AND a.course_id = ?
                GROUP BY a.lesson_id 
                ORDER BY a.course_id  ASC LIMIT ? , ?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

	//get_total_student_enrol_in_a_courses
    public function get_total_enrol_by_lesson_id($params) {
        
        $sql =  "SELECT COUNT(a.enroll_id) as total
                from course_enroll a
                JOIN `user` b on a.user_id = b.user_id
                JOIN course c on a.course_id = c.course_id
                JOIN com_user d on a.user_id = d.user_id 
                JOIN course_lesson e ON a.course_id = e.course_id
                JOIN course_assignment f ON f.lesson_id = e.lesson_id 
                WHERE e.lesson_id = ?
                ORDER BY a.enroll_id ASC";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }

	//get all
    public function get_all_enrol_by_lesson_id($params) {
        $sql = "SELECT * FROM (SELECT f.attachment , f.mdd, a.enroll_id,a.course_id , a.mdb ,a.mdb_name ,a.mdd as waktu, a.user_id, 
                b.full_name, b.phone, b.user_img ,f.attachment_type,
                c.title,e.lesson_id, f.nilai, f.assignment_id,
                d.user_mail 
                from course_enroll a
                JOIN `user` b on a.user_id = b.user_id
                JOIN course c on a.course_id = c.course_id
                JOIN com_user d on a.user_id = d.user_id 
                JOIN course_lesson e ON a.course_id = e.course_id
                JOIN course_assignment f ON f.lesson_id = e.lesson_id 
                WHERE e.lesson_id = ? 
                GROUP BY a.enroll_id 
                ORDER BY a.enroll_id ASC) rst
                GROUP BY rst.assignment_id  LIMIT ? , ?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

	//get by id
    public function get_detail_assignment_by_assignment_id($params) {
        $sql = "SELECT a.*,b.fasilitator_id from course_assignment a
                JOIN course b ON a.course_id = b.course_id 
                where a.assignment_id = ?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0){
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

	public function get_assignment_id()
    {
        $sql = "SELECT RIGHT(assignment_id, 4)'last_number'
                FROM course_assignment 
                ORDER BY assignment_id DESC 
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

		$data = $this->db->query("SELECT b.course_id, b.title, b.slug, b.level, b.description, b.meta_keywords, b.meta_descriptions, b.course_overview_thumbnail, b.banner, b.course_st from course_enroll a INNER JOIN course b ON a.course_id = b.course_id WHERE a.user_id = '$user_id' ")->result();

	return $data;
	}
	// get course by user id
	public function notRegisteredCourseByid($user_id = null) {

			$data = $this->db->query("SELECT b.course_id, b.title, b.slug, b.level, b.description, b.meta_keywords, b.meta_descriptions, b.course_overview_thumbnail, b.banner, CASE WHEN b.course_st = 1 THEN 'active' ELSE 'not-active' END
			AS course_st from course_enroll a INNER JOIN course b ON a.course_id = b.course_id WHERE a.user_id != '$user_id' ")->result();

		return $data;
	}

	// check token is true
	public function check_exist($token = null) {

		$data = $this->db->query("SELECT a.token from token a WHERE a.token = '$token' AND a.token_sts = 0")->last_row();

		return $data;
    }

	// get course assignment by course id
	public function assignment($course_id = null) {

		$data = $this->db->query("SELECT  b.title as bab, a.course_id, a.lesson_id, a.section_id, a.title as sub_bab, c.attachment, c.attachment, c.attachment_type, c.catatan, c.status, c.nilai from course_lesson a 
        INNER JOIN course_section b ON a.section_id = b.section_id 
        LEFT JOIN course_assignment c ON b.section_id = c.section_id 
        WHERE a.course_id = '$course_id' ")->result();

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

	// get all parent
    public function get_all_teacher() {
		$data = $this->db->query("SELECT d.full_name,a.user_id FROM com_user a JOIN com_role_user b ON a.user_id = b.user_id JOIN com_role c ON c.role_id = b.role_id JOIN user d ON d.user_id = a.user_id WHERE c.role_id = '2005'")->result();

		return $data;
    }

	// get all parent
    public function get_all_teachers() {
        $sql = "SELECT d.full_name,a.user_id FROM com_user a JOIN com_role_user b ON a.user_id = b.user_id JOIN com_role c ON c.role_id = b.role_id JOIN user d ON d.user_id = a.user_id WHERE c.role_id = '2005'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

	public function get_all_section($params){
        $sql = "SELECT *  FROM course_section WHERE course_id =  ? ORDER BY order_no ASC";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0){
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

	public function get_lesson_by_section_id($params)
    {
        $sql = "SELECT * FROM course_lesson WHERE section_id = ? ORDER BY order_no ASC";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0){
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

	 //get by id
	 public function get_by_id($params) {
        $sql = "SELECT a.*,b.full_name as 'trainer_name' 
            FROM course a JOIN user b ON a.fasilitator_id = b.user_id 
            WHERE a.course_id = ?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0){
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

	public function get_last_section_order($params) {
        $sql = "SELECT order_no
                FROM course_section
                WHERE course_id = ?
                ORDER BY mdd DESC 
                LIMIT 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['order_no']) + 1;
            return $number;
        } else {
            // create new number
            return 1;
        }
    }

	// get section_by_id
    public function get_section_by_id($params){
        $sql = "SELECT * FROM course_section WHERE section_id = ?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0){
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

	 // get_last_lesson_order
	 public function get_last_lesson_order($params) {
        $sql = "SELECT order_no
                FROM course_lesson
                WHERE section_id = ?
                ORDER BY mdd DESC 
                LIMIT 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['order_no']) + 1;
            return $number;
        } else {
            // create new number
            return 1;
        }
    }


	public function get_lesson_by_id($params){
        $sql = "SELECT * FROM course_lesson WHERE lesson_id = ?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0){
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }



}
