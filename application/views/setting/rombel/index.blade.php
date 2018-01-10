<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">Rombongan Belajar</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon-th-large"></i> Rombongan Belajar</h2>
                        <div class="box-icon">
                            <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    <div class="row-fluid">
                        <div class="span8">
                            <fieldset>
                                <legend>Data Rombongan Belajar</legend>
                            </fieldset>
                        </div>
                        <div class="span4">
                            <a href="{{ URL::To('setting/rombel/new') }}" class="btn btn-primary pull-right"><i class="icon-white icon-plus"></i> Tambah</a>
                        </div>
                        <br/>
                        <br/>
                        <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                <colgroup>
                                    <col class="con1" style="align: center; width: 50px;"/>
                                    <col class="con0" />
                                    <col class="con1" style="width: 100px;" />
                                    <col class="con0" style="align: center;width: 100px; " />
                                </colgroup>
                              <thead>
                                  <tr>
                                      <th>No</th>
                                      <th>Nama</th>
                                      <th>Jenjang</th>
                                      <th>Opsi</th>
                                  </tr>
                              </thead>   
                              <tbody>
                                  <?php $rownum = 1;?>
                                  @foreach($rombels as $rombel)
                                    <tr>
                                            <td>{{ $rownum++ }}</td>
                                            <td class="center">{{ $rombel->nama }}</td>
                                            <td class="center">
                                                @if($rombel->jenjang == 1)
                                                    1-SD
                                                @elseif($rombel->jenjang == 2)
                                                    2-SD
                                                @elseif($rombel->jenjang == 3)
                                                    3-SD
                                                @elseif($rombel->jenjang == 4)
                                                    4-SD
                                                @elseif($rombel->jenjang == 5)
                                                    5-SD
                                                @elseif($rombel->jenjang == 6)
                                                    6-SD
                                                @elseif($rombel->jenjang == 0)
                                                    Lulus
                                                @endif
                                            </td>
                                            <td class="center">
                                                <a class="btn btn-mini btn-success" href="{{ URL::to('setting/rombel/edit'.'/'.$rombel->id) }}" data-rel="tooltip" data-original-title="edit" >Edit</i></a>
                                                <a class="btn btn-mini btn-warning" href="{{ URL::to('setting/rombel/delete'.'/'.$rombel->id) }}" data-rel="tooltip" data-original-title="hapus" >Delete</i></a>
                                            </td>
                                    </tr>
                                  @endforeach
                              </tbody>
                          </table>
                    </div>
                </div>
        </div><!--/span-->

</div><!--/row-->





