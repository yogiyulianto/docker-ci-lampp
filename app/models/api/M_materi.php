<?php

class M_materi extends MY_Model {

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
        $base_url = base_url();
        $this->db->select("*");
        $this->db->from('konsultasi');
        $this->db->where('konsultasi.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    public function get_all() {
        $this->db->select('materi.*, materi.image_url as image, kategori_materi.deskripsi as deskripsi_kategori');
        $this->db->from('materi')->order_by('materi.mdd',"DESC");
        $this->db->join('kategori_materi', 'materi.id_kategori = kategori_materi.id_kategori', 'inner');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }
    public function get_all_by_category($id) {
        $this->db->select('materi.*,materi.image_url as image, kategori_materi.deskripsi as deskripsi_kategori');
        $this->db->from('materi')->order_by('materi.order_no',"ASC");
        $this->db->join('kategori_materi', 'materi.id_kategori = kategori_materi.id_kategori', 'inner');
        $this->db->where('materi.id_kategori', $id)->order_by('materi.order_no',"ASC"); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    public function get_category() {
        $this->db->select('*');
        $this->db->from('kategori_materi')->order_by('kategori_materi.order_no',"ASC");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }
    public function get_all_limit() {
        $this->db->select("blogs.blog_id, blogs.title, blogs.image, category.title as category_title, 'blog' as type");
        $this->db->from('blogs')->order_by('blogs.mdd',"DESC");
        $this->db->join('category', 'category.category_id = blogs.category_id', 'inner');
        $this->db->where('blogs.blog_st', 'published');
        $this->db->where('blogs.is_weekly_content', 'no');
        $this->db->limit(5,0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }

    public function get_by_category($category_id) {
        $this->db->select("blogs.blog_id, blogs.title, blogs.image, 'blog' as type");
        $this->db->from('blogs')->order_by('blogs.mdd',"DESC");
        $this->db->join('category', 'category.category_id = blogs.category_id', 'inner');
        $this->db->where('blogs.blog_st', 'published');
        $this->db->where('blogs.category_id', $category_id);
        $this->db->where('blogs.is_weekly_content', 'no');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();

    }

    public function count_by_category($category_id) {
        $this->db->select("blogs.blog_id, blogs.title, blogs.image, 'blog' as type");
        $this->db->from('blogs')->order_by('blogs.mdd',"DESC");
        $this->db->join('category', 'category.category_id = blogs.category_id', 'inner');
        $this->db->where('blogs.blog_st', 'published');
        $this->db->where('blogs.category_id', $category_id);
        $this->db->where('blogs.is_weekly_content', 'no');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }
    public function count_by_category_free($category_id) {
        $this->db->select("blogs.blog_id, blogs.title, blogs.image, 'blog' as type");
        $this->db->from('blogs')->order_by('blogs.mdd',"DESC");
        $this->db->join('category', 'category.category_id = blogs.category_id', 'inner');
        $this->db->where('blogs.blog_st', 'published');
        $this->db->where('blogs.pricing_st', 'free');
        $this->db->where('blogs.category_id', $category_id);
        $this->db->where('blogs.is_weekly_content', 'no');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }

    public function get_free_by_category($category_id) {
        $this->db->select("blogs.blog_id, blogs.title, blogs.image, 'blog' as type");
        $this->db->from('blogs')->order_by('blogs.mdd',"DESC");
        $this->db->join('category', 'category.category_id = blogs.category_id', 'inner');
        $this->db->where('blogs.blog_st', 'published');
        $this->db->where('blogs.pricing_st', 'free');
        $this->db->where('blogs.category_id', $category_id);
        $this->db->where('blogs.is_weekly_content', 'no');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }
    public function search_by_title($title) {
        $this->db->select("blogs.blog_id, blogs.title, blogs.image, 'blog' as type");
        $this->db->from('blogs')->order_by('blogs.mdd',"DESC");
        $this->db->join('category', 'category.category_id = blogs.category_id', 'inner');
        $this->db->where('blogs.blog_st', 'published');
        $this->db->where('blogs.is_weekly_content', 'no');
        $this->db->like('blogs.title', $title, 'both'); 
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        }
        return array();
    }
    public function search_free_by_title($title) {
        $this->db->select("blogs.blog_id, blogs.title, blogs.image, 'blog' as type");
        $this->db->from('blogs')->order_by('blogs.mdd',"DESC");
        $this->db->join('category', 'category.category_id = blogs.category_id', 'inner');
        $this->db->where('blogs.blog_st', 'published');
        $this->db->where('blogs.pricing_st', 'free');
        $this->db->where('blogs.is_weekly_content', 'no');
        $this->db->like('blogs.title', $title, 'both'); 
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
        $this->db->from('category')->order_by('mdd',"DESC");
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
    public function get_free_random_weekly_blogs($week) {
        $this->db->select('blogs.blog_id, blogs.title, blogs.image, category.title as category_title');
        $this->db->from('blogs')->limit(1)->order_by('blogs.blog_id',"RANDOM");
        $this->db->join('category', 'category.category_id = blogs.category_id', 'inner');
        $this->db->where('blogs.weekly_content', $week);
        $this->db->where('blogs.is_weekly_content', 'yes');
        $this->db->where('blogs.pricing_st', 'free');
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
        $this->db->select('blogs.blog_id, blogs.title, blogs.image, category.title as category_title');
        $this->db->from('blogs')->order_by('blogs.mdd',"DESC");
        $this->db->join('category', 'category.category_id = blogs.category_id', 'inner');
        $this->db->where('blogs.blog_st', 'published');
        $this->db->where('blogs.is_weekly_content', 'no');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }
    public function count_all_free() {
        $this->db->select('blogs.blog_id, blogs.title, blogs.image, category.title as category_title');
        $this->db->from('blogs')->order_by('blogs.mdd',"DESC");
        $this->db->join('category', 'category.category_id = blogs.category_id', 'inner');
        $this->db->where('blogs.blog_st', 'published');
        $this->db->where('blogs.pricing_st', 'free');
        $this->db->where('blogs.is_weekly_content', 'no');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }

    //count all
    public function count_all_category() {
        $this->db->select('*');
        $this->db->from('category')->order_by('mdd',"DESC");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }
    //count all
    public function count_search($title) {
        $this->db->select("blogs.blog_id, blogs.title, blogs.image, 'blog' as type");
        $this->db->from('blogs')->order_by('blogs.mdd',"DESC");
        $this->db->join('category', 'category.category_id = blogs.category_id', 'inner');
        $this->db->where('blogs.blog_st', 'published');
        $this->db->where('blogs.is_weekly_content', 'no');
        $this->db->like('blogs.title', $title, 'both'); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->num_rows();
            return $result;
        }
        return 0;
    }
    public function count_free_search($title) {
        $this->db->select("blogs.blog_id, blogs.title, blogs.image, 'blog' as type");
        $this->db->from('blogs')->order_by('blogs.mdd',"DESC");
        $this->db->join('category', 'category.category_id = blogs.category_id', 'inner');
        $this->db->where('blogs.blog_st', 'published');
        $this->db->where('blogs.pricing_st', 'free');
        $this->db->where('blogs.is_weekly_content', 'no');
        $this->db->like('blogs.title', $title, 'both'); 
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
