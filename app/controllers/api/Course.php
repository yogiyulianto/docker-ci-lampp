<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Course extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // load model
        $this->load->model('administrator/master/M_course', 'course');
    }

	// get all data course & by_id
	public function index_get(){
        $course_id = $this->get('course_id');

        if ($course_id === null) {
			$result = $this->course->course();
        } else {
			$result = $this->course->course($course_id);
		}

        if($result){
            $message = "Data ditemukan!";
            $response = array(
                'status' => true,
                'message' => $message,
                'result' => $result
            );
            $this->response($response, 200);
        } else {
            $message = "Data tidak ditemukan!";
            $response = array(
                'status' => false,
                'message' => $message
            );
            $this->response($response, 404);
        }
    }

	// get course by user id
	public function users_get(){
        $user_id = $this->get('user_id');

        if($user_id) {
			$result = $this->course->courseByid($user_id);

			if($result){
				$message = "Data ditemukan!";
			} else {
				$message = "Data tidak ditemukan!";
			}
			$response = array(
				'status' => true,
				'message' => $message,
				'result' => $result
			);
			$this->response($response, 200);
		} else {
				$message = "Data tidak lengkap!";
				$response = array(
					'status' => false,
					'message' => $message
				);
				$this->response($response, 404);
		}
    }


	// post register course with token
	public function users_post(){
        $user_id = $this->post('user_id');
		$token = $this->post('token');
		$course_id = $this->input->post('course_id');
		$enroll_id = $this->course->get_last_id();

        if($token && $course_id && $user_id) {

			$checkDataExist = $this->course->check_exist($token);
			if($checkDataExist) {
				$params = array(
					'enroll_id' => $enroll_id,
					'user_id' => $user_id,
					'course_id' => $course_id,
					'token' => $token,
					'mdb' => $user_id,
					'mdd' => date('Y-m-d H:i:s'),
				);

				$result = $this->course->insert('course_enroll', $params);
				if($result){
					$message = "Data berhasil ditambahkan!";
					$params_token = array(
						'token_sts' => 1,
					);
					$where = array(
						'token' => $token
					);
					$this->course->update('token', $params_token, $where);
				} else {
					$message = "Data gagal ditambahkan!";
				}

			} else {
				$message = "Token tidak terdaftar!";
			}

			$response = array(
				'status' => true,
				'message' => $message,
			);
			$this->response($response, 200);
		} else {
				$message = "Data tidak lengkap!";
				$response = array(
					'status' => false,
					'message' => $message
				);
				$this->response($response, 404);
		}
    }

	// get all course assignment by course id & get detail assignment_id
	public function assignment_get(){
        $course_id = $this->get('course_id');
		$assignment_id = $this->get('assignment_id');

        if($course_id) {
			$result = $this->course->assignment($course_id);

			if($result){
				$message = "Data ditemukan!";
			} else {
				$message = "Data tidak ditemukan!";
			}
			$response = array(
				'status' => true,
				'message' => $message,
				'result' => $result
			);
			$this->response($response, 200);
		}else if($assignment_id){
			$result = $this->course->assignmentByid($assignment_id);

			if($result){
				$message = "Data ditemukan!";
			} else {
				$message = "Data tidak ditemukan!";
			}
			$response = array(
				'status' => true,
				'message' => $message,
				'result' => $result
			);
			$this->response($response, 200);
		} else {
				$message = "Data tidak lengkap!";
				$response = array(
					'status' => false,
					'message' => $message
				);
				$this->response($response, 404);
		}
    }

	//get result course by user id
	public function score_get(){
        $user_id = $this->get('user_id');

        if($user_id) {
			$result = $this->course->score($user_id);

			if($result){
				$message = "Data ditemukan!";
			} else {
				$message = "Data tidak ditemukan!";
			}
			$response = array(
				'status' => true,
				'message' => $message,
				'result' => $result
			);
			$this->response($response, 200);
		} else {
				$message = "Data tidak lengkap!";
				$response = array(
					'status' => false,
					'message' => $message
				);
				$this->response($response, 404);
		}
    }

}
