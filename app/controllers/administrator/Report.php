<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Report extends PrivateBase {

    const SESSION_SEARCH = 'search_laporan';
    const PAGE_TITLE = 'Laporan Peminjaman';
    const PAGE_HEADER = 'Laporan Peminjaman';
    const PAGE_URL = 'administrator/report/';
    protected $page_limit = 10;

    protected $bulan ;
    protected $bulan_label ;

    // constructor
    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        $this->load->model('systems/M_user');
        $this->load->model('administrator/M_report');
        // $this->load->model('administrator/M_pegawai');
        $this->bulan = date('m');
        $this->bulan_label = date('M');
    }

    // public function index() {
    //     // PAGE RULES
    //     $this->_set_page_rule('R');
    //     $rs_search =  array();
    //     $rs_search = $this->session->userdata(self::SESSION_SEARCH);
    //     if (empty($rs_search)) {
    //         $rs_search['bulan'] = $this->bulan;
    //     }
    //     // create pagination
    //     $this->load->library('pagination');
    //     $this->load->config('pagination');
    //     $config = $this->config->item('pagination_config');
    //     $total_row = $this->M_report->get_total_peminjaman([$rs_search['bulan'],$rs_search['bulan']]);
    //     $config['base_url'] = base_url(self::PAGE_URL.'index');
    //     $config['total_rows'] = $total_row;
    //     $config['per_page'] = $this->page_limit;
    //     $from = (int)$this->uri->segment(4);
    //     $this->pagination->initialize($config);
    //     //get data 
    //     $rs_id = $this->M_report->get_all_peminjaman([$rs_search['bulan'],$rs_search['bulan'],$from,$config['per_page']]);
    //     $rs_bulan = $this->arr_bulan();
    //     $pagination = $this->pagination->create_links();
    //     // render view
    //     return view(self::PAGE_URL . 'index', compact('rs_id','pagination','rs_bulan','rs_search'));
    // }

    // public function detail($peminjaman_id = '') 
    // {
    //     // set page rules
    //     $this->_set_page_rule('U');
    //     //cek data
    //     if (empty($peminjaman_id)) {
    //         // default error
    //         $this->notification->send(self::PAGE_URL, 'error', 'Data tidak ditemukan!');
    //     }
    //     // get data
    //     $result = $this->M_report->get_peminjaman_by_id([$peminjaman_id]);
    //     $rs_perangkat = $this->M_report->get_perangkat_by_peminjaman_id([$peminjaman_id]);
    //     $rs_pemakai = $this->M_report->get_pemakai_by_peminjaman_id([$peminjaman_id]);
    //     //render view
    //     return view(self::PAGE_URL . 'detail', compact(['result','rs_perangkat','rs_pemakai']));
    // }

    // public function search_process() {
    //     // set page rule
    //     $this->_set_page_rule('R');
    //     // get data
    //     if ($this->input->post('search', true) == "submit") {
    //         // parameter
    //         $params = array(
    //             'bulan' => $this->input->post('bulan', true),
    //         );
    //         // set userdata
    //         $this->session->set_userdata(self::SESSION_SEARCH, $params);
    //     } else {
    //         // unset userdata
    //         $this->session->unset_userdata(self::SESSION_SEARCH);
    //     }
    //     // redirect back
    //     redirect(self::PAGE_URL);
    // }

    // public function arr_bulan()
    // {
    //     return array(
    //         '01' => 'Januari',
    //         '02' => 'Februari',
    //         '03' => 'Maret',
    //         '04' => 'April',
    //         '05' => 'Mei',
    //         '06' => 'Juni',
    //         '07' => 'Juli',
    //         '08' => 'Agustus',
    //         '09' => 'September',
    //         '10' => 'Oktober',
    //         '11' => 'November',
    //         '12' => 'Desember',
    //     );
    // }

    // public function download($peminjaman_id = '')
    // {
    //     $this->load->model('administrator/M_peminjaman');
    //     // get data
    //     $rs_search =  array();
    //     $rs_search = $this->session->userdata(self::SESSION_SEARCH);
    //     if (empty($rs_search)) {
    //         $rs_search['bulan'] = $this->bulan;
    //         $rs_search['bulan_label'] = $this->bulan_label;
    //     }
    //     //get data 
    //     $result = $this->M_report->get_list_peminjaman([$rs_search['bulan'],$rs_search['bulan']]);
    //     $rs_bulan = $this->arr_bulan();
    //     // set page rules
    //     $this->_set_page_rule('R');
    //     // set error 0
    //     error_reporting(0);
    //     set_time_limit(0);
    //     $html = $this->slice->view('administrator.report.pdf.index', compact(['result','rs_bulan','rs_search']), true);
    //     // load library
    //     $this->load->library('tcpdf');
    //     // create new PDF document
    //     $this->tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    //     // set margins
    //     $this->tcpdf->SetMargins(10, 10, 10);
    //     $this->tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    //     $this->tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    //     $this->tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    //     // add a page
    //     $this->tcpdf->AddPage("P", "A4");
    //     $this->tcpdf->setListIndentWidth(4);
    //     $this->tcpdf->writeHTML($html, true, false, true, false, '');
    //     // output (D : download, I : view)
    //     $filename = "LAPORAN_PEMINJAMAN_".$rs_search['bulan'].'_'.date('Y').'_'.date('dmYHis');
    //     $this->tcpdf->Output(str_replace("/", "-", $filename) . ".pdf", 'D');
    // }

    // public function download_detail($peminjaman_id = '')
    // {
    //     $this->load->model('administrator/M_peminjaman');
    //     $this->load->model('pengguna/peminjaman/M_riwayat');
    //     // get data
    //     $result = $this->M_peminjaman->get_peminjaman_by_id([$peminjaman_id]);
    //     if (empty($result)) {
    //         $this->notification->send(self::PAGE_URL,'error','Data Tidak Ditemukan!');
    //     }
    //     $rs_perangkat = $this->M_riwayat->get_perangkat_by_peminjaman_id([$peminjaman_id]);
    //     $rs_pemakai = $this->M_peminjaman->get_pemakai_by_peminjaman_id([$peminjaman_id]);
    //     // set page rules
    //     $this->_set_page_rule('R');
    //     // set error 0
    //     error_reporting(0);
    //     set_time_limit(0);
    //     $html = $this->slice->view('pengguna.peminjaman.pdf.detail', compact(['result','rs_perangkat','rs_pemakai']), true);
    //     // load library
    //     $this->load->library('tcpdf');
    //     // create new PDF document
    //     $this->tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    //     // set margins
    //     $this->tcpdf->SetMargins(10, 10, 10);
    //     $this->tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    //     $this->tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    //     $this->tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    //     // add a page
    //     $this->tcpdf->AddPage("P", "A4");
    //     $this->tcpdf->setListIndentWidth(4);
    //     $this->tcpdf->writeHTML($html, true, false, true, false, '');
    //     // output (D : download, I : view)
    //     $filename = "FORM_PEMINJAMAN_".$result['peminjaman_kode'].'_'.date('dmYHis');
    //     $this->tcpdf->Output(str_replace("/", "-", $filename) . ".pdf", 'D');
    // }

}
