<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function index()
	{
		$this->load->library('pdf_gen');
		/*
		$this->fpdf->SetFont('Arial','B',16);
		$this->fpdf->Cell(50,10,'Hello World!');
		$this->fpdf->MultiCell(0,4," TOKO ONLINE ELEKTRONIK",0,'J',false);
		$this->fpdf->MultiCell(25,6,"TOKO ONLINE ELEKTRONIK", 'LRT', 'L', 0);
		
		//$this->fpdf->image('assets/logo.jpg',12,14,25,25);
		//echo $this->fpdf->Output('hello_world.pdf','D');	
		$this->fpdf->Output();	
		*/
		
		//$this->fpdf->AddPage();
		/*
        // setting jenis font yang akan digunakan
        $this->fpdf->SetFont('Arial','B',16);
        // mencetak string 
        $this->fpdf->Cell(190,7,'SEKOLAH MENENGAH KEJURUSAN NEEGRI 2 LANGSA',0,1,'C');
        $this->fpdf->SetFont('Arial','B',12);
        $this->fpdf->Cell(190,7,'DAFTAR SISWA KELAS IX JURUSAN REKAYASA PERANGKAT LUNAK',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $this->fpdf->Cell(10,7,'',0,1);
        $this->fpdf->SetFont('Arial','B',10);
        $this->fpdf->Cell(20,6,'NIM',1,0);
        $this->fpdf->Cell(85,6,'NAMA MAHASISWA',1,0);
        $this->fpdf->Cell(27,6,'NO HP',1,0);
        $this->fpdf->Cell(25,6,'TANGGAL LHR',1,1);
        $this->fpdf->SetFont('Arial','',10);
        $mahasiswa = $this->db->get('karyawan')->result();
        foreach ($mahasiswa as $row){
            $this->fpdf->Cell(20,6,$row->nrp,1,0);
            $this->fpdf->Cell(85,6,$row->nama,1,0);
            $this->fpdf->Cell(27,6,$row->pangkat,1,0);
            $this->fpdf->Cell(25,6,$row->jabatan,1,1); 
        }
        $this->fpdf->Output();
		*/
		
		$this->fpdf->image('assets/logo.jpg',12,14,20,20);
		$this->fpdf->Ln(2);
   $this->fpdf->SetFont('Arial','B',10);
   $this->fpdf->MultiCell(0,4," TOKO ONLINE ELEKTRONIK",0,'C',false);
   $this->fpdf->SetFont('Arial','B',12);
   $this->fpdf->MultiCell(0,6," SUPERSTARS",0,'C',false);
   $this->fpdf->SetFont('Arial','',8);
   $this->fpdf->MultiCell(0,4," Jalan Pegangsaan No.21 Blok A4, Telp. 021-47626448, 2849622, 9337272, 8425273
   n Fax. 021-202   8986 Email : ssrvices@superstars.comn Jakarta Barat",0,'C',false);
   $this->fpdf->Ln(5);
   $this->fpdf->SetFont('Arial','B',10);
   $this->fpdf->MultiCell(0,4,"===========================================================================================",0,'C',false);
   $this->fpdf->Cell(0,10,'tes',2,1,'C');
   $this->fpdf->Output();
   
	}
	public function cuti()
	{
		   $this->load->library('pdf_gen');
		   $this->fpdf->image('assets/logo.jpg',12,9,25,25);
		   $this->fpdf->Ln(2);
		   $this->fpdf->SetFont('Arial','B',12);
		   $this->fpdf->MultiCell(0,4," PENGADILAN MILITER III-12 SURABAYA",0,'C',false);
		   $this->fpdf->SetFont('Arial','B',10);
		   $this->fpdf->MultiCell(0,6," Jl. Ir. H. Juanda Sidoarjo 61253",0,'C',false);
		   $this->fpdf->SetFont('Arial','B',8);
		   $this->fpdf->MultiCell(0,4," Telp. / Fax : 031-8665369
		   EMAIL : surabaya@dilmil.org",0,'C',false);
		   $this->fpdf->Ln(3);
		   $this->fpdf->Line(10, 35, 210-10, 35);
		   $this->fpdf->Ln(10);
		   $this->fpdf->SetFont('Arial','',12);
		   $this->fpdf->MultiCell(0,4,"SURAT CUTI
		   Nomor : ",0,'C',false);
		   $this->fpdf->Ln(10);
		   $this->fpdf->Cell(20,6,'Diberikan Kepada  : ',2,1);
		   $this->fpdf->Ln(5);
		   $this->fpdf->Cell(60,6,'          Nama',0,0);
		   $this->fpdf->Cell(30,6,':',2,1);
		   $this->fpdf->Cell(60,6,'          Pangkat / NRP',0,0);
		   $this->fpdf->Cell(30,6,':',2,1);
		   $this->fpdf->Cell(60,6,'          Jabatan',0,0);
		   $this->fpdf->Cell(30,6,':',2,1);
		   $this->fpdf->Cell(60,6,'          Kesatuan',0,0);
		   $this->fpdf->Cell(30,6,':',2,1);
		   $this->fpdf->Cell(60,6,'          Macam Cuti',0,0);
		   $this->fpdf->Cell(30,6,':',2,1);
		   $this->fpdf->Cell(60,6,'          Lama',0,0);
		   $this->fpdf->Cell(30,6,':',2,1);
		   $this->fpdf->Cell(60,6,'          Mulai tanggal',0,0);
		   $this->fpdf->Cell(30,6,':',2,1);
		   $this->fpdf->Cell(60,6,'          Sampai tanggal',0,0);
		   $this->fpdf->Cell(30,6,':',2,1);
		   $this->fpdf->Cell(60,6,'          Tujuan',0,0);
		   $this->fpdf->Cell(30,6,':',2,1);
		   $this->fpdf->Cell(60,6,'          Berkendaraan',0,0);
		   $this->fpdf->Cell(30,6,':',2,1);
		   $this->fpdf->Ln(10);
		   $this->fpdf->Cell(20,6,'Mohon kepada Instansi yang berwenang memberikan bantuan seperlunya.',2,1);
		   $this->fpdf->Ln(30);
		   $this->fpdf->Cell(100);
		   $this->fpdf->Cell(0,5,'Dikeluarkan di Sidoarjo',2,1,'L');
		   $this->fpdf->Cell(100);
		   $this->fpdf->Cell(0,5,'Pada Tanggal',2,1,'L');
		   $this->fpdf->Line(110, 188, 210-23, 188);
		   $this->fpdf->Cell(100);
		   $this->fpdf->Cell(0,5,'Kepala Pengadilan Militer III-12 Surabaya',2,1,'L');
		   $this->fpdf->Ln(30);
		   $this->fpdf->Cell(100);
		   $this->fpdf->Cell(80,6,'Asep Ridwan Hasyim, S.H.,M.Si.,M.H.',2,1,'C');
		   $this->fpdf->Cell(30,6,'Tembusan',0,0);
		   $this->fpdf->Cell(40,6,':',0,0);
		   $this->fpdf->Cell(30);
		   $this->fpdf->Cell(80,6,'Kolonel Laut (KH) NRP 12360/P',2,1,'C');
		   $this->fpdf->Output();
   
	}
}
