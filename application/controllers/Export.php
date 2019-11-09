<?php
	class Export extends CI_Controller {

	private $limit=10;

	function __construct()
	{
	parent::__construct();
	#load library dan helper yang dibutuhkan
	$this->load->library(array('table','form_validation'));
	$this->load->helper(array('form','url'));
	$this->load->library('excel');
	$this->load->model(array('pertanyaan_model','jawaban_model','data_model','about_model'));
	error_reporting(E_ALL & ~E_NOTICE);
	}
	
	function index()
	{
		echo "tes";
	}
	function harian($filetype='',$from='',$to='')
	{
	if (empty($filetype)) $filetype='xlsx';
	if (empty($from)) $from=date('Y-m-d');
	if (empty($to)) $to=date('Y-m-d');
	//echo $filetype.$from.$to;
	$config['base_url']= site_url('export/index/');
	$config['uri_segment']=4;
	
	$survey = $this->data_model->get_by_tanggal($from,$to)->result();
	$this->excel->setActiveSheetIndex(0);
	$this->excel->getActiveSheet()->setTitle('Laporan Harian');
	$worksheet = $this->excel->getActiveSheet();
	$worksheet->SetCellValue('A1', 'Laporan Harian Periode '.date('d-M-y',strtotime($from)).' s/d '.date('d-M-y',strtotime($to)));
	$worksheet->mergeCells('A1:N1');


	$this->excel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	$worksheet->SetCellValue('A3', 'Tanggal');
	$worksheet->SetCellValue('B3', 'Kel');
	$worksheet->SetCellValue('C3', '1');
	$worksheet->SetCellValue('D3', '2');
	$worksheet->SetCellValue('E3', '3');
	$worksheet->SetCellValue('F3', '4');
	$worksheet->SetCellValue('G3', '5');
	$worksheet->SetCellValue('H3', '6');
	$worksheet->SetCellValue('I3', '7');
	$worksheet->SetCellValue('J3', '8');
	$worksheet->SetCellValue('K3', '9');
	$worksheet->SetCellValue('L3', 'Rata');
	$worksheet->SetCellValue('M3', '%');
	$worksheet->SetCellValue('N3', 'P/TP');


	//judul
	$this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setSize(20);
	$this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);

	//tabel header
	$this->excel->getActiveSheet()->getStyle('A3:N3')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A3:N3')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('A3:N3')->getFont()->setBold(true);
	$this->excel->getActiveSheet()->getStyle('A3:N3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');


	$no = 1;
	$i=4;

	foreach ($survey as $value){
		$persen=$this->data_model->get_by_average($value->id)->row()->avg/$this->jawaban_model->get_by_max()->row()->max*100;
		$kesimpulan=$this->data_model->get_kesimpulan($persen)->row()->value;
		
		$worksheet->setCellValue('A'.$i,date('d-M-y',strtotime($value->datetime)));
		$worksheet->SetCellValue('B'.$i,$this->data_model->get_by_detail_id($value->id,1)->row()->jawaban); 
		$worksheet->SetCellValue('C'.$i,$this->data_model->get_by_detail_id($value->id,2)->row()->bobot); 
		$worksheet->SetCellValue('D'.$i,$this->data_model->get_by_detail_id($value->id,3)->row()->bobot); 
		$worksheet->SetCellValue('E'.$i,$this->data_model->get_by_detail_id($value->id,4)->row()->bobot);
		$worksheet->SetCellValue('F'.$i,$this->data_model->get_by_detail_id($value->id,5)->row()->bobot);
		$worksheet->SetCellValue('G'.$i,$this->data_model->get_by_detail_id($value->id,6)->row()->bobot);
		$worksheet->SetCellValue('H'.$i,$this->data_model->get_by_detail_id($value->id,7)->row()->bobot);
		$worksheet->SetCellValue('I'.$i,$this->data_model->get_by_detail_id($value->id,8)->row()->bobot);
		$worksheet->SetCellValue('J'.$i,$this->data_model->get_by_detail_id($value->id,9)->row()->bobot);
		$worksheet->SetCellValue('K'.$i,$this->data_model->get_by_detail_id($value->id,10)->row()->bobot);
		$worksheet->SetCellValue('L'.$i,$this->data_model->get_by_average($value->id)->row()->avg);
		$worksheet->SetCellValue('M'.$i,$persen);
		$worksheet->SetCellValue('N'.$i,$kesimpulan);
		$i++;
		$no++;
	}


	$worksheet->SetCellValue('B'.$i,'Rata');
	$worksheet->SetCellValue('C'.$i,'=AVERAGE(C4:C'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('D'.$i,'=AVERAGE(D4:D'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('E'.$i,'=AVERAGE(E4:E'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('F'.$i,'=AVERAGE(F4:F'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('G'.$i,'=AVERAGE(G4:G'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('H'.$i,'=AVERAGE(H4:H'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('I'.$i,'=AVERAGE(I4:I'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('J'.$i,'=AVERAGE(J4:J'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('K'.$i,'=AVERAGE(K4:K'.($i-1).')'); // Rata2

	$i++;
	$worksheet->SetCellValue('J'.$i,'Rata');
	
	$worksheet->SetCellValue('K'.$i,'=AVERAGE(C'.($i-1).':K'.($i-1).')'); // Rata2
	//tabel footer
	$this->excel->getActiveSheet()->getStyle('A'.($i-1).':N'.$i)->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A'.($i-1).':N'.$i)->getFont()->setSize(14);
	$this->excel->getActiveSheet()->getStyle('A'.($i-1).':N'.$i)->getFont()->setBold(true);

	//isi tabel
	$this->excel->getActiveSheet()->getStyle('A4:' . $this->excel->getActiveSheet()->getHighestColumn() . $this->excel->getActiveSheet()->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	$this->excel->getActiveSheet()->getStyle('A3:N3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$this->excel->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	
	
	$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);


		
	if($filetype=='xlsx'){
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	if($filetype=='pdf'){
	$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
    $rendererLibrary = 'dompdf';
    $rendererLibraryPath = APPPATH.'/third_party/phpexcel/PHPExcel/Writer/'. $rendererLibrary;
    	if (!PHPExcel_Settings::setPdfRenderer(
        $rendererName,
        $rendererLibraryPath
    	)) {
        die(
        'Please set the $rendererName and $rendererLibraryPath values' .
        PHP_EOL .
        ' as appropriate for your directory structure'
        );
    	}
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
	header('Content-Type: application/pdf');
	}
	header('Content-Disposition: attachment;filename="Laporan Harian.'.$filetype.'"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	$this->excel->disconnectWorksheets();
	
	}
	
	function bulanan($filetype='',$date)
	{
	if (empty($filetype)) $filetype='xlsx';
	if (empty($date)) $date=date('Y-m-01');
	//echo $filetype.$from.$to;
	$config['base_url']= site_url('export/index/');
	$config['uri_segment']=4;
	$date = date('Y-m-01',strtotime($date));
	$count=$this->data_model->get_by_kesimpulan_count($date,2)->row()->total;
	
	$this->excel->setActiveSheetIndex(0);
	$this->excel->getActiveSheet()->setTitle('Laporan Bulanan');
	$worksheet = $this->excel->getActiveSheet();
	$worksheet->SetCellValue('A1', 'Laporan Bulanan '.date('M-Y',strtotime($date)));
	$worksheet->mergeCells('A1:N1');
	$worksheet->mergeCells('A2:D2');
	$worksheet->mergeCells('F2:I2');
	$worksheet->mergeCells('K2:N2');
	$worksheet->mergeCells('A10:D10');
	$worksheet->mergeCells('F10:I10');
	$worksheet->mergeCells('K10:N10');
	$worksheet->mergeCells('A18:D18');
	$worksheet->mergeCells('F18:I18');
	$worksheet->mergeCells('K18:N18');
	$worksheet->SetCellValue('A2', $this->pertanyaan_model->get_by_id(2)->row()->ruang_lingkup);
	$worksheet->SetCellValue('F2', $this->pertanyaan_model->get_by_id(3)->row()->ruang_lingkup);
	$worksheet->SetCellValue('K2', $this->pertanyaan_model->get_by_id(4)->row()->ruang_lingkup);
	$worksheet->SetCellValue('A10', $this->pertanyaan_model->get_by_id(8)->row()->ruang_lingkup);
	$worksheet->SetCellValue('F10', $this->pertanyaan_model->get_by_id(6)->row()->ruang_lingkup);
	$worksheet->SetCellValue('K10', $this->pertanyaan_model->get_by_id(7)->row()->ruang_lingkup);
	$worksheet->SetCellValue('A18', $this->pertanyaan_model->get_by_id(8)->row()->ruang_lingkup);
	$worksheet->SetCellValue('F18', $this->pertanyaan_model->get_by_id(9)->row()->ruang_lingkup);
	$worksheet->SetCellValue('K18', $this->pertanyaan_model->get_by_id(10)->row()->ruang_lingkup);

	$this->excel->getActiveSheet()->getStyle('A2:D7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('F2:I7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('K2:N7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('A10:D15')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('F10:I15')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('K10:N15')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('A18:D23')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('F18:I23')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('K18:N23')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('C8')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('H8')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('M8')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('C16')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('H16')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('M16')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('C24')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('H24')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$this->excel->getActiveSheet()->getStyle('M24')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	
	$this->excel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('A2:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('A10:N11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('A18:N19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$this->excel->getActiveSheet()->getStyle('A2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('A10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('A18')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('F2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('F10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('F18')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('K2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('K10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
	$this->excel->getActiveSheet()->getStyle('K18')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');

	
	$idpertanyaan=2;
	$worksheet->SetCellValue('A3', 'No');
	$worksheet->SetCellValue('B3', 'Jawaban');
	$worksheet->SetCellValue('C3', 'Frekuensi');
	$worksheet->SetCellValue('D3', '%');
	$worksheet->SetCellValue('A4', '1');
	$worksheet->SetCellValue('B4', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('C4', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('D4', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,$idpertanyaan)->row()->total/$count*100);
	$worksheet->SetCellValue('A5', '2');
	$worksheet->SetCellValue('B5', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('C5', $this->data_model->get_by_kesimpulan_freq('B',$datetime,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('D5', $this->data_model->get_by_kesimpulan_freq('B',$datetime,$idpertanyaan)->row()->total/$count*100);
	$worksheet->SetCellValue('A6', '3');
	$worksheet->SetCellValue('B6', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('C6', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('D6', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,$idpertanyaan)->row()->total/$count*100);
	$worksheet->SetCellValue('A7', '4');
	$worksheet->SetCellValue('B7', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('C7', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,$idpertanyaan)->row()->total);
	$worksheet->SetCellValue('D7', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,$idpertanyaan)->row()->total/$count*100);
	$worksheet->SetCellValue('C8','=SUM(C4:C7)'); 
	
	$idpertanyaan=3;
	$worksheet->SetCellValue('F3', 'No');
	$worksheet->SetCellValue('G3', 'Jawaban');
	$worksheet->SetCellValue('H3', 'Frekuensi');
	$worksheet->SetCellValue('I3', '%');
	$worksheet->SetCellValue('F4', '1');
	$worksheet->SetCellValue('G4', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('H4', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,3)->row()->total);
	$worksheet->SetCellValue('I4', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,3)->row()->total/$count*100);
	$worksheet->SetCellValue('F5', '2');
	$worksheet->SetCellValue('G5', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('H5', $this->data_model->get_by_kesimpulan_freq('B',$datetime,3)->row()->total);
	$worksheet->SetCellValue('I5', $this->data_model->get_by_kesimpulan_freq('B',$datetime,3)->row()->total/$count*100);
	$worksheet->SetCellValue('F6', '3');
	$worksheet->SetCellValue('G6', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('H6', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,3)->row()->total);
	$worksheet->SetCellValue('I6', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,3)->row()->total/$count*100);
	$worksheet->SetCellValue('F7', '4');
	$worksheet->SetCellValue('G7', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('H7', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,3)->row()->total);
	$worksheet->SetCellValue('I7', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,3)->row()->total/$count*100);
	$worksheet->SetCellValue('H8','=SUM(H4:H7)'); 
	
	$idpertanyaan=4;
	$worksheet->SetCellValue('K3', 'No');
	$worksheet->SetCellValue('L3', 'Jawaban');
	$worksheet->SetCellValue('M3', 'Frekuensi');
	$worksheet->SetCellValue('N3', '%');
	$worksheet->SetCellValue('K4', '1');
	$worksheet->SetCellValue('L4', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('M4', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,4)->row()->total);
	$worksheet->SetCellValue('N4', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,4)->row()->total/$count*100);
	$worksheet->SetCellValue('K5', '2');
	$worksheet->SetCellValue('L5', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('M5', $this->data_model->get_by_kesimpulan_freq('B',$datetime,4)->row()->total);
	$worksheet->SetCellValue('N5', $this->data_model->get_by_kesimpulan_freq('B',$datetime,4)->row()->total/$count*100);
	$worksheet->SetCellValue('K6', '3');
	$worksheet->SetCellValue('L6', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('M6', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,4)->row()->total);
	$worksheet->SetCellValue('N6', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,4)->row()->total/$count*100);
	$worksheet->SetCellValue('K7', '4');
	$worksheet->SetCellValue('L7', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('M7', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,4)->row()->total);
	$worksheet->SetCellValue('N7', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,4)->row()->total/$count*100);
	$worksheet->SetCellValue('M8','=SUM(M4:M7)'); 
	
	$idpertanyaan=5;
	$worksheet->SetCellValue('A11', 'No');
	$worksheet->SetCellValue('B11', 'Jawaban');
	$worksheet->SetCellValue('C11', 'Frekuensi');
	$worksheet->SetCellValue('D11', '%');
	$worksheet->SetCellValue('A12', '1');
	$worksheet->SetCellValue('B12', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('C12', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,5)->row()->total);
	$worksheet->SetCellValue('D12', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,5)->row()->total/$count*100);
	$worksheet->SetCellValue('A13', '2');
	$worksheet->SetCellValue('B13', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('C13', $this->data_model->get_by_kesimpulan_freq('B',$datetime,5)->row()->total);
	$worksheet->SetCellValue('D13', $this->data_model->get_by_kesimpulan_freq('B',$datetime,5)->row()->total/$count*100);
	$worksheet->SetCellValue('A14', '3');
	$worksheet->SetCellValue('B14', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('C14', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,5)->row()->total);
	$worksheet->SetCellValue('D14', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,5)->row()->total/$count*100);
	$worksheet->SetCellValue('A15', '4');
	$worksheet->SetCellValue('B15', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('C15', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,5)->row()->total);
	$worksheet->SetCellValue('D15', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,5)->row()->total/$count*100);
	$worksheet->SetCellValue('C16','=SUM(C12:C15)'); 
	
	$idpertanyaan=6;
	$worksheet->SetCellValue('F11', 'No');
	$worksheet->SetCellValue('G11', 'Jawaban');
	$worksheet->SetCellValue('H11', 'Frekuensi');
	$worksheet->SetCellValue('I11', '%');
	$worksheet->SetCellValue('F12', '1');
	$worksheet->SetCellValue('G12', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('H12', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,6)->row()->total);
	$worksheet->SetCellValue('I12', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,6)->row()->total/$count*100);
	$worksheet->SetCellValue('F13', '2');
	$worksheet->SetCellValue('G13', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('H13', $this->data_model->get_by_kesimpulan_freq('B',$datetime,6)->row()->total);
	$worksheet->SetCellValue('I13', $this->data_model->get_by_kesimpulan_freq('B',$datetime,6)->row()->total/$count*100);
	$worksheet->SetCellValue('F14', '3');
	$worksheet->SetCellValue('G14', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('H14', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,6)->row()->total);
	$worksheet->SetCellValue('I14', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,6)->row()->total/$count*100);
	$worksheet->SetCellValue('F15', '4');
	$worksheet->SetCellValue('G15', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('H15', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,6)->row()->total);
	$worksheet->SetCellValue('I15', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,6)->row()->total/$count*100);
	$worksheet->SetCellValue('H16','=SUM(H12:H15)'); 
	
	$idpertanyaan=7;
	$worksheet->SetCellValue('K11', 'No');
	$worksheet->SetCellValue('L11', 'Jawaban');
	$worksheet->SetCellValue('M11', 'Frekuensi');
	$worksheet->SetCellValue('N11', '%');
	$worksheet->SetCellValue('K12', '1');
	$worksheet->SetCellValue('L12', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('M12', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,7)->row()->total);
	$worksheet->SetCellValue('N12', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,7)->row()->total/$count*100);
	$worksheet->SetCellValue('K13', '2');
	$worksheet->SetCellValue('L13', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('M13', $this->data_model->get_by_kesimpulan_freq('B',$datetime,7)->row()->total);
	$worksheet->SetCellValue('N13', $this->data_model->get_by_kesimpulan_freq('B',$datetime,7)->row()->total/$count*100);
	$worksheet->SetCellValue('K14', '3');
	$worksheet->SetCellValue('L14', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('M14', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,7)->row()->total);
	$worksheet->SetCellValue('N14', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,7)->row()->total/$count*100);
	$worksheet->SetCellValue('K15', '4');
	$worksheet->SetCellValue('L15', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('M15', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,7)->row()->total);
	$worksheet->SetCellValue('N15', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,7)->row()->total/$count*100);
	$worksheet->SetCellValue('M16','=SUM(M12:M15)'); 
	
	$idpertanyaan=8;
	$worksheet->SetCellValue('A19', 'No');
	$worksheet->SetCellValue('B19', 'Jawaban');
	$worksheet->SetCellValue('C19', 'Frekuensi');
	$worksheet->SetCellValue('D19', '%');
	$worksheet->SetCellValue('A20', '1');
	$worksheet->SetCellValue('B20', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('C20', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,8)->row()->total);
	$worksheet->SetCellValue('D20', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,8)->row()->total/$count*100);
	$worksheet->SetCellValue('A21', '2');
	$worksheet->SetCellValue('B21', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('C21', $this->data_model->get_by_kesimpulan_freq('B',$datetime,8)->row()->total);
	$worksheet->SetCellValue('D21', $this->data_model->get_by_kesimpulan_freq('B',$datetime,8)->row()->total/$count*100);
	$worksheet->SetCellValue('A22', '3');
	$worksheet->SetCellValue('B22', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('C22', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,8)->row()->total);
	$worksheet->SetCellValue('D22', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,8)->row()->total/$count*100);
	$worksheet->SetCellValue('A23', '4');
	$worksheet->SetCellValue('B23', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('C23', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,8)->row()->total);
	$worksheet->SetCellValue('D23', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,8)->row()->total/$count*100);
	$worksheet->SetCellValue('C24','=SUM(C20:C23)'); 
	
	$idpertanyaan=9;
	$worksheet->SetCellValue('F19', 'No');
	$worksheet->SetCellValue('G19', 'Jawaban');
	$worksheet->SetCellValue('H19', 'Frekuensi');
	$worksheet->SetCellValue('I19', '%');
	$worksheet->SetCellValue('F20', '1');
	$worksheet->SetCellValue('G20', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('H20', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,9)->row()->total);
	$worksheet->SetCellValue('I20', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,9)->row()->total/$count*100);
	$worksheet->SetCellValue('F21', '2');
	$worksheet->SetCellValue('G21', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('H21', $this->data_model->get_by_kesimpulan_freq('B',$datetime,9)->row()->total);
	$worksheet->SetCellValue('I21', $this->data_model->get_by_kesimpulan_freq('B',$datetime,9)->row()->total/$count*100);
	$worksheet->SetCellValue('F22', '3');
	$worksheet->SetCellValue('G22', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('H22', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,9)->row()->total);
	$worksheet->SetCellValue('I22', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,9)->row()->total/$count*100);
	$worksheet->SetCellValue('F23', '4');
	$worksheet->SetCellValue('G23', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('H23', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,9)->row()->total);
	$worksheet->SetCellValue('I23', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,9)->row()->total/$count*100);
	$worksheet->SetCellValue('H24','=SUM(H20:H23)'); 
	
	$idpertanyaan=10;
	$worksheet->SetCellValue('K19', 'No');
	$worksheet->SetCellValue('L19', 'Jawaban');
	$worksheet->SetCellValue('M19', 'Frekuensi');
	$worksheet->SetCellValue('N19', '%');
	$worksheet->SetCellValue('K20', '1');
	$worksheet->SetCellValue('L20', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,4)->row()->jawaban);
	$worksheet->SetCellValue('M20', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,10)->row()->total);
	$worksheet->SetCellValue('N20', $this->data_model->get_by_kesimpulan_freq('SB',$datetime,10)->row()->total/$count*100);
	$worksheet->SetCellValue('K21', '2');
	$worksheet->SetCellValue('L21', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,3)->row()->jawaban);
	$worksheet->SetCellValue('M21', $this->data_model->get_by_kesimpulan_freq('B',$datetime,10)->row()->total);
	$worksheet->SetCellValue('N21', $this->data_model->get_by_kesimpulan_freq('B',$datetime,10)->row()->total/$count*100);
	$worksheet->SetCellValue('K22', '3');
	$worksheet->SetCellValue('L22', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,2)->row()->jawaban);
	$worksheet->SetCellValue('M22', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,10)->row()->total);
	$worksheet->SetCellValue('N22', $this->data_model->get_by_kesimpulan_freq('KB',$datetime,10)->row()->total/$count*100);
	$worksheet->SetCellValue('K23', '4');
	$worksheet->SetCellValue('L23', $this->jawaban_model->get_by_pertanyaan_bobot($idpertanyaan,1)->row()->jawaban);
	$worksheet->SetCellValue('M23', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,10)->row()->total);
	$worksheet->SetCellValue('N23', $this->data_model->get_by_kesimpulan_freq('TB',$datetime,10)->row()->total/$count*100);
	$worksheet->SetCellValue('M24','=SUM(M20:M23)'); 

	//judul
	$this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setSize(20);
	$this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);

	//tabel header
	$this->excel->getActiveSheet()->getStyle('A2:N3')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A2:N3')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('A2:N3')->getFont()->setBold(true);
	$this->excel->getActiveSheet()->getStyle('A10:N11')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A10:N11')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('A10:N11')->getFont()->setBold(true);
	$this->excel->getActiveSheet()->getStyle('A18:N19')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A18:N19')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('A18:N19')->getFont()->setBold(true);
	//$this->excel->getActiveSheet()->getStyle('A2:N3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('66A342');

/*
	$worksheet->SetCellValue('B'.$i,'Rata');
	$worksheet->SetCellValue('C'.$i,'=AVERAGE(C4:C'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('D'.$i,'=AVERAGE(D4:D'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('E'.$i,'=AVERAGE(E4:E'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('F'.$i,'=AVERAGE(F4:F'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('G'.$i,'=AVERAGE(G4:G'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('H'.$i,'=AVERAGE(H4:H'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('I'.$i,'=AVERAGE(I4:I'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('J'.$i,'=AVERAGE(J4:J'.($i-1).')'); // Rata2
	$worksheet->SetCellValue('K'.$i,'=AVERAGE(K4:K'.($i-1).')'); // Rata2

	$i++;
	$worksheet->SetCellValue('J'.$i,'Rata');
	
	$worksheet->SetCellValue('K'.$i,'=AVERAGE(C'.($i-1).':K'.($i-1).')'); // Rata2
	//tabel footer
	$this->excel->getActiveSheet()->getStyle('A'.($i-1).':N'.$i)->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A'.($i-1).':N'.$i)->getFont()->setSize(14);
	$this->excel->getActiveSheet()->getStyle('A'.($i-1).':N'.$i)->getFont()->setBold(true);

	//isi tabel
	$this->excel->getActiveSheet()->getStyle('A4:' . $this->excel->getActiveSheet()->getHighestColumn() . $this->excel->getActiveSheet()->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	$this->excel->getActiveSheet()->getStyle('A3:N3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$this->excel->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	*/
	
	$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);


		
	if($filetype=='xlsx'){
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	if($filetype=='pdf'){
	$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
    $rendererLibrary = 'dompdf';
    $rendererLibraryPath = APPPATH.'/third_party/phpexcel/PHPExcel/Writer/'. $rendererLibrary;
    	if (!PHPExcel_Settings::setPdfRenderer(
        $rendererName,
        $rendererLibraryPath
    	)) {
        die(
        'Please set the $rendererName and $rendererLibraryPath values' .
        PHP_EOL .
        ' as appropriate for your directory structure'
        );
    	}
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
	header('Content-Type: application/pdf');
	}
	header('Content-Disposition: attachment;filename="Laporan Bulanan.'.$filetype.'"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	$this->excel->disconnectWorksheets();
	
	}
	
	function kesimpulan($filetype='',$date='')
	{
	if (empty($filetype)) $filetype='xlsx';
	if (empty($from)) $date=date('Y-m');
	//echo $filetype.$from.$to;
	$config['base_url']= site_url('export/kesimpulan/');
	$config['uri_segment']=4;
	
	$survey = $this->pertanyaan_model->get_by_bobot()->result();
	$this->excel->setActiveSheetIndex(0);
	$this->excel->getActiveSheet()->setTitle('Laporan Kesimpulan');
	$worksheet = $this->excel->getActiveSheet();
	$worksheet->SetCellValue('A1', 'Laporan Kesimpulan Periode '.date('M-Y',strtotime($date)));
	$worksheet->mergeCells('A1:C1');


	$this->excel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	$worksheet->SetCellValue('A2', 'No');
	$worksheet->SetCellValue('B2', 'Ruang Lingkup');
	$worksheet->SetCellValue('C2', 'Nilai');
	$worksheet->SetCellValue('D2', 'Kategori');
	$worksheet->SetCellValue('E2', 'Peringkat');


	//judul
	$this->excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setSize(20);
	$this->excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);

	//tabel header
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setName('Calibri');
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setSize(16);
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');


	$no = 1;
	$i=3;

	foreach ($survey as $value){
		
		$worksheet->setCellValue('A'.$i,$no);
		$worksheet->SetCellValue('B'.$i,$value->ruang_lingkup); 
		$worksheet->SetCellValue('C'.$i,round($this->data_model->get_by_kesimpulan($value->id,$datetime)->row()->rata,3)); 
		$worksheet->SetCellValue('D'.$i,$this->data_model->get_kesimpulan_rata($this->data_model->get_by_kesimpulan($value->id,$datetime)->row()->rata)->row()->value2);
		//$worksheet->setCellValue('E'.$i,'=RANK(C'.$i.',C3:C11');
		
		$i++;
		$no++;
	}
	
	for($t=3;$t<=11;$t++){
		$worksheet->setCellValue('E'.$t,'=RANK(C'.$t.',C3:C11)');
	}



	
	//isi tabel
	$this->excel->getActiveSheet()->getStyle('A3:' . $this->excel->getActiveSheet()->getHighestColumn() . $this->excel->getActiveSheet()->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	$this->excel->getActiveSheet()->getStyle('A2:E2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$this->excel->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	
	
	$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);


		
	if($filetype=='xlsx'){
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	if($filetype=='pdf'){
	$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
    $rendererLibrary = 'dompdf';
    $rendererLibraryPath = APPPATH.'/third_party/phpexcel/PHPExcel/Writer/'. $rendererLibrary;
    	if (!PHPExcel_Settings::setPdfRenderer(
        $rendererName,
        $rendererLibraryPath
    	)) {
        die(
        'Please set the $rendererName and $rendererLibraryPath values' .
        PHP_EOL .
        ' as appropriate for your directory structure'
        );
    	}
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
	header('Content-Type: application/pdf');
	}
	header('Content-Disposition: attachment;filename="Laporan Kesimpulan.'.$filetype.'"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	$this->excel->disconnectWorksheets();
	
	}
	
	}