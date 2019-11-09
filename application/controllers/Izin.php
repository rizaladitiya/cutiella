<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Izin extends CI_Controller {
	
	private $limit=30;
	private $id,$nama,$akses;
	private $data=array();
	function __construct(){
		parent::__construct();		
		error_reporting(0);
        //ini_set('display_errors', 0); 
		$this->load->model(array('about_model','user_model','karyawan_model','izin_model'));
		$this->load->helper(array('url','form'));
		$this->load->library('user_agent');
		
		$sess = getsession();
		$this->id = $sess->id;
		$this->nama = $sess->nama;
		$this->akses = $sess->akses;
		
		$this->data['id'] = $sess->id;
		$this->data['user'] = $sess->user;
		$this->data['email'] = $sess->nama;
		$this->data['akses'] = $sess->akses;
		if(!$this->session->userdata('logged_in'))
   			
   		{
     		//If no session, redirect to login page
     		redirect('auth', 'refresh');
   		}
 
	}
	
	function index($offset=0,$order_column='id',$order_type='asc',$where=''){
		$data=$this->data;
		$this->load->library(array('pagination','table'));
		if (empty($offset)) $offset=0;
		if (empty($order_column)) $order_column='id';
		if (empty($order_type)) $order_type='asc';
		//TODO: check for valid column
		if($this->akses=="admin"){
			$alls=$this->izin_model->get_paged_list($this->limit,
			$offset,$order_column,$order_type,$where)->result();
		}else{
			$alls=$this->izin_model->get_paged_list_user($this->limit,
			$offset,$order_column,$order_type,$where,$this->id)->result();
		}
		$config['base_url']= site_url('izin/index/');
		$config['total_rows']=$this->izin_model->count_all();
		$config['per_page']=$this->limit;
		$config['first_link'] = false; 
    	$config['last_link']  = false;
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a href="#"><b>';
		$config['cur_tag_close'] = '</b></a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
    	$config ['prev_link'] = '<i class="fa fa-caret-left"></i>';
    	$config ['next_link'] = '<i class="fa fa-caret-right"></i>';
		//$config['uri_segment']=3;
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
		// generate table data
		
		$this->table->set_empty("&nbsp;");
		$tmpl = array ('table_open'=>'<table id="tabellaporan" class="table table-hover">');
		$this->table->set_template($tmpl); 
		$new_order=($order_type=='asc'?'desc':'asc');
		$this->table->set_heading(
		'Print',
		'Approve',
		anchor('izin/index/'.$offset.'/nomor/'.$new_order."/".$where,'Nomor'),
		anchor('izin/index/'.$offset.'/nama/'.$new_order."/".$where,'Nama'),
		anchor('izin/index/'.$offset.'/nip/'.$new_order."/".$where,'NIP'),
		anchor('izin/index/'.$offset.'/unitkerja/'.$new_order."/".$where,'Unit Kerja'),
		anchor('izin/index/'.$offset.'/jabatan/'.$new_order."/".$where,'Jabatan'),
		'Tanggal',
		'Alasan izin',
		'&nbsp;',
		'&nbsp;'
	);
	$i=0+$offset;
	$max_char=45;
	foreach ($alls as $all){
		$this->table->add_row(
			anchor('cetak/izin/'.$all->id,'&nbsp;',array('class'=>'fa fa-print', "target"=>"_blank")),
			'<input type="checkbox" name="approve[]" id="approve[]" value="'.$all->id.'" class="minimal" '.(($all->approve==1)?' checked':'').' />',
			$all->nomor,
			$all->nama,
			$all->nip,
			$all->unitkerja,
			$all->jabatan,
			date('d-M-y',strtotime($all->tanggal)),
			$all->alasanizin,
			anchor('izin/update/'.$all->id,'&nbsp;',array('class'=>'fa fa-pencil')),
			anchor('izin/delete/'.$all->id,'&nbsp;',array('class'=>'fa fa-trash','onclick'=>"return confirm('Apakah Anda yakin ingin menghapus ".$all->nama." ".$all->nomor."?')"))
		);
	
	}
	$data['table']=$this->table->generate();
	
		$this->load->view('izin/view.php',$data);
		
	}
	public function save()
	{
		
		$pejabatizin=$this->about_model->get_by_nama('pejabatizin')->row()->value;
			$izin=array(
							'karyawan'=>(int) $this->input->post('karyawan'),
							'nomor'=>$this->input->post('nomor'),
							'tanggal'=>date('Y-m-d',strtotime($this->input->post('tanggal'))),
							'alasanizin'=>$this->input->post('alasanizin'),
							'atasan'=>$this->input->post('atasan'),
							'dikeluarkan'=>$this->input->post('atasan'),
							'tglkeluar'=>$this->input->post('tglkeluar'),
							'dari'=>$this->input->post('dari'),
							'hingga'=>$this->input->post('hingga'),
							'alasan'=>$this->input->post('alasan'),
							'approve'=>0,
							'verif1'=>0,
							'verif2'=>0
							);
			$id = $this->input->post('id');
			if($id==0){
				$id = $this->izin_model->add($izin);
				
				
				
			}else{
				$this->izin_model->update($id,$izin);
				
				
			}
			echo $id;
		//redirect('izin/add', 'refresh');	
        
	}
	public function add()
	{
		$data=$this->data;
		$tanggal=$this->input->post('tanggal');
		$data['karyawans'] = $this->karyawan_model->get_by_all()->result();
		$data['alasans'] = $this->izin_model->get_alasan_izin()->result();
		if(!empty($id))
		{
				$data['tanggal']=$tanggal;
			}else{
				
				$data['izin'] =  new stdClass;
				$data['tanggal']='';
				$data['izin'] = array(	
										'karyawan'=>0,
										'nomor'=>'',
										'tanggal'=>'',
										'hingga'=>'',
										'tglkeluar'=>'',
										'dari'=>'',
										'hingga'=>'',
										'alasanizin'=>'',
										'atasan'=>'',
										'alasan'=>''
									);
				
			}
		$this->load->view('izin/add',$data);
	}
	function update(){
		$data=$this->data;
		$data['karyawans'] = $this->karyawan_model->get_by_all()->result();
		$data['alasans'] = $this->izin_model->get_alasan_izin()->result();
		$alls=$this->izin_model->get_by_id($this->uri->segment(3))->result();
		foreach ($alls as $value) {
			$hasil=(object)array(
							'id'=>$value->id,
							'karyawan'=>$value->karyawan,
							'nomor'=>$value->nomor,
							'tanggal'=>$value->tanggal,
							'tglkeluar'=>$value->tglkeluar,
							'dari'=>$value->dari,
							'hingga'=>$value->hingga,
							'atasan'=>$value->atasan,
							'alasan'=>$value->alasan,
							'alasanizin'=>$value->alasanizin
						);
		}
		
		$data['izin']=$hasil;
		$this->load->view('izin/add.php',$data);
	}
	
	public function approve()
	{
		$acc = $this->uri->segment(4);
		$id = $this->uri->segment(3);
		$this->izin_model->approve($id,$acc);
	}
	public function verif1()
	{
		$acc = $this->uri->segment(4);
		$id = $this->uri->segment(3);
		$this->izin_model->verif1($id,$acc);
	}
	public function verif2()
	{
		$acc = $this->uri->segment(4);
		$id = $this->uri->segment(3);
		$this->izin_model->verif2($id,$acc);
	}
	public function delete()
	{
		$this->izin_model->delete($this->uri->segment(3));
		redirect($this->agent->referrer(), 'refresh');
	}
	public function report()
	{
		$data=$this->data;
		$dari= $this->input->post('dari');
		$hingga =  $this->input->post('hingga');
		$this->load->library(array('pagination','table'));
		if(!empty($dari)){
			$data['dari']=$dari;
		}else{
			$data['dari']=sekarang();
		}
		if(!empty($hingga)){
			$data['hingga']=$hingga;
		}else{
			$data['hingga']=sekarang();
		}
		if($this->akses=="admin"){
		$alls=$this->izin_model->get_by_tanggal($data['dari'],$data['hingga'])->result();
		}else{
		$alls=$this->izin_model->get_by_tanggal_user($data['dari'],$data['hingga'],$this->id)->result();
		}
		$config['base_url']= site_url('izin/index/');
		$config['total_rows']=$this->izin_model->count_all();
		$config['per_page']=$this->limit;
		$config['first_link'] = false; 
    	$config['last_link']  = false;
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a href="#"><b>';
		$config['cur_tag_close'] = '</b></a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
    	$config ['prev_link'] = '<i class="fa fa-caret-left"></i>';
    	$config ['next_link'] = '<i class="fa fa-caret-right"></i>';
		//$config['uri_segment']=3;
		// generate table data
		
		$this->table->set_empty("&nbsp;");
		$tmpl = array ('table_open'=>'<table id="tabellaporan" class="table table-hover">');
		$this->table->set_template($tmpl); 
		$this->table->set_heading(
		'Print',
		'Approve',
		'Nomor',
		'Nama',
		'NIP',
		'Jabatan',
		'Tanggal',
		'Dari',
		'Hingga',
		'Alasan izin',
		'&nbsp;',
		'&nbsp;'
	);
	$max_char=45;
	foreach ($alls as $all){
		$this->table->add_row(
			anchor('cetak/izin/'.$all->id,'&nbsp;',array('class'=>'fa fa-print', "target"=>"_blank")),
			'<input type="checkbox" name="approve[]" id="approve[]" value="'.$all->id.'" class="minimal" '.(($all->approve==1)?' checked':'').' />',
			$all->nomor,
			$all->nama,
			$all->nip,
			$all->jabatan,
			date('d-M-y',strtotime($all->tanggal)),
			date('h:i',strtotime($all->dari)),
			date('h:i',strtotime($all->hingga)),
			$all->alasanizin,
			anchor('izin/update/'.$all->id,'&nbsp;',array('class'=>'fa fa-pencil')),
			anchor('izin/delete/'.$all->id,'&nbsp;',array('class'=>'fa fa-trash','onclick'=>"return confirm('Apakah Anda yakin ingin menghapus ".$all->nama." ".$all->nomor."?')"))
		);
	}
	$data['table']=$this->table->generate();
		$this->load->view('izin/report',$data);
	}
	
	function cetak(){
		$id = $this->uri->segment(3);
		$data['izin']=$this->izin_model->get_by_id($id)->result();
		$this->load->view('izin/cetak.php',$data);
		
	}
	
	function qrcode(){
		$id = $this->uri->segment(3);
		$this->load->library('ciqrcode');
		$url="http://".$this->about_model->get_by_nama('server')->row()->value."/izin/cetak/".$id;
		header("Content-Type: image/png");
		$params['data'] = $url;
		$this->ciqrcode->generate($params);
	}
	
	
	
}
