<?php $rownum = 1;?>
<?php $pendapatan = 0;?>
<?php $pengeluaran = 0;?>
<table class="table table-striped table-bordered bootstrap-datatable " >
      <thead>
              <tr>
                  <th style="text-align: center;" >No</th>
                  <th style="text-align: center;" >Sumber Dana</th>
                  <th style="text-align: center;" >Tanggal</th>
                  <th style="text-align: center;" >Pendapatan (Rp)</th>
                  <th style="text-align: center;" >Pengeluaran (Rp)</th>
              </tr>
      </thead>   

      <tbody >
          @if(count($trans)>0)
            @foreach($trans as $tr)
                <tr>
                      <td>{{ $rownum++ }}</td>
                      <td>
                          <span>{{ $tr->biaya }}</span>
                          <br/>
                          <span style="margin-left: 10px;font-size: 0.9em;">
                          @if($tr->iuran == 'Y')
                              Siswa : <i>{{ $tr->siswa }} <strong>({{ $tr->nisn }})</strong> </i>
                          @else
                          Keterangan : <i>{{ $tr->ket }}</i>
                          @endif
                          </span>
                      </td>
                      <td>
                          {{ $tr->tgl }}
                      </td>
                      <td style="text-align: right;" class="angka">
                          @if($tr->jenis == 'M')
                              {{ $tr->total }}
                              <?php $pendapatan += $tr->total ?>
                          @else
                              -
                          @endif
                      </td>
                      <td style="text-align: right;" class="angka">
                          @if($tr->jenis == 'K')
                              {{ $tr->total }}
                              <?php $pengeluaran += $tr->total ?>
                          @else
                              -
                          @endif
                      </td>
                  </tr>
                @endforeach
                
                <tr style="font-weight: bold;color: white;font-size:1.5em;">
                    <td colspan="3" style="background-color: darkgrey;text-align: right;"> Total</td>
                    <td style="background-color: darkgrey;text-align: right;" class="angka">{{ $pendapatan }}</td>
                    <td style="background-color: darkgrey;text-align: right;" class="angka">{{ $pengeluaran }}</td>
                </tr>
          @else
                <tr>
                    <td colspan="4" style="text-align: center;">
                        {{ 'Tidak ada data yang ditemukan' }}
                    </td>
                </tr>
          @endif
      </tbody>
</table>