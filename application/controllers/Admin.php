<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	private $id,$nama,$akses;
	private $data=array();
	function __construct(){
		parent::__construct();		
		$this->load->model(array('about_model','cuti_model'));
		$this->load->helper(array('url','form'));
		
		$sess = getsession();
		$this->id = $sess->id;
		$this->nama = $sess->nama;
		$this->akses = $sess->akses;
		
		$this->data['id'] = $sess->id;
		$this->data['user'] = $sess->user;
		$this->data['nama'] = $sess->nama;
		$this->data['akses'] = $sess->akses;
		
		if(!$this->session->userdata('logged_in'))
   			
   		{
     		//If no session, redirect to login page
     		redirect('auth', 'refresh');
   		}
 
	}

	public function index()
	{
		$data=$this->data;
		$ambil=round($this->cuti_model->get_by_total_cuti(date('Y'),1,$this->id)->row()->total); 
		$jatah = round($this->cuti_model->get_sisacuti_by_id($this->id,date('Y'))->row()->lama);
		$data['totalsisa'] = $jatah-$ambil;
		$this->load->view('dashboard',$data);
	}
}
