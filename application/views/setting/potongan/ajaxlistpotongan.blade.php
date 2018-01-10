<?php $rownum=0; ?>
<table class="table table-striped table-bordered datatable">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>NIS</th>
            <th>Rombel</th>
            <th>Jenis</th>
            <th>Keterangan</th>
            <th>Iuran</th>
            <th>Bulan</th>
            <th>Harus Bayar</th>
            <th>Pot (%)</th>
            <th>Pot (Rp)</th>
            <th>Sisa Bayar (Rp)</th>
            <th>Opsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tahunajaran->potonganiuran as $th)
        <?php $rownum+=1; ?>
        <?php $jenisbiaya = Jenisbiaya::find($th->pivot->jenisbiaya_id); ?>
        <tr id="row_{{ $rownum }}" >
            <td>{{ $rownum }}</td>
            <td>{{ $th->nama }}</td>
            <td>{{ $th->nisn }}</td>
            <td>{{ $th->rombels()->where('tahunajaran_id','=',$tahunajaran->id)->first()->nama; }}</td>
            <td>
                @if($th->pivot->jenis == 'BP')
                    <span class="label label-warning">Bantuan Pendidikan</span>
                @else
                    <span class="label label-success">Beasiswa Prestasi</span>
                @endif
            </td>
            <td>{{ $th->pivot->ket }}</td>
            <td>{{ $jenisbiaya->nama }}</td>
            <td>{{ ($jenisbiaya->tipe == 'ITB' ? ucwords(Bulan::find($th->pivot->bulan_id)->nama) : '-') }}</td>
            <td style="text-align: right;" class="uang">
                <?php $rom =  $th->rombels()->where('tahunajaran_id','=',$tahunajaran->id)->first(); ?>
                <?php $iuran = $jenisbiaya->ketetapanbiaya()->where('tahunajaran_id','=',$tahunajaran->id)->where('jenjang','=',$rom->jenjang)->first()->pivot->jumlah; ?>
                {{ $iuran }}
            </td>
            <td style="text-align: right;">{{ $th->pivot->disc }}</td>
            <td style="text-align: right;" class="uang" >{{ $th->pivot->nilai }}</td>
            <td style="text-align: right;" class="uang" >
                {{ $iuran - $th->pivot->nilai }}
            </td>
            <td>
                <a rownumber="{{ $rownum }}" potid="{{ $th->pivot->id }}" class="btn btn-mini btn-warning buttonDelete" >Delete</i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
    jQuery(document).ready(function(){
       
    });
</script>