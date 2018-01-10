<?php $rownum=1; ?>
<table class="table table-striped table-bordered datatable" id="table-data">
    <thead>
        <tr>
            <!-- <th>No</th> -->
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
        @foreach($data as $dt)
            <tr id="row_{{ $rownum }}" >
                <!-- <td>{{ $rownum++ }}</td> -->
                <td>{{ $dt->nama_siswa }}</td>
                <td>{{ $dt->nisn }}</td>
                <td>{{ $dt->rombel }}</td>
                <td>
                    {{$dt->jenis_potongan}}
                </td>
                <td>{{ $dt->ket }}</td>
                <td>{{ $dt->jenis_biaya }}</td>
                <td>
                    {{$dt->bulan}}
                </td>
                <td style="text-align: right;" class="uang">
                    {{$dt->harus_bayar}}
                </td>
                <td style="text-align: right;">
                    {{$dt->disc}}
                </td>
                <td style="text-align: right;" class="uang" >
                    {{$dt->nilai}}
                </td>
                <td style="text-align: right;" class="uang" >
                    {{$dt->sisa_bayar}}
                </td>
                <td>
                    <a rownumber="{{ $rownum }}" potid="{{ $dt->id }}" class="btn btn-mini btn-warning buttonDelete" >Delete</i></a>
                </td>
            </tr>
        @endforeach
        
    </tbody>
</table>

<script type="text/javascript">
    jQuery(document).ready(function(){
       
    });
</script>