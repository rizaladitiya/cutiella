
<?php 
$sess = getsession();
$nama = $sess->nama;
$user = $sess->user;
$email = $sess->email;
?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url('assets/AdminLTE-2.0.5/dist/img/avatar2.png') ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p><?=$nama;?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form --><!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
            <li class="header">Navigasi</li>
            <li>
                <a href="<?php echo site_url('admin') ?>">
                    <i class="fa fa-circle-o"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview <?=$this->uri->segment('1')=="izin"?'active':'';?>">
                <a href="#">
                    <i class="fa fa-calendar" ></i> <span>Surat Izin</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                	<li class="<?=$this->uri->segment('2')=="add"?'active':'';?>"><a href="<?php echo site_url('izin/add') ?>"><i class="fa fa-plus"></i> Add</a></li>
                    <li class="<?=$this->uri->segment('2')==""?'active':'';?>"><a href="<?php echo site_url('izin') ?>"><i class="fa fa-search"></i> View</a></li>
                    <li class="<?=$this->uri->segment('2')=="report"?'active':'';?>"><a href="<?php echo site_url('izin/report') ?>"><i class="fa fa-envelope"></i> Report</a></li>
                    
                </ul>
            </li>
            <li class="treeview <?=$this->uri->segment('1')=="cuti"?'active':'';?>">
                <a href="#">
                    <i class="fa fa-calendar" ></i> <span>Surat Cuti</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                	<li class="<?=$this->uri->segment('2')=="add"?'active':'';?>"><a href="<?php echo site_url('cuti/add') ?>"><i class="fa fa-plus"></i> Add</a></li>
                    <li class="<?=$this->uri->segment('2')==""?'active':'';?>"><a href="<?php echo site_url('cuti') ?>"><i class="fa fa-search"></i> View</a></li>
                    <li class="<?=$this->uri->segment('2')=="report"?'active':'';?>"><a href="<?php echo site_url('cuti/report') ?>"><i class="fa fa-envelope"></i> Report</a></li>
                    
                </ul>
            </li>
            <li class="treeview <?=$this->uri->segment('1')=="tidakmasuk"?'active':'';?>">
                <a href="#">
                    <i class="fa fa-calendar" ></i> <span>Surat Tidak Masuk</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                	<li class="<?=$this->uri->segment('2')=="add"?'active':'';?>"><a href="<?php echo site_url('tidakmasuk/add') ?>"><i class="fa fa-plus"></i> Add</a></li>
                    <li class="<?=$this->uri->segment('2')==""?'active':'';?>"><a href="<?php echo site_url('tidakmasuk') ?>"><i class="fa fa-search"></i> View</a></li>
                    <li class="<?=$this->uri->segment('2')=="report"?'active':'';?>"><a href="<?php echo site_url('tidakmasuk/report') ?>"><i class="fa fa-envelope"></i> Report</a></li>
                </ul>
            </li>
</ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">