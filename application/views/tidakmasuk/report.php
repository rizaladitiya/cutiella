<?php
$this->load->view('template/head');
date_default_timezone_set("Asia/Jakarta");
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
<style type="text/css">
 /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
} 
</style>
<?php
$this->load->view('template/topbar');
if($akses=='admin'){
	$this->load->view('template/sidebar');
	}else{
	$this->load->view('template/sidebaruser');		
}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?=$this->about_model->get_by_nama('program')->row()->value;?><small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Tidak Masuk</li>
        <li class="active">Report</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
  <div class="col-xs-12">
  <form action="<?=base_url('tidakmasuk/report');?>" method="post">
  	<div class="nav-tabs-custom">
                  <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-pencil-square-o"></i>
                    <h3 class="box-title">Laporan Tidak Masuk</h3>
                </div>
                <div class="box-body">
                        <div class="form-group">
                        <div class="row">
                       	  <div class="col-xs-3">
                        <label>Dari</label>
                    			<div class="input-group">
                     				<div class="input-group-addon">
                        				<i class="fa fa-calendar"></i>
                      				</div>
                      			<input name="dari" type="text" class="form-control pull-right" id="dari" value="<?=(isset($dari))?$dari:'';?>"/>
                    			</div>
                          </div>
    <div class="col-xs-3">
   	    <label>Hingga</label>
                           	<div class="input-group">
                            	<div class="input-group-addon">
                        				<i class="fa fa-calendar"></i>
               				  </div>
                         	    <input name="hingga" type="text" class="form-control pull-right" id="hingga" value="<?=(isset($hingga))?$hingga:'';?>"/>
           	      </div></div>
</div>
                        </div>
                </div>
                <div class="box-footer clearfix">
                  <button class="pull-left btn btn-default" id="sendEmail">Tampilkan                <i class="fa fa-search"></i></button>
                </div>
            </div>
                
          </form> 
       
  </div> 
  <div class="row">
    	<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Tidak Masuk</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <?=$table;?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              
            </div>
          </div>
          <!-- /.box -->
        </div>
        </div>
    </div>
  
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
		

	$('#dari,#hingga').datepicker({
      		autoclose: true,
			format: 'yyyy-mm-dd'
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