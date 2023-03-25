<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CRUD_Controller extends CI_Controller 
{

	public $data;

    public function __construct() 
	{
        parent::__construct();
	
		$data['base_url'] = base_url();
		$data['site_url'] = site_url();
		$data['csrf_token_name'] = $this->security->get_csrf_token_name();
		$data['csrf_cookie_name'] = $this->config->item('csrf_cookie_name');
		$data['csrf_protection_field'] = insert_csrf_field(true);
		
	}

}