<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="{{ URL::to('setting/siswa') }}">Siswa</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">Edit Siswa</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon icon-darkgray icon-contacts"></i> Edit Siswa</h2>
                        <div class="box-icon">
                            <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    {{ Laravel\Form::open(null, 'POST', array('class'=>'form-horizontal'))}}
                        <fieldset>
                              <div class="control-group">
                                <label class="control-label" ></label>
                                <div class="controls">
                                    @if($siswa->mutasi == 'Y')
                                        <span class="label label-success">SISWA MUTASI</span>
                                    @endif
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" >Nomor Induk</label>
                                <div class="controls">
                                      {{ Form::text('nisn',$siswa->nisn,array('class'=>'input-mini'))}}
                                </div>
                              </div>
                            <div class="control-group">
                                <label class="control-label" >Nama</label>
                                <div class="controls">
                                      {{ Form::text('nama',$siswa->nama,array('class'=>'span6','required'))}}
                                </div>
                              </div>
                            <div class="control-group">
                                <label class="control-label" >Rombongan Belajar</label>
                                <div class="controls">                                                              
                                    <?php $rombelnya =  $siswa->rombels()->where('tahunajaran_id','=',$tahunselected->id)->first();?>
                                      {{ Form::select('rombel',$rombelselect,$rombelnya->id)}}
                                </div>
                              </div>
                              <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                <a href="{{ URL::to('setting/siswa') }}" type="reset" class="btn">Cancel</a>
                              </div>

                            <!--hidden value-->
                            {{ Form::hidden('siswa_id',$siswa->id)}}
                            {{ Form::hidden('tahunajaran',$tahunselected->id)}}
                        </fieldset>
                  {{ Form::close()}}
                </div>
        </div><!--/span-->

</div><!--/row-->





