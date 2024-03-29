<?php
$this->load->view('template/head');
?>

<!--tambahkan custom css disini-->
<!-- iCheck -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/iCheck/flat/blue.css') ?>" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/morris/morris.css') ?>" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-1.2.2.css') ?>" rel="stylesheet" type="text/css" />
<!-- Date Picker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/datepicker3.css') ?>" rel="stylesheet" type="text/css" />
<!-- Daterange picker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/daterangepicker/daterangepicker-bs3.css') ?>" rel="stylesheet" type="text/css" />
<!-- bootstrap wysihtml5 - text editor -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>" rel="stylesheet" type="text/css" />

<?php
$this->load->view('template/topbar');
if($akses=='admin'){
	$this->load->view('template/sidebar');
	}else{
	$this->load->view('template/sidebaruser');		
}
$where = $this->uri->segment(6);
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Tidak Masuk
    <small>(View)</small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tidak Masuk</li>
        <li class="active">View</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
 
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
    	<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Tidak Masuk</h3>
			
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input name="table_search" type="text" class="form-control pull-right" id="katakunci" value="<?=(!empty($where))?$where:'';?>" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" id="cari"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <?=$table;?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              
              <?=$pagination;?>
            </div>
          </div>
          <!-- /.box -->
        </div>
    </div><!-- /.row (main row) -->

</section><!-- /.content -->


<?php
$this->load->view('template/js');
?>

<!--tambahkan custom js disini-->
<!-- jQuery UI 1.11.2 -->
<script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>" type="text/javascript"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Morris.js charts -->
<script src="<?php echo base_url('assets/js/raphael-min.js') ?>"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/morris/morris.min.js') ?>" type="text/javascript"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/sparkline/jquery.sparkline.min.js') ?>" type="text/javascript"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') ?>" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/knob/jquery.knob.js') ?>" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/daterangepicker/daterangepicker.js') ?>" type="text/javascript"></script>
<!-- datepicker -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/bootstrap-datepicker.js') ?>" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') ?>" type="text/javascript"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/iCheck/icheck.min.js') ?>" type="text/javascript"></script>



<script type="text/javascript">
$(function () {		
		var akses;
		akses = '<?=$akses;?>';
		

		
		$("#cari").click(function(){
			window.location.href = '<?=base_url('tidakmasuk')."/index/0/nomor/asc/";?>'+$("#katakunci").val();  
		});
		$(".minimal").change(function() {
			var id = $(this).attr('value');
			var konfirm;
			
    		if(this.checked) {
        		//Do stuff
				//alert(id);
				konfirm = confirm("Apa anda ingin menyetujui?");
				if(konfirm){
				$.get( "<?=base_url('tidakmasuk')?>/approve/"+id+"/1", function( data ) {
				  //alert( "Data Loaded: " + data );
				});
				} else {
					$(this).prop('checked', false);
				}
    		} else {
				konfirm = confirm("Apa anda ingin membatalkan persetujuan?");
				if(konfirm){
				$.get( "<?=base_url('tidakmasuk')?>/approve/"+id+"/0", function( data ) {
				  //alert( "Data Loaded: " + data );
				});	
				}else{
					$(this).prop('checked', true);
				}
			}
		});
		$(".verif1").change(function() {
			
			var id = $(this).attr('value');
			var konfirm;
			
    		if(this.checked) {
        		//Do stuff
				konfirm = confirm("Apa anda ingin verivikasi?");
				if(konfirm){
				$.get( "<?=base_url('tidakmasuk')?>/verif1/"+id+"/1", function( data ) {
				  //alert( "Data Loaded: " + data );
				});
				} else {
					$(this).prop('checked', false);
				}
    		} else {
				konfirm = confirm("Apa anda ingin membatalkan verifikasi?");
				if(konfirm){
				$.get( "<?=base_url('tidakmasuk')?>/verif1/"+id+"/0", function( data ) {
				  //alert( "Data Loaded: " + data );
				});	
				}else{
					$(this).prop('checked', true);
				}
			}
		});
});
</script>
<?php
$this->load->view('template/foot');
?>