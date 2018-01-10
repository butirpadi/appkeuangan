@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            //hide formPerJenjang
            jQuery('#formPerJenjang').hide();
            jQuery('#formNonJenjang').hide();
            jQuery('#btnSave').attr('disabled','disabled');
            //select biaya
            jQuery('#selectBiaya').change(function(){
                selectedSelectBiaya();
            });
            //fungsi selected selectBiaya
            function selectedSelectBiaya(){
                var biaya_id = jQuery('#selectBiaya').attr('value');
                
                if(biaya_id > 0){
                    //get jenis perJenjang biaya
                    jQuery.ajaxSetup ({cache: false});  
                    var loadUrl = "{{ URL::to('setting/biaya/perjenjang') }}"+"/"+biaya_id;  
                    jQuery('#jenjang').load(loadUrl,function(){
                       //tampilkan form perjenjang jika jenis perjenjang
                        var isJenjang = jQuery('#hidejenjang').attr('value'); 
                        if (isJenjang == 'Y'){
                            jQuery('#formPerJenjang').show(500);
                            jQuery('#formNonJenjang').hide();
                            jQuery('#btnSave').removeAttr('disabled');
                        }else{
                            jQuery('#formPerJenjang').hide();
                            jQuery('#formNonJenjang').show(500);
                            jQuery('#btnSave').removeAttr('disabled');
                        }
                    });
                    
                }else{
                    jQuery('#formPerJenjang').hide();
                    jQuery('#formNonJenjang').hide();
                    jQuery('#btnSave').attr('disabled','disabled');
                }
            }
            //jika sudah terpilih
            selectedSelectBiaya();
        })
    </script>
@endsection
                        <div>
				<ul class="breadcrumb">
					<li>
						<a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Pengaturan Biaya</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> Pengaturan Biaya</h2>
						<div class="box-icon">
                                                    <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                                                </div>
					</div>
					<div class="box-content">
                                                    {{ Laravel\Form::open(URL::to('setting/pengaturanbiaya/new'), 'POST', array('class'=>'form-horizontal'))}}
                                                        <fieldset>
                                                            
                                                            <div class="control-group">
                                                                <label class="control-label" >Jenis Biaya</label>
                                                                <div class="controls">
                                                                    {{ Form::select('biaya',$biayaselect,Input::old('biaya'),array('id'=>'selectBiaya'))}}
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="control-group">
                                                                <label class="control-label" >Tahun Ajaran</label>
                                                                <div class="controls">
                                                                    {{ Form::select('tahunajaran',$taselect,(Input::old('tahunajaran') ? Input::old('tahunajaran') : $tahunaktif->id))}}
                                                                    <!--untuk menampung hidden value jenjang-->
                                                                    <div id="jenjang"></div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div id="formPerJenjang">
                                                                <div {{ $errors->has('jenjang_1') ? 'class="control-group error"' : 'class="control-group"' }}>
                                                                    <label class="control-label" >Jenjang 1</label>
                                                                    <div class="controls">
                                                                        Rp. {{ Form::text('jenjang_1',Input::old('jenjang_1'),array('class'=>'input-medium'))}}
                                                                        <span class="help-inline"> {{ $errors->has('jenjang_1') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
                                                                    </div>
                                                                </div>
                                                                <div {{ $errors->has('jenjang_2') ? 'class="control-group error"' : 'class="control-group"' }}>
                                                                    <label class="control-label" >Jenjang 2</label>
                                                                    <div class="controls">
                                                                        Rp. {{ Form::text('jenjang_2',Input::old('jenjang_2'),array('class'=>'input-medium'))}}
                                                                        <span class="help-inline"> {{ $errors->has('jenjang_2') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
                                                                    </div>
                                                                </div>
                                                                <div {{ $errors->has('jenjang_3') ? 'class="control-group error"' : 'class="control-group"' }}>
                                                                    <label class="control-label" >Jenjang 3</label>
                                                                    <div class="controls">
                                                                        Rp. {{ Form::text('jenjang_3',Input::old('jenjang_3'),array('class'=>'input-medium'))}}
                                                                        <span class="help-inline"> {{ $errors->has('jenjang_3') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
                                                                    </div>
                                                                </div>
                                                                <div {{ $errors->has('jenjang_4') ? 'class="control-group error"' : 'class="control-group"' }}>
                                                                    <label class="control-label" >Jenjang 4</label>
                                                                    <div class="controls">
                                                                        Rp. {{ Form::text('jenjang_4',Input::old('jenjang_4'),array('class'=>'input-medium'))}}
                                                                        <span class="help-inline"> {{ $errors->has('jenjang_4') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
                                                                    </div>
                                                                </div>
                                                                <div {{ $errors->has('jenjang_5') ? 'class="control-group error"' : 'class="control-group"' }}>
                                                                    <label class="control-label" >Jenjang 5</label>
                                                                    <div class="controls">
                                                                        Rp. {{ Form::text('jenjang_5',Input::old('jenjang_5'),array('class'=>'input-medium'))}}
                                                                        <span class="help-inline"> {{ $errors->has('jenjang_5') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
                                                                    </div>
                                                                </div>
                                                                <div {{ $errors->has('jenjang_6') ? 'class="control-group error"' : 'class="control-group"' }}>
                                                                    <label class="control-label" >Jenjang 6</label>
                                                                    <div class="controls">
                                                                        Rp. {{ Form::text('jenjang_6',Input::old('jenjang_6'),array('class'=>'input-medium'))}}
                                                                        <span class="help-inline"> {{ $errors->has('jenjang_6') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div {{ $errors->has('jumlah') ? 'class="control-group error"' : 'class="control-group"' }} id="formNonJenjang">
                                                                <label class="control-label" >Jumlah</label>
                                                                <div class="controls">
                                                                    {{ Form::text('jumlah',Input::old('jumlah'),array('class'=>'input-medium'))}}
                                                                    <span class="help-inline"> {{ $errors->has('jumlah') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                              <div class="form-actions">
                                                                    <button id="btnSave" type="submit" class="btn btn-primary" >Save</button>
                                                                    <button type="reset" class="btn" >Cancel</button>
                                                              </div>
                                                        </fieldset>
                                                      {{ Form::close()}}
					</div>
				</div><!--/span-->

			</div><!--/row-->