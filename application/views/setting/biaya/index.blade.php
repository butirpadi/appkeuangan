<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">Biaya</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon-list-alt"></i> Biaya</h2>
                        <div class="box-icon">
                            <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    <div class="row-fluid">
                        <div class="span8">
                            <fieldset>
                                <legend>Data Biaya</legend>
                            </fieldset>
                        </div>
                        <div class="span4">
                            <a href="{{ URL::To('setting/biaya/new') }}" class="btn btn-primary pull-right"><i class="icon-white icon-plus"></i> Tambah</a>
                        </div>
                        <br/>
                        <br/>
                        <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                <colgroup>
                                    <col class="con1" style="align: center; width: 50px;"/>
                                    <col class="con0" />
                                    <col class="con1" style="align: center;width: 200px;" />
                                    <col class="con0" style="align: center;width: 75px;" />
                                    <col class="con1" style="align: center;width: 75px;" />
                                    <col class="con0" style="align: center;width: 100px;" />
                                </colgroup>
                              <thead>
                                  <tr>
                                      <th>No</th>
                                      <th>Nama</th>
                                      <th>Jenis</th>
                                      <th>Perjenjang</th>
                                      <th>Arus</th>
                                      <th>Opsi</th>
                                  </tr>
                              </thead>   
                              <tbody>
                                  <?php $rownum = 1; ?>
                                  @foreach($jenisbiaya as $biaya)
                                    <tr>
                                            <td style="text-align: right;">{{ $rownum++ }}</td>
                                            <td>{{ $biaya->nama }}</td>
                                            <td style="text-align: center;">
                                                @if($biaya->tipe == 'ITB')
                                                    <span class="label label-success">&nbsp;Iuran Tetap Bulanan&nbsp;</span>
                                                @elseif($biaya->tipe == 'ITC')
                                                    <span class="label label-warning">&nbsp;Iuran Tetap Cicilan&nbsp;</span>
                                                @elseif($biaya->tipe == 'BTBI')
                                                    <span class="label label-important">&nbsp;Biaya Tetap Bukan Iuran&nbsp;</span>
                                                @elseif($biaya->tipe == 'BBBI')
                                                    <span class="label label-info">&nbsp;Biaya Bebas Bukan Iuran&nbsp;</span>
                                                @elseif($biaya->tipe == 'IB')
                                                <span class="label" style="background-color: #0074cc;">&nbsp;Iuran Bebas&nbsp;</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center;" >
                                                @if($biaya->perjenjang == 'Y')
                                                    <span class="label label-success"><i class="icon-ok icon-white"></i></span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td style="text-align: center;" >
                                                @if($biaya->arus == 'M')
                                                    <span class="label label-success"> MASUK </span>
                                                @else
                                                    <span class="label label-important"> KELUAR </span>
                                                @endif
                                            </td>
                                            <td style="text-align: center;">

                                                    <a class="btn btn-mini btn-success" href="{{ URL::to('setting/biaya/edit'.'/'.$biaya->id) }}" data-rel="tooltip" data-original-title="edit" >Edit</a>
                                                    <!--Biaya SPP tidak boleh dihapus-->
                                                    @if($biaya->id > 1)
                                                    <a class="btn btn-mini btn-warning" href="{{ URL::to('setting/biaya/delete'.'/'.$biaya->id) }}" data-rel="tooltip" data-original-title="hapus" >Delete</i></a>
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