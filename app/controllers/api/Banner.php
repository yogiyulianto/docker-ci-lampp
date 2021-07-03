<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
// require(APPPATH.'/libraries/RestController.php');  

class Banner extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // load model
        $this->load->model('administrator/M_banner');
    }

    // get treatment
    public function index_get(){
        $base_url = base_url();
        $result = $this->M_banner->get_all_banner($base_url);
        if(empty($result)){
            $message = "Data tidak ditemukan!";
            $response = array(
                'status' => false,
                'message' => $message
            );
            $this->response($response, 404);
        } else {
            $message = "Data ditemukan!";
            $response = array(
            'status' => true,
            'message' => $message,
            'result' => $result
        );
            $this->response($response, 200);
        }
    }

    
}