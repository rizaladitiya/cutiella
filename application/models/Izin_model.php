<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Izin_model extends CI_Model {
	private $primary_key='id';
	private $table_name='suratizin';
	private $table_karyawan='karyawan';
function __construct()
	{
		parent::__construct();
	}

function count_all() {
	return $this->db->count_all($this->table_name);
}
function get_by_all(){
	$select=array(
				'suratizin.id',
				'suratizin.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'karyawan.pangkat',
				'suratizin.nomor',
				'suratizin.alasan',
				'alasan_izin.nama as alasannama',
				'suratizin.alasanizin',
				'suratizin.tglkeluar',
				'suratizin.dari',
				'suratizin.hingga',
				'suratizin.atasan',
				'suratizin.dikeluarkan',
				'suratizin.approve',
				'suratizin.verif1',
				'suratizin.verif2',
				'suratizin.upload',
				'suratizin.filename',
				'date(suratizin.tanggal) as tanggal'
			);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->where($where);
	$this->db->join($this->table_karyawan, 'suratizin.karyawan = karyawan.id', 'inner');
	$this->db->join('alasan_izin', 'suratizin.alasan = alasan_izin.id', 'left');
	$this->db->order_by('tanggal asc');
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
				'suratizin.id',
				'suratizin.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'karyawan.pangkat',
				'suratizin.nomor',
				'suratizin.alasan',
				'alasan_izin.nama as alasannama',
				'suratizin.alasanizin',
				'suratizin.tglkeluar',
				'suratizin.dari',
				'suratizin.hingga',
				'suratizin.atasan',
				'suratizin.dikeluarkan',
				'suratizin.approve',
				'suratizin.verif1',
				'suratizin.verif2',
				'suratizin.upload',
				'suratizin.filename',
				'date(suratizin.tanggal) as tanggal'
			);
	$this->db->select($select);
	$this->db->from($this->table_name);
	$this->db->join($this->table_karyawan, 'suratizin.karyawan = karyawan.id', 'left');
	$this->db->join('alasan_izin', 'suratizin.alasan = alasan_izin.id', 'left');
	$this->db->where('suratizin.id',$id);
	return $this->db->get();
}
function get_by_tanggal($from,$to){
	$select=array(
				
				'suratizin.id',
				'suratizin.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'karyawan.pangkat',
				'suratizin.nomor',
				'suratizin.alasan',
				'alasan_izin.nama as alasannama',
				'suratizin.alasanizin',
				'suratizin.tglkeluar',
				'suratizin.dari',
				'suratizin.hingga',
				'suratizin.atasan',
				'suratizin.dikeluarkan',
				'suratizin.approve',
				'suratizin.verif1',
				'suratizin.verif2',
				'suratizin.upload',
				'suratizin.filename',
				'date(suratizin.tanggal) as tanggal'
			);
	$this->db->select($select);
	$this->db->from($this->table_name);
	$this->db->join($this->table_karyawan, 'suratizin.karyawan = karyawan.id', 'left');
	$this->db->join('alasan_izin', 'suratizin.alasan = alasan_izin.id', 'left');
	
	$this->db->where('suratizin.tanggal >=', $from);
	$this->db->where('suratizin.tanggal <=', $to);
	return $this->db->get();
}
function get_by_tanggal_user($from,$to,$user){
	$select=array(
				
				'suratizin.id',
				'suratizin.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'karyawan.pangkat',
				'suratizin.nomor',
				'suratizin.alasan',
				'alasan_izin.nama as alasannama',
				'suratizin.alasanizin',
				'suratizin.tglkeluar',
				'suratizin.dari',
				'suratizin.hingga',
				'suratizin.atasan',
				'suratizin.dikeluarkan',
				'suratizin.approve',
				'suratizin.verif1',
				'suratizin.verif2',
				'suratizin.upload',
				'suratizin.filename',
				'date(suratizin.tanggal) as tanggal'
			);
	$this->db->select($select);
	$this->db->from($this->table_name);
	$this->db->join($this->table_karyawan, 'suratizin.karyawan = karyawan.id', 'left');
	$this->db->join('alasan_izin', 'suratizin.alasan = alasan_izin.id', 'left');
	$this->db->where('karyawan.id', $user);
	$this->db->where('suratizin.tanggal >=', $from);
	$this->db->where('suratizin.tanggal <=', $to);
	return $this->db->get();
}

function get_paged_list($limit=10,$offset=0,$order_column='',$order_type='asc',$where=''){
	$select=array(
				
				'suratizin.id',
				'suratizin.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'karyawan.pangkat',
				'suratizin.nomor',
				'suratizin.alasan',
				'alasan_izin.nama as alasannama',
				'suratizin.alasanizin',
				'suratizin.tglkeluar',
				'suratizin.dari',
				'suratizin.hingga',
				'suratizin.atasan',
				'suratizin.dikeluarkan',
				'suratizin.approve',
				'suratizin.verif1',
				'suratizin.verif2',
				'suratizin.upload',
				'suratizin.filename',
				'date(suratizin.tanggal) as tanggal'
			);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->limit($limit,$offset);
	$this->db->join($this->table_karyawan, 'suratizin.karyawan = karyawan.id', 'inner');
	$this->db->join('alasan_izin', 'suratizin.alasan = alasan_izin.id', 'left');
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
				
				'suratizin.id',
				'suratizin.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'karyawan.pangkat',
				'suratizin.nomor',
				'suratizin.alasan',
				'alasan_izin.nama as alasannama',
				'suratizin.alasanizin',
				'suratizin.tglkeluar',
				'suratizin.dari',
				'suratizin.hingga',
				'suratizin.atasan',
				'suratizin.dikeluarkan',
				'suratizin.approve',
				'suratizin.verif1',
				'suratizin.verif2',
				'suratizin.upload',
				'suratizin.filename',
				'date(suratizin.tanggal) as tanggal'
			);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->limit($limit,$offset);
	$this->db->join($this->table_karyawan, 'suratizin.karyawan = karyawan.id', 'inner');
	$this->db->join('alasan_izin', 'suratizin.alasan = alasan_izin.id', 'left');
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
				'suratizin.id',
				'suratizin.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'karyawan.pangkat',
				'suratizin.nomor',
				'suratizin.alasan',
				'alasan_izin.nama as alasannama',
				'suratizin.alasanizin',
				'suratizin.tglkeluar',
				'suratizin.dari',
				'suratizin.hingga',
				'suratizin.atasan',
				'suratizin.dikeluarkan',
				'suratizin.approve',
				'suratizin.verif1',
				'suratizin.verif2',
				'suratizin.upload',
				'suratizin.filename',
				'date(suratizin.tanggal) as tanggal'
			);
	$where=array(
				'suratizin.id'=>$id
		);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->where($where);
	$this->db->join($this->table_karyawan, 'suratizin.karyawan = karyawan.id', 'inner');
	$this->db->join('alasan_izin', 'suratizin.alasan = alasan_izin.id', 'left');
	
	$this->db->order_by('dari asc');
	return $this->db->get();
}
// Fungsi untuk melakukan proses upload file
  public function upload(){
    $config['upload_path'] = './assets/images/izin/';
    $config['allowed_types'] = 'jpg|png|jpeg|pdf';
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
	  rename("./assets/images/izin/".$upload['file']['file_name'],"./assets/images/izin/".$id.".".strtolower(end(explode('.',$upload['file']['file_name']))));
    $data = array(
      'filename'=>$id.".".strtolower(end(explode('.',$upload['file']['file_name']))),
	  'upload'=>date('Y-m-d H:i:s')
    );
	
	$this->db->where($this->primary_key,$id);
    $this->db->update('suratizin', $data);
  }
function get_alasan_izin(){
	$select=array(
				$this->primary_key,
				'nama'
			);
	$this->db->select($select);    
	$this->db->from('alasan_izin');
	$this->db->order_by('nama desc');
	return $this->db->get();
	}
function add($data){
	$this->db->insert($this->table_name,$data);
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
function delete($id) {
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
}

}
