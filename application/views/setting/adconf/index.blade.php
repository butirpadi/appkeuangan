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
                        <a href="#">Admin System Config</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable ui-sortable">
        <div class="box span12">
            <div class="box-header well" data-original-title="">
                    <h2><i class="icon-cog"></i> Admin System Config</h2>
                    <div class="box-icon">
                        <a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>
                    </div>
            </div>
            <div class="box-content">
                <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#global">Global Setting</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active" id="global">
                            <fieldset>
                                <legend>MYSQLDUMP</legend>
                                <table class="table-striped">
                                    <tbody>
                                        <tr>
                                            {{\Laravel\Form::open(URL::to('setting/adconf/mysqldumppath'), 'POST')}}
                                            <td>Mysqldump Path</td>
                                            <td>{{Laravel\Form::text('mysqldumppath', $appset->mysqldumppath, array('class'=>'input-large','autocomplete'=>'off'))}}</td>
                                            <td>{{\Laravel\Form::submit('Update', array('class'=>'btn btn-primary'))}}</td>
                                            <td><i>Jangan diganti untuk settingan ini, tanpa pengetahuan lebih lanjut.</i></td>
                                            {{\Laravel\Form::close()}}
                                        </tr>
                                    </tbody>
                                </table>
                            </fieldset>
                            <br/>
                            <fieldset>
                                <legend>STATUS PEMBAYARAN</legend>
                                <div class="alert  {{ ($appset->lunas =='Y' ? 'alert-block' : 'alert-error') }} ">
                                    <h4 class="alert-heading" style="text-align: center;">{{ ($appset->lunas =='Y' ? 'S U D A H &nbsp;&nbsp;&nbsp; L U N A S' : 'B E L U M &nbsp;&nbsp;&nbsp; L U N A S') }}</h4>
                                </div>
                                @if($appset->lunas == 'N')
                                    <div style="text-align: center;">
                                        <a  href="{{ URL::to('setting/adconf/lunasi/Y') }}" class="btn btn-primary"  >LUNASI SEKARANG</a>
                                    </div>
                                @else
                                    <div style="text-align: center;">
                                        <a  href="{{ URL::to('setting/adconf/lunasi/N') }}" class="btn btn-warning"  >BATAL LUNASI</a>
                                    </div>
                                @endif
                            </fieldset>
                            <br/>
                            <fieldset>
                                <legend>APP LOCKER</legend>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $rownum=1;?>
                                        @foreach($applockers as $act)
                                        <tr>
                                            {{\Laravel\Form::open(URL::to('setting/adconf/applocker_update'),'POST');}}
                                            {{\Laravel\Form::hidden('applocker_id', $act->id);}}
                                            <td>{{ $rownum++ }}</td>
                                            <td>{{\Laravel\Form::text('tanggal'.$act->id, date('d-m-Y',strtotime($act->tanggal)),array('class'=>'datepicker'));}}</td>
                                            <td>{{\Laravel\Form::select('lunas'.$act->id, array('N'=>'BELUM LUNAS','Y'=>'LUNAS'),$act->lunas);}}</td>
                                            <td>
                                                {{\Laravel\Form::submit('UPDATE', array('class'=>'btn btn-primary'))}}
                                                <a href="{{ URL::to('setting/adconf/applocker_delete/' . $act->id) }}" class="btn btn-primary" ><i class="icon-trash icon-white"></i></a>
                                            </td>
                                            {{\Laravel\Form::close();}}
                                        </tr>
                                        @endforeach
                                        <tr style="background-color: #2187b5;">
                                            {{\Laravel\Form::open(URL::to('setting/adconf/applocker'),'POST');}}
                                            <td></td>
                                            <td>{{\Laravel\Form::text('tanggal', null,array('class'=>'datepicker'));}}</td>
                                            <td>{{\Laravel\Form::select('lunas', array('N'=>'BELUM LUNAS','Y'=>'LUNAS'));}}</td>
                                            <td>{{\Laravel\Form::submit('SAVE',array('class'=>'btn btn-success'));}}</td>
                                            {{\Laravel\Form::close();}}
                                        </tr>
                                    </tbody>
                                </table>
                            </fieldset>
                            <fieldset>
                                <legend>PRINTER</legend>
                                <table class="table-striped">
                                    <tbody>
                                        <tr>
                                            {{\Laravel\Form::open(URL::to('setting/adconf/printer'), 'POST')}}
                                            {{\Laravel\Form::hidden('appset_id', $appset->id);}}
                                            <td>Line Kertas</td>
                                            <td>{{Laravel\Form::text('linekertas', $appset->linekertas, array('class'=>'input-mini','autocomplete'=>'off'))}}</td>
                                            <td>Space Printer</td>
                                            <td>{{Laravel\Form::text('spaceprinter', $appset->spaceprinter, array('class'=>'input-mini','autocomplete'=>'off'))}}</td>
                                            <td>Character Count</td>
                                            <td>{{Laravel\Form::text('charcount', $appset->charcount, array('class'=>'input-mini','autocomplete'=>'off'))}}</td>
                                            <td>{{\Laravel\Form::submit('Update', array('class'=>'btn btn-primary'))}}</td>
                                            <td></td>
                                            {{\Laravel\Form::close()}}
                                        </tr>
                                    </tbody>
                                </table>
                            </fieldset>
                            
                        </div>
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