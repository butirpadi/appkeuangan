<style>
    table.table.input tbody tr td{
         border-top: none!important;
    }
</style>
<table class="table input">
    <tbody>
        <tr>
            <td>
                <strong>BULAN : </strong> {{ $bln }}
            </td>
            <td>
                <a class="btn btn-success pull-right btn-cetak"><i class="icon-white icon-print"></i> Cetak Dokumen</a>
            </td>
        </tr>
    </tbody>
</table>



<?php $pendapatan=0; ?>
<?php $pengeluaran=0; ?>

<table class="table table-condensed table-bordered datatable">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Biaya</th>
            <th>Siswa</th>
            <th>Ket</th>
            <th>Pendapatan</th>
            <th>Pengeluaran</th>
        </tr>
    </thead>
    <tbody>
        <?php $rownum=1; ?>
        @foreach($datarekap as $dr)
        <tr>
            <td>{{ $rownum++ }}</td>
            <td>{{ date('d-m-Y',strtotime($dr->tanggal)) }}</td>
            <td>
                {{ ucwords($dr->jenisbiaya) }}
                @if($dr->bulan != '')
                {{ '/ ' . ucwords($dr->bulan) }}
                @endif
            </td>
            <td>
                @if($dr->siswa != '')
                {{ $dr->siswa }}
                @else
                    -
                @endif
            </td>
            <td>
                @if($dr->ket != '')
                {{ ucfirst($dr->ket) }}
                @else
                    -
                @endif
            </td>
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
        
        <!--GENERATE TOTAL--> 
        <tr style="font-weight: bold;background-color: whitesmoke;">
            <td colspan="5">TOTAL</td>
            <td class="uang">{{ number_format($pendapatan,0,',','.') }}</td>
            <td class="uang">{{ number_format($pengeluaran,0,',','.') }}</td>
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
