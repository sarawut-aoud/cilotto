<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lotto extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
	}
	protected function renderview($path)
	{
		$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
		$this->data['another_css'] = $this->another_css;
		$this->data['another_js'] = $this->another_js;
		$this->parser->parse('templates/pageview', $this->data);
		if ($this->session->userdata('user_id')) {
			redirect('/Dashboard');
		}
	}
	public function index()
	{
		$this->another_js .= '<script src="' . base_url('assets/js_module/view.js?ft=') . time() . '"> </script>';

		$this->data['tab_header'] = array(
			array('href' => base_url('Lotto/login'), 'icon' => '<i class="fa-solid fa-right-to-bracket"></i>', 'text' => 'Login'),
			// array('href' => '#', 'icon' => '<i class="fa-solid fa-table-columns"></i>', 'text' => 'Dashboard'),
		);
		$this->renderview('view');
	}
	public function login()
	{

		$this->another_js = '<script src="' . base_url('assets/js_module/login.js?ft=') . time() . '"> </script>';
		$this->renderview('login');
	}
}
