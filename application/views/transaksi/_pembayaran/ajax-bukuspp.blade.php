<div class="control-group" >
    <label class="control-label" >Buku SPP</label>
    <div class="controls" >
        <table class="table table-condensed" style="border: thin solid lightgrey;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bulan</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Status</th>                                          
                </tr>
            </thead>   
            <tbody>
                <?php $rownum=1; ?>
                @foreach($bukuspp as $spp)
                    <tr>
                      <td>{{ $rownum++ }}</td>
                      <td>{{ $spp->bulan->nama }}</td>
                      <td class="center">{{ $spp->tgl_bayar }}</td>
                      <td class="center">
                          @if($spp->status == 'L')
                            <span class="label label-success">Lunas</span>
                          @else
                            <span class="label label-warning">Belum Lunas</span>
                          @endif
                      </td>                                       
                  </tr>
                @endforeach
            </tbody>
        </table>
    </div>  
</div>
<div class="control-group" >
    <label class="control-label" >Pembayaran untuk</label>
    <div class="controls" >
        {{ Form::select('bulan',$bulanselect,null,array('id'=>'selectBulan','style'=>'text-transform: capitalize;')) }}
    </div>
</div>
                                

