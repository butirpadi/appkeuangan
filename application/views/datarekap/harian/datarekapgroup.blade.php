<style>
    table.table.input tbody tr td{
         border-top: none!important;
    }
</style>
<table class="table input">
    <tbody>
        <tr>
            <td>
                <strong>PERIODE : </strong> {{ $awal . ' - ' . $akhir }}
            </td>
            <td>
                <a class="btn btn-success pull-right btn-cetak"><i class="icon-white icon-print"></i> Cetak Dokumen</a>
            </td>
        </tr>
    </tbody>
</table>

<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No</th>
            <th>Biaya</th>
            <th>Pendapatan</th>
            <th>Pengeluaran</th>
        </tr>
    </thead>
    <tbody>
        <?php $rownum=1; ?>
        <?php $pendapatan=0; ?>
        <?php $pengeluaran=0; ?>
        @foreach($datarekap as $dr)
        <tr>
            <td class="uang">{{ $rownum++ }}</td>
            <td>{{ $dr->jenisbiaya }}</td>
            <td class="uang">
                @if($dr->arus == 'M')
                    {{ number_format($dr->jumlah,0,',','.') }}
                    <?php $pendapatan += $dr->jumlah; ?>
                @else
                -
                @endif
            </td>
            <td class="uang">
                @if($dr->arus == 'K')
                    {{ number_format($dr->jumlah,0,',','.') }}
                    <?php $pengeluaran += $dr->jumlah; ?>
                @else
                -
                @endif
            </td>
        </tr>
        @endforeach
        <tr style="background-color: whitesmoke;font-weight: bolder;font-size: large;">
            <td colspan="2">TOTAL</td>
            <td class="uang" >{{ number_format($pendapatan,0,',','.') }}</td>
            <td class="uang" >{{ number_format($pengeluaran,0,',','.') }}</td>
        </tr>
    </tbody>
</table>

<div style="font-weight: bold;" class="alert alert-block  alert-heading span6">
    <table>
        <tr>
            <td>K E T E R A N G A N</td>
        </tr>
        <tr>
            <td>PENDAPATAN </td>
            <td>:</td>
            <td>Rp.</td>
            <td class="uang" >{{ number_format($pendapatan,0,',','.') }}</td>
        </tr>
        <tr>
            <td>PENGELUARAN </td>
            <td>:</td>
            <td>Rp.</td>
            <td class="uang" style="border-bottom: solid thin black;" >{{ number_format($pengeluaran,0,',','.') }}</td>
        </tr>
        <tr>
            <td>S E L I S I H</td>
            <td>:</td>
            <td>Rp.</td>
            <td class="uang"  >{{ number_format($pendapatan-$pengeluaran,0,',','.') }}</td>
        </tr>
    </table>
</div>