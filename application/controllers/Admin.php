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
		if($this->cuti_model->get_by_total_cuti(date('Y'),1,$this->id)->num_rows()>=1){
			$ambil=round($this->cuti_model->get_by_total_cuti(date('Y'),1,$this->id)->row()->total); 
		}else{
			$ambil=0;
		}
		$jatah = round($this->cuti_model->get_cuti_n_id($this->id)->row()->sisacuti);
		$totalsisa = $jatah-$ambil;
		$data['totalsisa'] = $totalsisa;
		
		
		
		
		
		if($this->cuti_model->get_by_total_cuti(date('Y'),7,$this->id)->num_rows()>=1){
    $ambil=round($this->cuti_model->get_by_total_cuti(date('Y'),7,$this->id)->row()->total); 
	}else{
		$ambil=0;
		}
		
		$jatah = round($this->cuti_model->get_cuti_n1_id($this->id)->row()->sisacuti1);
		
		$totalsisa = $jatah-$ambil;
		
		$data['totalsisa1'] = $totalsisa;
		
		
		
		if($this->cuti_model->get_by_total_cuti(date('Y'),8,$this->id)->num_rows()>=1){
    $ambil=round($this->cuti_model->get_by_total_cuti(date('Y'),8,$this->id)->row()->total); 
		}else{
		$ambil=0;
		}
			$jatah = round($this->cuti_model->get_cuti_n2_id($this->id)->row()->sisacuti2);
		
		$totalsisa = $jatah-$ambil;
		
		$data['totalsisa2'] = $totalsisa;
		
		
		$this->load->view('dashboard',$data);
	}
}
