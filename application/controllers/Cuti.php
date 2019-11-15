<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti extends CI_Controller {
	
	private $limit=30;
	private $id,$nama,$akses;
	private $data=array();
	function __construct(){
		parent::__construct();		
		error_reporting(0);
        //ini_set('display_errors', 0); 
		$this->load->model(array('about_model','user_model','karyawan_model','cuti_model','tembusan_model'));
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
	
	function index($offset=0,$order_column='id',$order_type='asc',$where=''){
		$data=$this->data;
		$data['akses']=$this->akses;
		$data['tembusans'] = $this->tembusan_model->get_by_all()->result();
		$this->load->library(array('pagination','table'));
		if (empty($offset)) $offset=0;
		if (empty($order_column)) $order_column='id';
		if (empty($order_type)) $order_type='asc';
		//TODO: check for valid column
		if($this->akses=="admin"){
		$alls=$this->cuti_model->get_paged_list($this->limit,
		$offset,$order_column,$order_type,$where)->result();
		}else{
			$alls=$this->cuti_model->get_paged_list_user($this->limit,
		$offset,$order_column,$order_type,$where,$this->id)->result();
		}
		$config['base_url']= site_url('cuti/index/');
		$config['total_rows']=$this->cuti_model->count_all();
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
		anchor('cuti/index/'.$offset.'/nomor/'.$new_order."/".$where,'Nomor'),
		anchor('cuti/index/'.$offset.'/nama/'.$new_order."/".$where,'Nama'),
		anchor('cuti/index/'.$offset.'/nip/'.$new_order."/".$where,'NIP'),
		anchor('cuti/index/'.$offset.'/unitkerja/'.$new_order."/".$where,'Unit Kerja'),
		anchor('cuti/index/'.$offset.'/jabatan/'.$new_order."/".$where,'Jabatan'),
		'Dari',
		'Hingga',
		'Alamat Cuti',
		'Lama',
		'Alasan Cuti',
		'&nbsp;',
		'&nbsp;'
	);
	$i=0+$offset;
	$max_char=45;
	foreach ($alls as $all){
		$daftartembusan = $this->cuti_model->get_by_tembusan($all->id);
		$this->table->add_row(
			anchor('cetak/cetak/'.$all->id,'&nbsp;',array('class'=>'fa fa-print', "target"=>"_blank")),
			'<input type="checkbox" name="approve[]" id="approve[]" value="'.$all->id.'" class="minimal" '.(($all->approve==1)?' checked':'').' />',
			$all->nomor,
			$all->nama,
			$all->nip,
			$all->unitkerja,
			$all->jabatan,
			date('d-M-y',strtotime($all->dari)),
			date('d-M-y',strtotime($all->hingga)),
			$all->alamatcuti,
			$all->lama,
			$all->alasancuti,
			anchor('cuti/update/'.$all->id,'&nbsp;',array('class'=>'fa fa-pencil')),
			anchor('cuti/delete/'.$all->id,'&nbsp;',array('class'=>'fa fa-trash','onclick'=>"return confirm('Apakah Anda yakin ingin menghapus ".$all->nama." ".$all->nomor."?')"))
		);
	}
	$data['table']=$this->table->generate();
	
		$this->load->view('cuti/view.php',$data);
		
	}
	public function save()
	{
		
		$pejabatcuti=$this->about_model->get_by_nama('pejabatcuti')->row()->value;
			$cuti=array(
							'karyawan'=>(int) $this->input->post('karyawan'),
							'nomor'=>$this->input->post('nomor'),
							'macamcuti'=>(int) $this->input->post('macamcuti'),
							'dari'=>date('Y-m-d',strtotime($this->input->post('dari'))),
							'hingga'=>date('Y-m-d',strtotime($this->input->post('hingga'))),
							'alamatcuti'=>$this->input->post('alamatcuti'),
							'alasancuti'=>$this->input->post('alasancuti'),
							'lama'=>$this->input->post('lama'),
							'atasan'=>$this->input->post('atasan'),
							'dikeluarkan'=>$pejabatcuti,
							'nomerhp'=>$this->input->post('nomerhp'),
							'tglkeluar'=>$this->input->post('tglkeluar'),
							'approve'=>0,
							'verif1'=>0,
							'verif2'=>0
							);
			$id = $this->input->post('id');
			$tembusan = $this->input->post('tembusan');
			if($id==0){
				$id = $this->cuti_model->add($cuti);
				
				
				if(isset($tembusan)){
					$this->cuti_model->add_tembusan($tembusan,$id);
				}
			}else{
				$this->cuti_model->update($id,$cuti);
				$tembusan = $this->input->post('tembusan');
				$this->cuti_model->delete_tembusan_by_cuti($id);
				
				if(isset($tembusan)){
					$this->cuti_model->add_tembusan($tembusan,$id);
				}
			}
			echo $id;
		//redirect('cuti/add', 'refresh');	
        
	}
	public function add()
	{
		$data['akses']=$this->akses;
		$data=$this->data;
		$dari=$this->input->post('dari');
		$hingga=$this->input->post('hingga');
		$data['karyawans'] = $this->karyawan_model->get_by_all()->result();
		$data['macamcutis'] = $this->cuti_model->get_by_macamcuti()->result();
		$data['tembusans'] = $this->tembusan_model->get_by_all()->result();
		if(!empty($id))
		{
				$data['dari']=$this->input->post('dari');
				$data['hingga']=$this->input->post('hingga');
				//$data['cuti'] = $this->cuti_model->get_by_detail_id($this->input->post('id'))->result();
			}else{
				
				$data['cuti'] =  new stdClass;
				$data['dari']='';
				$data['hingga']='';
				$data['cuti'] = array(	
										'karyawan'=>0,
										'nomor'=>'',
										'macamcuti'=>0,
										'dari'=>'',
										'hingga'=>'',
										'tglkeluar'=>'',
										'lama'=>'',
										'alasancuti'=>'',
										'tembusan'=>0,
										'atasan'=>'',
										'nomerhp'=>'',
										'alamatcuti'=>''
									);
				
			}
		$this->load->view('cuti/add',$data);
	}
	function update(){
		
		$data=$this->data;
		$data['akses']=$this->akses;
		$data['karyawans'] = $this->karyawan_model->get_by_all()->result();
		$data['macamcutis'] = $this->cuti_model->get_by_macamcuti()->result();
		$data['tembusans'] = $this->tembusan_model->get_by_all()->result();
		$alls=$this->cuti_model->get_by_id($this->uri->segment(3))->result();
		$tembusan = $this->cuti_model->get_tembusan_by_cuti($this->uri->segment(3))->result();
		foreach ($alls as $value) {
			$hasil=(object)array(
							'id'=>$value->id,
							'karyawan'=>$value->karyawan,
							'nomor'=>$value->nomor,
							'macamcuti'=>$value->macamcuti,
							'dari'=>$value->dari,
							'hingga'=>$value->hingga,
							'alamatcuti'=>$value->alamatcuti,
							'tglkeluar'=>$value->tglkeluar,
							'atasan'=>$value->atasan,
							'nomerhp'=>$value->nomerhp,
							'lama'=>$value->lama,
							'alasancuti'=>$value->alasancuti,
							'tembusan'=>$tembusan
						);
		}
		
		$data['cuti']=$hasil;
		$this->load->view('cuti/add.php',$data);
	}
	
	public function sisacuti()
	{
		$id = $this->input->post('id');
		if($this->cuti_model->get_by_total_cuti(date('Y'),1,$id)->num_rows()>=1){
    		$ambil=round($this->cuti_model->get_by_total_cuti(date('Y'),1,$id)->row()->total); 
	}else{
		$ambil=0;
		}
	$jatah = round($this->cuti_model->get_macamcuti_by_id(1)->row()->lama);
		echo $jatah-$ambil;
	}
	
	public function approve()
	{
		$acc = $this->uri->segment(4);
		$id = $this->uri->segment(3);
		$this->cuti_model->approve($id,$acc);
	}
	public function verif1()
	{
		$acc = $this->uri->segment(4);
		$id = $this->uri->segment(3);
		$this->cuti_model->verif1($id,$acc);
	}
	public function verif2()
	{
		$acc = $this->uri->segment(4);
		$id = $this->uri->segment(3);
		$this->cuti_model->verif2($id,$acc);
	}
	public function delete()
	{
		$this->cuti_model->delete($this->uri->segment(3));
		redirect($this->agent->referrer(), 'refresh');
	}
	public function report()
	{
		$data=$this->data;
		$data['akses']=$this->akses;
		$dari= $this->input->post('dari');
		$hingga =  $this->input->post('hingga');
		$data['tembusans'] = $this->tembusan_model->get_by_all()->result();
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
		$alls=$this->cuti_model->get_by_tanggal($data['dari'],$data['hingga'])->result();
		}else{
		$alls=$this->cuti_model->get_by_tanggal_user($data['dari'],$data['hingga'],$this->id)->result();
		}
		$config['base_url']= site_url('cuti/index/');
		$config['total_rows']=$this->cuti_model->count_all();
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
		'Dari',
		'Hingga',
		'Alamat Cuti',
		'Lama',
		'Alasan Cuti',
		'&nbsp;',
		'&nbsp;'
	);
	$max_char=45;
	foreach ($alls as $all){
		$daftartembusan = $this->cuti_model->get_by_tembusan($all->id);
		$this->table->add_row(
			anchor('cetak/cetak/'.$all->id,'&nbsp;',array('class'=>'fa fa-print', "target"=>"_blank")),
			'<input type="checkbox" name="approve[]" id="approve[]" value="'.$all->id.'" class="minimal" '.(($all->approve==1)?' checked':'').' />',
			$all->nomor,
			$all->nama,
			$all->nip,
			$all->jabatan,
			date('d-M-y',strtotime($all->dari)),
			date('d-M-y',strtotime($all->hingga)),
			$all->alamatcuti,
			$all->lama,
			$all->alasancuti,
			anchor('cuti/update/'.$all->id,'&nbsp;',array('class'=>'fa fa-pencil')),
			anchor('cuti/delete/'.$all->id,'&nbsp;',array('class'=>'fa fa-trash','onclick'=>"return confirm('Apakah Anda yakin ingin menghapus ".$all->nama." ".$all->nomor."?')"))
		);
	}
	$data['table']=$this->table->generate();
		$this->load->view('cuti/report',$data);
	}
	
	function cetak(){
		$id = $this->uri->segment(3);
		$data=$this->data;
		$data['cuti']=$this->cuti_model->get_by_id($id)->result();
		$this->load->view('cuti/cetak.php',$data);
		
	}
	
	function qrcode(){
		$id = $this->uri->segment(3);
		$this->load->library('ciqrcode');
		$url="http://".$this->about_model->get_by_nama('server')->row()->value."/cuti/cetak/".$id;
		header("Content-Type: image/png");
		$params['data'] = $url;
		$this->ciqrcode->generate($params);
	}
	
	
}
