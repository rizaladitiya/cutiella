<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
	
	function __construct(){
		parent::__construct();		
		//error_reporting(0);
        //ini_set('display_errors', 0); 
		$this->load->model(array('about_model','user_model','karyawan_model','tembusan_model','cuti_model'));
		$this->load->helper(array('url','form'));
		$this->load->library('user_agent');
		
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
		$this->load->view('cuti/add',$data);
	}
	public function save()
	{
		
		$id=$this->input->post('id');
		$password=$this->input->post('password');
		if(empty($password)){
		$data=array(
					'nama'=>$this->input->post('nama'),
					'user'=>$this->input->post('user'),
					'email'=>$this->input->post('email'),
					'sisacuti'=>$this->input->post('sisacuti')
					);
		}else{
			$data=array(
					'nama'=>$this->input->post('nama'),
					'user'=>$this->input->post('user'),
					'email'=>$this->input->post('email'),
					'sisacuti'=>$this->input->post('sisacuti'),
					'password'=>md5($this->input->post('password'))
					);
		}
		$this->user_model->update($id,$data);
		$sess_array = array(
         'id' => $this->input->post('id'),
         'user' => $this->input->post('user'),
         'nama' => $this->input->post('nama'),
		 'email' => $this->input->post('email')
       );
       $this->session->set_userdata('logged_in', $sess_array);
		redirect('user', 'refresh');	
        
	}
	public function karyawanupdate()
	{
		$data=$this->data;
		$id=$this->uri->segment(3);
		if(!empty($id)){
		
		$karyawans = $this->karyawan_model->get_by_id($id)->result();
		foreach($karyawans as $value){
				$hasil=(object) array(
										'id'=>$value->id,
										'nama'=>$value->nama,
										'nip'=>$value->nip,
										'awalkerja'=>$value->awalkerja,
										'jabatan'=>$value->jabatan,
										'unitkerja'=>$value->unitkerja,
										'gelar'=>$value->gelar,
										'email'=>$value->email,
										'sisacuti'=>$value->sisacuti,
										'pangkat'=>$value->pangkat
									);
			}
		$data['karyawan'] = $hasil;
		}
		
		
		//print_r($data);
		$this->load->view('master/karyawanupdate',$data);
	}
	public function karyawan()
	{
		$data=$this->data;
		$data['karyawans'] = $this->karyawan_model->get_by_all()->result();
		
		
		$this->load->view('master/karyawan',$data);
	}
	public function karyawansave()
	{
		$password=$this->input->post('password');
		if(empty($password)){
		$karyawan=array(
						'nama'=>$this->input->post('nama'),
						'nip'=>$this->input->post('nip'),
						'awalkerja'=>$this->input->post('awalkerja'),
						'jabatan'=>$this->input->post('jabatan'),
						'unitkerja'=>$this->input->post('unitkerja'),
						'gelar'=>$this->input->post('gelar'),
						'email'=>$this->input->post('email'),
						'sisacuti'=>$this->input->post('sisacuti'),
						'pangkat'=>$this->input->post('pangkat')
						);
		}else{
		$karyawan=array(
						'nama'=>$this->input->post('nama'),
						'nip'=>$this->input->post('nip'),
						'awalkerja'=>$this->input->post('awalkerja'),
						'jabatan'=>$this->input->post('jabatan'),
						'unitkerja'=>$this->input->post('unitkerja'),
						'gelar'=>$this->input->post('gelar'),
						'email'=>$this->input->post('email'),
						'sisacuti'=>$this->input->post('sisacuti'),
						'password'=>md5($password),
						'pangkat'=>$this->input->post('pangkat')
						);
		}
		if($this->input->post('id')==0){
			$this->karyawan_model->add($karyawan);
		}else{
			$this->karyawan_model->update($this->input->post('id'),$karyawan);
		}
		redirect(base_url('master/karyawan'), 'refresh');
	}
	public function karyawandelete()
	{
		$id=$this->uri->segment(3);
		if(!empty($id)){
			$this->karyawan_model->delete($id);
		}
		redirect($this->agent->referrer(), 'refresh');
	}
	public function karyawandata()
	{
		
		$json_data = $this->karyawan_model->get_by_all()->result();
		echo json_encode($json_data);
	}
	
	public function macamcuti()
	{
		$data=$this->data;
		$data['macamcutis'] = $this->cuti_model->get_by_macamcuti()->result();
			
		
		
		$this->load->view('master/macamcuti',$data);
	}
	public function macamcutiupdate()
	{
		$data=$this->data;
		$id=$this->uri->segment(3);
		if(!empty($id)){
		
		$macamcutis = $this->cuti_model->get_macamcuti_by_id($id)->result();
		foreach($macamcutis as $value){
				$hasil=(object) array(
										'id'=>$value->id,
										'nama'=>$value->nama,
										'lama'=>$value->lama
									);
			}
		$data['macamcuti'] = $hasil;
		}
		
		
		
		//print_r($data);
		$this->load->view('master/macamcutiupdate',$data);
	}
	public function macamcutisave()
	{
		$macamcuti=array(
						'nama'=>$this->input->post('nama'),
						'lama'=>$this->input->post('lama'),
						);
		if($this->input->post('id')==0){
			$this->cuti_model->macamcuti_add($macamcuti);
		}else{
			$this->cuti_model->macamcuti_update($this->input->post('id'),$macamcuti);
		}
		redirect(base_url('master/macamcuti'), 'refresh');
	}
	public function macamcutidelete()
	{
		$id=$this->uri->segment(3);
		if(!empty($id)){
			$this->cuti_model->macamcuti_delete($id);
		}
		redirect($this->agent->referrer(), 'refresh');
	}
	public function macamcutidata()
	{
		
		$json_data = $this->cuti_model->get_by_macamcuti()->result();
		echo json_encode($json_data);
	}
	
	
	public function tembusan()
	{
		$data=$this->data;
		$data['tembusans'] = $this->tembusan_model->get_by_all()->result();
			
		
		
		$this->load->view('master/tembusan',$data);
	}
	public function tembusanupdate()
	{
		$data=$this->data;
		$id=$this->uri->segment(3);
		if(!empty($id)){
		
		$tembusans = $this->tembusan_model->get_by_id($id)->result();
		foreach($tembusans as $value){
				$hasil=(object) array(
										'id'=>$value->id,
										'nama'=>$value->nama
									);
			}
		$data['tembusan'] = $hasil;
		}
		
		
		
		//print_r($data);
		$this->load->view('master/tembusanupdate',$data);
	}
	public function tembusansave()
	{
		$tembusan=array(
						'nama'=>$this->input->post('nama')
						);
		if($this->input->post('id')==0){
			$this->tembusan_model->add($tembusan);
		}else{
			$this->tembusan_model->update($this->input->post('id'),$tembusan);
		}
		redirect(base_url('master/tembusan'), 'refresh');
	}
	public function tembusandelete()
	{
		$id=$this->uri->segment(3);
		if(!empty($id)){
			$this->tembusan_model->delete($id);
		}
		redirect($this->agent->referrer(), 'refresh');
	}
	public function tembusandata()
	{
		
		$json_data = $this->tembusan_model->get_by_all()->result();
		echo json_encode($json_data);
	}
}

