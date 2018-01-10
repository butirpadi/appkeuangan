@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('#tabelrekapitulasi').hide();
            jQuery('#selectJenisKas').val([]);
            jQuery('#formDetilBiaya').hide();
            jQuery('#formGroupBiaya').hide();
            
            //hidden saat inputan berubah
            jQuery('select').change(function(){
               jQuery('#tabelrekapitulasi').hide(); 
            });
            
            //event selectJenisKas change
            jQuery('#selectJenisKas').change(function(){
                //hidden checkgroup
                jQuery('#formGroupBiaya').hide();
                
               var jenisKas = jQuery(this).attr('value');
               if (jenisKas == 'M' || jenisKas == 'K'){
                   //menampilkan selectBiaya
                   jQuery.ajaxSetup ({cache: false});
                   var loadUrl = "{{ URL::to('rekap/harian/ajaxselectbiaya') }}" + "/" + jenisKas;
                   jQuery('#formJenisBiaya').load(loadUrl,function(){
                       //select index ke enol
                       jQuery('#selectBiaya').val([]);
                       //selectBiaya change event
                       jQuery('#selectBiaya').change(function(){
                           //hidden tabel rekap
                           jQuery('#tabelrekapitulasi').hide(); 
                           //show jenisIuran
                           var biaya_id = jQuery(this).attr('value');
                           showJenisIuran(biaya_id); 
                           //tampilkan checkbox group jenis biaya
                           showGroupBiaya();
                       });
                   });
               }else if(jenisKas == 'all'){
                   jQuery.ajaxSetup ({cache: false});
                   var loadUrl = "{{ URL::to('rekap/harian/ajaxselectbiaya') }}" + "/all";
                   jQuery('#formJenisBiaya').load(loadUrl,function(){
                       //select index ke enol
                       jQuery('#selectBiaya').val([]);
                       //selectBiaya change event
                       jQuery('#selectBiaya').change(function(){
                           var biaya_id = jQuery(this).attr('value');
                           showJenisIuran(biaya_id);
                           //hidden tabel rekap
                           jQuery('#tabelrekapitulasi').hide(); 
                           //tampilkan checkbox group jenis biaya
                           showGroupBiaya();
                       });
                   });
               }
            });
            
            //menampilkan check box group per jenis jika selectJenisBiaya adalah all
            function showGroupBiaya(){
                if (jQuery('#selectBiaya').attr('value') == 'all'){
                   jQuery('#formGroupBiaya').show();
               }else{
                   jQuery('#formGroupBiaya').hide();
               }
            };
            
            //menampilkan jenis iuran
            function showJenisIuran(biaya_id){
                jQuery.ajaxSetup ({cache: false});
                var loadJenisIuranUrl = "{{ URL::to('setting/biaya/ajaxhiddenjenisiuran') }}" + "/" + biaya_id;
                jQuery('#formJenisIuran').load(loadJenisIuranUrl,function(){
                    //jika jenis iuran adalah Y maka tampilkan select Rombongan belajar dan select Siswa
                    var jenisIuran = jQuery('#hiddenjenisiuran').attr('value');
                    if (jenisIuran == 'Y'){
                        jQuery('#formDetilBiaya').css('visibility','visible');
                        jQuery('#formDetilBiaya').show();
                        
                        //reset selectSiswa dan selectRombel
                        jQuery('#selectRombel').val([]);
                        jQuery('#selectSiswa').val([]);
                    }else{
                        jQuery('#formDetilBiaya').hide();
                        jQuery('#formDetilBiaya').css('visibility','hidden');
                    }
                });
            }
            
            //event buttonTampil click
            jQuery('#buttonTampil').click(function(){
                
                //tampilkan tabel rekapitulasi
                var tgl = jQuery('#textTanggal').attr('value');
                var jenisKas = jQuery('#selectJenisKas').attr('value');
                var jenisBiaya = jQuery('#selectBiaya').attr('value');
                var tahunajaran_id = jQuery('#selectTahunajaran').attr('value');
                var jenisIuran = jQuery('#hiddenjenisiuran').attr('value');
                
                if (tgl != '' && jenisKas != '' && jenisBiaya != ''){
                    //jika jenis iuran maka tampilkan rekap dengan tambahan selectRombel dan select siswa
                    if (jenisIuran == 'Y'){
                        var rombel_id = jQuery('#selectRombel').attr('value');
                        var siswa_id = jQuery('#selectSiswa').attr('value');
                        
                        if (rombel_id != '' && siswa_id != ''){
                            //tampilkan tabel rekap
                            
                        }
                    }else{
                        //setting ajax
                        jQuery.ajaxSetup ({cache: false});
                        
                        //jika checkboxgrup atau dikelompokkan per jenis biaya
                        if(jQuery('#checkGroupBiaya').is(':checked')){
                            var loadUrl = "{{ URL::to('rekap/harian/ajaxtabelrekap') }}" + "/" + tahunajaran_id + "/" + tgl + "/" + jenisKas + "/" + jenisBiaya + "/all/all/" + "true"; 
                        }else{
                            var loadUrl = "{{ URL::to('rekap/harian/ajaxtabelrekap') }}" + "/" + tahunajaran_id + "/" + tgl + "/" + jenisKas + "/" + jenisBiaya; 
                        };
                        alert(loadUrl);
                        //tapmpilkan tabel rekap
                        jQuery('#formTabelRekap').load(loadUrl,function(){
                            //format uang to rupiah
                            jQuery('.uang').each(function(){
                               var uang = jQuery(this).text();
                               uang = jQuery.trim(uang);

                                 uang = formatRupiahVal(uang);
                                 uang  = uang.replace('Rp. ','');
                                 uang  = uang.replace('(','- ');
                                 uang  = uang.replace(')','');
                                 jQuery(this).text(uang);

                            });
                        });
                    }
                    //tampilkan tabel rekap                    
                   jQuery('#tabelrekapitulasi').show();
                   
                }else{
                    alert('Lengkapi data input yang masih kosong.')
                }
            });
            
            //selectRombel event change
            jQuery('#selectRombel').change(function(){
                var rombel_id = jQuery(this).attr('value');
                
                //tampilkan selectSiswa
                jQuery.ajaxSetup ({cache: false});
                var loadUrl = "{{ URL::to('setting/siswa/ajaxselectsiswa') }}" + "/" + rombel_id ;
                jQuery('#formSiswa').load(loadUrl,function(){});
                
            });
            
        });
    </script>
@endsection

@section('custom_style')
    <style type="text/css">
        span.forlabel{
            vertical-align: middle;
        }
        table tr td{
            vertical-align: middle!important;
        }
    </style>
@endsection

                        <div>
				<ul class="breadcrumb">
					<li>
						<a href="{{ URL::to('home') }}">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Rekapitulasi Transaksi Harian</a>
					</li>
				</ul>
			</div>

                        <div class="row-fluid sortable ui-sortable">
                            <div class="box span12">
                                <div class="box-header well" data-original-title="">
                                    <h2><i class="icon-th"></i> Rekapitulasi Transaksi Harian</h2>
                                    <div class="box-icon">
                                        <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
                                        <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                                        <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
                                    </div>
                                </div>
                                <div class="box-content">
                                    <div class="row-fluid">
                                        <form action="" class="form-horizontal">
                                            <fieldset>
                                                <h3>Input kriteria</h3>
                                                <div>
                                                    <table class="table table-condensed">
                                                        <tbody>
                                                            <tr>
                                                                <td>Tahun Ajaran</td>
                                                                <td>
                                                                    <span id="formJenisArus"><?php echoForm::select('tahunajaran',$taselect,$tahunaktif->id,array('id'=>'selectTahunajaran'))?> </span>
                                                                </td>
                                                                <td>Tanggal</td>
                                                                <td>
                                                                    <span id="formTanggal"><?php echoForm::text('tgl',null,array('id'=>'textTanggal','class'=>'datepicker','placeholder'=>'yyyy-mm-dd','required'))?> </span>
                                                                </td>
                                                                <td>Jenis Kas</td>
                                                                <td>
                                                                    <span id="formJenisArus"><?php echoForm::select('jeniskas',array('all'=>'Semua','K'=>'Kas Keluar','M'=>'Kas Masuk'),null,array('id'=>'selectJenisKas','style'=>'width:100px;'))?> </span>
                                                                </td>
                                                                <td>Jenis Biaya</td>
                                                                <td>
                                                                    <span id="formJenisBiaya"> <?php echoForm::select('jenisbiaya',array(''=>''))?></span>
                                                                    <span id="formGroupBiaya"><?php echo\Laravel\Form::checkbox('checkGroupBiaya', 1, false, array('id'=>'checkGroupBiaya'))?> Kelompokkan per jenis </span>
                                                                    <span id="formJenisIuran"></span>
                                                                </td>
                                                            </tr>
                                                            <tr id="formDetilBiaya" style="visibility: hidden;">
                                                                <td>Rombel</td>
                                                                <td>
                                                                    <span id="formRombel"><?php echoForm::select('rombel',$rombelselect,null,array('id'=>'selectRombel'))?> </span>
                                                                </td>
                                                                <td>Siswa</td>
                                                                <td>
                                                                    <span id="formSiswa"><?php echoForm::select('siswa',array(),null,array('id'=>'selectSiswa'))?> </span>
                                                                </td>
                                                                <td></td>
                                                                <td>
                                                                    
                                                                </td>
                                                                <td></td>
                                                                <td>
                                                                    
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>                                                        
                                                <div class="form-actions">
                                                        <a href="#" id="buttonTampil"  class="btn btn-primary">Tampilkan</a>
                                                  </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div><!--/span-->
                        </div>

                        <div class="row-fluid sortable ui-sortable" id="tabelrekapitulasi">
                            <div class="box span12">
                                <div class="box-header well" data-original-title="">
                                    <h2><i class="icon-th"></i> Tabel Rekapitulasi</h2>
                                    <div class="box-icon">
                                        <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
                                        <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                                        <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
                                    </div>
                                </div>
                                <div class="box-content">
                                    <div class="row-fluid" id="formTabelRekap">
                                        
                                    </div>
                                </div>
                            </div><!--/span-->
                        </div>

