                        <div>
				<ul class="breadcrumb">
					<li>
						<a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
					</li>
                                        <li>
						<a href="{{ URL::to('setting/biaya/pengaturan') }}">Pengaturan Biaya</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Edit Pengaturan Biaya</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> Edit Pengaturan Biaya</h2>
						<div class="box-icon">
                                                    <a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>
                                                </div>
					</div>
					<div class="box-content">
                                                    {{ Laravel\Form::open(URL::to('setting/biaya/editpengaturan'), 'POST', array('class'=>'form-horizontal')) }}
                                                        <fieldset>
                                                              <div class="control-group">
                                                                <label class="control-label" >Jenis Biaya</label>
                                                                <div class="controls">
                                                                      {{ Form::select('biaya',$biayaselect,$biaya->id,array('id'=>'selectBiaya','disabled')) }}
                                                                    <div id="jenjang"></div>
                                                                </div>
                                                              </div>
                                                            <div class="control-group">
                                                                <label class="control-label" >Tahun Ajaran</label>
                                                                <div class="controls">
                                                                      {{ Form::select('tahunajaran',$taselect,$tahunajaran->id,array('disabled')) }}
                                                                </div>
                                                              </div>
                                                            @if($biaya->perjenjang =='Y')
                                                                <div id="formPerJenjang">
                                                                @foreach($nilaibiaya as $nb)
                                                                    @if($nb->jenjang == 1)
                                                                        <div class="control-group">
                                                                            <label class="control-label" >Jenjang 1</label>
                                                                            <div class="controls">
                                                                                Rp. {{ Form::text('jenjang_1',$nb->jumlah,array('class'=>'input-medium','autofocus')) }}
                                                                            </div>
                                                                        </div>
                                                                    @elseif($nb->jenjang == 2)
                                                                        <div class="control-group">
                                                                            <label class="control-label" >Jenjang 2</label>
                                                                            <div class="controls">
                                                                                Rp. {{ Form::text('jenjang_2',$nb->jumlah,array('class'=>'input-medium')) }}
                                                                            </div>
                                                                        </div>
                                                                    @elseif($nb->jenjang == 3)
                                                                        <div class="control-group">
                                                                            <label class="control-label" >Jenjang 3</label>
                                                                            <div class="controls">
                                                                                Rp. {{ Form::text('jenjang_3',$nb->jumlah,array('class'=>'input-medium')) }}
                                                                            </div>
                                                                        </div>
                                                                    @elseif($nb->jenjang == 4)
                                                                        <div class="control-group">
                                                                            <label class="control-label" >Jenjang 4</label>
                                                                            <div class="controls">
                                                                                Rp. {{ Form::text('jenjang_4',$nb->jumlah,array('class'=>'input-medium')) }}
                                                                            </div>
                                                                        </div>
                                                                    @elseif($nb->jenjang == 5)
                                                                        <div class="control-group">
                                                                            <label class="control-label" >Jenjang 5</label>
                                                                            <div class="controls">
                                                                                Rp. {{ Form::text('jenjang_5',$nb->jumlah,array('class'=>'input-medium')) }}
                                                                            </div>
                                                                        </div>
                                                                    @elseif($nb->jenjang == 6)
                                                                        <div class="control-group">
                                                                            <label class="control-label" >Jenjang 6</label>
                                                                            <div class="controls">
                                                                                Rp. {{ Form::text('jenjang_6',$nb->jumlah,array('class'=>'input-medium')) }}
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                                </div>
                                                            @else
                                                                <!--HIDDEN VALUE-->
                                                                {{ Form::hidden('nilaibiaya_id',$nilaibiaya->id) }}
                                                                
                                                                <div class="control-group" id="formNonJenjang">
                                                                    <label class="control-label" >Jumlah</label>
                                                                    <div class="controls">
                                                                        {{ Form::text('jumlah',$nilaibiaya->jumlah,array('class'=>'input-medium','autofocus')) }}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                              <div class="form-actions">
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                                <a href="{{ URL::to('setting/biaya/pengaturan') }}" type="reset" class="btn">Cancel</a>
                                                              </div>
                                                        </fieldset>
                                            
                                                        <!--hidden value-->
                                                        {{ Form::hidden('biaya_id',$biaya->id) }}
                                                        {{ Form::hidden('tahunajaran_id',$tahunajaran->id) }}
                                                      {{ Form::close() }}
					</div>
				</div><!--/span-->

			</div><!--/row-->


			
			
			
