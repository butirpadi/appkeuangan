			<div>
				<ul class="breadcrumb">
					<li>
						<a href="{{ URL::to('home') }}">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Transaksi Pembayaran</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-calendar"></i> Transaksi Pembayaran</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                                            <fieldset class="form-horizontal">
                                                            <div class="control-group">
                                                                <label class="control-label" >Tahun Ajaran</label>
                                                                <div class="controls">
                                                                    {{Form::select('tahunajaran',$taselect,$tahunaktif->id)}}
                                                                </div>
                                                              </div>
                                                            <div class="control-group">
                                                                <label class="control-label" >Jenis Biaya</label>
                                                                <div class="controls">
                                                                    {{Form::select('biaya',$byselect)}}
                                                                </div>
                                                              </div>
                                                            <div class="control-group">
                                                                <label class="control-label" >Siswa</label>
                                                                <div class="controls">
                                                                    {{Form::text('siswa','2565 - Afia Najah Abdullah Hafizah',array('class'=>'input-xxlarge'))}}
                                                                </div>
                                                              </div>                                                             
                                                          <div class="form-actions">
                                                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                                                          </div>
                                                    </fieldset>
                                                    
                                                    <div>
                                                        <table class="table table-bordered" id="_tabelnya">
                <colgroup>
                    <col class="con1" style="align: center; width: 4%">
                    <col class="con0" style="align:right">
                    <col class="con1" style="align:right">
                    <col class="con0" style="align:right">
                    <col class="con1" style="align:right">
                    <col class="con0" style="align:right">
                    <col class="con1" style="align:right">
                    <col class="con0" style="align:right">
                    <col class="con1" style="align:right">
                    <col class="con0" style="align:right">
                    <col class="con1" style="align:right">
                    <col class="con0" style="align:right">
                    <col class="con1" style="align:right">
                    <col class="con0" style="align:right">
                    <col class="con1" style="align:right">
                    <col class="con0" style="align:right">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head0" style="vertical-align: middle;">No</th>
                        <th class="head1" style="vertical-align: middle;">NISN</th>
                        <th class="head0" style="vertical-align: middle;">Nama</th>
                        <th class="head1">Jul</th>
                        <th class="head0">Ags</th>
                        <th class="head1">Sep</th>
                        <th class="head0">Okt</th>
                        <th class="head1">Nov</th>
                        <th class="head0">Des</th>
                        <th class="head1">Jan</th>
                        <th class="head0">Feb</th>
                        <th class="head1">Mar</th>
                        <th class="head0">Apr</th>
                        <th class="head1">Mei</th>
                        <th class="head0">Jun</th>
                        <th class="head1">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="head0">1</td>
                        <td class="head1">2565</td>
                        <td class="head0">Afia Najah A. Hafizah</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">0</td>
                        <td class="head1">0</td>
                        <td class="head0">0</td>
                        <td class="head1">450.000</td>
                    </tr>
                    <tr>
                        <td class="head0">1</td>
                        <td class="head1">2565</td>
                        <td class="head0">Afia Najah A. Hafizah</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">0</td>
                        <td class="head1">0</td>
                        <td class="head0">0</td>
                        <td class="head1">450.000</td>
                    </tr>
                    <tr>
                        <td class="head0">2</td>
                        <td class="head1">2565</td>
                        <td class="head0">Maulana Malik Ibrahim</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">0</td>
                        <td class="head1">0</td>
                        <td class="head0">0</td>
                        <td class="head1">450.000</td>
                    </tr>
                    <tr>
                        <td class="head0">3</td>
                        <td class="head1">2565</td>
                        <td class="head0">Faliha Farannisa</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">0</td>
                        <td class="head1">0</td>
                        <td class="head0">0</td>
                        <td class="head1">450.000</td>
                    </tr>
                    <tr>
                        <td class="head0">4</td>
                        <td class="head1">2565</td>
                        <td class="head0">Muhammad Sultan Al Fatih</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">0</td>
                        <td class="head1">0</td>
                        <td class="head0">0</td>
                        <td class="head1">450.000</td>
                    </tr>
                    <tr>
                        <td class="head0">5</td>
                        <td class="head1">2565</td>
                        <td class="head0">Awilla Najah</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">0</td>
                        <td class="head1">0</td>
                        <td class="head0">0</td>
                        <td class="head1">450.000</td>
                    </tr>
                    <tr>
                        <td class="head0">6</td>
                        <td class="head1">2565</td>
                        <td class="head0">Farhad Achibly</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">0</td>
                        <td class="head1">0</td>
                        <td class="head0">0</td>
                        <td class="head1">450.000</td>
                    </tr>
                    <tr>
                        <td class="head0">7</td>
                        <td class="head1">2565</td>
                        <td class="head0">Afia Naila Arkarna</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">50.000</td>
                        <td class="head1">50.000</td>
                        <td class="head0">0</td>
                        <td class="head1">0</td>
                        <td class="head0">0</td>
                        <td class="head1">450.000</td>
                    </tr>
                    <!--TOTAL-->
                    <tr style="background: whitesmoke;">
                        <td class="head0" colspan="3" style="text-align: center;font-weight: bold;">Total</td>
                        <td class="head1"><strong>350.000</strong></td>
                        <td class="head0"><strong>350.000</strong></td>
                        <td class="head1"><strong>350.000</strong></td>
                        <td class="head0"><strong>350.000</strong></td>
                        <td class="head1"><strong>350.000</strong></td>
                        <td class="head0"><strong>350.000</strong></td>
                        <td class="head1"><strong>350.000</strong></td>
                        <td class="head0"><strong>350.000</strong></td>
                        <td class="head1"><strong>350.000</strong></td>
                        <td class="head0">0</td>
                        <td class="head1">0</td>
                        <td class="head0">0</td>
                        <td class="head1"><strong>3.1150.000</strong></td>
                    </tr>
                    
                </tbody>
            </table> 
                                                    </div>
					</div>
				</div><!--/span-->

			</div><!--/row-->


