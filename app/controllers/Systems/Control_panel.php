<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Control_panel extends PrivateBase {

    const PAGE_TITLE = 'Control Panel';
    const PAGE_HEADER = 'Control Panel';
    const BASE_URL = 'systems/control_panel/';

    // constructor
    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('BASE_URL', base_url(self::BASE_URL));
        // LOAD MODEL
        $this->load->model('systems/M_panel');
    }

    public function index() {
        $this->_set_page_rule('R');
        $data = [
            'server_cpu_usage' => $this->get_server_cpu_usage(),
            'server_memory_usage' => $this->get_server_memory_usage(),
            'server_disk_usage' => $this->get_server_disk_usage(),
            'server_information' => $this->server_infomation(),
        ];

        view(self::BASE_URL . 'index', $data);
    }

    private function get_server_cpu_usage() {
        $load = sys_getloadavg();
        $cpu_usage = round($load[0], 2);
        $data = array(
            'usage' => $cpu_usage,
            'free' => 100 - $cpu_usage,
            'total' => 100,
        );
        return $data;
    }

    private function get_server_memory_usage() {
        $memory_total = (int) ini_get('memory_limit') * 1024 * 1024;
        $memory_usage = memory_get_usage(true);
        $data = array(
            'usage_percentage' => round($memory_usage / $memory_total * 100,2),
            'usage' => $this->get_nice_file_size($memory_usage),
            'free' => $this->get_nice_file_size($memory_total - $memory_usage),
            'total' => $this->get_nice_file_size($memory_total),
        );

        return $data;
    }

    private function get_server_disk_usage() {
        if (!$disktotal = disk_total_space($_SERVER['DOCUMENT_ROOT'])) {
            $disktotal = 0;
        }
        if (!$diskfree = disk_free_space($_SERVER['DOCUMENT_ROOT'])) {
            $diskfree = 0;
        }
        $diskuse = $disktotal - $diskfree;
        $diskuse_percentage = round(100 - (($diskfree / $disktotal) * 100));

        $data = array(
            'usege_percentage' => $diskuse_percentage,
            'usage' => $this->get_nice_file_size($diskuse),
            'free' => $this->get_nice_file_size($diskfree),
            'total' => $this->get_nice_file_size($disktotal),
        );
        return $data;
    }

    public function get_nice_file_size($bytes, $binaryPrefix = true) {
        if ($binaryPrefix) {
            $unit = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
            if ($bytes == 0) {
                return '0 ' . $unit[0];
            }
            return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2) . ' ' . (isset($unit[$i]) ? $unit[$i] : 'B');
        } else {
            $unit = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
            if ($bytes == 0) {
                return '0 ' . $unit[0];
            }
            return @round($bytes / pow(1000, ($i = floor(log($bytes, 1000)))), 2) . ' ' . (isset($unit[$i]) ? $unit[$i] : 'B');
        }
    }

    public function server_infomation() {
        if (!function_exists('apache_get_version')) {

            function apache_get_version() {
                if (!isset($_SERVER['SERVER_SIGNATURE']) || strlen($_SERVER['SERVER_SIGNATURE']) == 0) {
                    return false;
                }
                return $_SERVER["SERVER_SIGNATURE"];
            }

        }
        if (!$apache = explode(' ', apache_get_version())) {
            $apache = '-';
        }
        $data = array(
            'hostname' => $_SERVER['SERVER_NAME'],
            'os' => $apache,
            'ip_address' => $_SERVER['SERVER_ADDR'],
            'cpu_core' => $this->get_cpu_core(),
            'memory' => $this->get_mem_info(),
        );

        return $data;
    }

    private function get_cpu_core() {
        $command = "cat /proc/cpuinfo | grep processor | wc -l";

        return (int) shell_exec($command);
    }

    private function get_mem_info() {
        return $this->get_nice_file_size(memory_get_peak_usage());
    }

}
