@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            //hide formPerJenjang
            jQuery('#formPerJenjang').hide();
            //select biaya
            jQuery('#selectBiaya').change(function(){
                var biaya_id = jQuery(this).attr('value');
                
                if(biaya_id > 0){
                    //get jenis perJenjang biaya
                    jQuery.ajaxSetup ({  
                            cache: false  
                    });  
                    var loadUrl = "{{ URL::to('setting/biaya/perjenjang') }}"+"/"+biaya_id;  
                    jQuery('#jenjang').load(loadUrl,function(){
                       //tampilkan form perjenjang jika jenis perjenjang
                        var isJenjang = jQuery('#hidejenjang').attr('value'); 
                        if (isJenjang == 'Y'){
                            jQuery('#formPerJenjang').show(500);
                            jQuery('#formNonJenjang').hide();
                        }else{
                            jQuery('#formPerJenjang').hide();
                            jQuery('#formNonJenjang').show(500);
                        }
                    });
                    
                }
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
						<a href="#">Pengaturan Biaya</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> Pengaturan Biaya</h2>
						<div class="box-icon">
                                                    <a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>
                                                </div>
					</div>
					<div class="box-content">
                                            <ul class="nav nav-tabs" id="myTab">
                                                    <li class="active"><a href="#data">Data</a></li>
                                                    <li><a href="#new">Pengaturan Baru</a></li>
                                                    <li><a href="#histori">Data Histori</a></li>
                                            </ul>

                                            <div id="myTabContent" class="tab-content">
                                                <div class="tab-pane active" id="data">
                                                    <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                                        <colgroup>
                                                            <col class="con1" style="align: center; width: 50px;"/>
                                                            <col class="con0" />
                                                            <col class="con1" style="align: center; " />
                                                        </colgroup>
                                                      <thead>
                                                          <tr>
                                                              <th>No</th>
                                                              <th>Nama</th>
                                                              <th>Biaya</th>
                                                              <th>Opsi</th>
                                                          </tr>
                                                      </thead>   
                                                      <tbody>
                                                          <?php $rownum = 1;?>
                                                          @foreach($biayas as $biaya)
                                                            <tr>
                                                                    <td>{{ $rownum++ }}</td>
                                                                    <td class="center">{{ $biaya->nama }}</td>
                                                                    <td class="center">
                                                                        @if($biaya->perjenjang == 'Y')
                                                                            <span class="label label-success">Biaya per jenjang</span>
                                                                        @else
                                                                            <?php $nilnya = 0;?>
                                                                            @foreach($biaya->nilaibiayas as $nil)
                                                                                <?php $nilnya = $nil->jumlah ?>
                                                                                <?php break; ?>
                                                                            @endforeach
                                                                            {{ $nilnya }}
                                                                        @endif
                                                                    </td>
                                                                    <td class="center">
                                                                        <a href="{{ URL::to('setting/biaya/editpengaturan'.'/'.$biaya->id.'/'.$tahunaktif->id) }}" data-rel="tooltip" data-original-title="edit" ><i class="icon icon-darkgray icon-edit"></i></a>
                                                                        <a href="#" data-rel="tooltip" data-original-title="hapus" ><i class="icon icon-darkgray icon-trash"></i></a>
                                                                    </td>
                                                            </tr>
                                                          @endforeach
                                                      </tbody>
                                                  </table>
                                                </div>
                                                <div class="tab-pane" id="new">
                                                    <?php echoLaravel\Form::open(URL::to('setting/biaya/pengaturan'), 'POST', array('class'=>'form-horizontal'))?>
                                                        <fieldset>
                                                              <div class="control-group">
                                                                <label class="control-label" >Jenis Biaya</label>
                                                                <div class="controls">
                                                                      <?php echoForm::select('biaya',$biayaselect,null,array('id'=>'selectBiaya'))?>
                                                                    <div id="jenjang"></div>
                                                                </div>
                                                              </div>
                                                            <div class="control-group">
                                                                <label class="control-label" >Tahun Ajaran</label>
                                                                <div class="controls">
                                                                      <?php echoForm::select('tahunajaran',$taselect,$tahunaktif->id)?>
                                                                </div>
                                                              </div>
                                                            <div id="formPerJenjang">
                                                                <div class="control-group">
                                                                    <label class="control-label" >Jenjang 1</label>
                                                                    <div class="controls">
                                                                        Rp. <?php echoForm::text('jenjang_1',null,array('class'=>'input-medium'))?>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label" >Jenjang 2</label>
                                                                    <div class="controls">
                                                                        Rp. <?php echoForm::text('jenjang_2',null,array('class'=>'input-medium'))?>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label" >Jenjang 3</label>
                                                                    <div class="controls">
                                                                        Rp. <?php echoForm::text('jenjang_3',null,array('class'=>'input-medium'))?>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label" >Jenjang 4</label>
                                                                    <div class="controls">
                                                                        Rp. <?php echoForm::text('jenjang_4',null,array('class'=>'input-medium'))?>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label" >Jenjang 5</label>
                                                                    <div class="controls">
                                                                        Rp. <?php echoForm::text('jenjang_5',null,array('class'=>'input-medium'))?>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label" >Jenjang 6</label>
                                                                    <div class="controls">
                                                                        Rp. <?php echoForm::text('jenjang_6',null,array('class'=>'input-medium'))?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="control-group" id="formNonJenjang">
                                                                <label class="control-label" >Jumlah</label>
                                                                <div class="controls">
                                                                    <?php echoForm::text('jumlah',null,array('class'=>'input-medium'))?>
                                                                </div>
                                                            </div>
                                                              <div class="form-actions">
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                                <button type="reset" class="btn">Cancel</button>
                                                              </div>
                                                        </fieldset>
                                                      <?php echoForm::close()?>
                                                </div>
                                                <div class="tab-pane" id="histori">
                                                    <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                                        <colgroup>
                                                            <col class="con1" style="align: center; width: 50px;"/>
                                                            <col class="con0" />
                                                            <col class="con1" />
                                                            <col class="con0" />
                                                            <col class="con1" />
                                                            <col class="con0" style="align: center; " />
                                                        </colgroup>
                                                      <thead>
                                                          <tr>
                                                              <th>No</th>
                                                              <th>Nama</th>
                                                              <th>Tahun Ajaran</th>
                                                              <th>Jenjang</th>
                                                              <th>Biaya</th>
                                                              <th>Opsi</th>
                                                          </tr>
                                                      </thead>   
                                                      <tbody>
                                                          <?php $rownum = 1;?>
                                                          @foreach($biayahis as $biaya)
                                                            <tr>
                                                                    <td>{{ $rownum++ }}</td>
                                                                    <td class="center">{{ $biaya->biaya->nama }}</td>
                                                                    <td class="center">{{ $biaya->tahunajaran->nama }}</td>
                                                                    <td class="center">{{ $biaya->jenjang }}</td>
                                                                    <td class="center">{{ $biaya->jumlah }}</td>
                                                                    <td class="center">
                                                                        <a href="#" data-rel="tooltip" data-original-title="edit" ><i class="icon icon-darkgray icon-edit"></i></a>
                                                                        <a href="#" data-rel="tooltip" data-original-title="hapus" ><i class="icon icon-darkgray icon-trash"></i></a>
                                                                    </td>
                                                            </tr>
                                                          @endforeach
                                                      </tbody>
                                                  </table>
                                                </div>
                                            </div>
					</div>
				</div><!--/span-->

			</div><!--/row-->


			
			
			
