<!--			<div>
				<ul class="breadcrumb">
					<li>
						<a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Pengaturan Buku SPP</a>
					</li>
				</ul>
			</div>-->
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-book"></i> Pengaturan Buku SPP</h2>
						<div class="box-icon">
                                                    <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                                                </div>
					</div>
					<div class="box-content">
                                            <table class="table table-striped table-bordered bootstrap-datatable">
                                                <colgroup>
                                                    <col class="con1" style="align: center; width: 50px;"/>
                                                    <col class="con0" style="align: center; width: 80px;"/>
                                                    <col class="con1" />
                                                    <col class="con0" />
                                                    <col class="con1" />
                                                </colgroup>
                                              <thead>
                                                  <tr>
                                                      <th>No</th>
                                                      <th style="text-align: center;">Posisi</th>
                                                      <th>Bulan</th>
                                                      <th>Tanggal</th>
                                                      <th>Status</th>
                                                  </tr>
                                              </thead>   
                                              <tbody>
                                                  <?php $rownum = 1;?>
                                                  @foreach($bulans as $bln)
                                                    <tr>
                                                            <td>{{ $rownum++ }}</td>
                                                            <td style="text-align: center;">
                                                                <a href="{{ URL::to('setting/bukuspp/shiftup'.'/'.$bln->id) }}" class="label label-success" ><i class="icon-white icon-arrow-up"></i></a>
                                                                <a href="{{ URL::to('setting/bukuspp/shiftdown'.'/'.$bln->id) }}" class="label label-success" ><i class="icon-white icon-arrow-down"></i></a>
                                                            </td>
                                                            <td class="center">{{ strtoupper($bln->nama) }}</td>
                                                            <td class="center"><strong/> { tanggal pembayaran }</strong></td>
                                                            <td class="center"><span class="label label-success">&nbsp;Lunas&nbsp;</span> / <span class="label label-warning">&nbsp;Belum Lunas&nbsp;</span></td>
                                                    </tr>
                                                  @endforeach
                                              </tbody>
                                          </table>
					</div>
				</div><!--/span-->

			</div><!--/row-->


			
			
			
