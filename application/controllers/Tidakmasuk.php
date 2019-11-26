<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tidakmasuk extends CI_Controller {
	
	private $limit=30;
	private $id,$nama,$akses;
	private $data=array();
	function __construct(){
		parent::__construct();		
		error_reporting(0);
        //ini_set('display_errors', 0); 
		$this->load->model(array('about_model','user_model','karyawan_model','tidakmasuk_model'));
		$this->load->helper(array('url','form'));
		$this->load->library('user_agent');
		$sess = getsession();
		$this->id = $sess->id;
		$this->nama = $sess->nama;
		$this->akses = $sess->akses;
		$this->user = $sess->user;
		
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
	
	function index($offset=0,$order_column='id',$order_type='asc',$where=''){
		
		$data=$this->data;
		$data['akses']=$this->akses;
		$this->load->library(array('pagination','table'));
		if (empty($offset)) $offset=0;
		if (empty($order_column)) $order_column='id';
		if (empty($order_type)) $order_type='asc';
		//TODO: check for valid column
		
		if($this->akses=="admin" or $this->akses=="VERIFY1"){
		$alls=$this->tidakmasuk_model->get_paged_list($this->limit,
		$offset,$order_column,$order_type,$where)->result();
		}else{
		$alls=$this->tidakmasuk_model->get_paged_list_user($this->limit,
		$offset,$order_column,$order_type,$where,$this->id)->result();
		}
		$config['base_url']= site_url('tidakmasuk/index/');
		$config['total_rows']=$this->tidakmasuk_model->count_all();
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
		'Verif',
		'Upload',
		'Approve',
		anchor('tidakmasuk/index/'.$offset.'/nomor/'.$new_order."/".$where,'Nomor'),
		anchor('tidakmasuk/index/'.$offset.'/nama/'.$new_order."/".$where,'Nama'),
		anchor('tidakmasuk/index/'.$offset.'/nip/'.$new_order."/".$where,'NIP'),
		anchor('tidakmasuk/index/'.$offset.'/unitkerja/'.$new_order."/".$where,'Unit Kerja'),
		anchor('tidakmasuk/index/'.$offset.'/jabatan/'.$new_order."/".$where,'Jabatan'),
		'Tanggal',
		'Alasan tidakmasuk',
		'&nbsp;',
		'&nbsp;'
	);
	$i=0+$offset;
	$max_char=45;
	foreach ($alls as $all){
		$upload="";
		$approve="";
		$verif1="";
		
		if($this->user=="admin"){
			$approve='<input type="checkbox" name="approve[]" id="approve[]" value="'.$all->id.'" class="minimal" '.(($all->approve==1)?' checked':'').' />';
			$delete=anchor('tidakmasuk/delete/'.$all->id,'&nbsp;',array('class'=>'fa fa-trash','onclick'=>"return confirm('Apakah Anda yakin ingin menghapus ".$all->nama." ".$all->nomor."?')"));
		(($all->verif1==1)?$verif1=givecheck(1):$verif1='');
		}else if($this->user=="verif1"){
			(($all->approve==1)?$approve=givecheck(1):$approve='');
			$verif1='<input type="checkbox" name="verif1[]" id="verif1[]" value="'.$all->id.'" class="verif1" '.(($all->verif1==1)?' checked':'').' />';
			$delete="&nbsp;";
		}else{
			(($all->approve==1)?$approve=givecheck(1):$approve='');
			(($all->verif1==1)?$verif1=givecheck(1):$verif1='');
			$delete="&nbsp;";
		}
		
		if($all->upload==""){
			$upload='<a href="'.site_url("tidakmasuk/upload/".$all->id).'" class="fa fa-upload">&nbsp;</a>';
		}else{
			$upload='<a href="'.site_url("assets/images/tidakmasuk/".$all->filename).'"  target="_blank">View</a>';
			}
			
		$this->table->add_row(
			anchor('cetak/tidakmasuk/'.$all->id,'&nbsp;',array('class'=>'fa fa-print', "target"=>"_blank")),
			$upload,
			$verif1,
			$approve,
			$all->nomor,
			$all->nama,
			$all->nip,
			$all->unitkerja,
			$all->jabatan,
			date('d-M-y',strtotime($all->tanggal)),
			$all->alasantidakmasuk,
			anchor('tidakmasuk/update/'.$all->id,'&nbsp;',array('class'=>'fa fa-pencil')),
			$delete
		);
	}
	$data['table']=$this->table->generate();
	
		$this->load->view('tidakmasuk/view.php',$data);
		
	}
	public function save()
	{
		
		$pejabattidakmasuk=$this->about_model->get_by_nama('pejabattidakmasuk')->row()->value;
			$tidakmasuk=array(
							'karyawan'=>(int) $this->input->post('karyawan'),
							'nomor'=>$this->input->post('nomor'),
							'tanggal'=>date('Y-m-d',strtotime($this->input->post('tanggal'))),
							'alasantidakmasuk'=>$this->input->post('alasantidakmasuk'),
							'atasan'=>$this->input->post('atasan'),
							'dikeluarkan'=>$this->input->post('atasan'),
							'tglkeluar'=>$this->input->post('tglkeluar'),
							'approve'=>0,
							'verif1'=>0,
							'verif2'=>0,
							'filename'=>''
							);
			$id = $this->input->post('id');
			if($id==0){
				$id = $this->tidakmasuk_model->add($tidakmasuk);
				
				
				
			}else{
				$this->tidakmasuk_model->update($id,$tidakmasuk);
				
				
			}
			echo $id;
		//redirect('tidakmasuk/add', 'refresh');	
        
	}
	public function add()
	{
		
		$data=$this->data;
		
		$data['akses']=$this->akses;
		$tanggal=$this->input->post('tanggal');
		$data['karyawans'] = $this->karyawan_model->get_by_all()->result();
		if(!empty($id))
		{
				$data['tanggal']=$tanggal;
			}else{
				
				$data['tidakmasuk'] =  new stdClass;
				$data['tanggal']='';
				$data['tidakmasuk'] = array(	
										'karyawan'=>0,
										'nomor'=>'',
										'tanggal'=>'',
										'hingga'=>'',
										'tglkeluar'=>'',
										'alasantidakmasuk'=>'',
										'atasan'=>'',
										'filename'=>''
									);
				
			}
		$this->load->view('tidakmasuk/add',$data);
	}
	function update(){
		
		$data=$this->data;
		
		$data['akses']=$this->akses;
		$data['karyawans'] = $this->karyawan_model->get_by_all()->result();
		$alls=$this->tidakmasuk_model->get_by_id($this->uri->segment(3))->result();
		foreach ($alls as $value) {
			$hasil=(object)array(
							'id'=>$value->id,
							'karyawan'=>$value->karyawan,
							'nomor'=>$value->nomor,
							'tanggal'=>$value->tanggal,
							'tglkeluar'=>$value->tglkeluar,
							'atasan'=>$value->atasan,
							'alasantidakmasuk'=>$value->alasantidakmasuk
						);
		}
		
		$data['tidakmasuk']=$hasil;
		$this->load->view('tidakmasuk/add.php',$data);
	}
	
	function upload(){
		
		$data=$this->data;
		
		$data['akses']=$this->akses;
		$data['karyawans'] = $this->karyawan_model->get_by_all()->result();
		$alls=$this->tidakmasuk_model->get_by_id($this->uri->segment(3))->result();
		foreach ($alls as $value) {
			$hasil=(object)array(
							'id'=>$value->id,
							'karyawan'=>$value->karyawan,
							'nomor'=>$value->nomor,
							'tanggal'=>$value->tanggal,
							'tglkeluar'=>$value->tglkeluar,
							'atasan'=>$value->atasan,
							'alasantidakmasuk'=>$value->alasantidakmasuk
						);
		}
		
		$data['tidakmasuk']=$hasil;
		$this->load->view('tidakmasuk/upload.php',$data);
	}
	
	public function approve()
	{
		$acc = $this->uri->segment(4);
		$id = $this->uri->segment(3);
		$this->tidakmasuk_model->approve($id,$acc);
	}
	public function verif1()
	{
		$acc = $this->uri->segment(4);
		$id = $this->uri->segment(3);
		$this->tidakmasuk_model->verif1($id,$acc);
	}
	public function verif2()
	{
		$acc = $this->uri->segment(4);
		$id = $this->uri->segment(3);
		$this->tidakmasuk_model->verif2($id,$acc);
	}
	public function delete()
	{
		$this->tidakmasuk_model->delete($this->uri->segment(3));
		redirect($this->agent->referrer(), 'refresh');
	}
	public function report()
	{
		$data=$this->data;
		$data['akses']=$this->akses;
		$dari= $this->input->post('dari');
		$hingga =  $this->input->post('hingga');
		$data=$this->data;
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
		if($this->akses=="admin" or $this->akses=="VERIFY1"){
		$alls=$this->tidakmasuk_model->get_by_tanggal($data['dari'],$data['hingga'])->result();
		}else{
		$alls=$this->tidakmasuk_model->get_by_tanggal_user($data['dari'],$data['hingga'],$this->id)->result();
			}
		$config['base_url']= site_url('tidakmasuk/index/');
		$config['total_rows']=$this->tidakmasuk_model->count_all();
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
		'Verif',
		'Upload',
		'Approve',
		'Nomor',
		'Nama',
		'NIP',
		'Jabatan',
		'Tanggal',
		'Alasan tidakmasuk',
		'&nbsp;',
		'&nbsp;'
	);
	$max_char=45;
	foreach ($alls as $all){
		$upload="";
		$approve="";
		$verif1="";
		
		if($this->user=="admin"){
			$approve='<input type="checkbox" name="approve[]" id="approve[]" value="'.$all->id.'" class="minimal" '.(($all->approve==1)?' checked':'').' />';
			$delete=anchor('tidakmasuk/delete/'.$all->id,'&nbsp;',array('class'=>'fa fa-trash','onclick'=>"return confirm('Apakah Anda yakin ingin menghapus ".$all->nama." ".$all->nomor."?')"));
		(($all->verif1==1)?$verif1=givecheck(1):$verif1='');
		}else if($this->user=="verif1"){
			(($all->approve==1)?$approve=givecheck(1):$approve='');
			$verif1='<input type="checkbox" name="verif1[]" id="verif1[]" value="'.$all->id.'" class="verif1" '.(($all->verif1==1)?' checked':'').' />';
			$delete="&nbsp;";
		}else{
			(($all->approve==1)?$approve=givecheck(1):$approve='');
			(($all->verif1==1)?$verif1=givecheck(1):$verif1='');
			$delete="&nbsp;";
		}
		
		if($all->upload==""){
			$upload='<a href="'.site_url("tidakmasuk/upload/".$all->id).'" class="fa fa-upload">&nbsp;</a>';
		}else{
			$upload='<a href="'.site_url("assets/images/tidakmasuk/".$all->filename).'"  target="_blank">View</a>';
			}
			
		$this->table->add_row(
			anchor('cetak/tidakmasuk/'.$all->id,'&nbsp;',array('class'=>'fa fa-print', "target"=>"_blank")),
			$upload,
			$verif1,
			$approve,
			$all->nomor,
			$all->nama,
			$all->nip,
			$all->jabatan,
			date('d-M-y',strtotime($all->tanggal)),
			$all->alasantidakmasuk,
			anchor('tidakmasuk/update/'.$all->id,'&nbsp;',array('class'=>'fa fa-pencil')),
			$delete
		);
	}
	$data['table']=$this->table->generate();
		$this->load->view('tidakmasuk/report',$data);
	}
	
	function cetak(){
		$id = $this->uri->segment(3);
		$data['tidakmasuk']=$this->tidakmasuk_model->get_by_id($id)->result();
		$this->load->view('tidakmasuk/cetak.php',$data);
		
	}
	
	function qrcode(){
		$id = $this->uri->segment(3);
		$this->load->library('ciqrcode');
		$url="http://".$this->about_model->get_by_nama('server')->row()->value."/tidakmasuk/cetak/".$id;
		header("Content-Type: image/png");
		$params['data'] = $url;
		$this->ciqrcode->generate($params);
	}
	
	public function uploadsave(){
    
      // lakukan upload file dengan memanggil function upload yang ada di GambarModel.php
	  
		$id = $this->input->post("id");
      $upload = $this->tidakmasuk_model->upload();
      if($upload['result'] == "success"){ // Jika proses upload sukses
         // Panggil function save yang ada di GambarModel.php untuk menyimpan data ke database
        $this->tidakmasuk_model->gambarsave($upload,$id);
		//echo "success";
		
		//redirect($this->agent->referrer(), 'refresh');
        
		redirect('tidakmasuk', 'refresh');	
        //redirect('gambar'); // Redirect kembali ke halaman awal / halaman view data
      }else{ // Jika proses upload gagal
        $data['message'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
		echo $data['message'];
      }
    
    
    //$this->load->view('gambar/form', $data);
  }
	
	
}
