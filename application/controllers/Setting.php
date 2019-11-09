<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {
	
	function __construct(){
		parent::__construct();		
		$this->load->model(array('about_model','karyawan_model'));
		$this->load->helper(array('url','form'));
		
		if(!$this->session->userdata('logged_in'))
   			
   		{
     		//If no session, redirect to login page
     		redirect('auth', 'refresh');
   		}
 
	}
	
	public function index()
	{
		$data['nama'] = $this->session->userdata('logged_in')['nama'];
		$data['user'] = $this->session->userdata('logged_in')['user'];
		$data['email'] = $this->session->userdata('logged_in')['email'];
		$data['program']=$this->about_model->get_by_nama('program')->row()->value;
		$data['creator']=$this->about_model->get_by_nama('creator')->row()->value;
		$data['versi']=$this->about_model->get_by_nama('versi')->row()->value;
		$data['title']=$this->about_model->get_by_nama('title')->row()->value;
		$data['server']=$this->about_model->get_by_nama('server')->row()->value;
		$data['pejabatcuti']=$this->about_model->get_by_nama('pejabatcuti')->row()->value;
		
		$data['karyawans'] = $this->karyawan_model->get_by_all()->result();
		$this->load->view('about',$data);
	}
	public function save()
	{
		$this->about_model->update('program',array('value'=>$this->input->post('program')));
		$this->about_model->update('title',array('value'=>$this->input->post('title')));
		$this->about_model->update('versi',array('value'=>$this->input->post('versi')));
		$this->about_model->update('creator',array('value'=>$this->input->post('creator')));
		$this->about_model->update('server',array('value'=>$this->input->post('server')));
		$this->about_model->update('pejabatcuti',array('value'=>$this->input->post('pejabatcuti')));
            
		redirect('setting', 'refresh');	
        
	}
	
}
