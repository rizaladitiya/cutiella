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
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/select2/select2.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/timepicker/bootstrap-timepicker.min.css') ?>" rel="stylesheet" type="text/css" />


<?php
$this->load->view('template/topbar');
if($akses=='admin'){
	$this->load->view('template/sidebar');
	}else{
	$this->load->view('template/sidebaruser');		
}
$sess = getsession();
$id = $sess->id;
$nama = $sess->nama;
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Izin
    <small>(Add)</small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Izin</li>
        <li class="active">Add</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
 <form action="<?=base_url('izin/save');?>" method="post" id="formizin">
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-10 connectedSortable">
        <div class="alert alert-success" id="success-alert" style="display:none">
    		<button type="button" class="close" data-dismiss="alert">x</button>
    		Data Berhasil Disimpan.
		</div>
        <div class="alert alert-danger" id="alert-danger" style="display:none">
    		<button type="button" class="close" data-dismiss="alert">x</button>
    		Data Gagal Disimpan, hubungi Administrator.
		</div>
        
        <!-- Custom tabs (Charts with tabs)-->
            <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <div class="tab-content no-padding">
                    <!-- Morris chart - Sales -->
                  <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-pencil-square-o"></i>
                    <h3 class="box-title">Input Izin</h3>
                </div>
                
                <div class="box-body">
                  <div class="form-group">
                        <div class="row">
                      		<div class="col-xs-4">
                            <label>Nama</label>
                      			<select class="form-control select2" name="karyawan" id="karyawan" style="width: 100%;">
							<?php  
							if($akses=="admin"){
								$karyawans2=$karyawans;
								}else{
									$karyawans2[]=(object)array(
												'id'=>$id,
												'nama'=>$nama
												);
								}
							foreach($karyawans2 as $karyawan){
							?>
      							<option value=<?=$karyawan->id; ?> <?=set_select('karyawan',$karyawan->id, ($izin->karyawan==$karyawan->id));?>><?=$karyawan->nama; ?></option>
      <?php } ?>            </select>
                       		</div>
                            <div class="col-xs-4">
                            <label>Nomor</label>
                      		    <input name="nomor" type="text" class="form-control pull-right" id="nomor" value="<?=(isset($izin->nomor))?$izin->nomor:'';?>" placeholder="Nomor..."/>
                       		</div>
                            <div class="col-xs-4">
                            <label>Alasan</label>
                      			<select class="form-control select2" name="alasan" id="alasan" style="width: 100%;">
							<?php  
							foreach($alasans as $alasan){
							?>
      							<option value=<?=$alasan->id; ?> <?=set_select('alasan',$alasan->id, ($izin->alasan==$alasan->id));?>><?=$alasan->nama; ?></option>
      <?php } ?>            </select>
                       		</div>
                    </div>
                    <div class="row">
                   	  
                       	  <div class="col-xs-4">
                            <label>Tanggal</label>
                   			<div class="input-group">
               				  <div class="input-group-addon">
                        				<i class="fa fa-calendar"></i>
               				  </div>
                   			  <input name="tanggal" type="text" class="form-control pull-right" id="tanggal" value="<?=(isset($izin->tanggal))?$izin->tanggal:'';?>"/>
               			    </div>
                          </div>
                          
                          <div class="col-xs-3">
                          	<div class="bootstrap-timepicker">
                            <label>Dari</label>
                   			<div class="input-group">
               				    <input name="dari" type="text" class="form-control timepicker" id="dari" value="<?=(isset($izin->dari))?$izin->dari:'';?>"/>
                                <div class="input-group-addon">
                                  <i class="fa fa-clock-o"></i>
                                </div>
               			    </div>
                            </div>
                          </div>
                          <div class="col-xs-3">
                          	<div class="bootstrap-timepicker">
                            <label>Hingga</label>
                   			<div class="input-group">
                   			  <input name="hingga" type="text" class="form-control  timepicker" id="hingga" value="<?=(isset($izin->hingga))?$izin->hingga:'';?>"/>
                              <div class="input-group-addon">
                                  <i class="fa fa-clock-o"></i>
                                </div>
               			    </div>
                            </div>
                          </div>
                          <div class="col-xs-4" style="display:none">
                          <label>Tanggal Keluar</label>
                                <div class="input-group">
               				  <div class="input-group-addon">
                        				<i class="fa fa-calendar"></i>
               				  </div>
                   			  <input name="tglkeluar" type="text" class="form-control pull-right" id="tglkeluar" value="<?=(strtotime($izin->tglkeluar))?$izin->tglkeluar:date('Y-m-d');?>"/>
               			    </div>
                          </div>
                    </div>
                    <div class="row"></div>
                    <div class="form-group">
                     <label>Alasan izin</label>
                     <textarea name="alasanizin" class="textarea" id="alasanizin" style="width: 100%; height: 50px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" placeholder="Alasan izin....."><?=(isset($izin->alasanizin))?$izin->alasanizin:'';?></textarea>
           			  
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                      <label>Atasan</label><select class="form-control select2" name="atasan" id="atasan" style="width: 100%;">
							<?php  
							foreach($karyawans as $karyawan){
							?>
      							<option value=<?=$karyawan->id; ?> <?=set_select('karyawan',$karyawan->id, ($izin->atasan==$karyawan->id));?>><?=$karyawan->nama; ?></option>
      <?php } ?>            </select>
                              
                       		</div>
                      		<div class="col-xs-4" style="display:none">
                          <label>Tanggal Keluar</label>
                                <div class="input-group">
               				  <div class="input-group-addon">
                        				<i class="fa fa-calendar"></i>
               				  </div>
                   			  <input name="tglkeluar" type="text" class="form-control pull-right" id="tglkeluar" value="<?=(strtotime($izin->tglkeluar))?$izin->tglkeluar:date('Y-m-d');?>"/>
               			    </div>
                          </div>
                    </div>
                    
                     </div>
                       <!-- Loading (remove the following to stop the loading)-->
            <div class="overlay" style="display:none">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
            <!-- end loading -->
                </div>
                <div class="box-footer clearfix">
                    <button class="pull-right btn btn-default" id="sendEmail">Simpan <i class="fa fa-save"></i></button>
                    <button class="pull-right btn btn-default" id="cancel">Batal <i class="fa fa-close"></i></button>
                    <input name="id" type="hidden" id="id" value="<?=(isset($izin->id))?$izin->id:0;?>" />
                </div>
            </div>
                </div>
                
       
            </div><!-- /.nav-tabs-custom -->


			<!-- /.box -->
            <!-- TO DO List --><!-- /.box -->

            <!-- quick email widget -->
          

        </section><!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <!-- right col -->
    </div><!-- /.row (main row) -->

                    </form>
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
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/select2/select2.full.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/timepicker/bootstrap-timepicker.min.js') ?>" type="text/javascript"></script>



<script type="text/javascript">
$(function () {
		$( "#cancel" ).click(function() {
		  window.location.href = '<?=$this->agent->referrer();?>'; 
		  return false;
		});
		$('.select2').select2();
		$('#tanggal,#tglkeluar').datepicker({
      		autoclose: true,
			format: 'yyyy-mm-dd',
			immediateUpdates: true,
            todayHighlight: true
    	});
		
		$(".timepicker").timepicker({
          showInputs: false,
		  showMeridian: false
        });
	// Bind to the submit event of our form
	$("#formizin").submit(function(event){
		if($('#tanggal').val()==""){
			alert('lengkapi data');
			return false;
		}
		if($('#alasanizin').val()==""){
			alert('lengkapi data');
			return false;
		}
		if($('#nomor').val()==0){
			alert('lengkapi data');
			return false;
		}
		
    event.preventDefault();
    var $form = $(this);
    var serializedData = $form.serialize();
    request = $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: serializedData,
		dataType: 'html',
		beforeSend:function(){
        	$(".overlay").show();
    	},
    	success:function(result){
			$(".overlay").hide();
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
               $("#success-alert").slideUp(500);
			   if($('#id').val()==0)
			   {
				   $('#formizin')[0].reset();
				   window.location.href = '<?=site_url('izin/');?>';
			   } else {
					window.location.href = '<?=$this->agent->referrer();?>';  
				}
            });
			/*
			var win = window.open('<?=site_url('izin/cetak/');?>/'+result, '_blank');
				if (win) {
    				//Browser has allowed it to be opened
   					win.focus();
				} else {
    				//Browser has blocked it
    				alert('Please allow popups for this website');
				} 
			*/
    	},
		error:function(data){
			$(".overlay").hide();
			alert(data.toSource());
			$("#alert-danger").fadeTo(2000, 500).slideUp(500, function(){
               $("#alert-danger").slideUp(500);
			   //$('#formizin')[0].reset();
            });
			
    	},
    	complete:function(){
			
    	}
    });

	});
	
});
</script>
<?php
$this->load->view('template/foot');
?>