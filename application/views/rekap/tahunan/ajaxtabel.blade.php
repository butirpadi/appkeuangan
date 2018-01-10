@if(count($trans)>0)
    <?php $rownum = 1;?>
    <?php $grandtotal = 0;?>
    <?php $saldomasuk = 0; ?>
    <?php $saldokeluar = 0; ?>
    <?php $totalmasuk = 0; ?>
    <?php $totalkeluar = 0; ?>

<table class="table table-bordered" >
    <colgroup>
        <col style="width: 50px;">
        <col>
        <col style="width: 15%;">
        <col style="width: 15%;">
    </colgroup>
    <thead>
            <tr>
                <th rowspan="2" style="vertical-align: middle; text-align: center;">No</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >Jenis Biaya</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >Masuk</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >Keluar</th>
            </tr>
    </thead>  
    <tbody>
        @foreach($trans as $tr)
            @if($tr->posisi_tahunajaran == $tahunajaran->posisi)
                <tr>
                    <td style="text-align: right;">{{$rownum++}}</td>
                    <td>{{ $tr->jenisbiaya }}</td>
                    <td class="uang">
                        @if($tr->arus == 'M')
                            {{ $tr->masuk }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="uang">
                        @if($tr->arus == 'K')
                            {{ $tr->keluar }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <?php $totalmasuk += $tr->masuk; ?>
                <?php $totalkeluar += $tr->keluar; ?>
            @endif
            
            @if($tr->posisi_tahunajaran < $tahunajaran->posisi)
                <?php $saldomasuk += $tr->masuk; ?>
                <?php $saldokeluar += $tr->keluar; ?>
            @endif
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
        <tr>
            <td style="text-align: right;">{{ $rownum++ }}</td>
            <td>Mutasi Kas ke Bank</td>
            <td class="uang">-</td>
            <td class="uang">
                <?php echo number_format($mutasikeluar,0,',','.'); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">{{ $rownum++ }}</td>
            <td>Mutasi Kas dari Bank</td>
            <td class="uang">
                <?php echo number_format($mutasimasuk,0,',','.'); ?>
            </td>
            <td class="uang">-</td>
        </tr>
        
        
        <tr style="background: #F4FBFE!important;font-weight: bold;">
            <td colspan="2" style="text-align: right;">SUB TOTAL</td>
            <td class="uang" >{{ $totalmasuk }}</td>
            <td class="uang" >{{ $totalkeluar }}</td>
        </tr>
        <tr style="background: #F4FBFE!important;font-weight: bold;">
            <td colspan="2" style="text-align: right;border-top: 2px solid grey!important;">TOTAL PENDAPATAN</td>
            <td colspan="2" class="uang" style="border-top: 2px solid grey!important;">{{ ($totalmasuk-$totalkeluar) }}</td>
        </tr>
        <!--CASH ON BANK-->
        <tr style="font-weight: bold;">
            <td colspan="2" style="text-align: right;">Cash On Bank</td>
            <td colspan="2" class="uang" ><?php echo number_format($cashonbank+$cob,0,',','.'); ?></td>
        </tr>
        <tr style="background: #F4FBFE!important;font-weight: bold;">
            <td colspan="2" style="text-align: right;">SALDO LALU</td>
            <td colspan="2" class="uang">{{ ($saldomasuk-$saldokeluar) }}</td>
        </tr>
        <tr style="background: #F4FBFE!important;font-weight: bolder;">
            <td colspan="2" style="text-align: right;border-top: 2px solid grey!important;">TOTAL SALDO</td>
            <td colspan="2" class="uang" style="border-top: 2px solid grey!important;">{{ (($saldomasuk-$saldokeluar)+($totalmasuk-$totalkeluar)+$cashonbank+$cob) }}</td>
        </tr>
    </tbody>
</table>

<style type="text/css">
    .uang,.nomer{
        text-align: right!important;
    }
</style>
    
@endif
