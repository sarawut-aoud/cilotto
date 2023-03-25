<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model', 'dashboard');
        if (!$this->session->userdata('user_id')) {
            redirect('/lotto/index', 'refresh');
        }
        $this->data['tab_header'] = array(
            array('href' => base_url('Dashboard'), 'icon' => '<i class="fa-solid fa-house"></i>', 'text' => 'Home'),
            array('href' => base_url('Dashboard/setting'), 'icon' => '<i class="fa-solid fa-table-columns"></i>', 'text' => 'Dashboard'),
            array('href' => base_url('Login/logout'), 'icon' => '<i class="fa-solid fa-right-from-bracket"></i>', 'text' => 'Logout'),
        );
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
        if ($this->session->userdata('nav_item')) {
            $this->session->unset_userdata('nav_item');
            if (!$this->session->userdata('nav_item')) {
                $this->session->set_userdata('nav_item', 'Home');
            }
        } else {
            $this->session->set_userdata('nav_item', 'Home');
        }
        $this->another_js = '<script src="' . base_url('assets/js_module/home.js?ft=') . time() . '"> </script>';

        $this->renderview('admin/index');
    }
    public function setting()
    {
        if ($this->session->userdata('nav_item')) {
            $this->session->unset_userdata('nav_item');
            if (!$this->session->userdata('nav_item')) {
                $this->session->set_userdata('nav_item', 'Dashboard');
            }
        } else {
            $this->session->set_userdata('nav_item', 'Dashboard');
        }

        $this->another_js = '<script src="' . base_url('assets/js_module/dashboard.js?ft=') . time() . '"> </script>';
        $this->renderview('admin/setting');
    }
    public function loaddata()
    {
        $result = $this->dashboard->loaddata();
        echo json_encode($result);
    }
    public function save()
    {
        $post = $this->input->post();
        $result = $this->dashboard->save_json($post);
        echo json_encode($result);
    }
    public function savedate()
    {
        $post = $this->input->post();
        $result = $this->dashboard->savedate($post);
        echo json_encode($result);
    }
    public function getDate()
    {
        $post = $this->input->post();
        $result = $this->dashboard->get_date($post);
        echo json_encode($result);
    }
}
