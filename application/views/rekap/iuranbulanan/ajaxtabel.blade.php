@if(count($trans)>0)
    <?php $rownum = 1;?>
    <?php $grandtotal = 0;?>
    <?php $saldomasuk = 0; ?>
    <?php $saldokeluar = 0; ?>
    <?php $totalmasuk = 0; ?>
    <?php $totalkeluar = 0; ?>

<table class="table table-bordered table-striped" >
    <colgroup>
        <col style="width: 50px;">
        <col>
        <col style="width: 15%;">
    </colgroup>
    <thead>
            <tr>
                <th rowspan="2" style="vertical-align: middle; text-align: center;">No</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >Jenis Biaya</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >Jumlah</th>
            </tr>
    </thead>  
    <tbody>
        <?php $total=0;?>
        @foreach($trans as $tr)
            <?php $detrans = $tr->detiltransmasuks()->where('jenisbiaya_id','=',$jenisbiaya->id)->get(); ?>
            <?php $total += $tr->detiltransmasuks()->where('jenisbiaya_id','=',$jenisbiaya->id)->sum('jumlah'); ?>
            @foreach($detrans as $det)
                @if($detil == 'true')
                <!--cetak detil per transaksi-->
                    <tr>
                        <td>{{ $rownum++ }}</td>
                        <td>{{ $det->jenisbiaya->nama . ' [' . $tr->siswa->nama . ']' . ' [' . date('d-m-Y',strtotime($tr->tanggal)) . ']' }}</td>
                        <td class="uang">{{ $det->jumlah }}</td>
                    </tr>
                @endif
            @endforeach
        @endforeach
        
        <!--cetak total--> 
        @if($detil=='true')
        <tr style="font-weight: bold;">
            <td colspan="2" style="text-align: right;border-top : 2px solid darkgray;" >TOTAL</td>
            <td class="uang" style="border-top: 2px solid darkgray;">{{ $total }}</td>
        </tr>
        @endif
        <!--cetak satu row-->
        @if($detil=='false')
        <tr>
            <td>1</td>
            <td>Total Penerimaan {{ $jenisbiaya->nama }}</td>
            <td class="uang">{{ $total }}</td>
        </tr>
        @endif
        <!--//pencapaiannya-->
        <tr style="font-weight: bold;">
            <td colspan="2" style="text-align: right;border-top: 2px solid darkgray;">Target Pencapaian</td>
            <td class="uang"style="border-top: 2px solid darkgray;">
                @if($pencapaian)
                    {{ $pencapaian->pivot->jumlah }}
                @else
                    -
                @endif
            </td>
        </tr>
        <tr style="font-weight: bold;">
            <td colspan="2" style="text-align: right;">Selisih Pencapaian</td>
            <td class="uang">
                @if($pencapaian)
                    {{ ($total)-($pencapaian->pivot->jumlah) }}
                @else
                    -
                @endif
            </td>
        </tr>
        
    </tbody>
</table>

<style type="text/css">
    .uang,.nomer{
        text-align: right!important;
    }
</style>
    
@endif
