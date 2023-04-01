<?php
defined('BASEPATH') or exit('No direct script access allowed');

class View extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model', 'dashboard');
    }
    public function get_number()
    {
        $get = $this->input->get();
        $result = $this->dashboard->get_number($get);
        echo json_encode($result);
    }
    public function loaddata()
    {
        $result = $this->dashboard->loaddata();
        echo json_encode($result);
    }
    public function getDate()
    {
        $post = $this->input->post();
        $result = $this->dashboard->get_date($post);
        echo json_encode($result);
    }
}
