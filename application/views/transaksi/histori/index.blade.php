@section('custom_script')
    <!--JZERA APPLET-->
    <applet name="jzebra" code="jzebra.PrintApplet.class" archive="{{ URL::to('packages/jzebra.jar') }}" width="50px" height="50px">
      <!-- Optional, searches for printer with "zebra" in the name on load -->
      <!-- Note:  It is recommended to use applet.findPrinter() instead for ajax heavy applications -->
      <param name="printer" value="{{ $appset->printeraddr }}">
      <!-- ALL OF THE CACHE OPTIONS HAVE BEEN REMOVED DUE TO A BUG WITH JAVA 7 UPDATE 25 -->
	  <!-- Optional, these "cache_" params enable faster loading "caching" of the applet -->
      <!-- <param name="cache_option" value="plugin"> -->
      <!-- Change "cache_archive" to point to relative URL of jzebra.jar -->
      <!-- <param name="cache_archive" value="./jzebra.jar"> -->
      <!-- Change "cache_version" to reflect current jZebra version -->
      <!-- <param name="cache_version" value="1.4.9.1"> -->
   </applet>
    <!--JZEBRA PRINTING-->    
    <script type="text/javascript">
            function jzebraDonePrinting() {
                if (applet.getException() != null) {
                   return alert('Error:' + applet.getExceptionMessage());
                }
                //return alert(MSG_SUCCESS);
            }

            function printNota(textforprint) {
                var applet = document.jzebra;
                if (applet != null) {
                   applet.append(textforprint);            
                   applet.print(); // send commands to printer
                }
                //jzebraDonePrinting();
                
            }
    </script>
    
    <script type="text/javascript">
        jQuery(document).ready(function(){
            /**
             * Global variable
             */
            var tglawal;
            var tglakhir;
            var tahunajaranid;
            var arus;
            var biayaid;
            /**
             * set select for filter to not selected & disable it
             */
            jQuery('#selectArus, #selectBiaya').val([]);
            jQuery('#selectArus, #selectBiaya').attr('disabled','disabled');
            /**
             * Hide tabel rekapitulasi
             */
            jQuery('#tabeltransaksi').hide();
            /**
             * select active tahun ajaran
             */
            jQuery('#selectTahun option:selected').css('background-color','green');
            jQuery('#selectTahun option:selected').css('color','white');
            /**
             * buttonTampil click event
             */
            jQuery('#buttonTampil').click(function(){
                //hide form tabel rekap
                jQuery('#tabelrekapitulasi').hide();
                //cek tanggal kosong
                tglawal = jQuery('#textTanggal').attr('value');
                tglakhir = jQuery('#textTanggalAkhir').attr('value');
                tahunajaranid = jQuery('#selectTahun').attr('value');
                
                var awal = new Date(tglawal.substr(6,4) + '/' + tglawal.substr(3,2) + '/' + tglawal.substr(0,2));
                var akhir = new Date(tglakhir.substr(6,4) + '/' + tglakhir.substr(3,2) + '/' + tglakhir.substr(0,2));
                
               if (tglawal == '' || tglakhir == ''){
                   showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
               //}else if( parseInt(Date.parse(tglakhir)) < parseInt(Date.parse(tglawal))){
               }else if( akhir < awal ){
                   showMessage('PERINGATAN','Data tanggal tidak valid.');
               }else{
                   //tampilkan table rekap
                    jQuery.ajaxSetup ({cache: false});
                    var loadUrl = "{{ URL::to('transaksi/histori/ajaxtransaksi') }}" + "/" + tahunajaranid + "/" + tglawal + "/" + tglakhir;
                    //tampilkan tabel rekapitulasi
                    jQuery('#formTabelTransaksi').load(loadUrl,function(){
                        //tooltip
                        $('[rel="tooltip"],[data-rel="tooltip"]').tooltip({"placement":"bottom",delay: { show: 400, hide: 200 }});
                        //set datatable
                        $('.datatable').dataTable({
                                "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
                                "sPaginationType": "bootstrap",
                                "iDisplayLength": 25,
                                "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                                "oLanguage": {
                                "sLengthMenu": "_MENU_ records per page"
                                }
                        } );
                        //format rupiah
                        formatToRupiah();
                        
                        //tampilkan detil histori transaksi
                        jQuery('.buttonPreview').live('click',function(){
                            jQuery.ajaxSetup ({cache: false});
                            var loadUrl = "{{ URL::to('transaksi/histori/detilhistori') }}" + "/" + jQuery(this).attr('idtrans');
                            jQuery('#tabel-histori').load(loadUrl,function(){
                                jQuery('.button-delete-detil').click(function(){
                                    var idtrans = jQuery(this).attr('idtrans');
                                    var iddet = jQuery(this).attr('iddetil');
                                    var detilTransJson = '{"detiltrans":["id":' + iddet + ',"transmasuk_id":' + idtrans +']}';
                                    //alert(detilTransJson);
                                    
                                    $.post("{{ URL::to('transaksi/histori/canceldetil') }}", {
                                        id: jQuery(this).attr('iddetil') ,
                                        transmasuk_id: jQuery(this).attr('idtrans')                        
                                    }, function(data) {
                                        var row4del = '#row_' + iddet;
                                        alert('Detil transaksi telah dibatalkan');
                                        //remove row yang didelete
                                        jQuery(row4del ).hide(500);
                                        //reload tabel transaksi histori
                                        jQuery('#buttonTampil').click();
                                    });
                                    
                                    return false; 
                                });
                            });
                            
                            jQuery('#detil-dialog').modal('show');
                            
                            return false;
                        });
                        
                    });
                    jQuery('#tabeltransaksi').show();
                    
               }
            });
            
            //menampilkan dialog detil histori transaksi
            function showDetilHistori($title,$message){
                jQuery('.modal-title').text($title);
                jQuery('.modal-message').text($message);
                jQuery('#modal-dialog').modal('show');
             }
            
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

<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">Histori Transaksi</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon-share-alt"></i> Histori Transaksi</h2>
                        <div class="box-icon">
                            <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    <fieldset>
                        <legend>Input kriteria </legend>
                        <table>
                            <tbody>
                                <tr>
                                    <td>Tahun Ajaran</td>
                                    <td>{{ \Laravel\Form::select('tahunajaran', $tahunajaranselect,(isset($tahunaktif) ? $tahunaktif->id : null),array('id'=>'selectTahun','style'=>'width:125px;'))}}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>{{ \Laravel\Form::text('tanggal',null,array('id'=>'textTanggal','class'=>'datepicker input-medium','placeholder'=>'tanggal awal'))}}</td>
                                    <td>{{ \Laravel\Form::text('tanggalAKhir',null,array('id'=>'textTanggalAkhir','class'=>'datepicker input-medium','placeholder'=>'tanggal akhir'))}}</td>
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
        </div><!--/span-->
</div><!--/row-->
<div class="row-fluid sortable ui-sortable" id="tabeltransaksi">
    <div class="box span12">
        <div class="box-header well" data-original-title="">
            <h2><i class="icon-th"></i> Tabel Transaksi</h2>
            <div class="box-icon">
                <a href="#" class="btn buttonPrint"><i class="icon-print"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div id="formTabelTransaksi"></div>
        </div>
    </div><!--/span-->
</div>

<!--dialog detil transaksi-->
<div class="modal hide fade" id="detil-dialog">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Detil Histori Transaksi</h3>
        </div>
        <div class="modal-body">
            <p class="modal-message">Here settings can be configured...</p>
            <div id="modal-custom-message" ></div>
            <div id="tabel-histori">
                
            </div>
        </div>
        <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">OK</a>
                <!--<a href="#" class="btn btn-primary">OK</a>-->
        </div>
</div>


			
			
			
