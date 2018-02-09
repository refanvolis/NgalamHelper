<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_m extends CI_Model {
    public function uname_check($uname)
    {
        $this->db->where('uname',$uname);
        $count_result = $this->db->count_all_results('member');
        if($count_result == 0){
            return true;
        }else{
            return false;
        }
    }
    public function new_member()
    {
        $data = array(
            'uname'     => $this->input->post('uname'),
            'upass'     => $this->input->post('upass'),
            'unick'     => $this->input->post('unick'),
            'token'     => $this->token_generator($this->input->post('uname'),$this->input->post('upass')) 
        );
        $this->db->insert('member',$data);
        return true;    
    }
    public function token_generator($uname,$upass)
    {
        $val = $uname.$upass;
        $salt = uniqid('RahasaiaArekNgalam', true);
        $hash = sha1($val . $salt);
        return $hash;
    }
    public function login()
    {
        $data = array(
            'uname'     =>  $this->input->post('uname'),
            'upass'     =>  $this->input->post('upass')
        );
        $this->db->where($data);
        $count_result = $this->db->count_all_results('member');
        if($count_result >= 1){
            return true;
        }else{
            return false;
        }
    }
    public function getMe()
    {
        $data = array(
            'uname'     =>  $this->input->post('uname'),
            'upass'     =>  $this->input->post('upass')
        );
        $this->db->where($data);
        return $this->db->get('member');
    }
    public function getNewToken()
    {
        $new_token = $this->token_generator($this->input->post('uname'), $this->input->post('upass'));
        $key = array(
            'uname'     => $this->input->post('uname'),
            'upass'     => $this->input->post('upass'),
        );
        $data = array(
            'token'     => $new_token
        );
        $this->db->where($key);
        $this->db->update('member', $data);
        $params = array(
            'response'      => true,
            'token'         => $new_token
        );
        return $params;
    }
}