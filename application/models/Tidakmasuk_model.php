<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tidakmasuk_model extends CI_Model {
	private $primary_key='id';
	private $table_name='surattidakmasuk';
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
				'surattidakmasuk.id',
				'surattidakmasuk.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'karyawan.pangkat',
				'surattidakmasuk.nomor',
				'surattidakmasuk.alasantidakmasuk',
				'surattidakmasuk.tglkeluar',
				'surattidakmasuk.atasan',
				'surattidakmasuk.dikeluarkan',
				'surattidakmasuk.approve',
				'surattidakmasuk.verif1',
				'surattidakmasuk.verif2',
				'date(surattidakmasuk.tanggal) as tanggal'
			);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->where($where);
	$this->db->join($this->table_karyawan, 'surattidakmasuk.karyawan = karyawan.id', 'inner');
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
				'surattidakmasuk.id',
				'surattidakmasuk.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'karyawan.pangkat',
				'surattidakmasuk.nomor',
				'surattidakmasuk.alasantidakmasuk',
				'surattidakmasuk.tglkeluar',
				'surattidakmasuk.atasan',
				'surattidakmasuk.dikeluarkan',
				'surattidakmasuk.approve',
				'surattidakmasuk.verif1',
				'surattidakmasuk.verif2',
				'date(surattidakmasuk.tanggal) as tanggal'
			);
	$this->db->select($select);
	$this->db->from($this->table_name);
	$this->db->join($this->table_karyawan, 'surattidakmasuk.karyawan = karyawan.id', 'left');
	$this->db->where('surattidakmasuk.id',$id);
	return $this->db->get();
}
function get_by_tanggal($from,$to){
	$select=array(
				
				'surattidakmasuk.id',
				'surattidakmasuk.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'karyawan.pangkat',
				'surattidakmasuk.nomor',
				'surattidakmasuk.alasantidakmasuk',
				'surattidakmasuk.tglkeluar',
				'surattidakmasuk.atasan',
				'surattidakmasuk.dikeluarkan',
				'surattidakmasuk.approve',
				'surattidakmasuk.verif1',
				'surattidakmasuk.verif2',
				'date(surattidakmasuk.tanggal) as tanggal'
			);
	$this->db->select($select);
	$this->db->from($this->table_name);
	$this->db->join($this->table_karyawan, 'surattidakmasuk.karyawan = karyawan.id', 'left');
	
	$this->db->where('surattidakmasuk.tanggal >=', $from);
	$this->db->where('surattidakmasuk.tanggal <=', $to);
	return $this->db->get();
}


function get_paged_list($limit=10,$offset=0,$order_column='',$order_type='asc',$where=''){
	$select=array(
				
				'surattidakmasuk.id',
				'surattidakmasuk.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'karyawan.pangkat',
				'surattidakmasuk.nomor',
				'surattidakmasuk.alasantidakmasuk',
				'surattidakmasuk.tglkeluar',
				'surattidakmasuk.atasan',
				'surattidakmasuk.dikeluarkan',
				'surattidakmasuk.approve',
				'surattidakmasuk.verif1',
				'surattidakmasuk.verif2',
				'date(surattidakmasuk.tanggal) as tanggal'
			);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->limit($limit,$offset);
	$this->db->join($this->table_karyawan, 'surattidakmasuk.karyawan = karyawan.id', 'inner');
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
				'surattidakmasuk.id',
				'surattidakmasuk.karyawan',
				'karyawan.nama',
				'karyawan.nip',
				'karyawan.jabatan',
				'karyawan.unitkerja',
				'karyawan.awalkerja',
				'karyawan.gelar',
				'karyawan.pangkat',
				'surattidakmasuk.nomor',
				'surattidakmasuk.alasantidakmasuk',
				'surattidakmasuk.tglkeluar',
				'surattidakmasuk.atasan',
				'surattidakmasuk.dikeluarkan',
				'surattidakmasuk.approve',
				'surattidakmasuk.verif1',
				'surattidakmasuk.verif2',
				'date(surattidakmasuk.tanggal) as tanggal'
			);
	$where=array(
				'surattidakmasuk.id'=>$id
		);
	$this->db->select($select);    
	$this->db->from($this->table_name);
	$this->db->where($where);
	$this->db->join($this->table_karyawan, 'surattidakmasuk.karyawan = karyawan.id', 'inner');
	
	$this->db->order_by('dari asc');
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
function verif2($id,$acc) {
	$data = array(
					'verif2'=>$acc
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
function delete($id) {
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
}

}
