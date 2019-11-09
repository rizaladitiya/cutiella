<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak extends CI_Controller {
	
	private $limit=30;
	function __construct(){
		parent::__construct();		
		//error_reporting(0);
        //ini_set('display_errors', 0); 
		$this->load->model(array('about_model','user_model','karyawan_model','cuti_model','izin_model','tidakmasuk_model','tembusan_model'));
		$this->load->helper(array('url','form'));
		$this->load->library('user_agent');
		
 
	}
	
	
	function cetak(){
		$id = $this->uri->segment(3);
		$data['cuti']=$this->cuti_model->get_by_id($id)->result();
		$data['nama'] = $this->session->userdata('logged_in')['nama'];
		$data['user'] = $this->session->userdata('logged_in')['user'];
		$data['email'] = $this->session->userdata('logged_in')['email'];
		$this->load->view('cuti/cetak.php',$data);
		
	}
	
	function izin(){
		$id = $this->uri->segment(3);
		$data['izin']=$this->izin_model->get_by_id($id)->result();
		$data['nama'] = $this->session->userdata('logged_in')['nama'];
		$data['user'] = $this->session->userdata('logged_in')['user'];
		$data['email'] = $this->session->userdata('logged_in')['email'];
		$this->load->view('izin/cetak.php',$data);
		
	}
	function tidakmasuk(){
		$id = $this->uri->segment(3);
		$data['tidakmasuk']=$this->tidakmasuk_model->get_by_id($id)->result();
		$data['nama'] = $this->session->userdata('logged_in')['nama'];
		$data['user'] = $this->session->userdata('logged_in')['user'];
		$data['email'] = $this->session->userdata('logged_in')['email'];
		$this->load->view('tidakmasuk/cetak.php',$data);
		
	}
	function qrcode(){
		$id = $this->uri->segment(3);
		$this->load->library('ciqrcode');
		$url="http://".$this->about_model->get_by_nama('server')->row()->value."/cuti/cetak/".$id;
		header("Content-Type: image/png");
		$params['data'] = $url;
		$this->ciqrcode->generate($params);
	}
	
	function qrcodeizin(){
		$id = $this->uri->segment(3);
		$this->load->library('ciqrcode');
		$url="http://".$this->about_model->get_by_nama('server')->row()->value."/cetak/izin/".$id;
		header("Content-Type: image/png");
		$params['data'] = $url;
		$this->ciqrcode->generate($params);
	}
	function qrcodetidakmasuk(){
		$id = $this->uri->segment(3);
		$this->load->library('ciqrcode');
		$url="http://".$this->about_model->get_by_nama('server')->row()->value."/cetak/tidakmasuk/".$id;
		header("Content-Type: image/png");
		$params['data'] = $url;
		$this->ciqrcode->generate($params);
	}
	
	
}
