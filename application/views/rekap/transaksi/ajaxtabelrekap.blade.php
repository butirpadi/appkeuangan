<?php $rownum = 1;?>
<?php $pendapatan = 0;?>
<?php $pengeluaran = 0;?>
<table class="table table-striped table-bordered bootstrap-datatable " >
      <thead>
              <tr>
                  <th style="vertical-align: middle; text-align: center;" >No</th>
                  <th style="vertical-align: middle;text-align: center;" >Sumber Dana</th>
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
                          <span>
                              @if($tr->tipe == 'ITB')
                                    {{ $tr->jenisbiaya }}
                                    {{ '(Bulan : ' . $tr->bulan . ')' }}
                                        <!--Jika ada potongan-->
                                        <?php $tahun = Tahunajaran::find($tr->tahunajaran_id); ?>
                                        <?php $pot; ?>
                                        @foreach($tahun->potonganiuran()->where('siswa_id','=',$tr->siswa_id)->where('bulan_id','=',$tr->bulan_id)->get() as $sis)
                                            <br/>
                                            {{ 'Potongan ' . ($sis->pivot->jenis == 'BS' ? 'Beasiswa Prestasi' : 'Bantuan Pendidikan') . ' : Rp. ' . number_format($sis->pivot->nilai, 0, ',', '.') . '' }}
                                        @endforeach
                                        
                              @else
                                    {{ $tr->jenisbiaya }}
                              @endif
                          </span>
                          <br/>
                          <span style="font-size: 0.9em;">
                          @if($tr->tipe == 'ITB' || $tr->tipe == 'ITC' || $tr->tipe == 'IB')
                                    Siswa : <i>{{ $tr->siswa }} <strong>({{ $tr->nisn }})</strong> </i>
                          @else
                                Keterangan : <i>{{ $tr->ket }}</i>
                          @endif
                          </span>
                      </td>
                      <td>
                          {{ date('d-m-Y',strtotime($tr->tanggal)) }}
                      </td>
                      <td style="text-align: right;" class="uang">
                          @if($tr->arus == 'M')
                              {{ $tr->jumlah }}
                              <?php $pendapatan += $tr->jumlah ?>
                          @else
                              -
                          @endif
                      </td>
                      <td style="text-align: right;" class="uang">
                          @if($tr->arus == 'K')
                              {{ $tr->jumlah }}
                              <?php $pengeluaran += $tr->jumlah ?>
                          @else
                              -
                          @endif
                      </td>
                  </tr>
                @endforeach
                <!--total pendapatan dan pengeluaran-->
                <tr style="font-weight: bold;color: white;font-size:1.5em;">
                    <td colspan="3" style="background-color: darkgrey;text-align: right;"> Total</td>
                    <td style="background-color: darkgrey;text-align: right;" class="uang"><?php echo number_format($pendapatan, 0, ',', '.'); ?></td>
                    <td style="background-color: darkgrey;text-align: right;" class="uang"><?php echo number_format($pengeluaran, 0, ',', '.'); ?></td>
                </tr>
                <!--total pendapatan - pengeluaran-->
                <tr style="font-weight: bold;color: white;font-size:1.5em;">
                    <td colspan="3" style="background-color: darkgrey;text-align: right;"> Grand Total</td>
                    <td colspan="2" style="background-color: darkgrey;text-align: right;" class="uang"><?php echo number_format($pendapatan-$pengeluaran, 0, ',', '.'); ?></td>
                </tr>
          @else
                <tr>
                    <td colspan="5" style="text-align: center;">
                        {{ 'Tidak ada data yang ditemukan' }}
                    </td>
                </tr>
          @endif
      </tbody>
</table>