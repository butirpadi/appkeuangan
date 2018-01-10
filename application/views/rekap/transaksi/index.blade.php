@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
                    /**
                     * select to not selected
                     * Disable filter input
                     */
                    jQuery('select[name=selectArus]').val([]);
                    jQuery('select[name=selectBiaya]').val([]);
                    jQuery('select.form-filter').attr('disabled','disabled');
                    jQuery('input.form-filter').attr('readonly','readonly');
                    jQuery('button.form-filter').attr('disabled','disabled');
                    
                    /**
                     * Tampilkan data rekap
                     */
                    jQuery('button[name=tampil]').click(function(){
                            var tahunajaranId = jQuery('select[name=tahunajaran]').val();
                            var awal = jQuery('input[name=tanggal]').val();
                            var akhir = jQuery('input[name=tanggalAkhir]').val();
                            
                            if (awal == '' || akhir == '' || tahunajaranId == ''){
                                showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
                            }else if(Date.parse(akhir) < Date.parse(awal)){
                                showMessage('PERINGATAN','Data tanggal tidak valid.');
                            }else{

                                var isDetil = jQuery('.opsi-detil').is(':checked');
                                if(isDetil){
                                         //tampilkan table rekap
                                          jQuery.ajaxSetup ({cache: false});
                                          var loadUrl = "{{ URL::to('rekap/transaksi/ajaxtabelrekap') }}" + "/" + tahunajaranId + "/" + awal + "/" + akhir;

                                          //tampilkan tabel rekapitulasi
                                          jQuery('#formTabelRekap').load(loadUrl);
//                                          jQuery('#formTabelRekap').load(loadUrl,function(){
//                                              //format rupiah
//                                              formatToRupiah();
//                                          });
                                          jQuery('#tabelrekapitulasi').show();
                                }else{
                                         //tampilkan table rekap
                                          jQuery.ajaxSetup ({cache: false});
                                          var loadUrl = "{{ URL::to('rekap/transaksi/ajaxrekap') }}" + "/" + tahunajaranId + "/" + awal + "/" + akhir;

                                          //tampilkan tabel rekapitulasi
//                                          jQuery('#formTabelRekap').load(loadUrl,function(){
//                                              //format rupiah
//                                              formatToRupiah();
//                                          });
                                          jQuery('#formTabelRekap').load(loadUrl);
                                          jQuery('#tabelrekapitulasi').show();
                                };
                                
                                //enablekan filter
                                jQuery('select.form-filter').removeAttr('disabled');
                                jQuery('input.form-filter').removeAttr('readonly');
                                jQuery('button.form-filter').removeAttr('disabled');
                                //disablekan input
                                jQuery('select[name=tahunajaran]').attr('disabled','disabled');
                                jQuery('input[name=tanggal]').attr('readonly','readonly');
                                jQuery('input[name=tanggalAkhir]').attr('readonly','readonly');
                                jQuery('input[name=opsi]').attr('disabled','disabled');
                                jQuery('button[name=tampil]').attr('disabled','disabled');
                                
                            }
                    });
                    /**
                     * Radio button change
                     */
                     jQuery('input[name=opsi]').change(function(){
                        var radioVal = jQuery(this).val();
                        
                        if(radioVal==2){
                            //sembunyikan form filter
                            jQuery('.table-filter').hide();
                        }else{
                            jQuery('.table-filter').show();
                        }
                     });
                     /**
                      * Filter By Arus
                      */
                     jQuery('.btn-filter-arus').click(function(){
                            var tahunajaranId = jQuery('select[name=tahunajaran]').val();
                            var awal = jQuery('input[name=tanggal]').val();
                            var akhir = jQuery('input[name=tanggalAkhir]').val();
                            var arusVal = jQuery('select[name=selectArus]').val();
                            
                            if(arusVal != null){
                                    var loadUrl = "{{ URL::to('rekap/transaksi/ajaxtabelrekapfilterarus') }}" + "/" + tahunajaranId + "/" + awal + "/" + akhir + "/" + arusVal;
                                    //tampilkan tabel rekapitulasi
                                    jQuery('#formTabelRekap').load(loadUrl);
//                                    jQuery('#formTabelRekap').load(loadUrl,function(){
//                                        //format rupiah
//                                        formatToRupiah();
//                                    });
                            }else{
                                showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
                            }
                     });
                     /**
                      * Filter By Biaya
                      */
                     jQuery('.btn-filter-biaya').click(function(){
                            var tahunajaranId = jQuery('select[name=tahunajaran]').val();
                            var awal = jQuery('input[name=tanggal]').val();
                            var akhir = jQuery('input[name=tanggalAkhir]').val();
                            var biayaId = jQuery('select[name=selectBiaya]').val();
                            
                            if(biayaId != null){
                                var loadUrl = "{{ URL::to('rekap/transaksi/ajaxtabelrekapfilterbiaya') }}" + "/" + tahunajaranId + "/" + awal + "/" + akhir + "/" + biayaId;
                                //tampilkan tabel rekapitulasi
                                jQuery('#formTabelRekap').load(loadUrl);
//                                jQuery('#formTabelRekap').load(loadUrl,function(){
//                                    //format rupiah
//                                    formatToRupiah();
//                                });
                            }else{
                                showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
                            }
                     });
                     /**
                      * Reset at select change
                      */
                     jQuery('select[name=selectArus]').change(function(){
                            //reset biaya
                            jQuery('select[name=selectBiaya]').val([]);
                            //empty
                            jQuery('#formTabelRekap').empty();
                     });
                     jQuery('select[name=selectBiaya]').change(function(){
                            //reset arus
                            jQuery('select[name=selectArus]').val([]);
                            //empty
                            jQuery('#formTabelRekap').empty();
                     });
                     /**
                      * Cetak Print No Filter
                      */
                     jQuery('.btn-cetak-no-filter').click(function(){
                            //cetak tanpa filter
                            var tahunajaranId = jQuery('select[name=tahunajaran]').val();
                            var awal = jQuery('input[name=tanggal]').val();
                            var akhir = jQuery('input[name=tanggalAkhir]').val();
                            
                            if (awal == '' || akhir == '' || tahunajaranId == ''){
                                showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
                            }else if(Date.parse(akhir) < Date.parse(awal)){
                                showMessage('PERINGATAN','Data tanggal tidak valid.');
                            }else{
                                var isDetil = jQuery('.opsi-detil').is(':checked');
                                if(isDetil){
                                    var printUrl = "{{URL::to('rekap/transaksi/printtopdf')}}"+"/"+tahunajaranId+"/"+awal+"/"+akhir;
                                }else{
                                    var printUrl = "{{ URL::to('rekap/transaksi/printrekap') }}" + "/" + tahunajaranId + "/" + awal + "/" + akhir;
                                }
                                
                                //redirect to print
                                window.location.href = printUrl;
                            }
                     });
                     /**
                      * Cetak Filter By Arus
                      */
                     jQuery('.btn-cetak-filter-arus').click(function(){
                            var tahunajaranId = jQuery('select[name=tahunajaran]').val();
                            var awal = jQuery('input[name=tanggal]').val();
                            var akhir = jQuery('input[name=tanggalAkhir]').val();
                            var arusVal = jQuery('select[name=selectArus]').val();
                            if(arusVal != null){
                                    var printUrl = "{{URL::to('rekap/transaksi/printtopdffilterarus')}}" + "/" + tahunajaranId + "/"+ awal +"/"+ akhir +"/"+ arusVal;
                                    //redirect
                                    window.location.href = printUrl;
                            }else{
                                    showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
                            }
                     });
                     /**
                      * Cetak Filter By Jenis Biaya
                      */
                     jQuery('.btn-cetak-filter-biaya').click(function(){
                            var tahunajaranId = jQuery('select[name=tahunajaran]').val();
                            var awal = jQuery('input[name=tanggal]').val();
                            var akhir = jQuery('input[name=tanggalAkhir]').val();
                            var biaya = jQuery('select[name=selectBiaya]').val();
                            if(biaya != null){
                                    var printUrl = "{{URL::to('rekap/transaksi/printtopdffilterbiaya')}}"+"/"+tahunajaranId+"/"+awal+"/"+akhir+"/"+biaya;
                                    //redirect
                                    window.location.href = printUrl;
                            }else{
                                    showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
                            }
                     });
             
             
        });
    </script>
@endsection

@section('custom_style')
    <style type="text/css">
        table.table-input tbody tr td{
            padding: 5px!important;
        }
        
        table.table-input tbody tr td input,table tbody tr td text,table tbody tr td select{
            vertical-align: middle!important;
            margin: 0;
        }
        
        table.table tbody tr td{
            vertical-align: middle;
        }
    </style>
@endsection


<!--                        <div>
				<ul class="breadcrumb">
					<li>
						<a href="{{ URL::to('home') }}">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Rekapitulasi Transaksi</a>
					</li>
				</ul>
			</div>-->

                        <div class="row-fluid sortable ui-sortable">
                            <div class="box span12">
                                <div class="box-header well" data-original-title="">
                                    <h2><i class="icon-th"></i> Rekapitulasi Transaksi</h2>
                                    <div class="box-icon">
                                        <!--<a href="#" class="btn btn-minimize"><i class="icon icon-darkgray icon-help"></i></a>-->
                                    </div>
                                </div>
                                <div class="box-content">
                                            <fieldset>
                                                <table class="table-input">
                                                    <tbody>
                                                        <tr>
                                                            <td>Tahun Ajaran</td>
                                                            <td>{{ \Laravel\Form::select('tahunajaran', $tahunajaranselect,(isset($tahunaktif) ? $tahunaktif->id : null),array('id'=>'selectTahun','style'=>'width:125px;')) }}</td>
                                                            <td>Tanggal</td>
                                                            <td>
                                                                {{ \Laravel\Form::text('tanggal',null,array('id'=>'textTanggal','class'=>'datepicker input-small','placeholder'=>'tanggal awal','autocomplete'=>'off')) }} - 
                                                                {{ \Laravel\Form::text('tanggalAkhir',null,array('id'=>'textTanggalAkhir','class'=>'datepicker input-small','placeholder'=>'tanggal akhir','autocomplete'=>'off')) }}
                                                            </td>
                                                            <td>
                                                                <?php echo Form::radio('opsi',1,true,array('class' =>'opsi-detil')); ?>&nbsp;Tampilkan detil per transaksi
                                                                <?php echo Form::radio('opsi',2,false,array('class' =>'opsi-kelompok')); ?>&nbsp;Kelompokkan per jenis biaya
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-primary" name="tampil" id="buttonTampil" >Tampilkan</button>
                                                                <button class="btn btn-success btn-cetak-no-filter" name="cetak" >Cetak</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table class="table-input table-filter">
                                                    <tbody>
                                                        <tr>
                                                            <td>Filter Jenis Arus</td>
                                                            <td>{{ Form::select('selectArus',array('M'=>'Masuk','K'=>'Keluar'),null,array('id'=>'selectArus','class' => 'form-filter')) }}</td>
                                                            <td>
                                                                <button class="btn btn-primary form-filter btn-filter-arus" id="buttonFilter" >Filter</button>
                                                                <button class="btn btn-success form-filter btn-cetak-filter-arus" id="buttonFilter" >Cetak</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Filter Jenis Biaya</td>
                                                            <td>{{ Form::select('selectBiaya',$biayaselect,null,array('id'=>'selectBiaya','class'=>'form-filter')) }}</td>
                                                            <td>
                                                                <button class="btn btn-primary form-filter btn-filter-biaya" id="buttonFilter" >Filter</button>
                                                                <button class="btn btn-success form-filter btn-cetak-filter-biaya"  id="buttonFilter" >Cetak</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </fieldset>
                                        </div>
                                    </div>                               
                        </div>

                        <div class="row-fluid sortable ui-sortable" id="tabelrekapitulasi">
                            <div class="box span12">
                                <div class="box-header well" data-original-title="">
                                    <h2><i class="icon-th"></i> Tabel Rekapitulasi</h2>
                                    <div class="box-icon">
                                        <!--<a href="#" class="btn buttonPrint"><i class="icon-print"></i></a>-->
                                    </div>
                                </div>
                                <div class="box-content">
                                    <div id="formTabelRekap"></div>
                                </div>
                            </div><!--/span-->
                        </div>
