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
$this->load->view('template/sidebar');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Program <small>Setting</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Setting</li>
        <li class="active">Program</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
                
<div class="box box-primary">
<form action="<?=base_url('setting/save');?>" method="post">
<div class="form-group">
<div class="box-header">
                    <i class="fa fa-cog"></i>
                    <h3 class="box-title">Program</h3>
                    
                </div>
                <div class="box-body">
<div class="row">
  <div class="col-xs-6">
            <!-- small box -->
                            Nama : 
                            <input name="program" type="text" class="form-control" id="program" value="<?=isset($program)?$program:'';?>" placeholder="Nama...."/>
        </div><!-- ./col -->
        <div class="col-xs-6">
        <!-- small box -->Judul : 
                            <input name="title" type="text" class="form-control" id="title" value="<?=isset($title)?$title:'';?>" placeholder="Judul..."/>
        </div><!-- ./col -->
        <div class="col-xs-6">
        Creator : 
                            <input name="creator" type="text" class="form-control" id="creator" value="<?=isset($creator)?$creator:'';?>" placeholder="Creator..."/>
        <!-- small box --></div>
        <div class="col-xs-6">
        Versi : 
                            <input name="versi" type="text" class="form-control" id="versi" value="<?=isset($versi)?$versi:'';?>" placeholder="Nama Program..."/>
        <!-- small box --></div>
        <div class="col-xs-6">
            <!-- small box -->
                            Pejabat Cuti : 
                            <select class="form-control select2" name="pejabatcuti" id="pejabatcuti" style="width: 100%;">
							<?php  
							foreach($karyawans as $karyawan){
							?>
      							<option value=<?=$karyawan->id; ?> <?=set_select('karyawan',$karyawan->id, ($pejabatcuti==$karyawan->id));?>><?=$karyawan->nama; ?></option>
      <?php } ?>            </select>
        </div>
        <div class="col-xs-6">
        Server : 
                            <input name="server" type="text" class="form-control" id="server" value="<?=isset($server)?$server:'';?>" placeholder="Server...."/>
        <!-- small box --></div>
      <!-- ./col -->
    </div>
    </div>
<hr />
<div class="box-footer clearfix">
                    <button class="pull-left btn btn-default" id="save">Simpan <i class="fa fa-save"></i></button>
                </div>

        <!-- ./col -->
        </div>
        </form>
        </div>
        
        
</section>
<!-- /.content -->


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
<script type="text/javascript">
$(function () {
    $('.select2').select2();
});
</script>


<?php
$this->load->view('template/foot');
?>