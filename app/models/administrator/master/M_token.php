<?php

class M_token extends MY_Model {

    //get count
    public function count_all()
    {
        $sql = "SELECT count(*) as 'total' FROM token ORDER BY token_id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        }
        return 0;
    }

	//get all
    public function get_all1($params) 
    {
        $sql = "SELECT * FROM token ORDER BY token_id ASC LIMIT ?,?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

      //all role
      public function get_all_role() {
        $this->db->select('*');
        $this->db->from('com_role');
        $this->db->where("(role_id='02002' OR role_id='02003')", NULL, FALSE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

	//get all
    public function get_all($rs_search, $number, $offset) {
		// echo'<pre>';
		// 	print_r($rs_search);
			// exit();
        $this->db->select('*');
        $this->db->from('token');
        if (!empty($rs_search['token'])) {
            $this->db->like('token.token', $rs_search['token'], 'both');
        }
        if (!empty($rs_search['token_sts'])) {
            $this->db->where('token_sts', $rs_search['token_sts'] );
        }
		$this->db->where("token_id is NOT NULL", NULL, FALSE);

        // $this->db->order_by("(token.token_id)", NULL, FALSE);

        $this->db->limit($number, $offset);
        $query = $this->db->get();
        // echo $this->db->last_query();exit();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
			// echo'<pre>';
			// print_r($result);
			// exit();
            return $result;
			
        }
        return array();
		
    }

	public function gencode($params){
		$code= '1234567890QWERTYUIOPASDFGHJKLZXCVBNM'.time();
		  $string = '';
		  for ($i = 0; $i < $params; $i++) {
		      $pos = rand(0, strlen($code)-1);
		      $string .= $code[$pos];
		      }
		  return 'YCA/'.date('y').'/'.date('m').'/'.$string;
	}

	// get by id
    public function getByid($params) 
    {
        $sql = "SELECT * FROM token WHERE token_id = ?";
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }



}
