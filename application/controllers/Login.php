<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->status = false;
        $this->code = 200;
        $this->key = 'key@_lotto';
        
       
    }
    public function setpassword()
    {

        $options = [
            'cost' => 12,
        ];
        // $pass = hash_hmac("sha256", $this->encode('!password1234'), $this->key);
        $pass = hash_hmac("sha256", $this->encode('1'), $this->key);

        echo password_hash($pass, PASSWORD_DEFAULT);
        die;
    }
    public function encode($pass)
    {

        $key = 'key@_lotto';
        $url = utf8_encode($pass);
        $base64 = base64_encode(base64_encode($url));
        $str = strrev($base64);
        $password = hash_hmac("sha256", $str, $key);
        return $password;
    }
    public function decode($string)
    {
        $key = 'key@_lotto';
        $str = strrev($string);
        $base64 = base64_decode(base64_decode($str));
        $url = urldecode($base64);
        return $url;
    }
    public function auth()
    {
        $post = $this->input->post();

        $post = (object)array(
            'username' => strtolower($post['username']),
            'password' =>  $this->encode($post['password']),
        );

        $data = $this->get_user($post);

        if ($data['status'] === true) {
            $this->session->set_userdata($data['msg']);
            echo json_encode(array('msg' => 'Login success', 'path' => '/Dashboard', 'status' => TRUE, 'code' => 200));
        } else {
            echo json_encode($data);
        }
    }
    private function get_user($post)
    {

        $result = $this->db->query("SELECT * FROM users WHERE username = ? OR mobile = ? ", [$post->username, $post->username]);
        $msg = 'Username ไม่ถูกต้อง';
        if ($result->num_rows() > 0) {
            $username = $result->row('username');
            $res = $this->db->get_where('users', ['username' => $username]);
            $pass = hash_hmac("sha256", $post->password, $this->key);

            if (password_verify($pass,  $res->row('password'))) {
                $this->status = true;
                $msg = $res->row_array();
            } else {
                $msg = 'Password ไม่ถูกต้อง';
            }
        }
        $data = array(
            'status' => $this->status,
            'msg' => $msg,
            'code' => $this->code,
        );
        return $data;
    }
    public function logout()
    {
        session_destroy();
        redirect('/lotto');
    }
}
