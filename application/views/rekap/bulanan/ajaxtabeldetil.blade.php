@if(count($trans)>0)
    <?php $rownum = 1;?>
    <?php $grandtotal = 0;?>
    <?php $saldomasuk = 0; ?>
    <?php $saldokeluar = 0; ?>
    <?php $totalmasuk = 0; ?>
    <?php $totalkeluar = 0; ?>

<table class="table table-bordered table-striped" >
<!--    <colgroup>
        <col style="width: 50px;">
        <col>
        <col style="width: 15%;">
        <col style="width: 15%;">
    </colgroup>-->
    <thead>
            <tr>
                <th rowspan="2" style="vertical-align: middle; text-align: center;">No</th>
                <th rowspan="2" style="vertical-align: middle; text-align: center;">Tanggal</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >Biaya</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >NIS</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >Siswa</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >Bulan</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >Keterangan</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >Pendapatan</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >Pengeluaran</th>
            </tr>
    </thead>  
    <tbody>
        @foreach($trans as $tr)
                <tr>
                    <td style="text-align: right;">{{$rownum++}}</td>
                    <td>{{ date('d-m-Y',strtotime($tr->tanggal)) }}</td>
                    <td>{{ $tr->jenisbiaya }}</td>
                    <td>
                        @if($tr->nisn)
                            {{ $tr->nisn }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($tr->siswa)
                            {{ $tr->siswa }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ ucwords($tr->bulan) }}</td>
                    <td>{{ ucwords($tr->ket) }}</td>
                    <td class="uang">
                        @if($tr->arus == 'M')
                            <?php echo number_format($tr->jumlah, 0, ',', '.');?>
                            <?php $totalmasuk += $tr->jumlah; ?>
                        @else
                        -
                        @endif
                    </td>
                    <td class="uang">
                        @if($tr->arus == 'K')
                            <?php echo number_format($tr->jumlah, 0, ',', '.');?>
                            <?php $totalkeluar += $tr->jumlah; ?>
                        @else
                        -
                        @endif
                    </td>
                </tr>
                
        @endforeach
        
        <!--MUTASI-->
        <?php $mutasikeluar = 0; ?>
        <?php $mutasimasuk = 0; ?>
        <?php $cob = 0; ?>
        @foreach($mutasi as $mt)
                @if($mt->asal == 'KU')
                     <!--mutasi keluar-->
                     <?php $mutasikeluar += $mt->jumlah;?>
                     <?php $totalkeluar += $mt->jumlah;?>
                     <?php $cob += $mt->jumlah;?>
                @else
                    <!--mutasi masuk-->
                    <?php $mutasimasuk += $mt->jumlah;?>
                    <?php $totalmasuk += $mt->jumlah;?>
                    <?php $cob -= $mt->jumlah;?>
                @endif
        @endforeach
<!--        <tr>
            <td style="text-align: right;">{{ $rownum++ }}</td>
            <td>Mutasi Kas ke Bank</td>
            <td >-</td>
            <td >-</td>
            <td >-</td>            
            <td >-</td>            
            <td class="uang">-</td>
            <td class="uang">
                <?php echo number_format($mutasikeluar,0,',','.'); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">{{ $rownum++ }}</td>
            <td>Mutasi Kas dari Bank</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>            
            <td>-</td>            
            <td class="uang">
                <?php echo number_format($mutasimasuk,0,',','.'); ?>
            </td>
            <td class="uang">-</td>
        </tr>-->
        <!--data mutasi-->
        @foreach($mutasi as $mut)
            <tr>
                <td style="text-align: right;">{{ $rownum++ }}</td>
                <td>{{ date('d-m-Y',strtotime($mut->tanggal)) }}</td>
                @if($mut->asal == 'KU')
                    <td>Mutasi Kas ke Bank</td>
                @else
                    <td>Mutasi Kas dari Bank</td>
                @endif
                
                <td>-</td>
                <td>-</td>
                <td>-</td>            
                <td>-</td>  
                @if($mut->asal == 'KU')
                    <td class="uang">-</td>
                    <td class="uang">
                        <?php echo number_format($mut->jumlah,0,',','.'); ?>
                    </td>
                @else
                    <td class="uang">
                        <?php echo number_format($mut->jumlah,0,',','.'); ?>
                    </td>
                    <td class="uang">-</td>
                @endif
            </tr>
        @endforeach
        
        <!--total masuk dan keluar-->
        <tr style="font-weight: bold;">
            <td colspan="7" style="text-align: right;border-top:solid 2px grey;">TOTAL</td>
            <td class="uang" style="border-top:solid 2px grey;"><?php echo number_format($totalmasuk,0,',','.'); ?></td>
            <td class="uang" style="border-top:solid 2px grey;"><?php echo number_format($totalkeluar,0,',','.'); ?></td>
        </tr>
        <!--TOTAL PENDAPATAN-->
        <tr style="font-weight: bold;">
            <td colspan="7" style="text-align: right;border-top:solid 2px grey;">TOTAL PENDAPATAN</td>
            <td colspan="2" class="uang" style="border-top:solid 2px grey;"><?php echo number_format($totalmasuk-$totalkeluar,0,',','.'); ?></td>
        </tr>
        <!--CASH ON BANK-->
        <tr style="font-weight: bold;">
            <td colspan="7" style="text-align: right;">Cash On Bank</td>
            <td colspan="2" class="uang" ><?php echo number_format($cashonbank+$cob,0,',','.'); ?></td>
        </tr>
<!--        CASH ON BANK LALU
        <tr style="font-weight: bold;">
            <td colspan="2" style="text-align: right;">Cash On Bank lalu</td>
            <td colspan="2" class="uang" ><?php echo number_format($cashonbank,0,',','.'); ?></td>
        </tr>-->
        <!--saldo masa lalu-->
        <tr style="font-weight: bold;">
            <td colspan="7" style="text-align: right;">SALDO LALU</td>
            <td colspan="2" class="uang" ><?php echo number_format($pendapatanlalu-$pengeluaranlalu,0,',','.'); ?></td>
        </tr>
        <!--SALDO SAAT INI-->
        <tr style="font-weight: bold;">
            <td colspan="7" style="text-align: right;border-top:solid 2px grey;">SALDO SAAT INI</td>
            <td colspan="2" class="uang" style="border-top:solid 2px grey;"><?php echo number_format(($totalmasuk-$totalkeluar)+($pendapatanlalu-$pengeluaranlalu)+$cob+$cashonbank,0,',','.'); ?></td>
        </tr>
    </tbody>
</table>

<style type="text/css">
    .uang,.nomer{
        text-align: right!important;
    }
</style>
    
@endif
