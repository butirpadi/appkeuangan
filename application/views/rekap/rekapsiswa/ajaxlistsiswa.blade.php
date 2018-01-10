<?php $rownum=1; ?>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>NO</th>
            <th>NIS</th>
            <th>NAMA</th>
            <th>ROMBEL</th>
            <th>OPSI</th>
        </tr>
    </thead>
    <tbody>
        @foreach($listsiswa as $sis)
        <tr>
            <td>{{ $rownum++ }}</td>
            <td>{{ $sis->nisn }}</td>
            <td>{{ $sis->nama }}</td>
            <td>{{ $sis->rombel }}</td>
            <td>
                <a nis="{{ $sis->nisn }}" data-dismiss="modal" class="btn btn-mini btn-primary btn-pilih">Pilih</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>