@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
           jQuery('#buttonOCT').click(function  (){
               //set custom message content
               jQuery.ajaxSetup ({cache: false});
                var nisn = jQuery('input[name=nisn]').attr('value');
                var loadUrl = "{{ URL::to('rekap/iurantahunan/ajxhistotranssiswa') }}" + "/" + nisn;
                //tampilkan tabel rekapitulasi ke dalam modal message
                jQuery('#modal-custom-message').load(loadUrl);
                                
               showMessage('Info Pembayaran Siswa','');
               return false;
           })
        });
    </script>
@endsection

<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="#">Home</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable">
    <div class="box span8">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon-home"></i> Home</h2>
                        <div class="box-icon">
                                <!--<a href="#" class="btn btn-setting "><i class="icon icon-darkgray icon-help"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    <div class="row-fluid">
                        <div class="span6">
                            <legend>Application Tiles</legend>
                        </div>
                        <div class="span6">
                            <div class="pull-right" >
                                {{Form::open()}}
                                <div class="input-append pull-left" style="margin-right: 5px;">
                                    Cek pembayaran siswa : <?php echo Laravel\Form::text('nisn', null, array('class'=>'input-small','autocomplete'=>'off','autofocus','placeholder'=>'Nomor Induk')); ?><button class="btn btn-primary" id="buttonOCT"><i class="icon-white icon-search"></i></button>
                                </div>
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>

                    <div class="row-fluid" >
                        @if($user)
                            <ul class="widgeticons">
                                @if($user->can('manage_transaksi_penerimaan_iuran'))
                                    <li class="one_fifth"><a href="{{ URL::to('transaksi/bayariuran') }}"><img style="width: 64px;height: 64px;" src="img/gemicon/transactions.png" alt="" class=""><span>Iuran Siswa</span></a></li>
                                @endif
                                @if($user->can('manage_transaksi_penerimaan'))
                                    <li class="one_fifth"><a href="{{ URL::to('transaksi/penerimaan') }}"><img style="width: 64px;height: 64px;" src="img/gemicon/receive.png" alt=""><span>Penerimaan</span></a></li> 
                                @endif
                                @if($user->can('manage_transaksi_pengeluaran'))
                                    <li class="one_fifth"><a href="{{ URL::to('transaksi/pengeluaran') }}"><img style="width: 64px;height: 64px;" src="img/gemicon/box_out.png" alt=""><span>Pengeluaran</span></a></li> 
                                @endif
                                @if($user->can('manage_mutasi_kas'))
                                    <li class="one_fifth"><a href="{{ URL::to('transaksi/mutasi') }}"><img style="width: 64px;height: 64px;" src="img/gemicon/mutasi.png" alt=""><span>Mutasi Kas</span></a></li> 
                                @endif
                                @if($user->can('manage_rekapitulasi_transaksi'))
                                    <li class="one_fifth"><a href="{{ URL::to('rekap/transaksi') }}"><img style="width: 64px;height: 64px;" src="img/gemicon/tables.png" alt=""><span>Rek. Transaksi</span></a></li> 
                                @endif
                                @if($user->can('manage_rekapitulasi_iuran'))
                                    <li class="one_fifth"><a href="{{ URL::to('rekap/iurantahunan') }}"><img style="width: 64px;height: 64px;" src="img/gemicon/report.png" alt=""><span>Rek. Iuran/Thn</span></a></li> 
                                @endif
                                @if($user->can('manage_rekapitulasi_bulanan'))
                                    <li class="one_fifth"><a href="{{ URL::to('rekap/iuranbulanan') }}"><img style="width: 64px;height: 64px;" src="img/gemicon/reports2.png" alt=""><span>Rek. Iuran/Bulan</span></a></li> 
                                @endif
                                @if($user->can('manage_rekapitulasi_tahunan'))
                                    <li class="one_fifth"><a href="{{ URL::to('rekap/tahunan') }}"><img style="width: 64px;height: 64px;" src="img/gemicon/laporan.png" alt=""><span>Rek. Tahunan</span></a></li> 
                                @endif
                                @if($user->can('manage_siswa'))
                                    <li class="one_fifth"><a href="{{ URL::to('setting/siswa') }}"><img style="width: 64px;height: 64px;" src="img/gemicon/elementary_school.png" alt=""><span>Data Siswa</span></a></li> 
                                @endif
                                @if($user->can('manage_kenaikan_siswa'))
                                    <li class="one_fifth"><a href="{{ URL::to('setting/kenaikan') }}"><img style="width: 64px;height: 64px;" src="img/gemicon/kenaikan.png" alt=""><span>Kenaikan Kelas</span></a></li> 
                                @endif
                                <!--user profile-->
                                    <li class="one_fifth"><a href="{{ URL::to('setting/profiler') }}"><img style="width: 64px;height: 64px;" src="img/gemicon/users-profile.png" alt=""><span>My Profile</span></a></li> 
                                
                                @if($user->can('manage_user'))
                                    <li class="one_fifth"><a href="{{ URL::to('setting/user') }}"><img style="width: 64px;height: 64px;" src="img/gemicon/user.png" alt=""><span>User</span></a></li> 
                                @endif
                                @if($user->can('manage_system_setting'))
                                    <li class="one_fifth"><a href="{{ URL::to('setting/sysconf') }}"><img style="width: 64px;height: 64px;" src="img/gemicon/Setting.png" alt=""><span>System Config</span></a></li> 
                                @endif
                                @if(strtolower($user->username) == 'eries')
                                    <li class="one_fifth"><a href="{{ URL::to('setting/adconf') }}"><img style="width: 64px;height: 64px;" src="img/gemicon/iEngrenages.png" alt=""><span>Admin Config</span></a></li> 
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
        </div><!--/span-->
        
        <div class="box span4">
        <div class="box-header well" data-original-title>
                <h2><i class="icon-list-alt"></i> Transaksi Monitor</h2>
                
                <div class="btn-group pull-right " style="font-size: small;">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" >
                            <span class="hidden-phone">Input Transaksi</span>
                            <span class="caret"></span>
                    </a>
                        <ul class="dropdown-menu" >
                            <li><a href="{{ URL::to('transaksi/bayariuran') }}">Transaksi Iuran</a></li>
                                <li><a href="{{ URL::to('transaksi/penerimaan') }}">Penerimaan</a></li>
                                <li><a href="{{ URL::to('transaksi/pengeluaran') }}">Pengeluaran</a></li>
                        </ul>
                </div>
        </div>
        <div class="box-content">
            <div class="row-fluid">
                <table class="table table-striped table-bordered datatableHome">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Arus</th>
                            <th>Siswa</th>
                            <th>Tot (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $rownum=1; ?>
                        @foreach($trans as $tr)
                        <tr>
                            <td>{{ $rownum++ }}</td>
                            <td style="text-align: center;">
                                @if($tr->arus == 'M')
                                  <span class="label label-success">PENERIMAAN</span>
                                @elseif($tr->arus == 'K')
                                  <span class="label label-warning">PENGELUARAN</span>
                                @endif
                            </td>
                            <td>
                                @if($tr->siswa)
                                  {{ $tr->siswa->nama }}
                                @else
                                  -
                                @endif
                            </td>
                            <td class="uang" style="text-align: right;" >
                                <?php $total = 0;?>
                                @foreach($tr->detiltransmasuks as $det)
                                  <?php $total += $det->jumlah; ?>
                                @endforeach
                                <?php echo number_format($total, 0, ',', '.') ?>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!--/row-->