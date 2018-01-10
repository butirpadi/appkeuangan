<!--			<div>
				<ul class="breadcrumb">
					<li>
						<a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Tahun Ajaran</a>
					</li>
				</ul>
			</div>-->
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-calendar"></i> Tahun Ajaran</h2>
						<div class="box-icon">
                                                    <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                                                </div>
					</div>
					<div class="box-content">
                                            <div class="row-fluid">
                                                <div class="span8">
                                                    <fieldset>
                                                        <legend>Data Tahun Ajaran</legend>
                                                    </fieldset>
                                                </div>
                                                <div class="span4">
                                                    <a href="{{ URL::To('setting/tahunajaran/new') }}" class="btn btn-primary pull-right"><i class="icon-white icon-plus"></i> Tambah</a>
                                                </div>
                                                <br/>
                                                <br/>
                                                <table class="table table-striped table-bordered bootstrap-datatable datatable">
                                                        <colgroup>
                                                            <col class="con1" style="align: center; width: 50px;"/>
                                                            <col class="con0" />
                                                            <col class="con1" style="width: 100px;"/>
                                                            <col class="con0" style="width: 100px;" />
                                                            <col class="con1" style="align: center;width: 100px; " />
                                                        </colgroup>
                                                          <thead>
                                                              <tr>
                                                                  <th>No</th>
                                                                  <th>Nama</th>
                                                                  <th>Aktif</th>
                                                                  <th>Atur Posisi/Urutan</th>
                                                                  <th>Opsi</th>
                                                              </tr>
                                                          </thead>   
                                                          <tbody>
                                                              <?php $rownum = 1; ?>
                                                              @foreach($tahunajarans as $tahun)
                                                                <tr>
                                                                        <td>{{ $rownum++ }}</td>
                                                                        <td class="center">{{ $tahun->nama }}</td>
                                                                        <td class="center">
                                                                            @if($tahun->aktif == 'Y')
                                                                                <span class="label label-success">Aktif</span>
                                                                            @else
                                                                                <span class="label label-warning">Not Aktif</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ URL::to('setting/tahunajaran/shiftup/' . $tahun->id) }}" class="label label-success"><i class="icon-white icon-arrow-up"></i></a>
                                                                            <a href="{{ URL::to('setting/tahunajaran/shiftdown/' . $tahun->id ) }}" class="label label-success"><i class="icon-white icon-arrow-down"></i></a>
                                                                        </td>
                                                                        <td class="center">
                                                                            <a class="btn btn-success btn-mini" href="{{ URL::to('setting/tahunajaran/edit'.'/'.$tahun->id) }}" data-rel="tooltip" data-original-title="edit" >Edit</i></a>
                                                                            <a class="btn btn-warning btn-mini" href="{{ URL::to('setting/tahunajaran/delete'.'/'.$tahun->id) }}" data-rel="tooltip" data-original-title="hapus" >Delete</a>
                                                                        </td>
                                                                </tr>
                                                              @endforeach
                                                          </tbody>
                                                      </table>
                                            </div>
					</div>
				</div><!--/span-->

			</div><!--/row-->
                        <style type="text/css">
                            table.table thead th{
                                text-align: center;
                                vertical-align: middle;
                            }
                        </style>


			
			
			
