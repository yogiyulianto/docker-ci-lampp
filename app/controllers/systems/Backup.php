<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Backup extends PrivateBase {

    const PAGE_TITLE = 'Database Backup';
    const PAGE_HEADER = 'Database Backup';
    const PAGE_URL = 'systems/backup/';
    const BACKUP_PATH = './files/db/';

    // constructor
    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
        // LOAD HELER
        $this->load->helper('file');
    }

    public function index() {
        // set page rules
        $this->_set_page_rule('R');
        // load view
        $files = glob(self::BACKUP_PATH.'*.zip', GLOB_BRACE);
        if (!isset($files)) {
            $this->notification->send(self::PAGE_URL, 'error', 'Could not check backup folder');
        }

        $dbs = glob(self::BACKUP_PATH.'*.txt', GLOB_BRACE);
        if (!isset($dbs)) {
            $this->notification->send(self::PAGE_URL, 'error', 'Could not check backup folder');
        }
        $rs_id = array();
        $n = 1;
        foreach ($files as $key => $value) {
            // set date string
            $date_string            = substr($value, 12, 10);
            $time_string            = substr($value, 23, 8);
            // set file_name
            $rs_id[$n]['file_name']    = basename($value);
            $rs_id[$n]['db_filename']  = substr(basename($value), 0, -4);
            $rs_id[$n]['date']         = $date_string . ' ' . str_replace('-', ':', $time_string);
            $n++;
        }
        foreach ($dbs as $key => $value) {
            // set date string
            $file_name              = basename($value);
            $date_string            = substr($file_name, 13, 10);
            $time_string            = substr($file_name, 24, 8);
            // set file_name
            $rs_id[$n]['file_name']    = $file_name;
            $rs_id[$n]['db_filename']  = substr($file_name, 0, -4);
            $rs_id[$n]['date']         = $date_string . ' ' . str_replace('-', ':', $time_string);
            $n++;
        }

        // data to view
        $data = array(
            'rs_id' => $rs_id 
        );
        // parse to view
        view(self::PAGE_URL . 'index',$data);
    }

    public function start_backup(){
        // set page rules
        $this->_set_page_rule('R');
        // load library
        $this->load->dbutil();
        // backup pref
        $prefs = array(
            'format' => 'sql',
            'filename' => 'ci_slice_v2_db.sql'
        );
        $back = $this->dbutil->backup($prefs);
        $backup = & $back;
        // db name
        $db_name = 'db-backup-on-' . date("Y-m-d-H-i-s") . '.txt';
        // save db
        $save = self::BACKUP_PATH . $db_name;
        // write files
        if(write_file($save, $backup)){
            // send notification
            $this->notification->send(self::PAGE_URL, 'success', 'Database backup successfully');
        } 
        // send notification
        $this->notification->send(self::PAGE_URL, 'errpr', 'Database failed to backup');
    }
    
    public function download_db($db_filename){
        // set page rules
        $this->_set_page_rule('R');
        // load library
        $this->load->library('zip');
        // read file
        $this->zip->read_file(self::BACKUP_PATH . $db_filename . '.txt');
        // download file
        $this->zip->download('db_backup_' . date('Y_m_d_H_i_s') . '.zip');
        exit();
    }

    public function restore_db($db_filename) {
        // set page rules
        $this->_set_page_rule('U');
        // read file
        $file = file_get_contents(self::BACKUP_PATH . $db_filename . '.txt');
        // start restore
        if($file){
            $this->db->conn_id->multi_query($file);
            $this->db->conn_id->close();
            // send notification
            $this->notification->send(self::PAGE_URL, 'success', 'Database restore successfully');
        }
        // send notification
        $this->notification->send(self::PAGE_URL, 'errpr', 'Database failed to restore');
    }

    public function delete_db($db_filename) {
        // set page rules
        $this->_set_page_rule('D');
        // unlink files
        if (unlink(self::BACKUP_PATH . $db_filename . '.txt')) {
            // send notifcation
            $this->notification->send(self::PAGE_URL, 'success', 'Database delete successfully');
        }
        // send notification
        $this->notification->send(self::PAGE_URL, 'errpr', 'Database failed to delete');
    }
}
