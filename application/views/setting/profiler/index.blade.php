@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){    
            
            
        });
    </script>
@endsection

<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">Profile</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable ui-sortable">
        <div class="box span12">
            <div class="box-header well" data-original-title="">
                    <h2><i class="icon-cog"></i> My Profile</h2>
                    <div class="box-icon">
                        <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                    </div>
            </div>
            <div class="box-content">
                        <div class="tab-pane active" id="global">
                            {{ \Laravel\Form::open(URL::to('setting/profiler/update'), 'POST')}}
                            {{ \Laravel\Form::hidden('user_id', $user->id)}}
                            <table class="table-striped">
                                <tbody>
                                    <tr>
                                        <td>Username</td>
                                        <td>{{ \Laravel\Form::text('username', $user->username,array('readonly','class'=>'input-xlarge'))}}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td>{{ \Laravel\Form::text('name', $user->name,array('class'=>'input-xlarge'))}}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Password</td>
                                        <td>{{ \Laravel\Form::password('password', array('placeholder'=>'input untuk mengganti password lama','class'=>'input-xlarge'))}}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>{{ \Laravel\Form::submit('Update', array('class'=>'btn btn-primary'))}}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            {{ \Laravel\Form::close()}}
                        </div>                
            </div>
        </div><!--/span-->
</div>


<style type="text/css">
    table tr td{
        padding: 5px;
    }
    table tbody tr td select,table tbody tr td input{
        margin:0!important;
    }

    table tbody tr td{
        vertical-align: middle!important;
        /*border:thin solid red;*/
    }
    .uang{
        text-align: right;
    }

</style>