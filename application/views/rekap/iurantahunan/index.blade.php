@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            /**
             * HIde tabelRekapitulasi
             */
            jQuery('#tabelrekapitulasi').hide();
                /**
                 * select to not selected & disabled
                 */
                jQuery('#selectBiaya').val([]);
                jQuery('#selectJenjang').val([]);
                jQuery('#selectRombel').val([]);
                jQuery('#selectRombel, #selectJenjang, #textNomorInduk').attr('disabled','disabled');
                /**
                 * Global variable
                 */
                var biayaid;
                var tahunajaranid;
                var jenjang;
                var rombelid;
             /**
              * RadioOption selected event 
              */
             jQuery('input[name=radioOption]').change(function(){
                if (jQuery('#tabelrekapitulasi').is(':visible')){
                    //process filter
                    var radioid = jQuery(this).attr('id');
                    
                    if(radioid == 'radioRombel'){
                        //tampilkan selectRombel
                        jQuery('#selectRombel').removeAttr('disabled');
                        //fokuskan
                        jQuery('#selectRombel').focus();
                        //sembunyikan selectJenjang
                        jQuery('#selectJenjang').val([]);
                        jQuery('#selectJenjang, #textNomorInduk').attr('disabled','disabled');
                        //clear textNomorInduk
                        jQuery('#textNomorInduk').attr('value','');
                    }else if(radioid == 'radioJenjang'){
                        //tampilkan selectJenjang
                        jQuery('#selectJenjang').removeAttr('disabled');
                        //fokuskasn
                        jQuery('#selectJenjang').focus();
                        //sembunyikan selectRombel
                        jQuery('#selectRombel').val([]);
                        jQuery('#selectRombel, #textNomorInduk').attr('disabled','disabled');
                        //clear textNomorInduk
                        jQuery('#textNomorInduk').attr('value','');
                    }else if(radioid == 'radioSiswa'){
                        //sembunyikan selectRombel & select to not selected
                        jQuery('#selectRombel, #selectJenjang').val([]);
                        jQuery('#selectRombel, #selectJenjang').attr('disabled','disabled');
                        //enablekan textNomorInduk
                        jQuery('#textNomorInduk').removeAttr('disabled');
                        jQuery('#textNomorInduk').focus();
                    }
                }
             });
             /**
              * ButtonFilter click event
              */
             jQuery('#buttonFilter').click(function(){
                 //empty dulu table sebelumnya
                 jQuery('#formTabelRekap').empty();
                if (jQuery('#tabelrekapitulasi').is(':visible')){
                    if (jQuery('#radioRombel').is(':checked') || jQuery('#radioJenjang').is(':checked') || jQuery('#radioSiswa').is(':checked')){
                        if(jQuery('#radioRombel').is(':checked')){
                            //filter by rombel
                            rombelid = jQuery('#selectRombel').attr('value');
                            
                            if(rombelid != ''){
                                //hidden tabel rekap terlebih dahulu
                                jQuery('#tabelrekapitulasi').hide();
                                
                                jQuery.ajaxSetup ({cache: false});
                                var loadUrl = "{{ URL::to('rekap/iurantahunan/ajaxtabelrekapfilterrombel') }}" + "/" + tahunajaranid + "/" + biayaid + "/" + rombelid;
                                //tampilkan tabel rekapitulasi
                                jQuery('#formTabelRekap').load(loadUrl,function(){
                                    //format rupiah
                                    formatToRupiah();
                                });
                                jQuery('#tabelrekapitulasi').show();
                                //end filter by arus
                            }else{
                                showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
                            }
                            
                        }else if(jQuery('#radioJenjang').is(':checked')){
                            //filter by jenjang
                            jenjang = jQuery('#selectJenjang').attr('value');
                            
                            if(jenjang != ''){
                                //hidden tabel rekap terlebih dahulu
                                jQuery('#tabelrekapitulasi').hide();
                                //filter by jenjang
                                jQuery.ajaxSetup ({cache: false});
                                var loadUrl = "{{ URL::to('rekap/iurantahunan/ajaxtabelrekapfilterjenjang') }}" + "/" + tahunajaranid + "/" + biayaid + "/" + jenjang;
                                //tampilkan tabel rekapitulasi
                                jQuery('#formTabelRekap').load(loadUrl,function(){
                                    //format rupiah
                                    formatToRupiah();
                                });
                                jQuery('#tabelrekapitulasi').show();

                                //end of filter by biaya
                            }else{
                                showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
                            }
                        }else if(jQuery('#radioSiswa').is(':checked')){
                            //filter per siswa
                            var nisn = jQuery('#textNomorInduk').attr('value');
                            
                            if(nisn != ''){
                                //hidden tabel rekap terlebih dahulu
                                jQuery('#tabelrekapitulasi').hide();
                                //filter by jenjang
                                jQuery.ajaxSetup ({cache: false});
                                var loadUrl = "{{ URL::to('rekap/iurantahunan/ajaxtabelrekapfiltersiswa') }}" + "/" + tahunajaranid + "/" + biayaid + "/" + nisn;
                                //tampilkan tabel rekapitulasi
                                jQuery('#formTabelRekap').load(loadUrl,function(){
                                    //format rupiah
                                    formatToRupiah();
                                });
                                jQuery('#tabelrekapitulasi').show();

                                //end of filter by biaya
                            }else{
                                showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
                            }
                        }
                    }else{
                        showMessage('PERINGATAN','Pilih jenis filter');
                    }                     
                }
                
             });
            /**
             * buttonTampil event clicked
             */
            jQuery('#buttonTampil').click(function(){
                biayaid = jQuery('#selectBiaya').attr('value');
                tahunajaranid = jQuery('#selectTahun').attr('value');
                if(biayaid == ''){
                    showMessage('PERINGATAN','Lengkapi data yang masih kosong');
                }else{
                    //tampilkan tabel rekap
                    jQuery.ajaxSetup ({cache: false});
                    var loadUrl = "{{ URL::to('rekap/iurantahunan/ajaxtabelrekap') }}" + "/" + tahunajaranid + "/" + biayaid;
                    //tampilkan tabel rekapitulasi
                    jQuery('#formTabelRekap').load(loadUrl,function(){
                        //format rupiah
                        formatToRupiah();
                    });
                    jQuery('#tabelrekapitulasi').show();
                }
            });
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
              * buttonClear click event
              */
             jQuery('#buttonClear').click(function(){
                jQuery('#buttonTampil').click();
                //clear filter
                jQuery('#radioRombel').attr('checked',false);
                jQuery('#radioJenjang').attr('checked',false);
                //select to not selected
                jQuery('#selectJenjang').val([]);
                jQuery('#selectRombel').val([]);
             });
             /**
              * buttonPrint event clicked
              */
             jQuery('.buttonPrint').click(function(){
                if(jQuery('#radioRombel').is(':checked') || jQuery('#radioJenjang').is(':checked')){
                    if(jQuery('#radioRombel').is(':checked')){
                        //cetak dengan filter rombel
                        jQuery(this).attr('href',"{{URL::to('rekap/iurantahunan/printtopdffilterrombel')}}"+"/"+tahunajaranid+"/"+biayaid+"/"+rombelid);
                        //redirect
                        window.location.href = jQuery(this).attr('href');
                    }else if(jQuery('#radioJenjang').is(':checked')){
                        //cetak dengan filter jenjang
                        jQuery(this).attr('href',"{{URL::to('rekap/iurantahunan/printtopdffilterjenjang')}}"+"/"+tahunajaranid+"/"+biayaid+"/"+jenjang);
                        //redirect
                        window.location.href = jQuery(this).attr('href');
                    }
                }else{
                    //cetak tanpa filter
                        jQuery(this).attr('href',"{{URL::to('rekap/iurantahunan/printtopdf')}}"+"/"+tahunajaranid+"/"+biayaid);
                        //redirect
                        window.location.href = jQuery(this).attr('href');
                }
                
                return false;
             });
             
        });
    </script>
@endsection

@section('custom_style')
    <style type="text/css">
        table td{
            vertical-align: top;
            padding: 5px;
        }
        table td input{
            vertical-align: middle!important;
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
						<a href="#">Rekapitulasi Iuran Tahunan</a>
					</li>
				</ul>
			</div>-->

                        <div class="row-fluid sortable ui-sortable">
                            <div class="box span12">
                                <div class="box-header well" data-original-title="">
                                    <h2><i class="icon-th"></i> Rekapitulasi Iuran Tahunan</h2>
                                    <div class="box-icon">
                                        <!--<a href="#" class="btn btn-minimize "><i class="icon icon-darkgray icon-help"></i></a>-->
                                    </div>
                                </div>
                                <div class="box-content">
                                    <div class="box span6">
                                        <div class="box-content">
                                            <fieldset>
                                                <legend>Input kriteria </legend>
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>Tahun Ajaran</td>
                                                            <td>{{\Laravel\Form::select('tahunajaran', $tahunajaranselect,(isset($tahunaktif) ? $tahunaktif->id : null),array('id'=>'selectTahun','style'=>'width:125px;'))}}</td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jenis Iuran</td>
                                                            <td>{{Form::select('selectBiaya',$biayaselect,null,array('id'=>'selectBiaya'))}}</td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td><button class="btn btn-primary" id="buttonTampil" >Tampilkan</button></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="box span6" >
                                        <div class="box-content">
                                            <fieldset class="">
                                                <legend>Filter </legend>
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{\Laravel\Form::radio('radioOption', 'jenjang', false, array('id'=>'radioJenjang'))}} &nbsp;Per Jenjang</td>
                                                            <td>{{Form::select('selectJenjang',array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6'),null,array('id'=>'selectJenjang'))}}</td>
                                                            <td>{{\Laravel\Form::radio('radioOption', 'siswa', false, array('id'=>'radioSiswa'))}} &nbsp;Per Siswa</td>
                                                            <td>{{Form::text('textNomorInduk',null,array('id'=>'textNomorInduk','placeholder'=>'Nomor Induk','class'=>'input-small'))}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{\Laravel\Form::radio('radioOption', 'rombel', false, array('id'=>'radioRombel'))}} &nbsp;Per Rombel</td>
                                                            <td>{{Form::select('selectRombel',$rombelselect,null,array('id'=>'selectRombel'))}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                <button class="btn btn-primary" id="buttonFilter" >Filter</button>
                                                                <button class="btn" id="buttonClear" >Clear</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                    
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div><!--/span-->
                        </div>

                        <div class="row-fluid sortable ui-sortable" id="tabelrekapitulasi">
                            <div class="box span12">
                                <div class="box-header well" data-original-title="">
                                    <h2><i class="icon-th"></i> Tabel Rekapitulasi</h2>
                                    <div class="box-icon">
                                        <a href="#" class="btn buttonPrint"><i class="icon-print"></i></a>
                                    </div>
                                </div>
                                <div class="box-content">
                                    <div id="formTabelRekap"></div>
                                </div>
                            </div><!--/span-->
                        </div>
