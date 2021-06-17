<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
// require(APPPATH.'/libraries/RestController.php');  

class Order extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // load model
        $this->load->model('administrator/M_order');
    }

    // add order
    public function add_post(){
        // cek input
        $this->form_validation->set_rules('pasien_id', 'Pasien ID', 'trim|required');
		$this->form_validation->set_rules('tanggal_order', 'Tanggal Order', 'trim|required');
		$this->form_validation->set_rules('tanggal_treatment', 'Tanggal Treatment', 'trim|required');
		$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
		$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
		$this->form_validation->set_rules('pasien_name', 'Nama Pasien', 'trim|required');
        // process
        if ($this->form_validation->run() !== FALSE) {
            // generate id
            $prefix = date('ymd');
            $params_prefix = $prefix . '%';
            $order_id = $this->M_order->generate_id($prefix, $params_prefix);
    	    // params
            $params = array(
                'order_id' => $order_id,
                'pasien_id' => $this->post('pasien_id'),
                'tanggal_order' => $this->post('tanggal_order'),
                'tanggal_treatment' => $this->post('tanggal_treatment'),
                'latitude' => $this->post('latitude'),
                'longitude' => $this->post('longitude'),
                'order_st' => 0,
                'mdb' => $this->post('pasien_id'),
                'mdb_name' => $this->post('pasien_name'),
                'mdd' => date('Y-m-d H:i:s'),
            );
            // process
            $result = $this->M_order->insert('orders', $params);
            if($result){
                $message = "Input data berhasi!";
                $response = array(
                    'status' => true,
                    'message' => $message,
                    'data' => $params
                );
                $this->response($response, 200);
            } else {
                $message = "Input data tidak berhasil";
                $response = array(
                    'status' => false,
                    'message' => $message
                );
                $this->response($response, 404);
            }
        } else {
            $message = "Isian tidak lengkap!";
            $response = array(
                'status' => false,
                'message' => $message
            );
            $this->response($response, 404);
        }
    }
    // add detail order
    public function add_detail_post(){
        // cek input
        $this->form_validation->set_rules('order_id', 'Order ID', 'trim|required');
		$this->form_validation->set_rules('jenis_treatment_id', 'Jenis Treatment ID', 'trim|required');
		$this->form_validation->set_rules('mdb', 'Mdb', 'trim');
		$this->form_validation->set_rules('mdb_name', 'Mdb Nama', 'trim');
        // process
        if ($this->form_validation->run() !== FALSE) {
            // generate id
            $order_id = $this->post('order_id');
            $order_detail_id = $this->M_order->generate_id($order_id);
    	    // params
            $params = array(
                'order_detail_id' => $order_detail_id,
                'order_id' => $order_id,
                'jenis_treatment_id' => $this->post('jenis_treatment_id'),
                'mdb' => $this->post('mdb'),
                'mdb_name' => $this->post('mdb_name'),
                'mdd' => date('Y-m-d H:i:s'),
            );
            // process
            $result = $this->M_order->insert('orders_detail', $params);
            if($result){
                $message = "Input data berhasi!";
                $response = array(
                    'status' => true,
                    'message' => $message,
                    'data' => $params
                );
                $this->response($response, 200);
            } else {
                $message = "Input data tidak berhasil";
                $response = array(
                    'status' => false,
                    'message' => $message
                );
                $this->response($response, 404);
            }
        } else {
            $message = "Isian tidak lengkap!";
            $response = array(
                'status' => false,
                'message' => $message
            );
            $this->response($response, 404);
        }
    }
    // update order
    public function update_status_post(){
        // cek input
        $this->form_validation->set_rules('order_id', 'Order ID', 'trim|required');
		$this->form_validation->set_rules('perawat_id', 'Perawat ID', 'trim');
		$this->form_validation->set_rules('perawat_name', 'Perawat Name', 'trim');
        // process
        if ($this->form_validation->run() !== FALSE) {
    	    // params
            $params = array(
                'order_st' => 2,
                'mdb' => $this->post('perawat_id'),
                'mdb_name' => $this->post('perawat_name'),
                'mdd' => date('Y-m-d H:i:s'),
            );
            $where = array(
                'order_id' => $this->post('order_id')
            );
            // process
            $result = $this->M_order->update('orders', $params, $where);
            if($result){
                $message = "Update data berhasi!";
                $response = array(
                    'status' => true,
                    'message' => $message,
                    'data' => $params
                );
                $this->response($response, 200);
            } else {
                $message = "Update data tidak berhasil";
                $response = array(
                    'status' => false,
                    'message' => $message
                );
                $this->response($response, 404);
            }
        } else {
            $message = "Isian tidak lengkap!";
            $response = array(
                'status' => false,
                'message' => $message
            );
            $this->response($response, 404);
        }
    }
    // get treatment
    public function treatment_get(){
        $jenis_treatment_id = $this->get('jenis_treatment_id');
        if ($jenis_treatment_id == '') {
            $result = $this->db->get('jenis_treatment')->result();
            $message = "Data ditemukan!";
            $response = array(
                'status' => true,
                'message' => $message,
                'result' => $result
            );
            $this->response($response, 200);
        } else {
            $this->db->where('jenis_treatment_id', $jenis_treatment_id);
            $result = $this->db->get('jenis_treatment')->result();
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

    
}