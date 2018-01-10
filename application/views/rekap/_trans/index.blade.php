@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            /**
             * selectBiaya set ke not selected
             * dan disable kan
             */
            jQuery('#selectBiaya').val([]);
            jQuery('#selectBiaya').attr('disabled','disabled');
            
            /**
             * selectArus set ke not selected
             * dan disable kan
             */
            jQuery('#selectArus').val([]);
            jQuery('#selectArus').attr('disabled','disabled');
            
            /**
             * Sembunyikan tabel rekap terlebih dahulu
             */
            jQuery('#tabelrekapitulasi').hide();
            
            /**
             * jadikan tahun ajaran aktif menjadi berwarna hijau
             */
            jQuery('#selectTahun option:selected').css('background-color','green');
            jQuery('#selectTahun option:selected').css('color','white');
            
            /**
             * checkJenisBiaya checked event
             * Ketika checkJenisBiaya tercentang maka hal yang harus dilakukan adalah
             * 1. enablekan selectJenisBiaya
             * 
             * Ketika checkJenisBiaya tidak tercentang maka hal yang harus dilakukan adalah
             * 1. set selectBiaya ke not selected
             * 2. disablekan selectJenisBiaya
             * 
             */
//            jQuery('#checkJenisBiaya').change(function(){
//               if(jQuery('#checkJenisBiaya').is(':checked')){
//                    jQuery('#selectBiaya').removeAttr('disabled');
//               }else{
//                    jQuery('#selectBiaya').val([]);
//                    jQuery('#selectBiaya').attr('disabled','disabled');
//               }
//            });
            
            /**
             * Button tampil selected event
             */
            jQuery('#buttonTampil').click(function(){
               var tahunajaran_id = jQuery('#selectTahun').attr('value');
               var tanggal = jQuery('#textTanggal').attr('value');
               var tanggal2 = jQuery('#textTanggalAkhir').attr('value');
               
               //compare tanggal & tanggal2
               //jika tanggal2 lebih kecil maka beri peringatan
               if(Date.parse(tanggal2) < Date.parse(tanggal)){
                   showMessage('PERINGATAN','Tanggal akhir tidak valid!');
               }else{
                   if (tahunajaran_id != '' && tanggal != ''){
                        //tampilkan table rekap
                        jQuery.ajaxSetup ({cache: false});
                        
                        if (tanggal2 != ""){
                            var loadUrl = "{{ URL::to('rekap/trans/ajaxtransrentang') }}" + "/" + tahunajaran_id + "/" + tanggal + "/" + tanggal2;
                        }else{
                            var loadUrl = "{{ URL::to('rekap/trans/ajaxtrans') }}" + "/" + tahunajaran_id + "/" + tanggal;
                        }
                        //tampilkan tabel rekapitulasi
                        showTabelRekap(loadUrl);
                    }else{
                        //Tampilkan pesan peringatan
                        showMessage('PERINGATAN','Lengkapi data yang masih kosong!');
                    }
                   
               }
            });
            
            
            /**
             * Tampilkan tabel rekapitulasi
             * @param {type} loadUrl
             * @returns {undefined}
             */
            function showTabelRekap(loadUrl){
                jQuery('#formTabelRekap').load(loadUrl,function(){
                    //format angka ke repuiah
                     jQuery('.angka').each(function(){
                          var uang = jQuery(this).text();
                          uang = jQuery.trim(uang);
                          uang = formatRupiahVal(uang);
                          uang  = uang.replace('Rp. ','');
                          uang  = uang.replace('(','- ');
                          uang  = uang.replace(')','');
                          jQuery(this).text(uang);

                     });
                });
                //tampilkan formTabelRekap dari hidden
                jQuery('#tabelrekapitulasi').show(150);
            }
            
//            /**
//             * Tampilkan modal message 
//             */
//             function showMessage($title,$message){
//                jQuery('.modal-title').text($title);
//                jQuery('.modal-message').text($message);
//                jQuery('#modal-dialog').modal('show');
//             }
            
            /**
             * textTanggal change event
             * Ketika textTanggal berubah maka hal yang harus dilakukan adalah :
             * 1. Sembunyikan tabel rekapitulasi
             */
             jQuery('#textTanggal').on('change',function(){
                    //----Point 1----
                    jQuery('#tabelrekapitulasi').hide(150);
                    // End Point 1
             });
             
             /**
             * textTanggalAkhir change event
             * Ketika textTanggal berubah maka hal yang harus dilakukan adalah :
             * 1. Sembunyikan tabel rekapitulasi
             */
             jQuery('#textTanggalAkhir').on('change',function(){
                    //----Point 1----
                    jQuery('#tabelrekapitulasi').hide(150);
                    // End Point 1
             });
             
             /**
              * selectTahun change event
              * Ketika selectTahun berubah maka hal yang harus dilakukan adalah:
              * 1. Sembunyikan tabel rekapitulasi
              */
             jQuery('#selectTahun').on('change',function(){
                    //----Point 1----
                    jQuery('#tabelrekapitulasi').hide(150);
                    // End Point 1
             });
             
             /**
              * radioOption selected event
              */
             jQuery('input[name=radioOption]').change(function(){
                var radio_id = jQuery(this).attr('id');
                
                if (radio_id == 'radioJenisArus'){
                    //enable kan selectArus
                    jQuery('#selectArus').removeAttr('disabled');
                    //disable selectBiaya
                    jQuery('#selectBiaya').attr('disabled','disabled');
                    //kembalikan selectBiaya ke posisi not selected
                    jQuery('#selectBiaya').val([]);
                }else if(radio_id == 'radioJenisBiaya'){
                    //enablekan selectBiaya
                    jQuery('#selectBiaya').removeAttr('disabled');
                    //disable selectArus
                    jQuery('#selectArus').attr('disabled','disabled');
                    //kembalikan selectArus ke posisi not selected
                    jQuery('#selectArus').val([]);
                }
             });
             
             /**
              * buttonTampil click event
              */
             jQuery('#buttonFilter').click(function(){
                var tahunajaran_id = jQuery('#selectTahun').attr('value');
                var tanggal = jQuery('#textTanggal').attr('value');
                var tanggal2 = jQuery('#textTanggalAkhir').attr('value');
                //var checkJenisBiaya = jQuery('#checkJenisBiaya').is(':checked');
                var radioOption = jQuery('input[name=radioOption]:checked').attr('id');
                
                if (radioOption){
                    var filterUrl = '';
                    
                    if (radioOption == 'radioJenisArus'){
                        var jenisArus = jQuery('#selectArus').attr('value');
                        if (jenisArus != ''){
                            //set url tabel rekap berdasarkan jenisArus
                            if(tanggal2 != ''){
                                //dengan rentang tanggal
                                filterUrl = "{{ URL::to('rekap/trans/ajtransrngwitarus') }}" + "/" + tahunajaran_id + "/" + tanggal + "/" + tanggal2 + "/" + jenisArus;
                            }else{
                                //tanpa rentang tanggal
                                filterUrl = "{{ URL::to('rekap/trans/ajtranswitarus') }}" + "/" + tahunajaran_id + "/" + tanggal + "/" + jenisArus;
                            }
                            
                            //tampilkan data rekapitulasi
                            showTabelRekap(filterUrl);
                        }else{
                            //tampilkan peringatan data kosong
                            showMessage('PERINGATAN','Lengkapi data yang masih kosong');
                        }
                    }else if(radioOption == 'radioJenisBiaya'){
                        var biaya_id = jQuery('#selectBiaya').attr('value');
                        
                        if (biaya_id != ''){
                            //tampilkan tabel rekap berdasarkan jenisBiaya
                            if(tanggal2 != ''){
                                //dengan rentang tanggal
                                filterUrl = "{{ URL::to('rekap/trans/ajtransrngwitby') }}" + "/" + tahunajaran_id + "/" + tanggal + "/" + tanggal2 + "/" + biaya_id;
                            }else{
                                //tanpa rentang tanggal
                                filterUrl = "{{ URL::to('rekap/trans/ajtranswitby') }}" + "/" + tahunajaran_id + "/" + tanggal + "/" + biaya_id;
                            }
                            
                            //tampilkan data rekapitulasi
                            showTabelRekap(filterUrl);                            
                        }else{
                            //tampilkan peringatan data kosong
                            showMessage('PERINGATAN','Lengkapi data yang masih kosong');
                        }
                    }
                }else{
                    //tampilkan pesan warning
                    showMessage('PERINGATAN','Pilih salah satu kategori filter.');
                }
             });
             
             /**
              * buttonClear click event
              * mengembalikan ke kondisi awal tanpa filter
              */
             jQuery('#buttonClearFilter').click(function(){
                 jQuery('#buttonTampil').click();
                 //uncheck checkBox
                 jQuery('input[name=radioOption]').attr('checked',false);
                 //kembalikan ke not selected
                 jQuery('#selectArus, #selectBiaya').val([]);
                 //disable kan
                 jQuery('#selectArus, #selectBiaya').removeAttr('disabled');
                 jQuery('#selectArus, #selectBiaya').attr('disabled','disabled');
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


                        <div>
				<ul class="breadcrumb">
					<li>
						<a href="{{ URL::to('home') }}">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Rekapitulasi Transaksi</a>
					</li>
				</ul>
			</div>

                        <div class="row-fluid sortable ui-sortable">
                            <div class="box span12">
                                <div class="box-header well" data-original-title="">
                                    <h2><i class="icon-th"></i> Rekapitulasi Transaksi</h2>
                                    <div class="box-icon">
                                        <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
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
                                                            <td><?php echo\Laravel\Form::select('tahunajaran', $tahunajaranselect,$tahunaktif->id,array('id'=>'selectTahun','style'=>'width:125px;'))?></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal</td>
                                                            <td><?php echo\Laravel\Form::text('tanggal',null,array('id'=>'textTanggal','class'=>'datepicker input-medium','placeholder'=>'tanggal awal'))?></td>
                                                            <td><?php echo\Laravel\Form::text('tanggalAKhir',null,array('id'=>'textTanggalAkhir','class'=>'datepicker input-medium','placeholder'=>'tanggal akhir'))?></td>
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
                                                            <td><?php echo\Laravel\Form::radio('radioOption', 'jenisarus', false, array('id'=>'radioJenisArus'))?> &nbsp;Per Jenis Arus</td>
                                                            <td><?php echoForm::select('selectArus',array('M'=>'Masuk','K'=>'Keluar'),null,array('id'=>'selectArus'))?></td>
                                                        </tr>
                                                        <tr>
                                                            <!--<td><?php echo\Laravel\Form::checkbox('checkJenisBiaya','checkJenisBiaya',false,array('id'=>'checkJenisBiaya'))?> Per Jenis Biaya</td>-->
                                                            <td><?php echo\Laravel\Form::radio('radioOption', 'jenisbiaya', false, array('id'=>'radioJenisBiaya'))?> &nbsp;Per Jenis Biaya</td>
                                                            <td><?php echoForm::select('selectBiaya',$biayaselect,null,array('id'=>'selectBiaya'))?></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                <button class="btn btn-primary" id="buttonFilter" >Filter</button>
                                                                <button class="btn" id="buttonClearFilter" >Clear</button>
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
                                        <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                                    </div>
                                </div>
                                <div class="box-content">
                                    <div id="formTabelRekap"></div>
                                </div>
                            </div><!--/span-->
                        </div>
                        

<!--                        DIALOG MODAL
                        <div class="modal hide fade" id="modal-dialog">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                        <h3 class="modal-title">Peringatan</h3>
                                </div>
                                <div class="modal-body">
                                    <p class="modal-message">Here settings can be configured...</p>
                                </div>
                                <div class="modal-footer">
                                        <a href="#" class="btn" data-dismiss="modal">OK</a>
                                        <a href="#" class="btn btn-primary">OK</a>
                                </div>
                        </div>-->

