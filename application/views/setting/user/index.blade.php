<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">User</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon icon-darkgray icon-user"></i> User</h2>
                        <div class="box-icon">
                            <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    <div class="row-fluid">
                        <div class="span8">
                            <fieldset>
                                <legend>Data User</legend>
                            </fieldset>
                        </div>
                        <div class="span4">
                            <a href="{{ URL::To('setting/user/new') }}" class="btn btn-primary pull-right"><i class="icon-white icon-plus"></i> Tambah</a>
                        </div>
                        <br/>
                        <br/>
                        <table class="table table-bordered bootstrap-datatable datatable">
                                <colgroup>
                                    <col style="width: 50px;">
                                    <col style="width: 100px;" >
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                    </colgroup>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Nama</th>
                                        <th>Group</th>
                                        <th>Aktif</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $rownum=1;?>
                                    @foreach($datauser as $user)
                                        <tr id="row_{{ $user->id }}">
                                            <td>{{ $rownum++ }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>
                                                @foreach($user->roles as $role)
                                                    {{ $role->name  }}
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($user->verified == 1)
                                                    <span class="label label-success">AKTIF</span>
                                                @elseif($user->disabled == 1)
                                                    <span class="label label-warning">TIDAK AKTIF</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-mini btn-success" href="{{ URL::to('setting/user/edit/'.$user->id) }}">Edit</a>
                                                @if($user->username != 'admin')
                                                    <a userid="{{ $user->id }}" class="btn btn-mini btn-warning btn-delete" href="{{ URL::to('setting/user/delete/'.$user->id) }}">Delete</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
        </div><!--/span-->

</div><!--/row-->

@section('custom_script')
<script type="text/javascript">
    jQuery(document).ready(function(){
       /**
        * Delete account
        */ 
       jQuery('.btn-delete').click(function(){
          if(confirm('Anda akan menghapus data ini?') ){
              var userid = jQuery(this).attr('userid');
              var delUrl = "{{ URL::to('setting/user/delete') }}" + "/" + userid;
              jQuery.get(delUrl).done(function(){
                  //hide row
                  jQuery('#row_'+ userid).hide(500);
              });
          }
          
          return false
       });
    });
</script>
@endsection





