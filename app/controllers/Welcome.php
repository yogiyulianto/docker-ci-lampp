<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Welcome extends CI_Controller {

    const PAGE_TITLE = 'Welcome';
    const PAGE_HEADER = 'Welcome';
    const PAGE_URL = 'welcome';

    // constructor
    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        $this->load->model('administrator/cms/M_testimonial');

        // $this->load->model('api/M_blogs');
    }

    public function index() {
        //get data
        $survey = $this->M_testimonial->get_all_survey();
        $data = array('survey' => $survey);
        // render view
        return view(self::PAGE_URL.'/index', $data);
    }

    public function webview($id){
        $data = array('response' => $this->M_blogs->get_by_id($id));
        return view(self::PAGE_URL.'/blog', $data);
    }
    public function privacy_policy(){
        return view(self::PAGE_URL.'/privacy');
    }
    public function about(){
        return view(self::PAGE_URL.'/about');
    }
}
