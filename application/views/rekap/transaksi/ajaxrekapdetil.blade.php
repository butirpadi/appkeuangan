<?php $rownum = 1;?>
<?php $pendapatan = 0;?>
<?php $pengeluaran = 0;?>
<?php $cob = 0;?>
<style type="text/css">
    table.table tbody tr td{
        vertical-align: top;
    }
</style>

<table class="table table-striped table-bordered bootstrap-datatable " >
      <thead>
              <tr>
                  <th style="vertical-align: middle; text-align: center;" >No</th>
                  <th style="vertical-align: middle;text-align: center;" >Sumber Dana</th>
                  <th style="vertical-align: middle;text-align: center;" >NIS</th>
                  <th style="vertical-align: middle;text-align: center;" >Siswa</th>
                  <th style="vertical-align: middle;text-align: center;" >Bulan</th>
                  <th style="vertical-align: middle;text-align: center;" >Keterangan</th>
                  <th style="vertical-align: middle;text-align: center;" >Tanggal<br/>(thn-bln-tgl)</th>
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
                      <td>
                          @if($tr->tipe == 'ITB' || $tr->tipe == 'ITC' || $tr->tipe == 'IB')
                                    {{ $tr->nisn }}
                          @else
                                -
                          @endif
                      </td>
                      <td>
                          @if($tr->tipe == 'ITB' || $tr->tipe == 'ITC' || $tr->tipe == 'IB')
                                    {{ $tr->siswa }}
                          @else
                                -
                          @endif
                      </td>
                      <td>
                            @if($tr->tipe == 'ITB')
                                {{ ucwords($tr->bulan )}}
                            @endif
                      </td>
                      <td>
                          
                                @if($tr->tipe == 'ITB')
                                        <!--Jika ada potongan-->
                                        <?php $tahun = Tahunajaran::find($tr->tahunajaran_id); ?>
                                        <?php $pot; ?>
                                        @foreach($tahun->potonganiuran()->where('siswa_id','=',$tr->siswa_id)->where('bulan_id','=',$tr->bulan_id)->get() as $sis)
                                            {{ 'Pot. ' . ($sis->pivot->jenis == 'BS' ? 'B Pres.' : 'B Pend.') . ' : Rp. ' . number_format($sis->pivot->nilai, 0, ',', '.')  }}
                                        @endforeach
                                @endif
                                
                                @if($tr->ket)
                                    {{ $tr->ket }}
                                @endif
                      </td>
                      <td>
                          {{ date('d-m-Y',strtotime($tr->tanggal)) }}
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
                @foreach($mutasi as $mt)
                    <tr>
                        <td style="text-align: right;vertical-align: top;">{{ $rownum++ }}</td>
                        <td>
                            @if($mt->asal == 'KU')
                                Mutasi Kas ke Bank
                            @else
                                Mutasi Kas dari Bank
                            @endif
                        </td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>{{ date('d-m-Y',strtotime($mt->tanggal)) }}</td>
                        <td class="uang">
                            @if($mt->asal == 'KB')
                                <?php echo number_format($mt->jumlah, 0,',', '.'); ?>
                                <?php $pendapatan += $mt->jumlah ?>
                                <?php $cob -= $mt->jumlah; ?>
                            @else
                                -
                            @endif
                        </td>
                        <td class="uang">
                            @if($mt->asal == 'KU')
                                <?php echo number_format($mt->jumlah, 0,',', '.'); ?>
                                <?php $pengeluaran += $mt->jumlah ?>
                                <?php $cob += $mt->jumlah; ?>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
                
                <!--TOTAL pendapatan dan pengeluaran-->
                <tr style="font-weight: bold;">
                    <td colspan="7" style="text-align: right;"> Total</td>
                    <td style="text-align: right;" class="uang"><?php echo number_format($pendapatan, 0, ',', '.'); ?> </td>
                    <td style="text-align: right;" class="uang"><?php echo number_format($pengeluaran, 0, ',', '.'); ?></td>
                </tr>
                <!--Cash On Bank-->
                <tr style="font-weight: bold;">
                    <td colspan="7" style="text-align: right;border-top: 2px darkgrey solid;"> Cash On Bank Periode ini</td>
                    <td colspan="2" style="text-align: right;border-top: 2px darkgrey solid;" class="uang"><?php echo number_format($cob, 0, ',', '.'); ?> </td>
                </tr>
                <!--Grand Total (pendapatan - pengeluaran)-->
                <tr style="font-weight: bold;color: white;font-size:1.5em;">
                    <td colspan="7" style="background-color: darkgrey;text-align: right;border-top: 2px darkgrey solid;"> Total Pendapatan Periode ini</td>
                    <td colspan="2" style="background-color: darkgrey;text-align: right;border-top: 2px darkgrey solid;" class="uang"><?php echo number_format($pendapatan-$pengeluaran + $cob, 0, ',', '.'); ?> </td>
                </tr>
          @else
                <tr>
                    <td colspan="9" style="text-align: center;">
                        {{ 'Tidak ada data yang ditemukan' }}
                    </td>
                </tr>
          @endif
      </tbody>
</table>