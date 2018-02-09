<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct(){
        parent::__construct();
        $this->load->model('Member_m');
    }
	public function index()
	{
		$this->load->view('Page Pasar');
    }
    public function renew_token()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'POST'){
            $response = array(
                'Success'   => FALSE,
                'info'      => 'Bad Request'  
            );
        }else{
            if($this->Member_m->login() == true){
                $res = $this->Member_m->getNewToken();
                if($res['response'] == true){
                    $response = array(
                        'Sucess'        => TRUE,
                        'content'       => array(
                            'uname'     => $this->input->post('uname'),
                            'new_token' => $res['token']
                        )
                    );
                }else{
                    $response = array(
                        'Success'   => FALSE,
                        'info'      => 'User Error'  
                    );  
                }
            }
        }
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
        exit();
    }
    public function login()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'POST'){
            $response = array(
                'Success'   => FALSE,
                'info'      => 'Bad Request'  
            );
        }else{
            if($this->Member_m->login() == true){
                $response = array(
                    'sucess'        => true,
                    'content'       => array(
                        'uname'         => $this->Member_m->getMe()->row()->uname,
                        'unick'         => $this->Member_m->getMe()->row()->unick,
                        'Token'         => $this->Member_m->getMe()->row()->token
                    )
                );   
            }else{
                $response = array(
                    'Success'   => FALSE,
                    'info'      => 'uname tidak ditemukan / password salah.'  
                );
            }
        }
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
        exit();
    }
    public function register()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'POST'){
            $response = array(
                'Success'   => FALSE,
                'info'      => 'Bad Request'  
            );
        }else{
            if($this->Member_m->uname_check($this->input->post('uname')) == true){
                $resp = $this->Member_m->new_member();
                if($resp == true){
                    $response = array(
                        'Success'   => TRUE,
                        'info'      => 'Account '.$this->input->post('uname').' telah di buat, silahkan cek e-mail anda.'  
                    );    
                }else{
                    $response = array(
                        'Success'   => FALSE,
                        'info'      => 'Error input data, cek lagi'  
                    );
                }
            }else{
                $response = array(
                    'Success'   => FALSE,
                    'info'      => 'Username sudah terpakai'  
                );
            }
        }
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
        exit();
    }
    public function cek_input()
    {
        $uname = $this->input->post('uname');
        $response = array(
            'uname'         => $this->input->post('uname'),
            'validation'    => $this->Member_m->login(),
            'content'       => array(
                'uname'         => $this->Member_m->getMe()->row()->uname,
                'unick'         => $this->Member_m->getMe()->row()->unick,
                'Token'         => $this->Member_m->getMe()->row()->token
            )
        );
        $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit();
    }
}
