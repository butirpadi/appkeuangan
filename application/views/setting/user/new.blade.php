<!--<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="#">Tambah</a>
        </li>
    </ul>
</div>-->

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon-edit"></i> Tambah User</h2>
                        <div class="box-icon">
                                <!--<a href="#" class="btn btn-help"><i class="icon-question-sign"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    <div class="form-horizontal">
                            {{ Laravel\Form::open(null, 'POST', array('class'=>'form-horizontal'))}}
                                <fieldset>
                                      <div class="control-group">
                                        <label class="control-label" >Username</label>
                                        <div class="controls">
                                              {{ Form::text('username',null,array('class'=>'input-large','autofocus','required','autocomplete'=>'off'))}}
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label" >Nama</label>
                                        <div class="controls">
                                              {{ Form::text('nama',null,array('class'=>'input-xxlarge','required','autocomplete'=>'off'))}}
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label" >Password</label>
                                        <div class="controls">
                                              {{ Form::password('password',array('class'=>'input-large','required','autocomplete'=>'off'))}}
                                        </div>
                                      </div>
                                    <div class="control-group">
                                        <label class="control-label" >Group</label>
                                        <div class="controls">
                                              {{ Form::select('roles',$roleselect)}}
                                        </div>
                                      </div>
                                      <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <a href="{{ URL::to('setting/user') }}" type="reset" class="btn">Cancel</a>
                                      </div>
                                </fieldset>
                              {{ Form::close()}}
                    </div>
                </div>
        </div><!--/span-->

</div><!--/row-->
