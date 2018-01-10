<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">User Group</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon icon-darkgray icon-users"></i> User Group</h2>
                        <div class="box-icon">
                            <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    
                    <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a href="#data">Data</a></li>
                            <li><a href="#new">Input Baru</a></li>
                    </ul>

                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active" id="data">
                            <table class="table table-bordered bootstrap-datatable datatable">
                                <colgroup>
                                    <col style="width: 50px;">
                                    <col style="width: 250px;">
                                    <col>
                                    <col style="width: 100px;">
                                    </colgroup>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Permissions</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $rownum=1; ?>
                                    @foreach($datarole as $role)
                                        <tr>
                                            <td>{{ $rownum++ }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @foreach($role->permissions as $perm)
                                                    <span class="label label-success">{{ $perm->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a class="btn btn-success btn-mini" href="{{URL::to('setting/role/edit/' . $role->id)}}" >Edit</a>
                                                <a class="btn btn-warning btn-mini" href="{{URL::to('setting/role/delete/'. $role->id)}}" >Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="new">
                            {{ Laravel\Form::open(null, 'POST', array('class'=>'form-horizontal')) }}
                                <fieldset>
                                      <div class="control-group">
                                        <label class="control-label" >Nama</label>
                                        <div class="controls">
                                              {{ Form::text('name',null,array('class'=>'input-large','autofocus','required','autocomplete'=>'off')) }}
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
                                                            {{ \Laravel\Form::checkbox('permissions[]', $perm->id) }}
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
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="reset" class="btn">Cancel</button>
                                      </div>
                                </fieldset>
                              {{ Form::close() }}
                        </div>
                    </div>
                </div>
        </div><!--/span-->

</div><!--/row-->





