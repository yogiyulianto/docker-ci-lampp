<?php

class M_video extends MY_Model {

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
    public function get_by_id($video_id) {
        $this->db->select('video.*, category_video.title as category_title');
        $this->db->from('video');
        $this->db->join('category_video', 'category_video.category_id = video.category_id', 'inner');
        $this->db->where('video.video_id', $video_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }
    public function get_all() {
        $this->db->select('video.video_id, video.title, video.image, category_video.title as category_title');
        $this->db->from('video')->limit(4)->order_by('video.mdd',"DESC");
        $this->db->join('category_video', 'category_video.category_id = video.category_id', 'inner');
        $this->db->where('video.video_st', 'published');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //count all
    public function count_all() {
        $this->db->select('*');
        $this->db->from('video')->limit(4)->order_by('video.mdd',"DESC");
        $this->db->join('category_video', 'category_video.category_id = video.category_id', 'inner');
        $this->db->where('video.video_st', 'published');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }

    public function get_by_category($category_id) {
        $this->db->select("video.video_id, video.title, video.image, 'video' as type");
        $this->db->from('video')->order_by('video.mdd',"DESC");
        $this->db->join('category_video', 'category_video.category_id = video.category_id', 'inner');
        $this->db->where('video.video_st', 'published');
        $this->db->where('video.category_id', $category_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }
    public function search_by_title($title) {
        $this->db->select("video.video_id, video.title, video.image, 'video' as type");
        $this->db->from('video')->order_by('video.mdd',"DESC");
        $this->db->join('category_video', 'category_video.category_id = video.category_id', 'inner');
        $this->db->where('video.video_st', 'published');
        $this->db->like('video.title', $title, 'both'); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    public function get_all_category() {
        $this->db->select('*');
        $this->db->from('category_video')->order_by('mdd',"DESC");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    //count all
    public function count_all_category() {
        $this->db->select('*');
        $this->db->from('category_video')->order_by('mdd',"DESC");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }
    //count all
    public function count_search($title) {
        $this->db->select("video.video_id, video.title, video.image, 'video' as type");
        $this->db->from('video')->order_by('video.mdd',"DESC");
        $this->db->join('category_video', 'category_video.category_id = video.category_id', 'inner');
        $this->db->where('video.video_st', 'published');
        $this->db->like('video.title', $title, 'both'); 
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
