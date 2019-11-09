<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if(!function_exists('baca_konfig'))
{
	function baca_konfig($nama)
	{
		$CI=& get_instance();
		$CI->load->library('m_db');
		$item=$CI->m_db->get_row('config',array(),$nama);
		return $item;
	}
}
if(!function_exists('referrer'))
{
	function referrer()
	{
		$CI=& get_instance();
		$CI->load->library('user_agent');
		if ($CI->agent->is_referral())
		{
    		return $CI->agent->referrer();
		}
	}
}
if(!function_exists('getsession'))
{
	function getsession() {
		// Get current CodeIgniter instance
		$CI =& get_instance();
		// We need to use $CI->session instead of $this->session
		$data=(object)array(
				'id'=>$CI->session->userdata('logged_in')['id'],
				'nama'=>$CI->session->userdata('logged_in')['nama'],
				'user'=>$CI->session->userdata('logged_in')['user'],
				'akses'=>$CI->session->userdata('logged_in')['akses'],
				'email'=>$CI->session->userdata('logged_in')['email']
					);
		return $data;
	}
}
if(!function_exists('kontroler'))
{
	function kontroler($nama)
	{
		$CI=& get_instance();
		$item = $CI->uri->segment(1);
		if (strtolower($item)==strtolower($nama)){
				return " active";
			}
	}
	
}
if(!function_exists('sekarang'))
{
	function sekarang()
	{
		return date('Y-m-d');
	}
}
if(!function_exists('now'))
{
	function now()
	{
		return date("Y-m-d H:i:s");
	}
}
if(!function_exists('tglshort'))
{
	function tglshort($tgl)
	{
		return date('d-M-y',strtotime($tgl));
	}
}
if(!function_exists('showmenu'))
{
	function showmenu($kelompok,$array)
	{
		if (in_array($kelompok, $array)) {
    		return "''";
		}else {
			return "style='display:none'";
			}
	}
}
if(!function_exists('tglsaja'))
{
	function tglsaja($tgl)
	{
		return date('Y-m-d',strtotime($tgl));
	}
}

if(!function_exists('jamsaja'))
{
	function jamsaja($tgl)
	{
		return date('H:i',strtotime($tgl));
	}
}

if(!function_exists('httpPost'))
{
	function httpPost($url, $data)
	{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
	}
}
if(!function_exists('gabungnama'))
{
	function gabungnama($data,$array)
	{
		//$newdata=explode(",",$data);
		$find=array();
		$hasil=array();
		foreach($data as $k){
			$find=cariarray($array,$k);
				foreach($find as $fin){
					array_push($hasil,$fin);
				}
		}
		$string = arrtostr($hasil);
		return $string;
	}
}
if(!function_exists('arraynama'))
{
	function arraynama($data,$array)
	{
		//$newdata=explode(",",$data);
		$find=array();
		$hasil=array();
		foreach($data as $k){
			$find=cariarray($array,$k);
				foreach($find as $fin){
					array_push($hasil,$fin);
				}
		}
		return $hasil;
	}
}
if(!function_exists('arrtostr'))
{
	function arrtostr($array)
	{
		$string = implode(",",$array);
		return $string;
	}
}
if(!function_exists('arrtolist'))
{
	function arrtolist($array)
	{
		$data ='<ol>';
		foreach($array as $value){
				$data .= '<li>'.$value.'</li>';
		}
		$data .= '</ol>';
		$hasil = $data;
		return $hasil;
	}
}
if(!function_exists('arrtolisttgl'))
{
	function arrtolisttgl($array)
	{
		$data ='<ol>';
		foreach($array as $value){
				$data .= '<li>'.date_indo(tglsaja($value)).'</li>';
		}
		$data .= '</ol>';
		$hasil = $data;
		return $hasil;
	}
}
if(!function_exists('cariarray'))
{
	function cariarray($data,$findme)
	{
		$newdata=array();
		foreach ($data as $k=>$v){
			if($v->id==$findme){
					//$newdata=$newdata+array('id'=>$v->id,'nama'=>$v->nama);
					array_push($newdata,$v->nama);
 			}
 		}
		return $newdata;
	}
}      
if ( ! function_exists('date_indo'))
    {
        function date_indo($tgl)
        {
            $ubah = gmdate($tgl, time()+60*60*8);
            $pecah = explode("-",$ubah);
            $tanggal = $pecah[2];
            $bulan = bulan($pecah[1]);
            $tahun = $pecah[0];
            return $tanggal.' '.$bulan.' '.$tahun;
        }
    }
      
    if ( ! function_exists('bulan'))
    {
        function bulan($bln)
        {
            switch ($bln)
            {
                case 1:
                    return "Januari";
                    break;
                case 2:
                    return "Februari";
                    break;
                case 3:
                    return "Maret";
                    break;
                case 4:
                    return "April";
                    break;
                case 5:
                    return "Mei";
                    break;
                case 6:
                    return "Juni";
                    break;
                case 7:
                    return "Juli";
                    break;
                case 8:
                    return "Agustus";
                    break;
                case 9:
                    return "September";
                    break;
                case 10:
                    return "Oktober";
                    break;
                case 11:
                    return "November";
                    break;
                case 12:
                    return "Desember";
                    break;
            }
        }
    }
 
    //Format Shortdate
    if ( ! function_exists('shortdate_indo'))
    {
        function shortdate_indo($tgl)
        {
            $ubah = gmdate($tgl, time()+60*60*8);
            $pecah = explode("-",$ubah);
            $tanggal = $pecah[2];
            $bulan = short_bulan($pecah[1]);
            $tahun = $pecah[0];
            return $tanggal.'/'.$bulan.'/'.$tahun;
        }
    }
      
    if ( ! function_exists('short_bulan'))
    {
        function short_bulan($bln)
        {
            switch ($bln)
            {
                case 1:
                    return "01";
                    break;
                case 2:
                    return "02";
                    break;
                case 3:
                    return "03";
                    break;
                case 4:
                    return "04";
                    break;
                case 5:
                    return "05";
                    break;
                case 6:
                    return "06";
                    break;
                case 7:
                    return "07";
                    break;
                case 8:
                    return "08";
                    break;
                case 9:
                    return "09";
                    break;
                case 10:
                    return "10";
                    break;
                case 11:
                    return "11";
                    break;
                case 12:
                    return "12";
                    break;
            }
        }
    }
 
    //Format Medium date
    if ( ! function_exists('mediumdate_indo'))
    {
        function mediumdate_indo($tgl)
        {
            $ubah = gmdate($tgl, time()+60*60*8);
            $pecah = explode("-",$ubah);
            $tanggal = $pecah[2];
            $bulan = medium_bulan($pecah[1]);
            $tahun = $pecah[0];
            return $tanggal.'-'.$bulan.'-'.$tahun;
        }
    }
      
    if ( ! function_exists('medium_bulan'))
    {
        function medium_bulan($bln)
        {
            switch ($bln)
            {
                case 1:
                    return "Jan";
                    break;
                case 2:
                    return "Feb";
                    break;
                case 3:
                    return "Mar";
                    break;
                case 4:
                    return "Apr";
                    break;
                case 5:
                    return "Mei";
                    break;
                case 6:
                    return "Jun";
                    break;
                case 7:
                    return "Jul";
                    break;
                case 8:
                    return "Ags";
                    break;
                case 9:
                    return "Sep";
                    break;
                case 10:
                    return "Okt";
                    break;
                case 11:
                    return "Nov";
                    break;
                case 12:
                    return "Des";
                    break;
            }
        }
    }
     
    //Long date indo Format
    if ( ! function_exists('longdate_indo'))
    {
        function longdate_indo($tanggal)
        {
            $ubah = gmdate($tanggal, time()+60*60*8);
            $pecah = explode("-",$ubah);
            $tgl = $pecah[2];
            $bln = $pecah[1];
            $thn = $pecah[0];
            $bulan = bulan($pecah[1]);
      
            $nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
            $nama_hari = "";
            if($nama=="Sunday") {$nama_hari="Minggu";}
            else if($nama=="Monday") {$nama_hari="Senin";}
            else if($nama=="Tuesday") {$nama_hari="Selasa";}
            else if($nama=="Wednesday") {$nama_hari="Rabu";}
            else if($nama=="Thursday") {$nama_hari="Kamis";}
            else if($nama=="Friday") {$nama_hari="Jumat";}
            else if($nama=="Saturday") {$nama_hari="Sabtu";}
            return $nama_hari.', '.$tgl.' '.$bulan.' '.$thn;
        }
    }
if ( ! function_exists('terbilang'))
{	
	function terbilang($x){
  $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . " Belas";
  elseif ($x < 100)
    return Terbilang($x / 10) . " Puluh" . Terbilang($x % 10);
  elseif ($x < 200)
    return " Seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " Ratus" . Terbilang($x % 100);
  elseif ($x < 2000)
    return " Seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " Ribu" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " Juta" . Terbilang($x % 1000000);
}
	if ( ! function_exists('masakerja'))
	{	
	function masakerja($tgl_masuk){
		if($tgl_masuk=='0000-00-00'){
			return 0;
		}else{
			$date1 = $tgl_masuk;
			
			
			$date2 = date("Y-m-d");
		
		
			$d1 = new DateTime($date1);
			$d2 = new DateTime($date2);
		
			$diff = $d2->diff($d1);
		
			$masa = $diff->y * 365.25 + $diff->m * 30 + $diff->d;
			return $diff->y." tahun, ".$diff->m." bulan";
			}
		}
	}
	if ( ! function_exists('givecheck'))
	{	
		function givecheck($value){
			$hasil="";
			if($value){
				$hasil="&#10004;";
			}else{
				$hasil="";
			}
			return $hasil;
		}
	}
	
	function em($word) {

    $word = str_replace("@","%40",$word);
    $word = str_replace("`","%60",$word);
    $word = str_replace("¢","%A2",$word);
    $word = str_replace("£","%A3",$word);
    $word = str_replace("¥","%A5",$word);
    $word = str_replace("|","%A6",$word);
    $word = str_replace("«","%AB",$word);
    $word = str_replace("¬","%AC",$word);
    $word = str_replace("¯","%AD",$word);
    $word = str_replace("º","%B0",$word);
    $word = str_replace("±","%B1",$word);
    $word = str_replace("ª","%B2",$word);
    $word = str_replace("µ","%B5",$word);
    $word = str_replace("»","%BB",$word);
    $word = str_replace("¼","%BC",$word);
    $word = str_replace("½","%BD",$word);
    $word = str_replace("¿","%BF",$word);
    $word = str_replace("À","%C0",$word);
    $word = str_replace("Á","%C1",$word);
    $word = str_replace("Â","%C2",$word);
    $word = str_replace("Ã","%C3",$word);
    $word = str_replace("Ä","%C4",$word);
    $word = str_replace("Å","%C5",$word);
    $word = str_replace("Æ","%C6",$word);
    $word = str_replace("Ç","%C7",$word);
    $word = str_replace("È","%C8",$word);
    $word = str_replace("É","%C9",$word);
    $word = str_replace("Ê","%CA",$word);
    $word = str_replace("Ë","%CB",$word);
    $word = str_replace("Ì","%CC",$word);
    $word = str_replace("Í","%CD",$word);
    $word = str_replace("Î","%CE",$word);
    $word = str_replace("Ï","%CF",$word);
    $word = str_replace("Ð","%D0",$word);
    $word = str_replace("Ñ","%D1",$word);
    $word = str_replace("Ò","%D2",$word);
    $word = str_replace("Ó","%D3",$word);
    $word = str_replace("Ô","%D4",$word);
    $word = str_replace("Õ","%D5",$word);
    $word = str_replace("Ö","%D6",$word);
    $word = str_replace("Ø","%D8",$word);
    $word = str_replace("Ù","%D9",$word);
    $word = str_replace("Ú","%DA",$word);
    $word = str_replace("Û","%DB",$word);
    $word = str_replace("Ü","%DC",$word);
    $word = str_replace("Ý","%DD",$word);
    $word = str_replace("Þ","%DE",$word);
    $word = str_replace("ß","%DF",$word);
    $word = str_replace("à","%E0",$word);
    $word = str_replace("á","%E1",$word);
    $word = str_replace("â","%E2",$word);
    $word = str_replace("ã","%E3",$word);
    $word = str_replace("ä","%E4",$word);
    $word = str_replace("å","%E5",$word);
    $word = str_replace("æ","%E6",$word);
    $word = str_replace("ç","%E7",$word);
    $word = str_replace("è","%E8",$word);
    $word = str_replace("é","%E9",$word);
    $word = str_replace("ê","%EA",$word);
    $word = str_replace("ë","%EB",$word);
    $word = str_replace("ì","%EC",$word);
    $word = str_replace("í","%ED",$word);
    $word = str_replace("î","%EE",$word);
    $word = str_replace("ï","%EF",$word);
    $word = str_replace("ð","%F0",$word);
    $word = str_replace("ñ","%F1",$word);
    $word = str_replace("ò","%F2",$word);
    $word = str_replace("ó","%F3",$word);
    $word = str_replace("ô","%F4",$word);
    $word = str_replace("õ","%F5",$word);
    $word = str_replace("ö","%F6",$word);
    $word = str_replace("÷","%F7",$word);
    $word = str_replace("ø","%F8",$word);
    $word = str_replace("ù","%F9",$word);
    $word = str_replace("ú","%FA",$word);
    $word = str_replace("û","%FB",$word);
    $word = str_replace("ü","%FC",$word);
    $word = str_replace("ý","%FD",$word);
    $word = str_replace("þ","%FE",$word);
    $word = str_replace("ÿ","%FF",$word);
	$word = str_replace(" ","%20",$word);
    return $word;
	}
}