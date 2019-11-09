<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	function __construct(){
		parent::__construct();		
		$this->load->model(array('about_model'));
		$this->load->helper(array('url','form'));
		
		if(!$this->session->userdata('logged_in'))
   			
   		{
     		//If no session, redirect to login page
     		redirect('auth', 'refresh');
   		}
 
	}

	public function index()
	{
		redirect('cuti', 'refresh');
	}
}
