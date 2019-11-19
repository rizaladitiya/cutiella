<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Form Cuti</title>
<style type="text/css">
table {
  border-collapse: collapse;
}
th, td {
  padding: 2px;
}
 @page 
    {
        size: 210mm 330mm;
        margin: 2mm;  /* this affects the margin in the printer settings */
    }
td img{
    display: block;
    margin-left: auto;
    margin-right: auto;

}
</style>
</head>


<body>
<?php
if(!empty($cuti)){
	$pejabatcuti=$this->about_model->get_by_nama('pejabatcuti')->row()->value;
		
	foreach($cuti as $value){
	
?>
<table width="100%" border="0">
  <tr>
    <td width="50%">&nbsp;</td>
    <td width="50%"><p align="center">- 24 -</p>
        <p>
        	ANAK LAMPIRAN 1.b<br />
        	PERATURAN BADAN KEPEGAWAIAN NEGARA
            REPUBLIK INDONESIA
            NOMOR 24 TAHUN 2017
            TENTANG
            TATA CARA PEMBERIAN CUTI PEGAWAI NEGERI SIPIL
        </p>
    </td>
  </tr>
  <tr>
  	<td></td>
    <td align="right"><?=(!empty($value->tglkeluar))?longdate_indo($value->tglkeluar):'';?></td>
  </tr>
  <tr>
  	<td></td>
    <td align="center">
    	<p>
        	Kepada<br />
          Yth. <?=$this->karyawan_model->get_by_id($pejabatcuti)->row()->jabatan; ?><br />
            di tempat<br />
        </p>
    </td>
  </tr>
</table>
<h3 align="center">FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</h3>
<table width="100%" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4">I. DATA PEGAWAI</td>
  </tr>
  <tr>
    <td width="15%">Nama</td>
    <td width="35%"><?=(!empty($value->nama))?$value->nama.", ".$value->gelar:'';?></td>
    <td width="15%">NIP</td>
    <td width="35%"><?=(!empty($value->nama))?$value->nip:'';?></td>
  </tr>
  <tr>
    <td>Jabatan</td>
    <td><?=(!empty($value->jabatan))?$value->jabatan:'';?></td>
    <td>Masa Kerja</td>
    <td><?=(!empty($value->awalkerja))?masakerja($value->awalkerja):'';?></td>
  </tr>
  <tr>
    <td>Unit Kerja</td>
    <td><?=(!empty($value->unitkerja))?$value->unitkerja:'';?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="100%" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4">II. JENIS CUTI YANG DIAMBIL**</td>
  </tr>
  
  <tr>
    <td width="35%">1. Cuti Tahunan</td>
    <td width="15%" align="center">
		<?php 
			if($value->macamcuti==1){
				echo givecheck(1);
				}
		?>
    </td>
    <td width="35%">2.Cuti Besar</td>
    <td width="15%" align="center"><?php 
			if($value->macamcuti==4){
				echo givecheck(1);
				}
		?></td>
  </tr>
  <tr>
    <td>3. Cuti Sakit</td>
    <td align="center"><?php 
			if($value->macamcuti==2){
				echo givecheck(1);
				}
		?></td>
    <td>4. Cuti Melahirkan</td>
    <td align="center"><?php 
			if($value->macamcuti==5){
				echo givecheck(1);
				}
		?></td>
  </tr>
  <tr>
    <td>5. Cuti Karena Alasan Penting</td>
    <td align="center"><?php 
			if($value->macamcuti==3){
				echo givecheck(1);
				}
		?></td>
    <td>6. Cuti di Luar Tanggungan Negara</td>
    <td align="center"><?php 
			if($value->macamcuti==6){
				echo givecheck(1);
				}
		?></td>
  </tr>
  
</table>
<br />
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td>III. ALASAN CUTI</td>
  </tr>
  <tr>
    <td><?=(!empty($value->alasancuti))?$value->alasancuti:'';?></td>
  </tr>
</table>
<br />
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="6">IV. LAMANYA CUTI</td>
  </tr>
  <tr>
    <td width="15%">Selama</td>
    <td width="25%" align="center"><?=(!empty($value->lama))?$value->lama:'';?></td>
    <td width="15%" align="center">mulai tanggal</td>
    <td width="20%" align="center"><?=(!empty($value->dari))?date_indo($value->dari):'';?></td>
    <td width="5%" align="center">s/d</td>
    <td width="20%" align="center"><?=(!empty($value->hingga))?date_indo($value->hingga):'';?></td>
  </tr>
</table>
<br />
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="5">V. CATATAN CUTI</td>
  </tr>
  <tr>
    <td colspan="3">1. CUTI TAHUNAN</td>
    <td>2. CUTI BESAR</td>
    <td align="center"><?php
	if($value->macamcuti==4){
	if($this->cuti_model->get_by_total_cuti(date('Y'),4,$value->id)->num_rows()>=1){
    $ambil=round($this->cuti_model->get_by_total_cuti(date('Y'),4,$value->id)->row()->total); 
		
		
	}else{
		$ambil=0;
		}
	$jatah = round($this->cuti_model->get_macamcuti_by_id(4)->row()->lama);
		echo $jatah-$ambil;
	}
	?></td>
  </tr>
  <tr>
    <td width="13%">Tahun</td>
    <td align="center" width="8%">Sisa</td>
    <td width="16%">Keterangan</td>
    <td width="45%">3. CUTI SAKIT</td>
    <td width="18%" align="center">
	<?php
	if($value->macamcuti==2){
	if($this->cuti_model->get_by_total_cuti(date('Y'),2,$value->id)->num_rows()>=1){
    $ambil=round($this->cuti_model->get_by_total_cuti(date('Y'),2,$value->id)->row()->total); 
		
		
	}else{
		$ambil=0;
		}
	$jatah = round($this->cuti_model->get_macamcuti_by_id(2)->row()->lama);
		echo $jatah-$ambil;
	}
	?></td>
  </tr>
  <tr>
    <td>N-2</td>
    <td align="center"><?php
	if($value->macamcuti==1){
    if($this->cuti_model->get_by_total_cuti(date('Y', strtotime('-2 year')),1,$value->id)->num_rows()>=1){
    $ambil=round($this->cuti_model->get_by_total_cuti(date('Y'),1,$value->id)->row()->total); }else{
		$ambil=0;
		}
		if(idate('Y')<=2021){
			$jatah=0;
		}else{
		$jatah = round($this->cuti_model->get_sisacuti_by_id($value->karyawan,date('Y', strtotime('-2 year')))->row()->lama);
		}
		$totalsisa = $jatah-$ambil;
		echo ($totalsisa==0)?'':$totalsisa;
		//echo $jatah-$ambil;
	}
	
	?></td>
    <td>&nbsp;</td>
    <td>4. CUTI MELAHIRKAN</td>
    <td align="center"><?php
	if($value->macamcuti==5){
	if($this->cuti_model->get_by_total_cuti(date('Y'),5,$value->id)->num_rows()>=1){
    $ambil=round($this->cuti_model->get_by_total_cuti(date('Y'),5,$value->id)->row()->total); 
		
		
	}else{
		$ambil=0;
		}
	$jatah = round($this->cuti_model->get_macamcuti_by_id(5)->row()->lama);
		echo $jatah-$ambil;
	}
	?></td>
  </tr>
  <tr>
    <td>N-1</td>
    <td align="center"><?php
	if($value->macamcuti==1){
	if($this->cuti_model->get_by_total_cuti(date('Y', strtotime('-1 year')),1,$value->id)->num_rows()>=1){
    $ambil=round($this->cuti_model->get_by_total_cuti(date('Y'),1,$value->id)->row()->total); 
	}else{
		$ambil=0;
		}
		if(idate('Y')==2019){
			$jatah=0;
		}else{
		$jatah = round($this->cuti_model->get_sisacuti_by_id($value->karyawan,date('Y', strtotime('-1 year')))->row()->lama);
		}
		$totalsisa = $jatah-$ambil;
		echo ($totalsisa==0)?'':$totalsisa;
		
	}
	?></td>
    <td>&nbsp;</td>
    <td>5. CUTI KARENA ALASAN PENTING</td>
    <td align="center"><?php
	if($value->macamcuti==3){
	if($this->cuti_model->get_by_total_cuti(date('Y'),3,$value->id)->num_rows()>=1){
    $ambil=round($this->cuti_model->get_by_total_cuti(date('Y'),3,$value->id)->row()->total); 
		
		
	}else{
		$ambil=0;
		}
	$jatah = round($this->cuti_model->get_macamcuti_by_id(3)->row()->lama);
		echo $jatah-$ambil;
	}
	?></td>
  </tr>
  <tr>
    <td>N</td>
    <td align="center"><?php
	if($value->macamcuti==1){
	if($this->cuti_model->get_by_total_cuti(date('Y'),1,$value->id)->num_rows()>=1){
    $ambil=round($this->cuti_model->get_by_total_cuti(date('Y'),1,$value->id)->row()->total); 
		
		
	}else{
		$ambil=0;
		}
	$jatah = round($this->cuti_model->get_sisacuti_by_id($value->karyawan,date('Y'))->row()->lama);
		$totalsisa = $jatah-$ambil;
		echo ($totalsisa==0)?'':$totalsisa;
	}
	?></td>
    <td>&nbsp;</td>
    <td>6. CUTI DILUAR TANGGUNGAN NEGARA</td>
    <td align="center"><?php
	if($value->macamcuti==6){
	if($this->cuti_model->get_by_total_cuti(date('Y'),6,$value->id)->num_rows()>=1){
    $ambil=round($this->cuti_model->get_by_total_cuti(date('Y'),6,$value->id)->row()->total); 
		
		
	}else{
		$ambil=0;
		}
	$jatah = round($this->cuti_model->get_macamcuti_by_id(6)->row()->lama);
		echo $jatah-$ambil;
	}
	?></td>
  </tr>
</table>
<br />
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3">VI. ALAMAT SELAMA MENJALANKAN CUTI</td>
  </tr>
  <tr>
    <td width="60%">&nbsp;</td>
    <td width="15%">TELP</td>
    <td width="25%"><?=(!empty($value->nomerhp))?$value->nomerhp:'';?></td>
  </tr>
  <tr>
    <td><?=(!empty($value->alamatcuti))?$value->alamatcuti:'';?></td>
    <td colspan="2">
        <p align="center">
        	Hormat saya,<br />
            <br /><br />
            ( <?=(!empty($value->nama))?$value->nama.", ".$value->gelar:'';?> )<br />
            NIP. <?=(!empty($value->nip))?$value->nip:'';?>
        </p>
    </td>
  </tr>
</table>
<br />
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr border="1">
    <td colspan="4" border="1">VII. PERTIMBANGAN ATASAN LANGSUNG**</td>
  </tr>
  <tr>
    <td width="25%">DISETUJUI</td>
    <td width="25%">PERUBAHAN****</td>
    <td width="25%">DITANGGUHKAN****</td>
    <td width="25%">TIDAK DISETUJUI****</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">
<table width="100%" border="1" cellspacing="0" cellpadding="0">
        	<tr>
            	<td align="center"><?=$this->karyawan_model->get_by_id($value->atasan)->row()->nama.", ".$this->karyawan_model->get_by_id($value->atasan)->row()->gelar; ?>
                <br /><br />
                <br />NIP. <?=$this->karyawan_model->get_by_id($value->atasan)->row()->nip;?>
                </td>
            </tr>
        </table>
    </td>
  </tr>
</table>
<br />

<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr border="1">
    <td colspan="4" border="1">VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI**</td>
  </tr>
  <tr>
    <td width="25%">DISETUJUI</td>
    <td width="25%">PERUBAHAN****</td>
    <td width="25%">DITANGGUHKAN****</td>
    <td width="25%">TIDAK DISETUJUI****</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">
<table width="100%" border="1" cellspacing="0" cellpadding="0">
        	<tr>
            	<td align="center">
				<?=$this->karyawan_model->get_by_id($pejabatcuti)->row()->nama.", ".$this->karyawan_model->get_by_id($pejabatcuti)->row()->gelar; ?>
                <br /><br /><br />NIP. <?=$this->karyawan_model->get_by_id($pejabatcuti)->row()->nip;?>
                
                </td>
            </tr>
      </table>
    </td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3">Catatan:</td>
  </tr>
  <tr>
    <td width="8%">*</td>
    <td width="72%">Coret yang tidak perlu</td>
    <td width="20%" rowspan="7"><img src="<?=site_url("cetak/qrcode/".$value->id);?>" alt="" /></td>
  </tr>
  <tr>
    <td>**</td>
    <td>Pilih salah satu dengan memberi tanda centang (&#10004;)</td>
  </tr>
  <tr>
    <td>***</td>
    <td>diisi oleh pejabat yang menangani bidang kepegawaian sebelum PNS mengajukan cuti</td>
  </tr>
  <tr>
    <td>****</td>
    <td>diberi tanda centang dan alasannya</td>
  </tr>
  <tr>
    <td>N</td>
    <td>= Cuti tahun berjalan</td>
  </tr>
  <tr>
    <td>N-1</td>
    <td>= Sisa cuti 1 tahun sebelumnya</td>
  </tr>
  <tr>
    <td>N-2</td>
    <td>= Sisa cuti 2 tahun sebelumnya</td>
  </tr>
</table>



<?php
	}
}
?>
</body>

</html>