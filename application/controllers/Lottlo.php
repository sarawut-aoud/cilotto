<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lottlo extends MY_Controller
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
	}
	public function index()
	{
		$this->data['tab_header'] = array(
			array('href' => base_url('Lottlo/loging'), 'icon' => '<i class="fa-solid fa-right-to-bracket"></i>', 'text' => 'Login'),
			// array('href' => '#', 'icon' => '<i class="fa-solid fa-table-columns"></i>', 'text' => 'Dashboard'),
		);
		$this->renderview('view');
	}
	public function admin()
	{
		$this->data['tab_header'] = array(
			array('href' => 'Dashboard/index', 'icon' => '<i class="fa-solid fa-house"></i>', 'text' => 'Home'),
			array('href' => 'Dashboard/setting', 'icon' => '<i class="fa-solid fa-table-columns"></i>', 'text' => 'Dashboard'),
		);
		$this->renderview('admin/index');
	}
}
