@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            /**
             * Set to not selected
             * @returns {undefined}
             */
            jQuery('#selectBiaya').val([]);
            /**
             * Set tahun ajaran aktif
             */
            function setTahunAjaranAktif(){
                var tahunaktif_id = "{{ $tahunaktif->id }}";
                jQuery('#selectTahun option[value=' + tahunaktif_id + ']').css('background-color','green');
                jQuery('#selectTahun option[value=' + tahunaktif_id + ']').css('color','white');
            }
            setTahunAjaranAktif();
            /**
             * Fungsi format rupiah untuk class uang 
             */
             function formatToRupiah(){
                jQuery('.uang').each(function(){
                    var uang = jQuery(this).text();
                    uang = jQuery.trim(uang);
                    uang = formatRupiahVal(uang);
                    uang  = uang.replace('Rp. ','');
                    uang  = uang.replace('(','- ');
                    uang  = uang.replace(')','');
                    jQuery(this).text(uang);
                });
             }
             /**
              * Cetak Rekapitulasi
              */
             jQuery('.btn-cetak').click(function(){
                  var tahunajaran_id = jQuery('#selectTahun').attr('value');
                    var jenisbiaya_id = jQuery('#selectBiaya').attr('value');
                    var tanggal = jQuery('#selectBulan').attr('value');
                    var detil = jQuery('#checkDetil').attr('checked');
                    var isDetil = false;
                    if(detil == 'checked'){
                        isDetil = 'true';
                    }
                    
                    if(tahunajaran_id != '' && jenisbiaya_id != '' && tanggal != ''){
                        var loadUrl = "{{ URL::to('rekap/iuranbulanan/printtopdf') }}" + "/" + tahunajaran_id + "/" + jenisbiaya_id + "/" + tanggal + "/" + isDetil;
                        window.location.href = loadUrl;
                    }else{
                        showMessage('PERINGATAN','Lengkapi data yang masih kosong');
                    }
             })
             /**
              * buttonTampil click event
              */
             jQuery('#buttonTampil').click(function(){
                //tampilkan table rekap
                    var tahunajaran_id = jQuery('#selectTahun').attr('value');
                    var jenisbiaya_id = jQuery('#selectBiaya').attr('value');
                    var tanggal = jQuery('#selectBulan').attr('value');
                    var detil = jQuery('#checkDetil').attr('checked');
                    var isDetil = false;
                    if(detil == 'checked'){
                        isDetil = 'true';
                    }
                    
                    if(tahunajaran_id != '' && jenisbiaya_id != '' && tanggal != ''){
                        jQuery.ajaxSetup ({cache: false});
                        var loadUrl = "{{ URL::to('rekap/iuranbulanan/ajaxtabel') }}" + "/" + tahunajaran_id + "/" + jenisbiaya_id + "/" + tanggal + "/" + isDetil;
//                        alert(loadUrl);
                        //tampilkan tabel rekapitulasi
//                        jQuery('#tabelrekap').load(loadUrl,function(){
//                            //format rupiah
//                            formatToRupiah();
//                        });
                        jQuery('#tabelrekap').load(loadUrl,function(){
                                    formatToRupiah();
                            });
                    }else{
                        showMessage('PERINGATAN','Lengkapi data yang masih kosong');
                    }
             });
             /**
              * buttonPrint event clicked
              * Printe data ke file PDF
              */
             jQuery('.buttonPrint').click(function(){
                    var tahunajaran_id = jQuery('#selectTahun').attr('value');
                    var jenisbiaya_id = jQuery('#selectBiaya').attr('value');
                    var tanggal = jQuery('#selectBulan').attr('value');
                    var detil = jQuery('#checkDetil').attr('checked');
                    var isDetil = false;
                    if(detil == 'checked'){
                        isDetil = 'true';
                    }
                    var loadUrl = "{{ URL::to('rekap/iuranbulanan/printtopdf') }}" + "/" + tahunajaran_id + "/" + jenisbiaya_id + "/" + tanggal + "/" + isDetil;
                    
//                    jQuery(this).attr('href',"{{URL::to('rekap/tahunan/printtopdf')}}"+"/"+tahunajaran_id);
                    //redirect
                    window.location.href = loadUrl;
                    
                return false;
             });
             
        });
    </script>
@endsection

@section('custom_style')
    <style type="text/css">
        table td{
            vertical-align: middle;
            padding: 5px;
        }
        table td input{
            vertical-align: middle!important;
            margin:0!important;
        }
    </style>
@endsection


<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Dashboard</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">Rekapitulasi Iuran Bulanan</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable ui-sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title="">
            <h2><i class="icon-th"></i> Rekapitulasi Iuran Bulanan</h2>
            <div class="box-icon">
                <!--<a href="#" class="btn buttonPrint"><i class="icon-print"></i></a>-->
            </div>
        </div>
        <div class="box-content">
            <fieldset>
                <table>
                    <tbody>
                        <tr>
                            <td>Tahun Ajaran</td>
                            <td>{{\Laravel\Form::select('tahunajaran', $tahunajaranselect,(isset($tahunaktif) ? $tahunaktif->id : null),array('id'=>'selectTahun','style'=>'width:125px;margin:0;'))}}</td>
                            <td>Bulan</td>
                            <td>{{\Laravel\Form::text('bulan',null,array('id'=>'selectBulan','class' => 'input-medium bulandatepicker','placeholder' => 'Pilih sembarang tanggal'))}}</td>
                            <td>Jenis Biaya</td>
                            <td>{{\Laravel\Form::select('jenisbiaya', $selectbiaya,null,array('id'=>'selectBiaya','style'=>'width:125px;margin:0;'))}}</td>
                            <td><?php echo \Laravel\Form::checkbox('detil', 1,FALSE,array('id' => 'checkDetil')); ?>&nbsp;Tampilkan detil per transaksi</td>
                            <td>
                                <a href="#" class="btn btn-primary" id="buttonTampil">Tampilkan</a>
                                <a href="#" class="btn btn-success btn-cetak">Cetak</a>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
            <br/>
            <div id="tabelrekap">

            </div>
        </div>
    </div><!--/span-->
</div>
