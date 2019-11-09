<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'third_party/fpdf/fpdf.php';

class Custompdf extends FPDF {

    function __construct()
  {
    parent::__construct();
}


  function MultiCellBltArray($w, $h, $blt_array, $border=0, $align='J', $fill=false)
    {
        if (!is_array($blt_array))
        {
            die('MultiCellBltArray requires an array with the following keys: bullet,margin,text,indent,spacer');
            exit;
        }
                
        //Save x
        $bak_x = $this->x;
        
        for ($i=0; $i<sizeof($blt_array['text']); $i++)
        {
            //Get bullet width including margin
            $blt_width = $this->GetStringWidth($blt_array['bullet'] . $blt_array['margin'])+$this->cMargin*2;
            
            // SetX
            $this->SetX($bak_x);
            
            //Output indent
            if ($blt_array['indent'] > 0)
                $this->Cell($blt_array['indent']);
            
            //Output bullet
            $this->Cell($blt_width,$h,$blt_array['bullet'] . $blt_array['margin'],0,'',$fill);
            
            //Output text
            $this->MultiCell($w-$blt_width,$h,$blt_array['text'][$i],$border,$align,$fill);
            
            //Insert a spacer between items if not the last item
            if ($i != sizeof($blt_array['text'])-1)
                $this->Ln($blt_array['spacer']);
            
            //Increment bullet if it's a number
            if (is_numeric($blt_array['bullet']))
                $blt_array['bullet']++;
        }
    
        //Restore x
        $this->x = $bak_x;
    }
		public function rptDetailData ($data = array()) {
		//
		$border = 0;
		$this->AddPage();
		$this->SetAutoPageBreak(true,60);
		$this->AliasNbPages();
		$left = 25;
 
		//header
		$this->SetFont("", "B", 15);
		$this->MultiCell(0, 12, 'PT. ACHMATIM DOT NET');
		$this->Cell(0, 1, " ", "B");
		$this->Ln(10);
		$this->SetFont("", "B", 12);
		$this->SetX($left); $this->Cell(0, 10, 'LAPORAN DATA KARYAWAN', 0, 1,'C');
		$this->Ln(10);
 
		$h = 13;
		$left = 40;
		$top = 80;
		#tableheader
		$this->SetFillColor(200,200,200);
		$left = $this->GetX();
		$this->Cell(20,$h,'NO',1,0,'L',true);
		$this->SetX($left += 20); $this->Cell(75, $h, 'NIP', 1, 0, 'C',true);
		$this->SetX($left += 75); $this->Cell(100, $h, 'NAMA', 1, 0, 'C',true);
		$this->SetX($left += 100); $this->Cell(150, $h, 'ALAMAT', 1, 0, 'C',true);
		$this->SetX($left += 150); $this->Cell(100, $h, 'EMAIL', 1, 0, 'C',true);
		$this->SetX($left += 100); $this->Cell(100, $h, 'WEBSITE', 1, 1, 'C',true);
		//$this->Ln(20);
 
		$this->SetFont('Arial','',9);
		$this->SetWidths(array(20,75,100,150,100,100));
		$this->SetAligns(array('C','L','L','L','L','L'));
		$no = 1; $this->SetFillColor(255);
		foreach ($data as $baris) {
			$this->Row(
				array($no++,
				$baris['nip'],
				$baris['nama'],
				$baris['alamat'],
				$baris['email'],
				$baris['website']
			));
		}
 
	}
	public function tableData2 ($data = array()) {
		$border = 1;
		$h = 5;
		$left = 40;
		$top = 80;
		$this->SetFont('Arial','',10);
		$left = $this->GetX();
		$this->Cell(10,$h,'1',1,0,'C',false);
		
		$this->SetX($left += 10); $this->Cell(100, $h, 'Pejabat Pembuat Komitmen', 1, 0, 'L',false);
		$this->SetX($left += 100); $this->Cell(75, $h, 'Kasubag Umum Dan Keuangan', 1, 1, 'L',false);
		
		$this->SetFont('Arial','',9);
		$this->SetWidths(array(10,100,75));
		$this->SetAligns(array('C','L','L'));
		$no = 1; 
		foreach ($data as $baris) {
			$this->Row2(
				array(
				$baris['no'],
				$baris['nama'],
				$baris['pangkat']
			));
		}
	}
	
	public function tableData ($data = array()) {
		//
		$border = 0;
		//$this->AddPage();
		//$this->SetAutoPageBreak(true,60);
		//$this->AliasNbPages();
		$left = 25;
 		/*
		//header
		$this->SetFont("", "B", 15);
		$this->MultiCell(0, 12, 'PT. ACHMATIM DOT NET');
		$this->Cell(0, 1, " ", "B");
		$this->Ln(10);
		$this->SetFont("", "B", 12);
		$this->SetX($left); $this->Cell(0, 10, 'LAPORAN DATA KARYAWAN', 0, 1,'C');
		$this->Ln(10);
 		*/
		$h = 13;
		$left = 40;
		$top = 80;
		#tableheader
		$this->SetFillColor(200,200,200);
		$left = $this->GetX();
		$this->Cell(10,$h,'NO',1,0,'L',true);
		
		$this->SetX($left += 10); $this->Cell(50, $h, 'Nama', 1, 0, 'C',true);
		$this->SetX($left += 50); $this->Cell(50, $h, 'Pangkat / NRP / NIP', 1, 0, 'C',true);
		$this->SetX($left += 50); $this->Cell(40, $h, 'Jabatan', 1, 0, 'C',true);
		$this->SetX($left += 40); $this->Cell(30, $h, 'Keterangan', 1, 1, 'C',true);
		//$this->Ln(20);
 
		$this->SetFont('Arial','',9);
		$this->SetWidths(array(10,50,50,40,30));
		$this->SetAligns(array('C','L','L','L','L'));
		$no = 1; $this->SetFillColor(255);
		foreach ($data as $baris) {
			$this->Row(
				array(
				$baris['no'],
				$baris['nama'],
				$baris['pangkat'],
				$baris['jabatan'],
				$baris['keterangan']
			));
		}
 
	}
 
	public function printPDF () {
 
		if ($this->options['paper_size'] == "F4") {
			$a = 8.3 * 72; //1 inch = 72 pt
			$b = 13.0 * 72;
			$this->FPDF($this->options['orientation'], "pt", array($a,$b));
		} else {
			$this->FPDF($this->options['orientation'], "pt", $this->options['paper_size']);
		}
 
	    $this->SetAutoPageBreak(false);
	    $this->AliasNbPages();
	    $this->SetFont("helvetica", "B", 10);
	    //$this->AddPage();
 
	    $this->rptDetailData();
 
	    $this->Output($this->options['filename'],$this->options['destinationfile']);
  	}
 
  	private $widths;
	private $aligns;
 
	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}
 
	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}
 
	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=10*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,10,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}
	function Row2($data)
	{
		//Calculate the height of the row
		$nb=1;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=6*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,6,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}
 
	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}
 
	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}
	function MultiCell2($w, $h, $txt, $border=0, $align='J', $fill=false, $indent=0)
{
    //Output text with automatic or explicit line breaks
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;

    $wFirst = $w-$indent;
    $wOther = $w;

    $wmaxFirst=($wFirst-2*$this->cMargin)*1000/$this->FontSize;
    $wmaxOther=($wOther-2*$this->cMargin)*1000/$this->FontSize;

    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 && $s[$nb-1]=="\n")
        $nb--;
    $b=0;
    if($border)
    {
        if($border==1)
        {
            $border='LTRB';
            $b='LRT';
            $b2='LR';
        }
        else
        {
            $b2='';
            if(is_int(strpos($border,'L')))
                $b2.='L';
            if(is_int(strpos($border,'R')))
                $b2.='R';
            $b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
        }
    }
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $ns=0;
    $nl=1;
        $first=true;
    while($i<$nb)
    {
        //Get next character
        $c=$s[$i];
        if($c=="\n")
        {
            //Explicit line break
            if($this->ws>0)
            {
                $this->ws=0;
                $this->_out('0 Tw');
            }
            $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $ns=0;
            $nl++;
            if($border && $nl==2)
                $b=$b2;
            continue;
        }
        if($c==' ')
        {
            $sep=$i;
            $ls=$l;
            $ns++;
        }
        $l+=$cw[$c];

        if ($first)
        {
            $wmax = $wmaxFirst;
            $w = $wFirst;
        }
        else
        {
            $wmax = $wmaxOther;
            $w = $wOther;
        }

        if($l>$wmax)
        {
            //Automatic line break
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
                if($this->ws>0)
                {
                    $this->ws=0;
                    $this->_out('0 Tw');
                }
                $SaveX = $this->x; 
                if ($first && $indent>0)
                {
                    $this->SetX($this->x + $indent);
                    $first=false;
                }
                $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                    $this->SetX($SaveX);
            }
            else
            {
                if($align=='J')
                {
                    $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                    $this->_out(sprintf('%.3f Tw',$this->ws*$this->k));
                }
                $SaveX = $this->x; 
                if ($first && $indent>0)
                {
                    $this->SetX($this->x + $indent);
                    $first=false;
                }
                $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
                    $this->SetX($SaveX);
                $i=$sep+1;
            }
            $sep=-1;
            $j=$i;
            $l=0;
            $ns=0;
            $nl++;
            if($border && $nl==2)
                $b=$b2;
        }
        else
            $i++;
    }
    //Last chunk
    if($this->ws>0)
    {
        $this->ws=0;
        $this->_out('0 Tw');
    }
    if($border && is_int(strpos($border,'B')))
        $b.='B';
    $this->Cell($w,$h,substr($s,$j,$i),$b,2,$align,$fill);
    $this->x=$this->lMargin;
    }

}
?>