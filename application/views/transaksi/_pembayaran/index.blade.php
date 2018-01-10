@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
           //pertama sembunyikan dulu formDataSiswa & formBukuSPP
           jQuery('#formDataSiswa').hide();
           jQuery('#tabelBukuSpp').hide();
           //disable selectBiaya
           jQuery('#selectBiaya').attr('disabled','disabled');
           //disable btnSave
           jQuery('#btnSave').attr('disabled','disabled');
           
           //event btnSearchClick
           jQuery('#btnSearch').click(function(){
               //jika formDataSiswa & selectBiaya terbuka maka harus ditutup dulu
               jQuery('#formDataSiswa').hide();
               jQuery('#selectBiaya').attr('disabled','disabled');
               //kembalikan ke posisi awal selectBiaya
               jQuery('#selectBiaya').val('');
               //jika formBukuSPP terbuka maka tutup dulu ya...karena data berubah
               jQuery('#tabelBukuSpp').hide();
               //tutup formBiaya
                jQuery('#formTotalBiaya').hide();
               //btnSave juga di disable dulu
               jQuery('#btnSave').attr('disabled','disabled');
               
              var nisn = jQuery('#textNisn').attr('value');
              if (nisn == ''){
                  alert('NISN masih kosong.');
              }else{
                  //get data siswa
                  jQuery.ajaxSetup ({cache: false});
                  var loadUrl = "{{ URL::to('transaksi/pembayaran/ajaxdatasiswa') }}" + "/" + nisn;
                  jQuery('#formDataSiswa').load(loadUrl);
                  jQuery('#formDataSiswa').show(150,function(){
                      //cek apakah data siswa tersedia
                      var siswa_id = jQuery('input[name=siswa_id]').attr('value');
                      if (siswa_id){
                        //jika data siswa tersedia maka enablekan selectBiaya
                        jQuery('#selectBiaya').removeAttr('disabled');
                      }else{
                          alert('Data siswa tidak tersedia.');
                      }
                  });
              }
              
              return false;
           });
           
           //event selected selectBiaya 
           jQuery('#selectBiaya').change(function(){
                //cek apakah biaya nya adalah spp
                jQuery.ajaxSetup ({cache: false});
                var biaya_id = jQuery(this).attr('value');
                var cekBiayaUrl = "{{ URL::to('transaksi/pembayaran/ajaxjenisbiaya') }}" + "/" + biaya_id;
                //jika selected value dari selectBiaya lebih dari 0
                if (biaya_id > 0){
                    jQuery('#formJenisBiaya').load(cekBiayaUrl,function(){
                        //get jenis biaya
                        var jenisBiaya = jQuery('#hidejenisbiaya').attr('value');
                        if (jenisBiaya == 'SPP'){
                            //jika jenis biaya adalah SPP maka tampilkan formBukuSpp
                            jQuery.ajaxSetup ({cache: false});
                            var siswa_id = jQuery('input[name=siswa_id]').attr('value');
                            var tahunajaran_id = jQuery('#selectTahun').attr('value');
                            var loadUrl = "{{ URL::to('transaksi/pembayaran/ajaxbukuspp') }}" + "/" + siswa_id + "/" + tahunajaran_id;
                            jQuery('#tabelBukuSpp').load(loadUrl,function(){
                                //selected selectBulan
                                jQuery('#selectBulan').change(function(){
                                     var bulan_id = jQuery(this).attr('value');
                                     if (bulan_id > 0){
                                         //enable kan btnSave
                                         jQuery('#btnSave').removeAttr('disabled');
                                     }else{
                                         jQuery('#btnSave').attr('disabled','disabled');
                                     }
                                     return false;
                                });
                            });
                            jQuery('#tabelBukuSpp').show(150);
                            
                            //tampilkan total biaya
                            jQuery.ajaxSetup ({cache: false});
                            var tahunajaran_id = jQuery('#selectTahun').attr('value');
                            var biaya_id = jQuery('#selectBiaya').attr('value');
                            var jenjang = jQuery('#textJenjang').attr('value');
                            var loadUrl = "{{ URL::to('transaksi/pembayaran/ajaxtotal') }}" + "/" + tahunajaran_id + "/" + biaya_id + "/" + jenjang;  
                            jQuery('#formTotalBiaya').load(loadUrl,function(){
                                //format to rupiah
//                                var tot = jQuery('#labelTotal').text();
//                                jQuery('#labelTotal').text(formatRupiahVal(jQuery(this).text()));
                                jQuery('#labelTotal').text(formatRupiahVal(jQuery('#labelTotal').text()));
                            });
                            jQuery('#formTotalBiaya').show();
                        }else{
                            //tutup tableBuku
                            jQuery('#tabelBukuSpp').hide();
                            //tutup formBiaya
                            jQuery('#formTotalBiaya').hide();
                            
                            //tampilkan total biaya
                            jQuery.ajaxSetup ({cache: false});
                            var tahunajaran_id = jQuery('#selectTahun').attr('value');
                            var biaya_id = jQuery('#selectBiaya').attr('value');
                            var loadUrl = "{{ URL::to('transaksi/pembayaran/ajaxtotal') }}" + "/" + tahunajaran_id + "/" + biaya_id ;
                            jQuery('#formTotalBiaya').load(loadUrl);
                            jQuery('#formTotalBiaya').show();
                        }
                    });
                }else{
                    //tutup tableBuku
                    jQuery('#tabelBukuSpp').hide();
                    //disable btnSave
                    jQuery('#btnSave').attr('disabled','disabled');
                    //tutup formBiaya
                    jQuery('#formTotalBiaya').hide();
                }
                
                return false;
           });
           
        });
    </script>
@endsection

                        <div>
				<ul class="breadcrumb">
					<li>
						<a href="{{ URL::to('home') }}">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Transaksi Pembayaran Akademik</a>
					</li>
				</ul>
			</div>

                        <div class="row-fluid sortable ui-sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-share-alt"></i> Transaksi Pembayaran Akademik</h2>
						<div class="box-icon">
                                                    <a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>
                                                </div>
					</div>
					<div class="box-content">
                                            {{ Form::open(URL::to('transaksi/pembayaran'),'POST') }}
                                            <div class="row-fluid">
                                                <div class="span8">
                                                    <fieldset class="form-horizontal">
                                                        <div class="control-group">
                                                            <label class="control-label" >NISN Siswa</label>
                                                            <div class="controls">
                                                                {{ Form::text('nisn','',array('class'=>'input-medium','autofocus','required','id'=>'textNisn')) }}
                                                                <button class="btn btn-primary" id="btnSearch" ><i class="icon-white icon-search"></i></button>
                                                            </div>
                                                          </div>
                                                        
                                                        <!--untuk menampilkan detil data siswa-->
                                                        <div class="control-group" id="formDataSiswa"></div>
                                                        
                                                        <div class="control-group">
                                                            <label class="control-label" >Tanggal</label>
                                                            <div class="controls">
                                                                {{ Form::text('tgl',date('Y-m-d'),array('class'=>'input-medium datepicker','required')) }}
                                                            </div>
                                                          </div>
                                                        <div class="control-group">
                                                            <label class="control-label" >Tahun Ajaran</label>
                                                            <div class="controls">
                                                                {{ Form::select('tahunajaran',$taselect,$tahunaktif->id,array('id'=>'selectTahun')) }}
                                                            </div>
                                                          </div>
                                                        <div class="control-group">
                                                            <label class="control-label" >Jenis Biaya</label>
                                                            <div class="controls">
                                                                {{ Form::select('biaya',$byselect,null,array('id'=>'selectBiaya','disabled')) }}
                                                                <span id="formJenisBiaya"></span>
                                                            </div>
                                                          </div>
                                                        <div id="tabelBukuSpp"></div>
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                {{ \Laravel\Form::checkbox('cetak', 1, true,array('style'=>'vertical-align:middle;')) }} &nbsp;&nbsp; <span style="vertical-align: middle;">Cetak bukti pembayaran</span>
                                                            </div>
                                                          </div>
                                                        
                                                    </fieldset> 
                                                </div>
                                                <div class="span4" id="formTotalBiaya"></div>
                                                
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <fieldset class="form-horizontal">
                                                        <div class="form-actions">
                                                            <button id="btnSave" type="submit" class="btn btn-primary" disabled="disabled" >Save</button>
                                                            <a href="{{ URL::to('transaksi/pembayaran') }}" type="reset" class="btn">Cancel</a>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            {{ Form::close() }}
                                      </div>
                                </div><!--/span-->
                        </div>


			
			
			
