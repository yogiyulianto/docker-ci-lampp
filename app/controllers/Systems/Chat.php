<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Chat extends PrivateBase{

    public $options;
    public $pusher;

    public function __construct()
	{
		parent::__construct();
		$this->config_pusher();
    }
    
    public function send_chat()
	{
		
        // get_data
		$username = $this->com_user('user_name');
        $message = $this->input->post('message',true);
        // set params
		$data['username'] = $username;
		$data['message'] = $message;
		$data['timestamp'] = date('Y-m-d H:i:s');
		$result = $this->pusher->trigger('chat-kuy', 'chat', $data);
		if ($result) {
            return $this->output->set_status_header(201)->set_output(json_encode(['success' => true,'message' => 'Message created']));
		} else {
			return $this->output->set_status_header(500)->set_output(json_encode(['success' => false,'message' => 'Message failed to create']));
		}
	}

	public function someone_is_typing()
	{
		$data['username'] = $this->com_user('user_name');
		$result = $this->pusher->trigger('chat-kuy', 'typing', $data);
		if ($result) {
			return $this->output->set_status_header(200)->set_output(json_encode(['success' => true]));
		} else {
			return $this->output->set_status_header(500)->set_output(json_encode(['success' => false]));
		}
    }
    public function config_pusher()
	{
		$this->options = [
			'cluster' => 'ap1',
			'useTLS' => 'true'
		];
		$this->pusher = new Pusher\Pusher('4f98bfaae3edcce213b4', '8b304444fe65a327e173', '955396',$this->options);
	}
}