<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginBase extends CI_Controller
{
    protected $asset_url = 'assets/themes/atlantis/';

    public function __construct()
    {        
        parent::__construct();
        $this->load->model('systems/M_site');
        $this->_display_logo();
    }

    protected function _asset_url()
    {
        return base_url($this->asset_url);
    }

	public function _display_logo()
	{
		$params = array(
			'pref_group' => 'logo',
			'pref_nm'	=> 'logo'
		);
		$logo = $this->M_site->get_com_reference_by_pref_nm($params);
		$this->slice->with('logo', $logo);
		$this->slice->with('site_name', 'CISLICE v1.0');
		$this->slice->with('asset_url',$this->_asset_url());
    }
    
}
