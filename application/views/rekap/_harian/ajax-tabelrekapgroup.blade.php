@if($trans)
    <table class="table table-bordered table-striped">
          <thead>
                  <tr>
                      <th style="text-align: center;width: 10%;">No</th>
                      <th style="text-align: center;">Sumber Dana</th>
                      <th style="text-align: center;">Pendapatan (Rp)</th>
                      <th style="text-align: center;">Pengeluaran (Rp)</th>                                          
                  </tr>
          </thead>   
          <tbody>
              <?php $rownum = 1;?>
              <?php $masuk=0; ?>
              <?php $keluar=0; ?>
              @foreach($trans as $tr)
                <tr>
                    <td>{{ $rownum++ }}</td>
                    <td class="center">
                        <span>{{ $tr->biaya }}</span>                        
                    </td>
                    <td class="center uang" style="text-align: right;">
                        @if($tr->jenis == 'M')
                            {{ $tr->total }}
                            <?php $masuk +=$tr->total; ?> 
                        @else
                            -
                        @endif
                    </td>
                    <td class="center uang" style="text-align: right;">
                        @if($tr->jenis == 'K')
                            {{ $tr->total }}
                            <?php $keluar +=$tr->total; ?> 
                        @else
                            -
                        @endif
                    </td>
                </tr>
              @endforeach
              
              <tr style="font-weight: bold;font-size: larger;">
                    <td colspan="2" style="text-align: right;border-top: solid darkgray 2px;">Total (Rp)</td>
                    <td class="center uang" style="text-align: right;border-top: solid darkgray 2px;">
                        {{ $masuk }}
                    </td>
                    <td class="center uang" style="text-align: right;border-top: solid darkgray 2px;">
                        {{ $keluar }}
                    </td>
                </tr>
                <tr style="font-weight: bold;font-size: larger;">
                    <td colspan="3" style="text-align: right;border-top: solid darkgray 2px;">Grand Total (Rp)</td>
                    <td class="center uang" style="text-align: right;border-top: solid darkgray 2px;">
                        {{ $masuk - $keluar }}
                    </td>
                </tr>
          </tbody>
    </table>  
@else
    Kosong
@endif
