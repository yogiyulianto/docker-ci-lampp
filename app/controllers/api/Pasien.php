<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
// require(APPPATH.'/libraries/RestController.php');  

class Pasien extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // load model
        $this->load->model('administrator/master/M_pasien');
    }

	// get pasien by_id
	public function data_pasien_get(){
        $pasien_id = $this->get('user_id');
		$result = $this->M_pasien->get_pasien_id($pasien_id);

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

	public function data_pasien_put(){
        $pasien_id = $this->put('user_id');
		$data['dt'] = [
				'full_name' => $this->put('full_name'),
                'user_mail' => $this->put('user_mail'),
                'phone' => $this->put('phone'),
				'address' => $this->put('address'),
				'user_name' => $this->put('user_name'),
				'user_pass' => $this->bcrypt->hash_password(md5($this->put('user_pass'))),
				'latitude' => $this->put('latitude'),
                'longitude' => $this->put('longitude')
		];
		if(!empty($pasien_id)){
			$result = $this->M_pasien->update_pasien_id($data, $pasien_id);
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


	// get all review by pasien_id
    public function review_get(){
        $pasien_id = $this->get('pasien_id');
		$result = $this->M_pasien->get_all_review($pasien_id);

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

	// get nota by order_id
    public function nota_get(){
        $order_id = $this->get('order_id');
		$result = $this->M_pasien->get_nota_by_id($order_id);

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
			$pasien_id = $this->get('pasien_id');
			$result = $this->M_pasien->get_history_by_id($pasien_id);
	
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


		// get lokasi pasien by pasien_id
		public function lokasi_pasien_get(){
			$user_id = $this->get('user_id');
			$result = $this->M_pasien->get_lokasi_by_id($user_id);
	
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
    public function data_pasien_post(){
        $user_id = $this->post('user_id');
        $result = $this->M_pasien->get_pasien_data_by_id(array($user_id));
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

	// get pemesanan
	public function data_order_get(){
        $user_id = $this->get('user_id');
		$order_id = $this->get('order_id');
		
        if ($order_id === null) {
			$result = $this->M_pasien->get_order_by_pasien($user_id);
        } else {
			$result = $this->M_pasien->get_order_by_pasien($user_id, $order_id);
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

	// get all layanan
    public function layanan_get(){
        $result = $this->M_pasien->get_all_layanan();
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

	// get all perawat
    public function perawat_get(){
        $result = $this->M_pasien->get_all_perawat();
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

	// get all jasa
    public function select_jasa_get(){
        $result = $this->M_pasien->get_all_jasa();
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

	// post tambah layanan
	public function tambah_layanan_post(){
        $order_id = $this->post('order_id');
		$prefix = date('ymd');
        $params_prefix = $prefix . '%';
		$rand = rand(0000, 9999);
		$order_detail_id = $this->M_pasien->generate_id($prefix, $params_prefix);
		$data['dt'] = [
				'order_id' => $this->post('order_id'),
				'jenis_treatment_id' => $this->post('jenis_treatment_id'),
                'tanggal_treatment' => $this->post('tanggal_treatment'),
                'longitude' => $this->post('longitude'),
				'latitude' => $this->post('latitude'),
				'order_detail_id' => $order_detail_id . $rand,
		];
		if(!empty($order_id)){
			$result = $this->M_pasien->insert_layanan($data);
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

	// edit tambah lokasi
	public function lokasi_pasien_put(){
        $order_id = $this->put('order_id');
		$data['dt'] = [
				'latitude' => $this->put('latitude'),
                'longitude' => $this->put('longitude')
		];
		if(!empty($order_id)){
			$result = $this->M_pasien->update_lokasi_id($data, $order_id);
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

    
}
