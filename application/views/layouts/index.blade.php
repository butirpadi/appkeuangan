<!DOCTYPE html>
<html lang="en">
<head>
	<!--
		Charisma v1.0.0

		Copyright 2012 Muhammad Usman
		Licensed under the Apache License v2.0
		http://www.apache.org/licenses/LICENSE-2.0

		http://usman.it
		http://twitter.com/halalit_usman
	-->
	<base href="<?php echo URL::base() ?>/">
	<meta charset="utf-8">
	<title>{{ $web_title }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
	<meta name="author" content="Muhammad Usman">

	<!-- The styles -->
	<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
	
	<style type="text/css">
            /*@font-face { font-family: Museo; font-weight: 100; src:url('../fonts/MuseoSans-100.otf'); }*/
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>
	<?php echo Asset::container('header')->styles() ?>
        
        @yield('custom_style')

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="img/favicon.ico">
		
</head>

<body>
	<!-- topbar starts -->
        <div class="navbar">
		<div class="navbar-inner">
                    <div class="container-fluid " style="padding-left: 0;">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
                            <a class="brand" href="{{ URL::to('home') }}" style=""> 
                                <div class="row-fluid sortable" >
                                    <div >
                                        <img alt="Charisma Logo"  src="img/logo.png" style="width: 35%;height: 35%;background-color: #f2fafd;padding: 5px;-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);"> 
                                    </div>
                                    <div class="span4" style="font-family: 'ditedregular';text-shadow: none;">
                                        <span style="min-width: 800px;font-size: 20px!important;">{{ $app_name }}</span>
                                        <span style="width: 500px;font-size: 16px!important; margin-top: 15px;">{{ $syssetting->nama_skul }}</span>
                                        <span style="width: 800px;font-size: 12px!important; margin-top: 5px;">{{ $syssetting->alamat_skul }}</span>
                                    </div>
                                    
                                </div>                                
                            </a>
                        <div class="pull-right" id="jam"></div>				
			</div>
		</div>
<!--            <div style="width: 100%;min-height: 20px;background-color: #404040;">
                <span style="font-size: 14px!important; color: yellow; font-family: 'ditedregular'; ">Mencetak Generasi Aktif, Kreatif, Inovatif dan Berakhlak Mulia</span>
            </div>-->
            <div style="width: 100%;min-height: 40px;background-color: #054a8f;" class="top-menu" >
                @if($user)
                <div class="btn-group pull-left ">
                    <a class="btn "  href="{{ URL::to('home') }}" >
                            <i class="icon-home"></i><span class="hidden-phone"> Home</span>
                    </a>
                </div>
                <!--pengaturan dasar-->
                <div class="btn-group pull-left ">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" >
                                <i class="icon-cog"></i><span class="hidden-phone"> Pengaturan Dasar</span>
                                <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" >
                            @if($user->can('manage_tahun_ajaran'))
                                <li><a data-value="cerulean" href="setting/tahunajaran"><i class="icon-calendar"></i> Tahun Ajaran</a></li>
                            @endif
<!--                            @if($user->can('manage_bulan'))
                                <li><a data-value="cyborg" href="setting/bukuspp"><i class="icon-book"></i> Pengaturan Bulan</a></li>
                            @endif-->
                            @if($user->can('manage_rombel'))
                                <li><a data-value="cyborg" href="setting/rombel"><i class="icon-th-large"></i> Rombongan Belajar</a></li>
                            @endif
                            @if($user->can('manage_biaya'))
                                <li><a data-value="cyborg" href="setting/biaya"><i class="icon-list-alt"></i> Biaya</a></li>
                            @endif
                            @if($user->can('manage_biaya'))
                                <li><a data-value="cyborg" href="setting/setbiaya"><i class="icon-list"></i> Pengaturan Biaya</a></li>
                            @endif
                            @if($user->can('manage_target_pencapaian'))
                                <li><a data-value="cyborg" href="setting/target"><i class="icon-random"></i> Target Pencapaian Pendapatan</a></li>
                            @endif
                            @if($user->can('manage_siswa'))
                                <li><a data-value="cyborg" href="setting/siswa"><i class="icon icon-darkgray icon-contacts"></i> Data Siswa</a></li>
                                <li><a data-value="cyborg" href="setting/kenaikan"><i class="icon-signal"></i> Kenaikan Siswa</a></li>
                            @endif
                            @if($user->can('manage_beasiswa'))
                                <li><a data-value="cyborg" href="setting/potongan"><i class="icon icon-darkgray icon-flag"></i> Beasiswa & Bantuan</a></li>
                            @endif
                            @if($user->can('manage_penyesuaian_spp'))
                                <li><a data-value="cyborg" href="setting/penyesuaian"><i class="icon-refresh "></i> Penyesuaian Nilai SPP</a></li>
                            @endif
                            <li class="divider"></li>
                            @if($user->can('manage_user'))
                                <li><a data-value="classic" href="setting/user"><i class="icon-user"></i> User</a></li>
                            @endif
                            @if($user->can('manage_user_group'))
                                <li><a data-value="classic" href="setting/role"><i class="icon icon-darkgray icon-users"></i> User Group</a></li>
                            @endif
                            @if($user->can('manage_system_setting'))
                                <li><a data-value="cyborg" href="setting/sysconf"><i class="icon-cog"></i> System Setting</a></li>
                            @endif
                        </ul>
                </div>
                
                <div class="btn-group pull-left ">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" >
                                <i class="icon-retweet"></i><span class="hidden-phone"> Transaksi</span>
                                <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" >
                            @if($user->can('manage_transaksi_penerimaan_iuran'))
                                <!--<li><a data-value="classic" href="{{ URL::to('transaksi/iuran') }}"><i class="icon-share-alt"></i> Penerimaan Iuran Siswa</a></li>-->
                                <li><a data-value="classic" href="{{ URL::to('transaksi/bayariuran') }}"><i class="icon-share-alt"></i> Penerimaan Iuran</a></li>
                            @endif
                            @if($user->can('manage_transaksi_penerimaan'))
                                <li><a data-value="classic" href="{{ URL::to('transaksi/penerimaan') }}"><i class="icon-share-alt"></i> Penerimaan</a></li>
                            @endif
                            @if($user->can('manage_transaksi_pengeluaran'))
                                <li><a data-value="classic" href="{{ URL::to('transaksi/pengeluaran') }}"><i class="icon-share-alt"></i> Pengeluaran</a></li>
                            @endif
                            @if($user->can('manage_histori_transaksi'))
                                <li><a data-value="classic" href="{{ URL::to('transaksi/histori') }}"><i class="icon-share-alt"></i> Histori Transaksi</a></li>
                            @endif
                            @if($user->can('manage_mutasi_kas'))
                                <li><a data-value="classic" href="{{ URL::to('transaksi/mutasi') }}"><i class="icon-share-alt"></i> Mutasi Kas</a></li>
                            @endif
                        </ul>
                </div>
                
                <div class="btn-group pull-left ">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" >
                                <i class="icon-th"></i><span class="hidden-phone"> Rekapitulasi</span>
                                <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" >
                            @if($user->can('manage_rekapitulasi_transaksi'))
                                <li><a data-value="classic" href="{{ URL::to('rekap/transaksi') }}"><i class="icon-th"></i> Rekapitulasi Transaksi</a></li>
                            @endif
                            @if($user->can('manage_rekapitulasi_bulanan'))
                                <li><a data-value="classic" href="{{ URL::to('rekap/iuranbulanan') }}"><i class="icon-th"></i> Rekapitulasi Iuran Bulanan</a></li>
                            @endif
                            @if($user->can('manage_rekapitulasi_tahunan'))
                                <li><a data-value="classic" href="{{ URL::to('rekap/bulanan') }}"><i class="icon-th"></i> Rekapitulasi Keuangan Bulanan</a></li>
                            @endif
                            @if($user->can('manage_rekap_siswa'))
                                <li><a data-value="classic" href="{{ URL::to('rekap/rekapsiswa') }}"><i class="icon-th"></i> Rekapitulasi Transaksi Siswa</a></li>
                            @endif
                            @if($user->can('manage_rekapitulasi_iuran'))
                                <li><a data-value="classic" href="{{ URL::to('rekap/iurantahunan') }}"><i class="icon-th"></i> Rekapitulasi Iuran Bulanan Per Tahun Ajaran</a></li>
                            @endif                            
                            @if($user->can('manage_rekapitulasi_tahunan'))
                                <li><a data-value="classic" href="{{ URL::to('rekap/tahunan') }}"><i class="icon-th"></i> Rekapitulasi Keuangan Tahunan</a></li>
                            @endif
                                <li><a data-value="classic" href="{{ URL::to('rekap/iuranpertapel') }}"><i class="icon-th"></i> Rekapitulasi Iuran Per Tahun Ajaran</a></li>
                        </ul>
                </div>
                <div class="btn-group pull-left ">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" >
                                <i class="icon-folder-open"></i><span class="hidden-phone"> Data Rekapitulasi</span>
                                <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" >
                                <li><a data-value="classic" href="{{ URL::to('datarekap/rekapharian') }}"><i class="icon-file"></i> Transaksi Harian</a></li>
                                <li><a data-value="classic" href="{{ URL::to('datarekap/rekapbulanan') }}"><i class="icon-file"></i> Transaksi Bulanan</a></li>
                        </ul>
                </div>
                <div class="btn-group pull-left ">
                    <a class="btn btn-dev" id="btnAbout" href="#" >
                            <i class="icon-thumbs-up"></i><span class="hidden-phone"> Info Pengembang</span>
                    </a>
                </div>
                
                <!-- user dropdown starts -->
                <div class="btn-group pull-right" >
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="icon-user"></i><span class="hidden-phone"> {{ ($user->name != '' ? $user->name : $user->username) }}</span>
                                <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                                <li><a href="{{ URL::to('setting/profiler') }}">Profile</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ URL::to('login/logout') }}">Logout</a></li>
                        </ul>
                </div>
                @endif
            </div>
	</div>
	<!-- topbar ends -->
<!--        <div class="clear "></div>
        <br/>-->
	<div class="container-fluid">
		<div class="row-fluid">
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
                        <div id="content" class="span12" style="margin:0;">
                            <!-- content starts -->
                            <?php
                            // Our view content
                            echo $content;
                            ?>

                            <!-- content ends -->
			</div><!--/#content.span10-->
			
		</div><!--/fluid-row-->
		
		<hr>

		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
				<p>Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>
                
                <div class="modal hide fade" id="myModalDev">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Info Pengembang</h3>
			</div>
			<div class="modal-body">
                            <p class="center">
                                {{ \Laravel\HTML::image('img/lomed.png','Logikamedia',array('style'=>'width:25%;')) }}
                            </p>
                            <table class="table table-condensed">
                                  <tbody>
                                        <tr>
                                            <td>Produk</td>
                                            <td class="center">
                                                <p style="margin: 0;">SIMAS-ad [ Sistem Administrasi Keuangan ]</p>
                                                <p style="margin: 0;">Hak pakai untuk SDI Sabilil Huda Sumorame-Candi</p>
                                            </td>
                                        </tr>
<!--                                        <tr>
                                            <td>Alamat Pengembang</td>
                                            <td class="center">
                                                <p style="margin: 0;">Ngaban RT 05 RW 02 No. 15, Tanggulangin, Sidoarjo</p>
                                                <p style="margin: 0;">Jawa Timur, Indonesia</p>
                                            </td>
                                        </tr>-->
                                        <tr>
                                            <td>Contact Person</td>
                                            <td class="center">
                                                <p style="margin: 0;"><b>Eries Hermanto, S.Kom</b></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Telepon</td>
                                            <td class="center">
                                                <p style="margin: 0;"><strong style="font-size: 1.5em;color:orangered;">081-357-359-019<strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Produk lain</td>
                                            <td class="center">
                                                <p style="margin: 0;">Web Site, Sistem Akademik (sekolah,universitas),</p>
                                                <p style="margin: 0;">Sistem Rumah Sakit (SIMRS),Sistem Puskesmas (SIMPUS),</p>
                                                <p style="margin: 0;">dan Sistem Informasi Lainnya</p>
                                                
                                            </td>
                                        </tr>
                                  </tbody>
                         </table>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
			</div>
		</div>

		<footer>
			<p class="pull-left"> SIMAS-ad &copy; <a href="#" target="_blank">SDI Sabilil Huda</a> 2013</p>
                        <p class="pull-right">Deveoped by: <a href="#" class="btn-dev">Logikamedia</a></p>
		</footer>
                <footer>
                    <p class="pull-right">Powered by: <a href="http://usman.it/free-responsive-admin-template">Charisma</a></p>
                </footer>

	</div><!--/.fluid-container-->
        
        <!--DIALOG MODAL-->
        <div class="modal hide fade" id="modal-dialog">
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h3 class="modal-title">Peringatan</h3>
                </div>
                <div class="modal-body">
                    <p class="modal-message">Here settings can be configured...</p>
                    <div id="modal-custom-message" ></div>
                </div>
                <div class="modal-footer">
                        <a href="#" class="btn" data-dismiss="modal">OK</a>
                        <!--<a href="#" class="btn btn-primary">OK</a>-->
                </div>
        </div>

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<?php echo Asset::container('footer')->scripts() ?>
	
        @yield('custom_script')
        
        <script type="text/javascript">
            jQuery(document).ready(function(){
               //setting jam
               var options2 = {format: '%A, %d %B %Y [%H:%M:%S]' };
               var jamLengkap = {format: '<div class="clock light"><p id="jamnya" data-date="%d %B %Y" data-ampm="{{ "TA : " . ( isset($tahunaktif->nama) ? $tahunaktif->nama : "TIDAK TERSEDIA")}}" >%H:%M:%S</p></div>' };
               var jamTok = {format: '%H:%M:%S' };
               var tanggalTok = {format: '%A, %d %B %Y' };
               jQuery('#jam').jclock(jamLengkap);   
               
            });
            
            function showMessage($title,$message){
                jQuery('.modal-title').text($title);
                jQuery('.modal-message').text($message);
                jQuery('#modal-dialog').modal('show');
             }
        </script>
</body>
</html>
