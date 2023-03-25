<?php

if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Dashboard_model extends CI_Model

{
    public function __construct()
    {
        parent::__construct();
        $this->code = 200;
        $this->status = false;
    }
    public function loaddata()
    {

        $result = $this->db->get_where('lotto_setting');
        $msg = 'Error : Data';
        $data = [];
        if (!empty($result)) {
            $this->status = true;
            $msg = 'Success : Data';
            $data = $result->row();
            $data->json_pay = json_decode($data->json_pay);
            $data->json_top = json_decode($data->json_top);
            $data->json_bottom = json_decode($data->json_bottom);
        }

        $json = array('status' => $this->status, 'data' => $data, 'code' => $this->code);
        return $json;
    }

    public function save_json($post)
    {
        $type = $post['function'];
        $json_pay = json_encode($post['data'], JSON_UNESCAPED_UNICODE);
        if (self::chk_row($json_pay, $type)) {
            $str = '';
            switch ($type) {
                case "pay":
                    $str = "json_pay";
                    break;
                case "top":
                    $str = "json_top";
                    break;
                case "bottom":
                    $str = "json_bottom";
                    break;
            }

            $strSQL = "UPDATE `lotto_setting` 
                        SET `$str`='{$json_pay}' 
                        WHERE 1";

            $result = $this->db->query($strSQL);
        }
        $msg = 'Error : Data';
        if ($result) {
            $this->status = true;
            $msg = 'Success : Data';
        }
        $json = array('status' => $this->status, 'data' => $msg, 'code' => $this->code);
        return $json;
    }
    private function chk_row($data, $type)
    {
        $str = '';
        switch ($type) {
            case "pay":
                $str = "json_pay";
                break;
            case "top":
                $str = "json_top";
                break;
            case "bottom":
                $str = "json_bottom";
                break;
        }

        $result =  $this->db->get_where("lotto_setting");
        if ($result->num_rows() == 0) {
            $set = array(
                $str => $data,
            );
            $result = $this->db->insert('lotto_setting', $set);
        }
        return true;
    }
    public function savedate($post)
    {
        $post = (object)array(
            'date' => date('Y-m-d', strtotime($post['date'])),
        );

        $result =  $this->db->get_where("lotto_setting", ['date' => $post->date]);

        $msg = 'มีข้อมูลในระบบแล้ว';

        if ($result->num_rows() == 0) {
            $set = array(
                'date' => $post->date,
            );
            $result = $this->db->insert('lotto_setting', $set);
            $this->status = true;
            $msg = 'บันทึกสำเสร็จ';
        }
        $json = array(
            'status' => $this->status,
            'data' => $msg,
            'code' => $this->code,
        );
        return $json;
    }
    public function get_date()
    {
        $result =  $this->db->query("SELECT id,DATE_FORMAT(`date`,'%d-%M-%Y')  as `date`,is_active FROM lotto_date ");
        $data = [];

        if ($result->num_rows() > 0) {
            $this->status = true;
            $i = 0;
            $data =  $result->result();
        }
        $json = array(
            'status' => $this->status,
            'data' => $data,
            'code' => $this->code,
        );
        return  $json;
    }
}
