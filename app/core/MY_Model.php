<?php

defined('BASEPATH') OR exit('No direct script access allowed');

    class MY_Model extends CI_Model {

    //insert
    public function insert($table ,$params)
    {
		$this->db->insert($table,$params);
		$query_string = $this->db->last_query();
		return $this->changelog($query_string,'C',$table);
	}
	// insert batch
    public function insert_batch($table ,$params)
    {
		$this->db->insert_batch($table,$params);
		$query_string = $this->db->last_query();
		return $this->changelog($query_string,'C',$table);
    }
    //delete
    public function delete($table ,$where)
    {
        $this->db->where($where);
		$this->db->delete($table);
		$query_string = $this->db->last_query();
		return $this->changelog($query_string,'D',$table,$where);
		
    }	
    //update
    public function update($table, $params, $where)
    {
        $this->db->set($params);
		$this->db->where($where);
		$this->db->update($table);
		$query_string = $this->db->last_query();
		return $this->changelog($query_string,'U',$table,$where);
		
	}
	public function com_user($params)
	{
		$com_user = $this->session->userdata('com_user');
		return $com_user[$params];
	}
	private function changelog($query_string, $action_type, $table,$where = null) {
		// load library
		$this->load->library('user_agent');
		// switch action
		switch ($action_type) {
			case 'C':
				$log_message = "Created ".$table;
				break;
			case 'U':
				$log_message = "Updated ".$table." with ".array_keys($where)[0]." ".array_shift($where);
				break;
			case 'D':
				$log_message = "Deleted ".$table." with ".array_keys($where)[0]." ".array_shift($where);
				break;
			default:
				break;
		}
		$url        = base_url().(!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '');
		
		$ip         = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : 'none';
		
		$user_agent = array(
						'ip' => $this->input->ip_address(), 
						'browser' => $this->agent->browser(), 
						'platform' => $this->agent->platform()
					);
		$params = array(
			'log_id' => generate_id(),
			'log_message' => $log_message,
			'action_type' => $action_type,
			'query_string' => $query_string,
			'url' => $url,
			'ip_address' => $ip,
			'user_agent' => json_encode($user_agent),
			'mdb'	=> $this->com_user('user_id'),
			'mdb_name'	=> $this->com_user('user_name'),
			'mdd' => now(),
		);
		return $this->db->insert('com_log', $params);
	}
}
