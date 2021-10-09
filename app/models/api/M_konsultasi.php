<?php

class M_konsultasi extends MY_Model {

    //generate id terakhir
    public function generate_id($prefixdate, $params) {
        $sql = "SELECT RIGHT(user_id, 4) as 'last_number'
                FROM com_user
                WHERE user_id LIKE ?
                ORDER BY user_id DESC
                LIMIT 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['last_number']) + 1;
            if ($number > 9999) {
                return false;
            }
            $zero = '';
            for ($i = strlen($number); $i < 4; $i++) {
                $zero .= '0';
            }
            return $prefixdate . $zero . $number;
        } else {
            // create new number
            return $prefixdate . '0001';
        }
    }

    //get all roles

    //get by id
    public function get_by_id($id) {
        $this->db->select("*");
        $this->db->from('konsultasi');
        $this->db->where('konsultasi.user_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }
    public function get_all($user_id) {
        $this->db->select('*');
        $this->db->from('chat')->order_by('message_date',"DESC");
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }
    public function get_all_detail($chat_id) {
        $this->db->select('*');
        $this->db->from('chat_detail')->order_by('order_by',"ASC");
        $this->db->where('chat_id', $chat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }
    public function get_random_weekly_blogs($week) {
        $this->db->select('blogs.blog_id, blogs.title, blogs.image, category.title as category_title');
        $this->db->from('blogs')->limit(1)->order_by('blogs.blog_id',"RANDOM");
        $this->db->join('category', 'category.category_id = blogs.category_id', 'inner');
        $this->db->where('blogs.weekly_content', $week);
        $this->db->where('blogs.is_weekly_content', 'yes');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //get by id
    public function get_last_by_id($chat_id) {
        $this->db->select('*');
        $this->db->from('chat_detail')->limit(1)->order_by('chat_detail.order_by','DESC');;
        $this->db->where('chat_detail.chat_id', $chat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //count all
    public function count_all($user_id) {
        $this->db->select('*');
        $this->db->from('chat')->order_by('message_date',"DESC");
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }
    //count all
    public function count_all_detail($chat_id) {
        $this->db->select('*');
        $this->db->from('chat_detail')->order_by('order_by',"ASC");
        $this->db->where('chat_id', $chat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }

    //cek email
    public function is_exist_email($params) {
        $query = $this->db->get_where('com_user', array('user_mail' => $params));
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return 0;
    }

    //cek username
    public function is_exist_username($params) {
        $query = $this->db->get_where('com_user', array('user_name' => $params));
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return 0;
    }

    //insert
    public function insert($table, $params) {
        return $this->db->insert($table, $params);
    }

    //delete
    public function delete($table, $where) {
        $this->db->where($where);
        return $this->db->delete($table);
    }

    //update
    public function update($table, $params, $where) {
        $this->db->set($params);
        $this->db->where($where);
        return $this->db->update($table);
    }
    
}
