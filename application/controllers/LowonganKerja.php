<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lowongankerja extends CI_Controller {

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
	public function __construct()
	{
		parent::__construct();
		$this->load->model('AllData_m');
	}
	public function index()
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "localhost/ngalamhelper/index.php/lowongankerja/getData",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		$data['item'] = json_decode($response, true);
		/*
		for($i=0; $i < count($data['content']); $i ++){
			echo "<center>".nl2br($data['content'][$i]['jdul_feed'])."</center><br>";
			echo nl2br($data['content'][$i]['desc_feed']);
		}
		*/
		$this->load->view('v_lowongankerja',$data);
	}
	public function getData($var = null)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$response = array(
				'success'		=> false,
				'info'			=> 'Bad Request'
			);
		}else{
			if($var == null){
				$response = array(
					'sucess'	=> true,
					'title'		=> 'Lowongan Kerja',
					'content'	=> $this->AllData_m->getDatas(2)->result()
				);
			}else{
				if(count($this->AllData_m->getSingleDatas(2,$var)->result()) <= 0){
					$response = array(
						'success'		=> false,
						'info'			=> 'Data not found'
					);
				}else{
					$response = array(
						'sucess'	=> true,
						'title'		=> 'Lowongan Kerja',
						'content'	=> array(
							'id_feed'		=> 	$this->AllData_m->getSingleDatas(2,$var)->row()->id_feed,
							'jdul_feed'		=>	$this->AllData_m->getSingleDatas(2,$var)->row()->jdul_feed,
							'rating'		=> 	$this->AllData_m->getSingleDatas(2,$var)->row()->rating,
							'desc_feed'		=>	$this->AllData_m->getSingleDatas(2,$var)->row()->desc_feed,
							'almt_feed'		=>	$this->AllData_m->getSingleDatas(2,$var)->row()->almt_feed,
							'jam_publish'	=> 	$this->AllData_m->getSingleDatas(2,$var)->row()->jam_publish,
							'tgl_publish'	=>	$this->AllData_m->getSingleDatas(2,$var)->row()->tgl_publish,
							'publshr_feed'	=>	$this->AllData_m->getSingleDatas(2,$var)->row()->publishr_feed
						)
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
}
