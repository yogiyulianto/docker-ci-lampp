<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once( APPPATH . 'controllers/base/PrivateBase.php' );

class Welcome extends CI_Controller {

    const PAGE_TITLE = 'Welcome';
    const PAGE_HEADER = 'Welcome';
    const PAGE_URL = 'welcome';

    // constructor
    public function __construct() {
        parent::__construct();
        // page constructor
        $this->slice->with('PAGE_TITLE', self::PAGE_TITLE);
        $this->slice->with('PAGE_HEADER', self::PAGE_HEADER);
        $this->slice->with('PAGE_URL', base_url(self::PAGE_URL));
    }

    public function index() {
        // render view
        return view(self::PAGE_URL.'/index');
    }
}
