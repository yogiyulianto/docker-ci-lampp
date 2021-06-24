<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Order extends PrivateBase {

    // constructor
    const PAGE_TITLE = 'Order';
    const PAGE_HEADER = 'Order';
    const PAGE_URL = 'administrator/order/';
    protected $page_limit = 10;

    public function __construct() 
    {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // load model
        $this->load->model('administrator/M_order');
    }

    public function index() 
    {
        // PAGE RULES
        $this->_set_page_rule('R');
        // create pagination
        $this->load->library('pagination');
        $this->load->config('pagination');
        $config = $this->config->item('pagination_config');
        $total_row = $this->M_order->get_total_order();
        $config['base_url'] = base_url(self::PAGE_URL.'index');
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->page_limit;
        $from = (int)$this->uri->segment(5);
        $this->pagination->initialize($config);
        //get data 
        $rs_id = $this->M_order->get_all_order([ $from ,$config['per_page']]);

        $pagination = $this->pagination->create_links();
        // render view
        return view(self::PAGE_URL . 'index', compact('rs_id','pagination'));
    }


    public function edit($order_id = '') 
    {
        // set page rules
        $this->_set_page_rule('U');
        //cek data
        if (empty($order_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        // get data
        $result = $this->M_order->get_order_by_id([$order_id]);
        $perawat = $this->M_order->get_list_perawat();
        //render view
        return view(self::PAGE_URL . 'edit', compact('result', 'perawat'));
    }

    public function edit_process() 
    {
        // set page rules
        $this->_set_page_rule('U');
        // cek input
        $this->form_validation->set_rules('order_id', 'Order ID', 'trim|required');
        $this->form_validation->set_rules('perawat', 'Pilih perawat', 'trim|required');
        // check data
        $order_id = $this->input->post('order_id');
        if (empty($order_id)) {
            // notification success
            $this->notification->send(self::PAGE_URL.'edit', 'error', 'Data tidak ditemukan!');
        }
        // process
        if ($this->form_validation->run() !== FALSE) {
            $params = array(
                'order_st' => '1',
                'perawat_id' => $this->input->post('perawat'),
                'mdb' => $this->com_user('user_id'),
                'mdb_name' => $this->com_user('user_name'),
                'mdd' => now(),
            );
            $where = array(
                'order_id' => $order_id
            );
            // insert
            if ($this->M_order->update('orders', $params, $where)) {
                // notification success
                $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil diedit !');
            } else {
                // default error
                $this->notification->send(self::PAGE_URL.'edit' . $order_id, 'error', 'Data gagal diedit!');
            }
        } else {
            // default error
            $this->notification->send(self::PAGE_URL.'edit/' . $order_id, 'error', 'Ada Field Yang Tidak Sesuai!');
        }
    }

    public function delete_process() 
    {
        // set page rule
        $this->_set_page_rule('D');
        // get id
        $order_id = $this->input->post('id', true);
        //cek data
        if (empty($order_id)) {
            // default error
            $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
        }
        $where = array(
            'order_id' => $order_id
        );
        //process
        if ($this->M_order->delete('order', $where)) {
            // notification success
            $this->notification->send(self::PAGE_URL, 'success', 'Data berhasil dihapus');
        } else {
            //default error
            $this->notification->send(self::PAGE_URL.'delete/' . $order_id, 'error', 'Data failed to delete !');
        }
    }

}
