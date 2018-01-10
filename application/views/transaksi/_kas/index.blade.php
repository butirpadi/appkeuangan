@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){    
            //unselect selectJenisBiaya
            jQuery('#selectBiaya').val([]);
            //hide form jenis biaya
            jQuery('#formJenisKas').hide();
            //event selected selectBiaya
            jQuery('#selectBiaya').change(function(){
                //enable dulu textJumlahnya
                jQuery('#textJumlah').removeAttr('disabled');
                jQuery('#textJumlah').removeAttr('value');
                
                var biaya_id = jQuery(this).attr('value');
                var tahunajaran_id = jQuery('#selectTahun').attr('value');
                
                if(biaya_id > 0){
                    jQuery.ajaxSetup ({cache: false});
                    var loadUrl = "{{ URL::to('transaksi/kas/ajaxjeniskas') }}" + "/" + biaya_id;
                    jQuery('#formJenisKas').load(loadUrl);
                    jQuery('#formJenisKas').show();
                    
                    //get nilai biaya
                    if (tahunajaran_id > 0 && biaya_id > 0){
                        //cek apakah biaya tetap atau tak tentu
                        var loadUrl = "{{ URL::to('transaksi/kas/ajaxnilaitentu') }}" + "/" + biaya_id;
                        jQuery('#formNilaiTentu').load(loadUrl,function(){
                            var nilaiTentu = jQuery('#hidetentu').attr('value');
                            if (nilaiTentu == 'N'){
                                //enable textJumlah
                                jQuery('#textJumlah').removeAttr('readonly');
                                jQuery('#textJumlah').focus();
                            }else{
                                //disable textJumlah
                                jQuery('#textJumlah').attr('readonly','readonly');
                                //set nilai biaya
                                var loadUrl = "{{ URL::to('transaksi/kas/ajaxnilaibiaya') }}" + "/" + tahunajaran_id + "/" + biaya_id;
                                jQuery('#formNilaiBiaya').load(loadUrl,function(){
                                    var nilaiBiaya = jQuery('#hidenilai').attr('value');                                    
                                    //tampilkan nilai biaya dan disable textbiaya & format ke bentuk rupiah
                                    jQuery('#textJumlah').attr('value',formatRupiahVal(nilaiBiaya));
                                    //focus kan ke element keterangan
                                    jQuery('input[name=ket]').focus();
                                });
                            }
                        });
                    }
                }else{
                    jQuery('#formJenisKas').hide();
                }
                
                return false;
            });
            
            jQuery('textJumlah').change(function(){
                alert('pret');
            })
            
            
        });
    </script>
@endsection

                        <div>
				<ul class="breadcrumb">
					<li>
						<a href="{{ URL::to('home') }}">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Transaksi Kas</a>
					</li>
				</ul>
			</div>

                        <div class="row-fluid sortable ui-sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title="">
						<h2><i class="icon-share-alt"></i> Transaksi Kas</h2>
						<div class="box-icon">
                                                    <a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>
                                                </div>
					</div>
					<div class="box-content">
                                            {{ Form::open(URL::to('transaksi/kas'),'POST') }}
                                            <div class="row-fluid">
                                                <div class="span8">
                                                    <fieldset class="form-horizontal">
                                                        <div class="control-group">
                                                            <label class="control-label" >Tahun Ajaran</label>
                                                            <div class="controls">
                                                                {{ Form::select('tahunajaran',$taselect,$tahunaktif->id,array('id'=>'selectTahun','style'=>'width:100px;')) }}
                                                                &nbsp;&nbsp;<span>Tanggal</span>
                                                                {{ Form::text('tgl',date('d-m-Y'),array('class'=>'input-medium datepicker','required')) }}
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label" >Jenis Biaya</label>
                                                            <div class="controls">
                                                                {{ Form::select('biaya',$byselect,null,array('id'=>'selectBiaya','required')) }}
                                                                &nbsp;&nbsp;&nbsp;
                                                                <span id="formJenisKas"></span>
                                                                <span id="formNilaiBiaya"></span>
                                                                <span id="formNilaiTentu"></span>
                                                            </div>
                                                          </div>
                                                        <div class="control-group">
                                                            <label class="control-label" >Jumlah</label>
                                                            <div class="controls">
                                                                <input class="input-medium" style="text-align:right;" required="required" id="textJumlah" autocomplete="off"  type="text" name="jumlah" onblur="formatRupiah('textJumlah');" onfocus="unformatRupiah('textJumlah')" placeholder="Rp.0,-" autocomplete="off" >
                                                            </div>
                                                          </div>
                                                        <div class="control-group">
                                                            <label class="control-label" >Keterangan</label>
                                                            <div class="controls">
                                                                {{ Form::text('ket',null,array('class'=>'input-xxlarge','id'=>'textKet')) }}
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
                                                            <button id="btnSave" type="submit" class="btn btn-primary" >Save</button>
                                                            <a href="{{ URL::to('transaksi/kas') }}" type="reset" class="btn">Cancel</a>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            {{ Form::close() }}
                                      </div>
                                </div><!--/span-->
                        </div>


			
			
			
