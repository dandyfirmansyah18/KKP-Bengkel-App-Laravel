<?php
use Illuminate\Support\Facades\DB;
use App\WebMenuModel;
use App\UserModel;
use App\WebRoleMenuModel;
?>

<script type="text/javascript">
  var base_url = window.location.origin;
</script>

    <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ URL::asset('/AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Session::get('username')}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="#" onclick="call('<?= url('home'); ?>','_content_')"><i class="fa fa-home"></i> <span>Home</span></a></li>
        @if(Session::get('jabatan') == 'SA' || Session::get('jabatan') == 'SUPER')
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#" onclick="call('<?= url('listkaryawan'); ?>','_content_')"><i class="fa fa-circle-o"></i> <span>Data Karyawan</span></a></li>
            <li><a href="#" onclick="call('<?= url('listcus'); ?>','_content_')"><i class="fa fa-circle-o"></i> <span>Data Pelanggan</span></a></li>
            <li><a href="#" onclick="call('<?= url('listbarang'); ?>','_content_')"><i class="fa fa-circle-o"></i> <span>Data Barang</span></a></li>
          </ul>
        </li>
        @endif
        @if(Session::get('jabatan') != 'Admin' || Session::get('jabatan') == 'SUPER')
        <li class="treeview">
          <a href="#">
            <i class="fa fa-suitcase"></i>
            <span>Transaksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if(Session::get('jabatan') == 'SA' || Session::get('jabatan') == 'SUPER')
            <li><a href="#" onclick="call('<?= url('listspk'); ?>','_content_')"><i class="fa fa-circle-o"></i> <span>Surat Perintah Kerja</span></a></li>
            @endif
            @if(Session::get('jabatan') == 'Mekanik' || Session::get('jabatan') == 'SUPER')
            <li><a href="#" onclick="call('<?= url('listbap'); ?>','_content_')"><i class="fa fa-circle-o"></i> <span>Berita Acara Pekerjaan</span></a></li>
            @endif
            @if(Session::get('jabatan') == 'Kasir' || Session::get('jabatan') == 'SUPER')
            <li><a href="#" onclick="call('<?= url('listkwitansi'); ?>','_content_')"><i class="fa fa-circle-o"></i> <span>Kwitansi</span></a></li>
            <li><a href="#" onclick="call('<?= url('listgaransi'); ?>','_content_')"><i class="fa fa-circle-o"></i> <span>Klaim Garansi</span></a></li>
            @endif
          </ul>
        </li>
        @endif
        @if(Session::get('jabatan') == 'Admin' || Session::get('jabatan') == 'SUPER')
        <li class="treeview">
          <a href="#">
            <i class="fa fa-sticky-note"></i>
            <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#" onclick="call('<?= url('lapspk'); ?>','_content_')"><i class="fa fa-circle-o"></i> <span>Surat Perintah Kerja</span></a></li>
            <li><a href="#" onclick="call('<?= url('lapbap'); ?>','_content_')"><i class="fa fa-circle-o"></i> <span>Berita Acara Pekerjaan</span></a></li>
            <li><a href="#" onclick="call('<?= url('lapkwitansi'); ?>','_content_')"><i class="fa fa-circle-o"></i> <span>Kwitansi</span></a></li>
            <li><a href="#" onclick="call('<?= url('lapgaransi'); ?>','_content_')"><i class="fa fa-circle-o"></i> <span>Klaim Garansi</span></a></li>
            <li><a href="#" onclick="call('<?= url('laprekapservice'); ?>','_content_')"><i class="fa fa-circle-o"></i> <span>Rekapitulasi Service</span></a></li>
          </ul>
        </li>
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
