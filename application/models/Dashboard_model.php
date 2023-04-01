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

        $result =  $this->db->get_where("lotto_date", ['date' => $post->date]);

        $msg = 'มีข้อมูลในระบบแล้ว';

        if ($result->num_rows() == 0) {
            $set = array(
                'date' => $post->date,
            );
            $result = $this->db->insert('lotto_date', $set);
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
        $result =  $this->db->query("SELECT id,DATE_FORMAT(`date`,'%d-%M-%Y')  as `date`,DATE_FORMAT(`date`,'%d')  as `datesort`,DATE_FORMAT(`date`,'%m')  as `msort`,DATE_FORMAT(`date`,'%Y')  as `ysort`,is_active FROM lotto_date ORDER BY msort ASC, ysort ASC , datesort ASC;");
        $data = [];
        $row = (object)array();
        if ($result->num_rows() > 0) {
            $this->status = true;
            $data = $result->result();
        }

        $json = array(
            'status' => $this->status,
            'data' => $data,
            'code' => $this->code,
        );
        return  $json;
    }
    public function setdate($post)
    {
        $post = (object)array(
            'id' => $post['dateid'],
        );
        $msg = 'Error';

        $active = $this->db->get_where('lotto_date', ['id' => $post->id])->row('is_active');

        $this->db->set('is_active', $active == 1 ? 0 : 1);
        $this->db->where('id', $post->id);
        $rs = $this->db->update('lotto_date');
        if ($rs) {
            $this->status = true;
            $msg = 'Success';
            $this->db->query("UPDATE lotto_date SET is_active = 0 WHERE id != ?", [$post->id]);
        }
        $json = array(
            'status' => $this->status,
            'msg' => $msg,
            'code' => $this->code,
        );
        return  $json;
    }
    public function savedata($post)
    {
        $post = (object)array(
            'number' => $post['number'],
            'name' => $post['name'],
            'phone' => $post['phone'],
            'date' => date('Y-m-d', strtotime($post['date']))
        );

        if ($post->number == 'N/A') {
            $msg = 'Error';
        } else {
            $this->db->insert('lotto_personal', ['fname' => $post->name, 'phone' => $post->phone]);
            $last_id = $this->db->insert_id();

            $data = array(
                'number' => $post->number,
                'person_id' =>  $last_id,
                'lot_date' => $post->date
            );


            $rs = $this->db->insert('lotto_pay', $data);
            if ($rs) {
                $this->status = true;
                $msg = 'Success';
            }
        }

        $json = array(
            'status' => $this->status,
            'msg' => $msg,
            'code' => $this->code,
        );
        return  $json;
    }
    public function get_number($post)
    {
        $post = (object)array(
            'date' => date('Y-m-d', strtotime($post['date'])),
        );
        $number = 100;
        $data = [];
        for ($i = 0; $i < $number; $i++) {
            $this->status = true;
            $result = $this->db->query("SELECT t1.*,CAST(number as UNSIGNED) as number_chk  FROM lotto_pay t1 
            WHERE CAST(t1.number as UNSIGNED) = ? 
            AND lot_date=DATE(?) ", [$i, $post->date]);

            $data[$i]['number'] = $i;
            if ($result->num_rows() > 0 && $i == $result->row('number_chk')) {
                $res = $result->row();
                $data[$i] = $res;
                $data[$i]->number = $res->number_chk;
            }
        }
        $json = array(
            'status' => $this->status,
            'data' => $data,
            'code' => $this->code,
        );
        return $json;
    }
    public function get_numberById($post)
    {
        $data = [];

        $result = $this->db->query("SELECT t1.*,t2.fname ,t2.phone FROM lotto_pay t1 
                                    LEFT JOIN lotto_personal t2 ON t2.id = t1.person_id 
                                    WHERE t1.id = ?
                                    ", [$post['id']]);

        if ($result->num_rows() > 0) {
            $data = $result->row();
            $this->status = true;
        }

        $json = array(
            'status' => $this->status,
            'data' => $data,
            'code' => $this->code,
        );
        return $json;
    }
    public function get_report($post)
    {

        $data = [];
        $sql = "SELECT t1.*, DATE_FORMAT(t1.lot_date,'%d-%M-%Y') as lot_date ,t2.fname ,t2.phone FROM lotto_pay t1 
        LEFT JOIN lotto_personal t2 ON t2.id = t1.person_id ";

        if ($post['date']) {
            $date = date('Y-m-d', strtotime($post['date']));
            $sql .= " WHERE lot_date = '$date'";
        }

        $result = $this->db->query($sql);

        if ($result->num_rows() > 0) {
            $data = $result->result();
            $this->status = true;
        }

        $json = array(
            'status' => $this->status,
            'data' => $data,
            'code' => $this->code,
        );
        return $json;
    }
}
