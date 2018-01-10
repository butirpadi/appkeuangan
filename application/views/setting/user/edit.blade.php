<!--<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="#">Edit User</a>
        </li>
    </ul>
</div>-->

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon-edit"></i> Edit User</h2>
                        <div class="box-icon">
                                <!--<a href="#" class="btn btn-help"><i class="icon-question-sign"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    <div class="form-horizontal">
                        {{ \Laravel\Form::open() }}
                        <!--hidden user-->
                        {{ \Laravel\Form::hidden('user_id', $user->id) }}
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" >Username</label>
                                <div class="controls">
                                    {{ \Laravel\Form::text('username', $user->username, array('class'=>'input-large','required','autocomplete'=>'off','autofocus')) }}
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" >Nama</label>
                                <div class="controls">
                                    {{ \Laravel\Form::text('nama', $user->name, array('class'=>'input-xxlarge','required','autocomplete'=>'off')) }}
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" >Passwrod</label>
                                <div class="controls">
                                    {{ \Laravel\Form::password('password', array('class'=>'input-large','placeholder'=>'input password untuk merubah saja')) }}
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" >Group</label>
                                <div class="controls">
                                    <?php $rolenya; ?>
                                    @foreach($user->roles as $role)
                                        <?php $rolenya = $role; ?>
                                    @endforeach
                                    
                                    {{ \Laravel\Form::select('roles', $selectrole,$rolenya->id, array('required')) }}
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a type="reset" class="btn" href="{{ URL::to('setting/user') }}" >Batal</a>
                            </div>
                        </fieldset>
                        {{ \Laravel\Form::close() }}
                    </div>
                </div>
        </div><!--/span-->

</div><!--/row-->
