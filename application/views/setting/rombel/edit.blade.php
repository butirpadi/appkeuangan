<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="{{ URL::to('setting/rombel') }}">Rombongan Belajar</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">Edit Rombongan Belajar</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon-th-large"></i> Edit Rombongan Belajar</h2>
                        <div class="box-icon">
                            <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                            {{Laravel\Form::open(URL::to('setting/rombel/edit'), 'POST', array('class'=>'form-horizontal'))}}
                                <fieldset>
                                    {{Form::hidden('rombel_id',$rombel->id)}}
                                      <div class="control-group">
                                        <label class="control-label" >Nama</label>
                                        <div class="controls">
                                              {{Form::text('nama',$rombel->nama,array('class'=>'span6','autofocus','required'))}}
                                        </div>
                                      </div>
                                    <div class="control-group">
                                        <label class="control-label" >Jenjang</label>
                                        <div class="controls">
                                            <?php $tingkat = array('1'=>'1-SD','2'=>'2-SD','3'=>'3-SD','4'=>'4-SD','5'=>'5-SD','6'=>'6-SD','0'=>'Lulus') ?>
                                              {{Form::select('jenjang',$tingkat,$rombel->jenjang)}}
                                        </div>
                                      </div>
                                      <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                        <a href="{{ URL::to('setting/rombel') }}" type="reset" class="btn">Cancel</a>
                                      </div>
                                </fieldset>
                              {{Form::close()}}
                </div>
        </div><!--/span-->

</div><!--/row-->





