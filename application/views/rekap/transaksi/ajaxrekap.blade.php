<?php $rownum = 1;?>
<?php $pendapatan = 0;?>
<?php $pengeluaran = 0;?>
<?php $cob = 0;?>
<table class="table table-striped table-bordered bootstrap-datatable " >
      <thead>
              <tr>
                  <th style="vertical-align: middle; text-align: center;" >No</th>
                  <th style="vertical-align: middle;text-align: center;" >Sumber Dana</th>
                  <th style="vertical-align: middle;text-align: center;" >Pendapatan (Rp)</th>
                  <th style="vertical-align: middle;text-align: center;" >Pengeluaran (Rp)</th>
              </tr>
      </thead>   

      <tbody >
          @if(count($trans)>0)
            @foreach($trans as $tr)
                <tr>
                        <td style="text-align: right;vertical-align: top;">{{ $rownum++ }}</td>
                        <td>
                            {{ $tr->jenisbiaya }}
                        </td>
                      <td style="text-align: right;" class="uang">
                          @if($tr->arus == 'M')
                              <?php echo number_format($tr->jumlah, 0, ',', '.'); ?>
                              <?php $pendapatan += $tr->jumlah ?>
                          @else
                              -
                          @endif
                      </td>
                      <td style="text-align: right;" class="uang">
                          @if($tr->arus == 'K')
                              <?php echo number_format($tr->jumlah, 0, ',', '.'); ?>
                              <?php $pengeluaran += $tr->jumlah ?>
                          @else
                              -
                          @endif
                      </td>
                  </tr>
                @endforeach
                
                <!--list mutasi-->
                <?php $mutasikebank = 0; ?>
                <?php $mutasidaribank = 0; ?>
                @foreach($mutasi as $mt)
                    @if($mt->asal == 'KU')
                        <?php $mutasikebank += $mt->jumlah ?>
                        <?php $pengeluaran += $mt->jumlah ?>
                        <?php $cob += $mt->jumlah ?>
                    @elseif($mt->asal =='KB')
                        <?php $mutasidaribank += $mt->jumlah ?>
                        <?php $pendapatan += $mt->jumlah ?>
                        <?php $cob -= $mt->jumlah ?>
                    @endif
                @endforeach
                @if(count($mutasi) > 0)
                    <tr>
                        <td style="text-align: right;vertical-align: top;">{{ $rownum++ }}</td>
                        <td>Mutasi ke bank</td>
                        <td class="uang">-</td>
                        <td class="uang"><?php echo number_format($mutasikebank, 0, ',', '.') ; ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;vertical-align: top;">{{ $rownum++ }}</td>
                        <td>Mutasi dari bank</td>
                        <td  class="uang" ><?php echo number_format($mutasidaribank, 0, ',', '.') ; ?></td>
                        <td class="uang">-</td>
                    </tr>
                @endif
                
                
                <!--total pendapatan dan pengeluaran-->
                <tr style="font-weight: bold;">
                    <td colspan="2" style="text-align: right;"> Total</td>
                    <td style="text-align: right;" class="uang"><?php echo number_format($pendapatan, 0, ',', '.'); ?></td>
                    <td style="text-align: right;" class="uang"><?php echo number_format($pengeluaran, 0, ',', '.'); ?></td>
                </tr>
                <!--Cash On Bank-->
                <tr style="font-weight: bold;">
                    <td colspan="2" style="text-align: right;border-top: 2px darkgrey solid;"> Cash On Bank Periode ini</td>
                    <td colspan="2" style="text-align: right;border-top: 2px darkgrey solid;" class="uang"><?php echo number_format($cob, 0, ',', '.'); ?> </td>
                </tr>
                <!--total pendapatan-pengeluaran-->
                <tr style="font-weight: bold;color: white;font-size:1.5em;">
                    <td colspan="2" style="background-color: darkgrey;text-align: right;"> Total Pendapatan Periode ini</td>
                    <td colspan="2" style="background-color: darkgrey;text-align: right;" class="uang"><?php echo number_format($pendapatan-$pengeluaran+$cob, 0, ',', '.'); ?></td>
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