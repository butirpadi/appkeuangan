<?php $rownum = 1;?>
<?php $grandtotal = 0;?>
<?php $total_bayar = 0;?>
<?php $total_kewajiban = 0;?>
<?php $total_potongan = 0;?>
<?php $total_sisa = 0;?>
<table class="table table-bordered" >
    <thead>
            <tr>
                <th rowspan="2" style="vertical-align: middle; text-align: center;" >NO</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >NISN</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >NAMA SISWA</th>
                @if(!$rombel)
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >ROMBEL</th>
                @endif
                <th colspan="12" style="vertical-align: middle;text-align: center;" >BULAN</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >BAYAR</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >KEWAJIBAN</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >POTONGAN</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >KEKURANGAN</th>
            </tr>
            <tr>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[0]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[1]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[2]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[3]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[4]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[5]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[6]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[7]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[8]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[9]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[10]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[11]->nama,0,3) }}</th>
            </tr>
    </thead>   

    <tbody>
        @foreach($data as $rek)
            <tr>
                <td class="nomer">{{ $rownum++ }}</td>
                <td>{{ $rek->nisn }}</td>
                <td>{{ $rek->siswa }}</td>
                @if(!$rombel)
                <td>{{ $rek->rombel }}</td>
                @endif
                <td class="uang">
                    @if($rek->juli)
                        <?php echo number_format($rek->juli, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->agustus)
                        <?php echo number_format($rek->agustus, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->september)
                        <?php echo number_format($rek->september, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->oktober)
                        <?php echo number_format($rek->oktober, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->november)
                        <?php echo number_format($rek->november, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->desember)
                        <?php echo number_format($rek->desember, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->januari)
                        <?php echo number_format($rek->januari, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->februari)
                        <?php echo number_format($rek->februari, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->maret)
                        <?php echo number_format($rek->maret, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->april)
                        <?php echo number_format($rek->april, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->mei)
                        <?php echo number_format($rek->mei, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->juni)
                        <?php echo number_format($rek->juni, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->total_bayar)
                        <?php echo number_format($rek->total_bayar, 0, ',', '.'); ?>
                        <?php $grandtotal += $rek->total_bayar; ?>
                        <?php $total_bayar += $rek->total_bayar; ?>
                    @else
                        0
                    @endif
                </td>
                <td class="uang">
                    @if($rek->harus_bayar)
                        {{number_format($rek->harus_bayar, 0, ',', '.')}}
                        <?php $total_kewajiban += $rek->harus_bayar; ?>
                    @else
                        0
                    @endif
                </td>
                <td class="uang">
                    @if($rek->potongan)
                        {{number_format($rek->potongan, 0, ',', '.')}}
                        <?php $total_potongan += $rek->potongan; ?>
                    @else
                        0
                    @endif
                </td>
                <td class="uang">
                    @if($rek->amount_due)
                        {{number_format($rek->amount_due, 0, ',', '.')}}
                        <?php $total_sisa += $rek->amount_due; ?>
                    @else
                        0
                    @endif
                </td>
            </tr>
        @endforeach
        <tr style="font-weight: bolder;">
            @if(!$rombel)
                <td colspan="16" style="text-align: center;">GRAND TOTAL</td>
            @else
                <td colspan="15" style="text-align: center;">GRAND TOTAL</td>
            @endif
            <td class="uang"><?php echo number_format($total_bayar, 0, ',', '.'); ?></td>
            <td class="uang"><?php echo number_format($total_kewajiban, 0, ',', '.'); ?></td>
            <td class="uang"><?php echo number_format($total_potongan, 0, ',', '.'); ?></td>
            <td class="uang"><?php echo number_format($total_sisa, 0, ',', '.'); ?></td>

            <!-- <td colspan="3" class="uang"><?php echo number_format($grandtotal, 0, ',', '.'); ?></td> -->
        </tr>
            
    </tbody>
</table>

<style type="text/css">
    .uang,.nomer{
        text-align: right!important;
    }
</style>
    