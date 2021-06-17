<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
// require(APPPATH.'/libraries/RestController.php');  

class Perawat extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // load model
        $this->load->model('administrator/master/M_perawat');
    }

    // get treatment
    public function data_perawat_post(){
        $user_id = $this->post('user_id');
        $result = $this->M_perawat->get_perawat_data_by_id(array($user_id));
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

	// get data perawat
    public function data_perawat_get(){
        $perawat_id = $this->get('user_id');
		$result = $this->M_perawat->get_perawat_id($perawat_id);

		if($result){
            $message = "Data ditemukan!";
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

	// update data perawat
	public function data_perawat_put(){
        $perawat_id = $this->put('user_id');
		$data['dt'] = [
				'full_name' => $this->put('full_name'),
                'user_mail' => $this->put('user_mail'),
                'phone' => $this->put('phone'),
				'address' => $this->put('address'),
				'user_name' => $this->put('user_name'),
				'user_pass' => $this->bcrypt->hash_password(md5($this->put('user_pass'))),
		];
		if(!empty($perawat_id)){
			$result = $this->M_perawat->update_perawat_id($data, $perawat_id);
			if($result){
				$message = "Data berhasil diubah!";
				$response = array(
					'status' => true,
					'message' => $message,
					'result' => $result
				);
				$this->response($response, 200);
			} 
		} else {
			$message = "Data tidak lengkap!";
			$response = array(
				'status' => false,
				'message' => $message
			);
			$this->response($response, 404);
		}
    }

	// get nota by order_id
    public function nota_get(){
        $order_id = $this->get('order_id');
		$result = $this->M_perawat->get_nota_by_id($order_id);

		if($result){
            $message = "Data ditemukan!";
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

	// get all review by perawat_id
    public function review_get(){
        $perawat_id = $this->get('perawat_id');
		$result = $this->M_perawat->get_all_review($perawat_id);

		if($result){
            $message = "Data ditemukan!";
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

	// get history pemesanan by pasien_id
	public function history_pemesanan_get(){
		$perawat_id = $this->get('perawat_id');
		$result = $this->M_perawat->get_history_by_id($perawat_id);

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

    // get treatment
    public function data_order_get(){
        $user_id = $this->get('user_id');
		$order_id = $this->get('order_id');
		
        if ($order_id === null) {
			$result = $this->M_perawat->get_order_by_perawat($user_id);
        } else {
			$result = $this->M_perawat->get_order_by_perawat($user_id, $order_id);
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
}
