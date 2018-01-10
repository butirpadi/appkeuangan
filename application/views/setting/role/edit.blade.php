<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="#">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">Edit Group Baru</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon-edit"></i> Edit User Group</h2>
                        <div class="box-icon">
                                <!--<a href="#" class="btn btn-help"><i class="icon-question-sign"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    <div class="form-horizontal">
                        {{ \Laravel\Form::open() }}
                        <fieldset>
                            <!--hidden role id-->
                            {{ \Laravel\Form::hidden('role_id', $role->id) }}
                            <div class="control-group">
                                <label class="control-label" >Nama</label>
                                <div class="controls">
                                    {{ \Laravel\Form::text('name', $role->name, array('class'=>'input-xxlarge','required','autocomplete'=>'off')) }}
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" >Permissions</label>
                                <div class="controls">
                                    <table class="table table-striped">
                                        <tbody>
                                            @foreach($datapermission as $perm)
                                            <tr>
                                                <td>
                                                    <?php $exist = false; ?>
                                                    @foreach($role->permissions as $rperm)
                                                        @if($perm->id == $rperm->id)
                                                            <?php $exist = true; ?>
                                                        @endif
                                                    @endforeach
                                                    
                                                    {{ \Laravel\Form::checkbox('permissions[]', $perm->id, $exist) }}
                                                    {{ $perm->name }}
                                                </td>
                                                <td>
                                                    <i>{{ $perm->description }}</i>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a type="reset" class="btn" href="{{ URL::to('setting/role') }}" >Batal</a>
                            </div>
                        </fieldset>
                        {{ \Laravel\Form::close() }}
                    </div>
                </div>
        </div><!--/span-->

</div><!--/row-->
