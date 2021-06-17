<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('slice', 'session'));
		$this->load->helper('url');
		
	}

	public function my404()
	{
		$this->output->set_status_header('404');
		$data = array(
			'BASE_URL'	=> base_url(),
			'error_code' => '404',
			'error_title' => 'SORRY!',
			'error_message' => "The page you’re looking for was not found."
		);
		$this->load->view('base/errors',$data);
	}

	public function my401()
	{
		$this->output->set_status_header('401');
		$data = array(
			'BASE_URL'	=> base_url(),
			'error_code' => '401',
			'error_title' => 'Unauthorized!',
			'error_message' => "You don't have permissions to access on this page"
		);
		$this->load->view('base/errors',$data);
	}
	public function my500()
	{
		$this->output->set_status_header('500');
		$data = array(
			'BASE_URL'	=> base_url(),
			'error_code' => '500',
			'error_title' => 'SORRY!',
			'error_message' => 'Internal Server Error'
		);
		$this->load->view('base/errors',$data);
	}



}
