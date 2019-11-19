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
        margin: 15mm;  /* this affects the margin in the printer settings */
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
if(!empty($izin)){
	$pejabatcuti=$this->about_model->get_by_nama('pejabatcuti')->row()->value;
		
	foreach($izin as $value){
	
?>
<table width="100%" border="0">
  <tr>
    <td width="45%" rowspan="2">&nbsp;</td>
    <td width="10%" rowspan="2">&nbsp;</td>
    <td width="45%"><p align="right">Formulir A</p>
    </td>
  </tr>
  <tr>
    <td align="center">
    	<p>
        	Kepada<br />
          Yth. <?=$this->karyawan_model->get_by_id($pejabatcuti)->row()->jabatan; ?><br />
            di tempat<br />
        </p>
    </td>
  </tr>
</table>
<h3 align="center">FORMULIR PERMOHONAN IZIN</h3>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2">Yang bertandatangan di bawah ini :</td>
  </tr>
  <tr>
    <td width="15%">Nama</td>
    <td width="35%">: <?=(!empty($value->nama))?$value->nama.", ".$value->gelar:'';?></td>
  </tr>
  <tr>
    <td>NIP</td>
    <td>:
    <?=(!empty($value->nip))?$value->nip:'';?></td>
  </tr>
  <tr>
    <td>Jabatan</td>
    <td>: <?=(!empty($value->jabatan))?$value->jabatan:'';?></td>
  </tr>
  <tr>
    <td>Pangkat/Golongan</td>
    <td>:
    <?=(!empty($value->pangkat))?$value->pangkat:'';?></td>
  </tr>
  <tr>
    <td>Unit Kerja</td>
    <td>: <?=(!empty($value->unitkerja))?$value->unitkerja:'';?></td>
  </tr>
</table>
<br />
<br />
<br />
<br />
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4">Mohon izin 
    <?=(!empty($value->alasannama))?$value->alasannama:'';?></td>
  </tr>
  <tr>
    <td colspan="4">pukul 
      <?=(!empty($value->dari))?jamsaja($value->dari):'';?> 
      s/d 
      <?=(!empty($value->hingga))?jamsaja($value->hingga):'';?> 
      WIB hari
<?=(!empty($value->tanggal))?longdate_indo($value->tanggal):'';?> dengan alasan 
<?=(!empty($value->alasanizin))?$value->alasanizin:'';?></td>
  </tr>
  <tr>
    <td colspan="4">Atas perhatian Bapak / Ibu, kami ucapkan terima kasih.</td>
  </tr>
  <tr>
    <td width="45%"><p align="center">
        	Mengetahui/Menyetujui,<br />
            <?=$this->karyawan_model->get_by_id($value->atasan)->row()->jabatan;?><br />
            <br /><br /><br />
            <u>( <?=$this->karyawan_model->get_by_id($value->atasan)->row()->nama.", ".$this->karyawan_model->get_by_id($value->atasan)->row()->gelar; ?> )</u><br />
            NIP. <?=$this->karyawan_model->get_by_id($value->atasan)->row()->nip;?>
        </p></td>
    <td width="10%">&nbsp;</td>
    <td colspan="2" width="45%">
        <p align="center">
          <?=(!empty($value->tanggal))?longdate_indo($value->tanggal):'';?>
          <br />
        	Hormat saya,<br />
            <br /><br /><br />
            <u>( <?=(!empty($value->nama))?$value->nama.", ".$value->gelar:'';?> )</u><br />
            NIP. <?=(!empty($value->nip))?$value->nip:'';?>
        </p>
    </td>
  </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="45%"><img src="<?=site_url("cetak/qrcodeizin/".$value->id);?>" alt="" /></td>
    <td width="10%">&nbsp;</td>
    <td colspan="2" width="45%" align="center">
    <table width="50%" border="1" cellpadding="0" cellspacing="0">
    	<tr><td>
        <p align="center"> 
            <?=$this->karyawan_model->get_by_id($pejabatcuti)->row()->jabatan;?><br />
            <?=(!empty($value->tanggal))?longdate_indo($value->tanggal):'';?>
            <br />
            <br />
            <br /><br />
            <u>( <?=$this->karyawan_model->get_by_id($pejabatcuti)->row()->nama.", ".$this->karyawan_model->get_by_id($pejabatcuti)->row()->gelar; ?> )</u><br />
              NIP. <?=$this->karyawan_model->get_by_id($pejabatcuti)->row()->nip;?>
        </p>
        </td></tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>Tembusan:<br />Kasubag Administrasi Kepegawaian</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<br />
<br />
<br />
<?php
	}
}
?>
</body>

</html>