@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            //hide formPerJenjang
            //jQuery('#formPerJenjang').hide();
            jQuery('#formNonJenjang').hide();
            jQuery('#btnTampil').attr('disabled','disabled');
            jQuery('#tabelKetentuan').hide();
            //selected select
            jQuery('#selectBiaya, #selectTahun').change(function(){
                //sembunyikan dulu tabelKetentuan
                jQuery('#tabelKetentuan').hide();
                //enable and disable btnTampil
                if(jQuery('#selectBiaya').attr('value')!='' && jQuery('#selectTahun').attr('value')!=''){
                    jQuery('#btnTampil').removeAttr('disabled');
                }else{
                    jQuery('#btnTampil').attr('disabled','disabled');
                }
                
            });
            //btnTampil clicked
            jQuery('#btnTampil').click(function(){
                //tampilkan tabel ketentuan with ajax
                var biayaId = jQuery('#selectBiaya').attr('value');
                var tahunId = jQuery('#selectTahun').attr('value');
                jQuery.ajaxSetup ({  
                    cache: false                    
                });  
                var loadUrl = "{{ URL::to('setting/pengaturanbiaya/ajaxindex') }}"+"/"+biayaId+"/"+tahunId;  
                jQuery('#formKetentuan').load(loadUrl);
                
                jQuery('#tabelKetentuan').show(500);
                
            });
        })
    </script>
@endsection
                        <div>
				<ul class="breadcrumb">
					<li>
						<a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Ketentuan Biaya</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> Ketentuan Biaya</h2>
						<div class="box-icon">
                                                    <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                                                </div>
					</div>
					<div class="box-content">
                                            <fieldset class="form-horizontal">

                                                    <div class="control-group">
                                                        <label class="control-label" >Jenis Biaya</label>
                                                        <div class="controls">
                                                            {{ Form::select('biaya',$biayaselect,null,array('id'=>'selectBiaya')) }}
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" >Tahun Ajaran</label>
                                                        <div class="controls">
                                                            {{ Form::select('tahunajaran',$taselect,null,array('id'=>'selectTahun')) }}
                                                            <!--untuk menampung hidden value jenjang-->
                                                            <div id="jenjang"></div>
                                                        </div>
                                                    </div>

                                                    <div id="formPerJenjang"></div>
                                                    <div id="formNonJenjang"></div>

                                                      <div class="form-actions">
                                                            <button id="btnTampil" type="submit" class="btn btn-primary" >Tampilkan</button>
                                                            <button type="reset" class="btn" >Cancel</button>
                                                      </div>
                                                </fieldset>
					</div>
				</div><!--/span-->

			</div><!--/row-->
                        <div class="row-fluid sortable" id="tabelKetentuan">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> Tabel Ketentuan Biaya</h2>
					</div>
                                        <div class="box-content">
                                            <fieldset class="form-horizontal" id="formKetentuan">
                                                
                                            </fieldset>
					</div>
				</div><!--/span-->

			</div><!--/row-->