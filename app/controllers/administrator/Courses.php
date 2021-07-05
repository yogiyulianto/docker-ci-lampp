<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Courses extends PrivateBase {

    const PAGE_TITLE = 'Pelatihan';
    const PAGE_HEADER = 'Pelatihan';
    const PAGE_URL = 'administrator/courses/';
    const SESSION_SEARCH = 'search_courses_admin';

    protected $page_limit = 10;
    // constructor
    public function __construct() {
        parent::__construct();
        // CONST
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD MODEL
		$this->load->model('administrator/master/M_course', 'course');

        // LOAD LIBRARY
        $this->load->library('tupload');
    }
    // COURSE MASTER
    public function index() {
		// error_reporting(0);
        // PAGE RULES
        $this->_set_page_rule('R');
        // get search
        $sess_search = $this->session->userdata(self::SESSION_SEARCH);
        $search['category_id'] = $sess_search['category_id'];
        $search['fasilitator_id'] = $sess_search['fasilitator_id'];
        $search['course_st']    = $sess_search['course_st'];
        $search['sort_by']    = ($sess_search['sort_by']) ? $sess_search['sort_by'] : "title-asc";
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->course->get_total_courses($search);
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = $this->uri->segment(4,0);
        $this->pagination->initialize($config);
        // params 
        $limit = array((int)$from,$config['per_page']);
        //get data
        $data['rs_id'] = $this->course->get_all($search,$limit);
        $data['rs_search'] = $search;
        $data['pagination'] = $this->pagination->create_links();

        view(self::PAGE_URL . 'index', $data);
    }

	public function add() {
        $this->_set_page_rule('C');
        // get data & parse
        $data['rs_teacher'] = $this->course->get_all_teacher();
		// echo'<pre>';
		// print_r($data['rs_teacher']);
        // render view
        view(self::PAGE_URL . 'add', $data);
    }

	public function add_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('fasilitator_id','Instruktur','trim|required');
        $this->form_validation->set_rules('title','Judul','trim|required');
        $this->form_validation->set_rules('level','Tingkatan','trim|required');
        $this->form_validation->set_rules('description','Deskripsi','trim|required');
        $this->form_validation->set_rules('summary','Untuk Siapa Pelatihan','trim|required');
        $this->form_validation->set_rules('requirements[]','Persyaratan','trim');
        $this->form_validation->set_rules('outcomes[]','Luaran','trim');
        $this->form_validation->set_rules('price','Harga','trim');
        $this->form_validation->set_rules('discount_price','Harga Setelah Diskon','trim');
        $this->form_validation->set_rules('is_free_course','Centang Pelatihan Gratis','trim');
        $this->form_validation->set_rules('course_overview_url','URL Cuplikan Pelatihan','trim');
        $this->form_validation->set_rules('course_overview_thumbnail','Thumbnail Pelatihan','trim');
        $this->form_validation->set_rules('meta_keywords','Meta Keywords','trim');
        $this->form_validation->set_rules('meta_description','Meta Description','trim');
        $this->form_validation->set_rules('course_st','Status Pelatihan','trim');
        $this->form_validation->set_rules('is_top_course','Status Unggulan','trim');
        // get last di role
        $course_id = generate_id();

        // process
        if ($this->form_validation->run() !== FALSE) {
            if (!empty($_FILES['course_overview_thumbnail']['tmp_name'])) {
                // upload config
                $config['upload_path'] = 'assets/images/course/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = $course_id . '_thumbnail_' . date('Ymdhis');
                $this->tupload->initialize($config);
                // process upload images
                if ($this->tupload->do_upload_image('course_overview_thumbnail', 128, false)) {
                    $data_upload = $this->tupload->data();
                    $file_name = 'assets/images/course/'.$data_upload['file_name'];
                }
                $this->notification->send(self::PAGE_URL.'add', 'error',  $this->tupload->display_errors());
            }
            // update params
            $params = array(
				// 'course_id' => $course_id,
                'fasilitator_id' => $this->input->post('fasilitator_id',TRUE),
                'title' => $this->input->post('title',TRUE),
                'slug' => slugify(html_escape($this->input->post('title',TRUE))),
                'level' => $this->input->post('level',TRUE),
                'description' => $this->input->post('description',TRUE),
                'summary' => $this->input->post('summary',TRUE),
                'requirements' => $this->trim_and_return_json($this->input->post('requirements',TRUE)),
                'outcomes' => $this->trim_and_return_json($this->input->post('outcomes',TRUE)),
                'is_free_course' => $this->input->post('is_free_course',TRUE) ?? 'no',
                'price' => $this->input->post('price',TRUE),
				'discount_price' => $this->input->post('discount_price',TRUE),
                'is_top_course' => $this->input->post('is_top_course',TRUE) ?? 'no',
                'course_overview_url' => $this->convert_youtube_url($this->input->post('course_overview_url',TRUE)),
                'course_overview_thumbnail' => (isset($file_name)) ? $file_name : '',
                'meta_keywords' => $this->input->post('meta_keywords',TRUE),
                'meta_descriptions' => $this->input->post('meta_description',TRUE),
                'course_st' => $this->input->post('course_st',TRUE),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert

            if ($this->course->insert('course', $params)) {

                //sukses notif
                $this->notification->send(self::PAGE_URL.'edit/'.$course_id,'success', 'Data berhasil ditambahkan!');
            } else {
                $this->notification->send(self::PAGE_URL.'add', 'error', 'Data gagal ditambahkan!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'add', 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

	public function edit($course_id = '') {
        $this->_set_page_rule('U');
        //cek data
        if (empty($course_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        $rs_section = $this->course->get_all_section(array($course_id));
        $rs_section_merged = array();
        foreach ($rs_section as $key => $value) {
            $rs_section_merged[$key] = $value;
            $rs_section_merged[$key]['lessons'] = $this->course->get_lesson_by_section_id(array($value['section_id']));
        }
        //parsing
        $data = array(
            'course_id' => $course_id,
            'rs_section' => $rs_section_merged,
            'rs_teacher' => $this->course->get_all_teachers(),
            'result' => $this->course->get_by_id(array($course_id)),
        );

        //parsing and view content
        view(self::PAGE_URL.'edit', $data);
    }

	public function edit_process() {
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('course_id','Pelatihan','trim|required');
        $this->form_validation->set_rules('fasilitator_id','Instruktur','trim|required');
        $this->form_validation->set_rules('title','Judul','trim|required');
        $this->form_validation->set_rules('level','Tingkatan','trim|required');
        $this->form_validation->set_rules('description','Deskripsi','trim|required');
        $this->form_validation->set_rules('summary','Untuk Siapa Pelatihan','trim|required');
        $this->form_validation->set_rules('requirements[]','Persyaratan','trim');
        $this->form_validation->set_rules('outcomes[]','Luaran','trim');
        $this->form_validation->set_rules('price','Harga','trim');
        $this->form_validation->set_rules('discount_price','Harga Setelah Diskon','trim');
        $this->form_validation->set_rules('is_free_course','Centang Pelatihan Gratis','trim');
        $this->form_validation->set_rules('is_top_course','Centang Pelatihan Gratis','trim');
        $this->form_validation->set_rules('course_overview_url','URL Cuplikan Pelatihan','trim');
        $this->form_validation->set_rules('course_overview_thumbnail','Thumbnail Pelatihan','trim');
        $this->form_validation->set_rules('meta_keywords','Meta Keywords','trim');
        $this->form_validation->set_rules('meta_description','Meta Description','trim');
        $this->form_validation->set_rules('course_st','Status Pelatihan','trim');
        // get last di role
        $course_id = $this->input->post('course_id',TRUE);
        // process
        if ($this->form_validation->run() !== FALSE) {
            if (!empty($_FILES['course_overview_thumbnail']['tmp_name'])) {
                // upload config
                $config['upload_path'] = 'assets/images/course/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = $course_id . '_thumbnail_' . date('Ymdhis');
                $this->tupload->initialize($config);
                // process upload images
                if ($this->tupload->do_upload_image('course_overview_thumbnail', 128, false)) {
                    $data_upload = $this->tupload->data();
                    $file_name = 'assets/images/course/'.$data_upload['file_name'];
                }
                $this->notification->send(self::PAGE_URL.'edit/'. $course_id, 'error',  $this->tupload->display_errors());
            }
            // update params
            $params = array(
                'course_id' => $course_id,
                'fasilitator_id' => $this->input->post('fasilitator_id',TRUE),
                'title' => $this->input->post('title',TRUE),
                'slug' => slugify(html_escape($this->input->post('title',TRUE))),
                'level' => $this->input->post('level',TRUE),
                'description' => $this->input->post('description',TRUE),
                'summary' => $this->input->post('summary',TRUE),
                'requirements' => $this->trim_and_return_json($this->input->post('requirements',TRUE)),
                'outcomes' => $this->trim_and_return_json($this->input->post('outcomes',TRUE)),
                'is_free_course' => $this->input->post('is_free_course',TRUE) ?? 'no',
                'is_top_course' => $this->input->post('is_top_course',TRUE) ?? 'no',
                'price' => $this->input->post('price',TRUE),
                'discount_price' => $this->input->post('discount_price',TRUE),
                'course_overview_url' => $this->convert_youtube_url($this->input->post('course_overview_url',TRUE)),
                'course_overview_thumbnail' => (isset($file_name)) ? $file_name : $this->input->post('old_course_overview_thumbnail',TRUE),
                'meta_keywords' => $this->input->post('meta_keywords',TRUE),
                'meta_descriptions' => $this->input->post('meta_description',TRUE),
                'course_st' => $this->input->post('course_st',TRUE),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            $where = array(
                'course_id' => $course_id
            );
            // insert
            if ($this->course->update('course', $params,$where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL.'edit/'.$course_id, 'success', 'Data berhasil diubah!');
            } else {
                $this->notification->send(self::PAGE_URL.'edit/'.$course_id, 'error', 'Data gagal diubah!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/'.$course_id, 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

	// SECTION MASTER
    public function add_section($course_id){
        $this->_set_page_rule('C');
        // get data & parse
        $data = array(
            'course_id' => $course_id
        );
        // parse to view
        view( self::PAGE_URL .'section.add',$data );
    }

	public function add_section_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('course_id','ID Pelatihan','trim|required');
        $this->form_validation->set_rules('title','Judul','trim|required');
        // get global vars
        $course_id = $this->input->post('course_id',TRUE);
        // process
        if ($this->form_validation->run() !== FALSE) {
            // add params
            $params = array(
                'course_id' => $course_id,
                'title' => $this->input->post('title',TRUE),
                'order_no' => $this->course->get_last_section_order(array($course_id)),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->course->insert('course_section', $params)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL.'edit/'.$course_id,'success', 'Data berhasil ditambahkan!');
            } else {
                $this->notification->send(self::PAGE_URL.'add_section/'.$course_id, 'error', 'Data gagal ditambahkan!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'add_section/'.$course_id, 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

	public function edit_section($course_id,$section_id){
        $this->_set_page_rule('U');
        if (empty($section_id)) {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/'.$course_id, 'error', 'Data tidak ditemukan!');
        }
        // get data & parse
        $data = array(
            'result'  => $this->course->get_section_by_id(array($section_id)),
            'course_id' => $course_id
        );
        // parse to view
        view( self::PAGE_URL .'section.edit',$data);
    }

	public function edit_section_process() {
        $this->_set_page_rule('C');
        // cek input
        $this->form_validation->set_rules('course_id','ID Pelatihan','trim|required');
        $this->form_validation->set_rules('section_id','ID Bab','trim|required');
        $this->form_validation->set_rules('title','Judul','trim|required');
        // get global vars
        $course_id = $this->input->post('course_id',TRUE);
        $section_id = $this->input->post('section_id',TRUE);
        // process
        if ($this->form_validation->run() !== FALSE) {
            // add params
            $params = array(
                'course_id' => $course_id,
                'title' => $this->input->post('title',TRUE),
                'order_no' => $this->course->get_last_section_order(array($course_id)),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            $where = array(
                'section_id' => $section_id
            );
            // insert
            if ($this->course->update('course_section', $params,$where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL.'edit/'.$course_id,'success', 'Data berhasil diubah!');
            } else {
                $this->notification->send(self::PAGE_URL.'edit_section/'.$course_id, 'error', 'Data gagal ditambahkan!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit_section/'.$course_id, 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

	public function delete_section() {
		$this->_set_page_rule('D');
        if ($_GET['section_id'] != null) {
			$where = array(
				'section_id' => $_GET['section_id'],
			);
			if ($this->course->delete('course_section', $where)) {
				//sukses notif
				$this->notification->send(self::PAGE_URL, 'success', 'Data successfully deleted');
			} else {
				//default error
				$this->notification->send(self::PAGE_URL, 'error', 'Data failed to delete !');
			}
        } else {
            $this->notification->send(self::PAGE_URL, 'error', 'Data Not Found !');
        }
    }
	
	public function sort_section($course_id)
    {
        $data['course_id'] = $course_id;
        $this->load->view('administrator/courses/section/sort',$data);
    }
    // LESSON MASTER
    public function add_lesson($course_id){
        $this->_set_page_rule('C');
        // get data & parse
        $data = array(
            'course_id' => $course_id,
            'rs_section' => $this->course->get_all_section(array($course_id))
        );
        // parse to view
        view( self::PAGE_URL .'lesson.add',$data );
    }

	public function add_lesson_process() {
        $this->_set_page_rule('C'); 
        // load model
        // $this->load->model('m_video');
        // cek input
        $this->form_validation->set_rules('course_id','ID Pelatihan','trim|required');
        $this->form_validation->set_rules('section_id','Bab','trim|required');
        $this->form_validation->set_rules('title','Judul','trim|required');
        $this->form_validation->set_rules('lesson_type','Tipe Materi Pelajaran','trim|required');
        $this->form_validation->set_rules('summary','Ringkasan','trim|required');
        $this->form_validation->set_rules('video_url','Video Url','trim');
        // get global vars
        $course_id = $this->input->post('course_id',TRUE);
        $section_id = $this->input->post('section_id',TRUE);
        $lesson_id =  generate_id();
        $lesson_type_array = explode('-', $this->input->post('lesson_type',TRUE));
        $lesson_type = $lesson_type_array[0];
        // process
        if ($this->form_validation->run() !== FALSE) {
            // add params
            $params = array(
                // 'lesson_id' => $lesson_id,
                'section_id' => $section_id,
                'course_id' => $course_id,
                'title' => $this->input->post('title',TRUE),
                'lesson_type' => $lesson_type,
                'assignment_type' =>  (isset($assignment_type)) ? $assignment_type : 'attachment',
                'video_type' => (isset($video_type)) ? $video_type : 'YouTube',
                'video_url' => (isset($video_url)) ? $this->convert_youtube_url($video_url) : '',
                'attachment_type' => $lesson_type_array[1] ?? 'url',
                'attachment' => (isset($attachment)) ? $attachment : '',
                'gdocs_url' => (isset($gdocs_url)) ? $gdocs_url : '',
                'summary' => $this->input->post('summary',TRUE),
                'order_no' => $this->course->get_last_lesson_order(array($section_id)),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->course->insert('course_lesson', $params)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL.'edit/'.$course_id,'success', 'Data berhasil ditambahkan!');
            } else {
                $this->notification->send(self::PAGE_URL.'add_lesson/'.$course_id, 'error', 'Data gagal ditambahkan!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'add_lesson/'.$course_id, 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

	public function edit_lesson($course_id,$lesson_id){
        $this->_set_page_rule('U');
        if (empty($lesson_id)) {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/'.$course_id, 'error', 'Data tidak ditemukan!');
        }
        // get data & parse
        $data = array(
            'result'  => $this->course->get_lesson_by_id(array($lesson_id)),
            'rs_section' => $this->course->get_all_section(array($course_id)),
            'course_id' => $course_id
        );
        // parse to view
        view( self::PAGE_URL .'lesson.edit',$data);
    }

	public function edit_lesson_process() {
        $this->_set_page_rule('U');
        // load model
        // cek input
        $this->form_validation->set_rules('course_id','ID Pelatihan','trim|required');
        $this->form_validation->set_rules('section_id','ID Bab','trim|required');
        $this->form_validation->set_rules('title','Judul','trim|required');
        $this->form_validation->set_rules('lesson_type','Tipe Materi Pelajaran','trim|required');
        $this->form_validation->set_rules('summary','Ringkasan','trim|required');
        $this->form_validation->set_rules('video_url','Video Url','trim');
        // get global vars
        $course_id = $this->input->post('course_id',TRUE);
        $section_id = $this->input->post('section_id',TRUE);
        $lesson_id =  $this->input->post('lesson_id',TRUE);
        $lesson_type_array = explode('-', $this->input->post('lesson_type',TRUE));
        $lesson_type = $lesson_type_array[0];
        // process
        if ($this->form_validation->run() !== FALSE) {
            // add params
            $params = array(
                'section_id' => $section_id,
                'course_id' => $course_id,
                'title' => $this->input->post('title',TRUE),
                'lesson_type' => $lesson_type,
                'assignment_type' => 'attachment',
                'video_type' => (isset($video_type)) ? $video_type : 'YouTube',
                'video_url' => (isset($video_url)) ? $this->convert_youtube_url($video_url) : '',
                'attachment_type' => $lesson_type_array[1] ?? 'url',
                'attachment' => (isset($attachment)) ? $attachment : '',
                'summary' => $this->input->post('summary',TRUE),
                'order_no' => $this->course->get_last_lesson_order(array($section_id)),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            $where = array(
                'lesson_id' => $lesson_id,
            );
            // insert
            if ($this->course->update('course_lesson', $params,$where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL.'edit/'.$course_id,'success', 'Data berhasil diubah!');
            } else {
                $this->notification->send(self::PAGE_URL.'edit_lesson/'.$course_id.'/'.$lesson_id, 'error', 'Data failed to update !');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit_lesson/'.$course_id.'/'.$lesson_id,'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

	public function delete_lesson() {
		$this->_set_page_rule('D');
        if ($_GET['lesson_id'] != null) {
			$where = array(
				'lesson_id' => $_GET['lesson_id'],
			);
			if ($this->course->delete('course_lesson', $where)) {
				//sukses notif
				$this->notification->send(self::PAGE_URL, 'success', 'Data successfully deleted');
			} else {
				//default error
				$this->notification->send(self::PAGE_URL, 'error', 'Data failed to delete !');
			}
        } else {
            $this->notification->send(self::PAGE_URL, 'error', 'Data Not Found !');
        }
    }

	public function sort_lesson($section_id)
    {
        $data['section_id'] = $section_id;
        $this->load->view('administrator/courses/lesson/sort',$data);
    }

	 // QUIZ MASTER
	 public function add_quiz($course_id){
        $this->_set_page_rule('C');
        // get data & parse
        $data = array(
            'course_id' => $course_id,
            'rs_section' => $this->course->get_all_section(array($course_id))
        );
        // parse to view
        view( self::PAGE_URL .'quiz.add',$data );
    }

	public function add_quiz_process() {
        $this->_set_page_rule('C');
        // load model
        // cek input
        $this->form_validation->set_rules('course_id','ID Pelatihan','trim|required');
        $this->form_validation->set_rules('section_id','ID Bab','trim|required');
        $this->form_validation->set_rules('title','Judul','trim|required');
        $this->form_validation->set_rules('summary','Ringkasan','trim|required');
        // get global vars
        $course_id = $this->input->post('course_id',TRUE);
        $section_id = $this->input->post('section_id',TRUE);
        $lesson_id =  generate_id();
        $lesson_type = 'quiz';
        // process
        if ($this->form_validation->run() !== FALSE) {
            // add params
            $params = array(
                'lesson_id' => $lesson_id,
                'section_id' => $section_id,
                'course_id' => $course_id,
                'title' => $this->input->post('title',TRUE),
                'lesson_type' => $lesson_type,
                'summary' => $this->input->post('summary',TRUE),
                'order_no' => $this->course->get_last_lesson_order(array($section_id)),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            // insert
            if ($this->course->insert('course_lesson', $params)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL.'edit/'.$course_id,'success', 'Data berhasil ditambahkan!');
            } else {
                $this->notification->send(self::PAGE_URL.'add_quiz/'.$course_id, 'error', 'Data gagal ditambahkan!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'add_quiz/'.$course_id, 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

	public function edit_quiz($course_id,$quiz_id){
        $this->_set_page_rule('U');
        if (empty($quiz_id)) {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/'.$course_id, 'error', 'Data tidak ditemukan!');
        }
        // get data & parse
        $data = array(
            'result'  => $this->course->get_lesson_by_id(array($quiz_id)),
            'rs_section' => $this->course->get_all_section(array($course_id)),
            'course_id' => $course_id
        );
        // parse to view
        view( self::PAGE_URL .'quiz.edit',$data);
    }

	public function edit_quiz_process() {
        $this->_set_page_rule('U');
        // load model
        $this->form_validation->set_rules('course_id','ID Pelatihan','trim|required');
        $this->form_validation->set_rules('section_id','ID Bab','trim|required');
        $this->form_validation->set_rules('title','Judul','trim|required');
        $this->form_validation->set_rules('summary','Ringkasan','trim|required');
        // get global vars
        $course_id = $this->input->post('course_id',TRUE);
        $section_id = $this->input->post('section_id',TRUE);
        $lesson_id =  $this->input->post('lesson_id',TRUE);
        $lesson_type = 'quiz';
        // process
        if ($this->form_validation->run() !== FALSE) {
            // add params
            $params = array(
                'section_id' => $section_id,
                'course_id' => $course_id,
                'title' => $this->input->post('title',TRUE),
                'lesson_type' => $lesson_type,
                'summary' => $this->input->post('summary',TRUE),
                'order_no' => $this->course->get_last_lesson_order(array($section_id)),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            $where = array(
                'lesson_id' => $lesson_id,
            );
            // insert
            if ($this->course->update('course_lesson', $params,$where)) {
                //sukses notif
                $this->notification->send(self::PAGE_URL.'edit/'.$course_id,'success', 'Data berhasil diubah!');
            } else {
                $this->notification->send(self::PAGE_URL.'edit_quiz/'.$course_id.'/'.$lesson_id, 'error', 'Data failed to update !');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit_quiz/'.$course_id.'/'.$lesson_id, 'error', 'Ada Field Yang Tidak Sesuai. !');
        }
    }

	public function delete() {
		$this->_set_page_rule('D');
        if ($_GET['course_id'] != null) {
			$where = array(
				'course_id' => $_GET['course_id'],
			);
			if ($this->course->delete('course', $where)) {
				//sukses notif
				$this->notification->send(self::PAGE_URL, 'success', 'Data successfully deleted');
			} else {
				//default error
				$this->notification->send(self::PAGE_URL, 'error', 'Data failed to delete !');
			}
        } else {
            $this->notification->send(self::PAGE_URL, 'error', 'Data Not Found !');
        }
    }

	// ASSIGNMENT
    public function assignment($course_id){
        // PAGE RULES
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->course->get_total_assignment_by_course_id(array($course_id));
        $config['base_url'] = base_url(self::PAGE_URL.'index/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $this->pagination->initialize($config);
        // params 
        $params = array($course_id,(int)$from,$config['per_page']);
        //get data 
        $rs_id = $this->course->get_assignment_by_course_id($params);
        $data = array(
            'rs_id' => $rs_id,
            'pagination' => $this->pagination->create_links()
        );
        view(self::PAGE_URL . 'assignment_process/index', $data);
    }

    public function assignment_detail($lesson_id){
        // PAGE RULES
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->course->get_total_enrol_by_lesson_id(array($lesson_id));
        $config['base_url'] = base_url(self::PAGE_URL.'assignment_detail/'.$lesson_id.'/');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $config['uri_segment'] = 5;
        $from = $this->uri->segment(5,0);
        $this->pagination->initialize($config);
        // params 
        $params = array($lesson_id,(int)$from,$config['per_page']);
        //get data 
        $rs_id = $this->course->get_all_enrol_by_lesson_id($params);
        $data = array(
            'rs_id' => $rs_id,
            'pagination' => $this->pagination->create_links()
        );
        view(self::PAGE_URL . 'assignment_process/detail', $data);
    }
    public function assignment_detail_process($assignment_id){
        $this->_set_page_rule('U');
        //cek data
        if (empty($assignment_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        $rs_assignment = $this->course->get_detail_assignment_by_assignment_id(array($assignment_id));
        //parsing
        $data = array(
            'assignment_id' => $assignment_id,
            'rs_assignment' => $rs_assignment
        );
        //parsing and view content
        view(self::PAGE_URL.'assignment_process/detail-process', $data);
    }

    public function update_nilai_process(){
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('nilai','Nilai','trim|required');
        // get id
        $assignment_id = $this->input->post('assignment_id', TRUE);
        $lesson_id = $this->input->post('lesson_id', TRUE);
        // process
        if ($this->form_validation->run() !== false) {
            // update params
            $params = array(
                'nilai' => $this->input->post('nilai', true),
                'catatan' => $this->input->post('catatan', true),
            );
            $where = array(
                'assignment_id' => $assignment_id
            );
            // update
            if ($this->course->update('course_assignment', $params, $where)) {
                    //sukses notif
                    $this->notification->send(self::PAGE_URL.'assignment_detail/'.$lesson_id, 'success', 'Data berhasil diubah!');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'assignment_detail/'.$lesson_id, 'error', 'Ada Field Yang Tidak Sesuai. !');
            }
        }
    }

	function trim_and_return_json($untrimmed_array){
        $trimmed_array = array();
        if (sizeof($untrimmed_array) > 0) {
            foreach ($untrimmed_array as $row) {
                if ($row != "") {
                    array_push($trimmed_array, $row);
                }
            }
        }
        return json_encode($trimmed_array);
    }

	function convert_youtube_url($string) {
        return preg_replace(
            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
            "//www.youtube.com/embed/$2",
            $string
        );
    }
}
