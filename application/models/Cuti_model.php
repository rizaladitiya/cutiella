<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti_model extends CI_Model {
	private $primary_key='id';
	private $table_name='suratcuti';
	private $table_karyawan='karyawan';
	private $table_macamcuti='macamcuti';
function __construct()
	{
		parent::__construct();
	}

function count_all() {
	return $this->db->count_all($this->table_name);
}
function get_by_all(){
	$select=array(
				'suratcuti.id',
				'suratcuti.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'suratcuti.nomor',
				'suratcuti.macamcuti',
				'suratcuti.alamatcuti',
				'suratcuti.alasancuti',
				'suratcuti.lama',
				'suratcuti.tglkeluar',
				'suratcuti.atasan',
				'suratcuti.dikeluarkan',
				'suratcuti.nomerhp',
				'suratcuti.approve',
				'suratcuti.verif1',
				'suratcuti.verif2',
				'suratcuti.upload',
				'suratcuti.filename',
				'macamcuti.nama as namamacamcuti',
				'date(suratcuti.dari) as dari',
				'date(suratcuti.hingga) as hingga'
			);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->where($where);
	$this->db->join($this->table_karyawan, 'suratcuti.karyawan = karyawan.id', 'inner');
	$this->db->join($this->table_karyawan, 'suratcuti.macamcuti = macamcuti.id', 'inner');
	$this->db->order_by('dari asc');
	return $this->db->get();
}

function get_by_macamcuti(){
	$select=array(
				$this->primary_key,
				'nama',
				'lama'
			);
	$this->db->select($select);    
	$this->db->from($this->table_macamcuti);
	$this->db->order_by('nama asc');
	return $this->db->get();
}

function get_macamcuti_by_id($id){
	
	$select=array(
			$this->primary_key,
			'nama',
			'lama');
	$this->db->select($select);    
	$this->db->from($this->table_macamcuti);
	$this->db->where($this->primary_key,$id);
	$this->db->order_by('nama asc');
	return $this->db->get();
}

function get_sisacuti_by_id($id,$year){
	$tahunberlaku = 2019;
	
	if($year==$tahunberlaku){
		$select=array(
				'sisacuti as lama'
			);
		$where=array(
				'id'=>$id
			);
		$from = "karyawan";
	} else {
		$select=array(
			'lama'
		);
		$where=array(
				'id'=>1
			);
		$from = $this->table_macamcuti;
	}
	$this->db->select($select);    
	$this->db->from($from);
	$this->db->where($this->primary_key,$id);
	$this->db->order_by('nama asc');
	return $this->db->get();
}

function get_cuti_n_id($id){
	
		$select=array(
				'sisacuti'
			);
		$where=array(
				'id'=>$id
			);
		$from = "karyawan";
	
	$this->db->select($select);    
	$this->db->from($from);
	$this->db->where($this->primary_key,$id);
	$this->db->order_by('nama asc');
	return $this->db->get();
}
function get_cuti_n1_id($id){
	
		$select=array(
				'sisacuti1'
			);
		$where=array(
				'id'=>$id
			);
		$from = "karyawan";
	
	$this->db->select($select);    
	$this->db->from($from);
	$this->db->where($this->primary_key,$id);
	$this->db->order_by('nama asc');
	return $this->db->get();
}
function get_cuti_n2_id($id){
	
		$select=array(
				'sisacuti2'
			);
		$where=array(
				'id'=>$id
			);
		$from = "karyawan";
	
	$this->db->select($select);    
	$this->db->from($from);
	$this->db->where($this->primary_key,$id);
	$this->db->order_by('nama asc');
	return $this->db->get();
}

function get_macamcuti_by_name($name){
	$select=array(
				$this->primary_key,
				'nama',
				'lama'
			);
	$this->db->select($select);    
	$this->db->from($this->table_macamcuti);
	$this->db->where("nama",$name);
	$this->db->order_by('nama asc');
	return $this->db->get();
}
function get_by_tembusan($id){
	$data=array();
	$select=array(
				'tembusan'
			);
	$this->db->select($select);    
	$this->db->from('suratcutitembusan');
	$this->db->where('suratcuti',$id);
	foreach($this->db->get()->result() as $input_type) {
    	$data[] = $input_type->tembusan;
	}
	return $data;
}
function get_tembusan_by_cuti($id) {
	$this->db->from('suratcutitembusan');
	$this->db->where('suratcuti',$id);
	return $this->db->get();
}
function get_by_last(){
	$select=array(
				$this->primary_key,
				'nama'
			);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->limit(1, 0);
	$this->db->order_by('id desc');
	return $this->db->get();
}
function get_by_id($id){
	$select=array(
				'suratcuti.id',
				'suratcuti.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'suratcuti.nomor',
				'suratcuti.macamcuti',
				'suratcuti.alamatcuti',
				'suratcuti.alasancuti',
				'suratcuti.lama',
				'suratcuti.tglkeluar',
				'suratcuti.atasan',
				'suratcuti.dikeluarkan',
				'suratcuti.nomerhp',
				'suratcuti.approve',
				'suratcuti.verif1',
				'suratcuti.verif2',
				'suratcuti.upload',
				'suratcuti.filename',
				'macamcuti.nama as namamacamcuti',
				'date(suratcuti.dari) as dari',
				'date(suratcuti.hingga) as hingga'
			);
	$this->db->select($select);
	$this->db->from($this->table_name);
	$this->db->join($this->table_karyawan, 'suratcuti.karyawan = karyawan.id', 'left');
	$this->db->join($this->table_macamcuti, 'suratcuti.macamcuti = macamcuti.id', 'left');
	$this->db->where('suratcuti.id',$id);
	return $this->db->get();
}
function get_by_tanggal($from,$to){
	$select=array(
				
				'suratcuti.id',
				'suratcuti.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'suratcuti.nomor',
				'suratcuti.macamcuti',
				'suratcuti.alamatcuti',
				'suratcuti.alasancuti',
				'suratcuti.lama',
				'suratcuti.tglkeluar',
				'suratcuti.atasan',
				'suratcuti.dikeluarkan',
				'suratcuti.nomerhp',
				'suratcuti.approve',
				'suratcuti.verif1',
				'suratcuti.verif2',
				'suratcuti.upload',
				'suratcuti.filename',
				'macamcuti.nama as namamacamcuti',
				'date(suratcuti.dari) as dari',
				'date(suratcuti.hingga) as hingga'
			);
	$this->db->select($select);
	$this->db->from($this->table_name);
	$this->db->join($this->table_karyawan, 'suratcuti.karyawan = karyawan.id', 'left');
	$this->db->join($this->table_macamcuti, 'suratcuti.macamcuti = macamcuti.id', 'left');
	$this->db->where('suratcuti.dari >=', $from);
	$this->db->where('suratcuti.dari <=', $to);
	return $this->db->get();
}
function get_by_tanggal_user($from,$to,$user){
	$select=array(
				
				'suratcuti.id',
				'suratcuti.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'suratcuti.nomor',
				'suratcuti.macamcuti',
				'suratcuti.alamatcuti',
				'suratcuti.alasancuti',
				'suratcuti.lama',
				'suratcuti.tglkeluar',
				'suratcuti.atasan',
				'suratcuti.dikeluarkan',
				'suratcuti.nomerhp',
				'suratcuti.approve',
				'suratcuti.verif1',
				'suratcuti.verif2',
				'suratcuti.upload',
				'suratcuti.filename',
				'macamcuti.nama as namamacamcuti',
				'date(suratcuti.dari) as dari',
				'date(suratcuti.hingga) as hingga'
			);
	$this->db->select($select);
	$this->db->from($this->table_name);
	$this->db->join($this->table_karyawan, 'suratcuti.karyawan = karyawan.id', 'left');
	$this->db->join($this->table_macamcuti, 'suratcuti.macamcuti = macamcuti.id', 'left');
	$this->db->where('karyawan.id', $user);
	$this->db->where('suratcuti.dari >=', $from);
	$this->db->where('suratcuti.dari <=', $to);
	return $this->db->get();
}
function get_kendaraan_by_cuti($id) {
	$this->db->from('suratcutikendaraan');
	$this->db->where('suratcuti',$id);
	return $this->db->get();
}
function get_by_kendaraan($id){
	$data=array();
	$select=array(
				'kendaraan'
			);
	$this->db->select($select);    
	$this->db->from('suratcutikendaraan');
	$this->db->where('suratcuti',$id);
	foreach($this->db->get()->result() as $input_type) {
    	$data[] = $input_type->kendaraan;
	}
	return $data;
}
function get_paged_list($limit=10,$offset=0,$order_column='',$order_type='asc',$where=''){
	$select=array(
				
				'suratcuti.id',
				'suratcuti.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'suratcuti.nomor',
				'suratcuti.macamcuti',
				'suratcuti.alamatcuti',
				'suratcuti.alasancuti',
				'suratcuti.lama',
				'suratcuti.tglkeluar',
				'suratcuti.atasan',
				'suratcuti.dikeluarkan',
				'suratcuti.nomerhp',
				'suratcuti.approve',
				'suratcuti.verif1',
				'suratcuti.verif2',
				'suratcuti.upload',
				'suratcuti.filename',
				'macamcuti.nama as namamacamcuti',
				'date(suratcuti.dari) as dari',
				'date(suratcuti.hingga) as hingga'
			);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->limit($limit,$offset);
	$this->db->join($this->table_karyawan, 'suratcuti.karyawan = karyawan.id', 'inner');
	$this->db->join($this->table_macamcuti, 'suratcuti.macamcuti = macamcuti.id', 'inner');
	if (empty($order_column)|| empty($order_type))
	$this->db->order_by($this->primary_key,'desc');
	else
	$this->db->order_by($order_column,$order_type);
	if(!empty($where)){
		$this->db->like('nomor',$where);
		$this->db->or_like('karyawan.nama',$where);
	}
	return $this->db->get();
	//return $this->db->get($this->table_name,$limit,$offset);
}
function get_paged_list_user($limit=10,$offset=0,$order_column='',$order_type='asc',$where='',$user=''){
	$select=array(
				
				'suratcuti.id',
				'suratcuti.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'suratcuti.nomor',
				'suratcuti.macamcuti',
				'suratcuti.alamatcuti',
				'suratcuti.alasancuti',
				'suratcuti.lama',
				'suratcuti.tglkeluar',
				'suratcuti.atasan',
				'suratcuti.dikeluarkan',
				'suratcuti.nomerhp',
				'suratcuti.approve',
				'suratcuti.verif1',
				'suratcuti.verif2',
				'suratcuti.upload',
				'suratcuti.filename',
				'macamcuti.nama as namamacamcuti',
				'date(suratcuti.dari) as dari',
				'date(suratcuti.hingga) as hingga'
			);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->limit($limit,$offset);
	$this->db->join($this->table_karyawan, 'suratcuti.karyawan = karyawan.id', 'inner');
	$this->db->join($this->table_macamcuti, 'suratcuti.macamcuti = macamcuti.id', 'inner');
	$this->db->where('karyawan.id',$user);
	if (empty($order_column)|| empty($order_type))
	$this->db->order_by($this->primary_key,'desc');
	else
	$this->db->order_by($order_column,$order_type);
	if(!empty($where)){
		$this->db->like('nomor',$where);
		$this->db->or_like('karyawan.nama',$where);
	}
	return $this->db->get();
	//return $this->db->get($this->table_name,$limit,$offset);
}
function get_by_detail_id($id){
	$select=array(
				'suratcuti.id',
				'suratcuti.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'suratcuti.nomor',
				'suratcuti.macamcuti',
				'suratcuti.alamatcuti',
				'suratcuti.alasancuti',
				'suratcuti.lama',
				'suratcuti.tglkeluar',
				'suratcuti.atasan',
				'suratcuti.dikeluarkan',
				'suratcuti.nomerhp',
				'suratcuti.approve',
				'suratcuti.verif1',
				'suratcuti.verif2',
				'suratcuti.upload',
				'suratcuti.filename',
				'macamcuti.nama as namamacamcuti',
				'date(suratcuti.dari) as dari',
				'date(suratcuti.hingga) as hingga'
			);
	$where=array(
				'suratcuti.id'=>$id
		);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->where($where);
	$this->db->join($this->table_karyawan, 'suratcuti.karyawan = karyawan.id', 'inner');
	$this->db->join($this->table_macamcuti, 'suratcuti.macamcuti = macamcuti.id', 'inner');
	$this->db->order_by('dari asc');
	return $this->db->get();
}
function get_by_total_cuti($year,$idcuti,$id){
	$select=array(
				'suratcuti.macamcuti',
				'suratcuti.lama',
				'sum(suratcuti.lama) as total',
			);
	$where=array(
				'suratcuti.karyawan'=>$id,
				'suratcuti.macamcuti'=>$idcuti,
				'suratcuti.approve'=>1,
				'year(suratcuti.dari)'=>$year
		);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->where($where);
	$this->db->join($this->table_karyawan, 'suratcuti.karyawan = karyawan.id', 'inner');
	$this->db->join($this->table_macamcuti, 'suratcuti.macamcuti = macamcuti.id', 'inner');
	$this->db->group_by('suratcuti.karyawan,suratcuti.macamcuti');
	$this->db->order_by('dari asc');
	return $this->db->get();
}

// Fungsi untuk melakukan proses upload file
  public function upload(){
    $config['upload_path'] = './assets/images/cuti/';
    $config['allowed_types'] = 'jpg|png|jpeg';
    $config['max_size']	= '2048';
    $config['remove_space'] = TRUE;
  
    $this->load->library('upload', $config); // Load konfigurasi uploadnya
	$this->upload->initialize($config);
    if($this->upload->do_upload("input_gambar")){ // Lakukan upload dan Cek jika proses upload berhasil
      // Jika berhasil :
      $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
      return $return;
    }else{
      // Jika gagal :
      $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
      return $return;
    }
  }
  
  // Fungsi untuk menyimpan data ke database
  public function gambarsave($upload,$id){
	  rename("./assets/images/cuti/".$upload['file']['file_name'],"./assets/images/cuti/".$id.".".strtolower(end(explode('.',$upload['file']['file_name']))));
    $data = array(
      'filename'=>$id.".".strtolower(end(explode('.',$upload['file']['file_name']))),
	  'upload'=>date('Y-m-d H:i:s')
    );
	
	$this->db->where($this->primary_key,$id);
    $this->db->update('suratcuti', $data);
  }
function add_tembusan($datas,$id) {
	$data = array();
	foreach($datas as $data2){
		$data[] = array('tembusan'=>$data2,'suratcuti'=>$id);
	}
	$this->db->insert_batch('suratcutitembusan',$data);
}
function add($data){
	$this->db->insert($this->table_name,$data);
	return $this->db->insert_id();
}
function macamcuti_add($data){
	$this->db->insert($this->table_macamcuti,$data);
	return $this->db->insert_id();
}
function update($id,$data) {
	$this->db->where($this->primary_key,$id);
	$this->db->update($this->table_name,$data);
}
function approve($id,$acc) {
	$data = array(
					'approve'=>$acc
					);
	$this->db->where($this->primary_key,$id);
	$this->db->update($this->table_name,$data);
}
function verif1($id,$acc) {
	$data = array(
					'verif1'=>$acc
					);
	$this->db->where($this->primary_key,$id);
	$this->db->update($this->table_name,$data);
}
function verif2($id,$acc) {
	$data = array(
					'verif2'=>$acc
					);
	$this->db->where($this->primary_key,$id);
	$this->db->update($this->table_name,$data);
}
function macamcuti_update($id,$data) {
	$this->db->where($this->primary_key,$id);
	$this->db->update($this->table_macamcuti,$data);
}

function delete($id) {
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
}
function macamcuti_delete($id) {
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_macamcuti);
}
function delete_tembusan_by_cuti($id) {
	$this->db->where('suratcuti',$id);
	$this->db->delete('suratcutitembusan');
}
}
