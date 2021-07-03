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
		$this->load->library('tupload');
		$this->load->library('form_validation');
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
		$course_id = $this->post('course_id');

        if($token && $course_id && $user_id) {

			$checkDataExist = $this->course->check_exist($token);
			if($checkDataExist) {
				$params = array(
					'user_id' => $user_id,
					'course_id' => $course_id,
					'token' => $token,
					'mdb' => $user_id,
					'mdd' => date('Y-m-d H:i:s'),
				);

				$result = $this->course->insert('course_enroll', $params);
				if($result){
					$message = "Pendaftaran berhasil!";
					$params_token = array(
						'token_sts' => 1,
					);
					$where = array(
						'token' => $token
					);
					$this->course->update('token', $params_token, $where);
				} else {
					$message = "Pendaftaran gagal!";
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
				$message = "Pendaftaran tidak lengkap!";
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
			$result = $this->course->assignmentByid($course_id);

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


	//post assignment upload file
	public function assignment_post(){
		$this->form_validation->set_rules('lesson_id', 'Lesson ID', 'trim|required');
		$this->form_validation->set_rules('section_id', 'Section ID', 'trim|required');
		$this->form_validation->set_rules('course_id', 'Course ID', 'trim|required');
		$this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
		// $this->form_validation->set_rules('attachment', 'Video', 'trim|required');
		$lesson_id = $this->post('lesson_id');
		$section_id = $this->post('section_id');
		$course_id = $this->post('course_id');
        $user_id = $this->post('user_id');
		$attachment = $_FILES;
        if($this->form_validation->run() != FALSE) {

			$config['upload_path'] = 'assets/video/course/';
            $config['allowed_types'] = '*';
			$config['file_name'] = $user_id . '_' . date('Ymdhis');
            $this->load->library('upload', $config);
			
            if($this->upload->do_upload('attachment'))
            {
                //Get uploaded file information
                $upload_data = $this->upload->data();
				// print_r($upload_data);die;
				$params = array(
					'lesson_id' => $lesson_id,
					'section_id' => $section_id,
					'course_id' => $course_id,
					'user_id' => $user_id,
					'attachment' => base_url(). 'assets/video/course/' . $config['file_name']. $upload_data['file_ext'],
					// 'deadline' => $deadline,
					'attachment_type' => $upload_data['file_type'],
					'mdb' => $user_id,
					'mdb_name' => $user_id,
					'mdd' => date('Y-m-d H:i:s'),
				);
				$result = $this->course->insert('course_assignment', $params);
				if($result){
					$message = "Data berhasil ditambahkan!";
				} else {
					$message = "Data gagal ditambahkan!";
				}

			$response = array(
				'status' => true,
				'message' => $message,
			);
			$this->response($response, 200);
		} else {
				$message = $this->form_validation->error_array();
				$response = array(
					'status' => false,
					'message' => $message
				);
				$this->response($response, 404);
		}
            }
				
    }
	// public function assignment_post(){
	// 	$this->form_validation->set_rules('lesson_id', 'Lesson ID', 'trim|required');
	// 	$this->form_validation->set_rules('section_id', 'Section ID', 'trim|required');
	// 	$this->form_validation->set_rules('course_id', 'Course ID', 'trim|required');
	// 	$this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
	// 	// $this->form_validation->set_rules('attachment', 'Video', 'trim|required');
	// 	$lesson_id = $this->post('lesson_id');
	// 	$section_id = $this->post('section_id');
	// 	$course_id = $this->post('course_id');
    //     $user_id = $this->post('user_id');
	// 	$attachment = $_FILES;
	// 	// $response = array(
	// 	// 	'status' => true,
	// 	// 	'message' => $attachment['attachment']['name'],
	// 	// );
	// 	// $this->response($response, 200);
    //     if($this->form_validation->run() != FALSE) {

	// 		 // upload config
	// 		 $config['upload_path'] = 'assets/video/course/';
	// 		 $config['allowed_types'] = '*';
	// 		 $config['file_name'] = $user_id . '_' . date('Ymdhis');
			 
	// 		 $this->tupload->initialize($config);

	// 		 // process upload images
	// 		 $this->tupload->do_upload_image('attachment', 128, false);
	// 			$data = $this->tupload->data();
				
	// 			$params = array(
	// 				'lesson_id' => $lesson_id,
	// 				'section_id' => $section_id,
	// 				'course_id' => $course_id,
	// 				'user_id' => $user_id,
	// 				'attachment' => 'assets/video/course/' . $data['file_name'],
	// 				// 'deadline' => $deadline,
	// 				'attachment_type' => $_FILES['attachment']['type'],
	// 				'mdb' => $user_id,
	// 				'mdb_name' => $user_id,
	// 				'mdd' => date('Y-m-d H:i:s'),
	// 			);
	// 			$result = $this->course->insert('course_assignment', $params);
	// 			if($result){
	// 				$message = "Data berhasil ditambahkan!";
	// 			} else {
	// 				$message = "Data gagal ditambahkan!";
	// 			}

	// 		$response = array(
	// 			'status' => true,
	// 			'message' => $message,
	// 		);
	// 		$this->response($response, 200);
	// 	} else {
	// 			$message = $this->form_validation->error_array();
	// 			$response = array(
	// 				'status' => false,
	// 				'message' => $message
	// 			);
	// 			$this->response($response, 404);
	// 	}
    // }


	// get course not registered by user_id
	public function not_registered_get(){
        $user_id = $this->get('user_id');

        if($user_id) {
			$result = $this->course->notRegisteredCourseByid($user_id);

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
