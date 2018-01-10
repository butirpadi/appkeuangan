<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>NO</th>
            <th>Biaya</th>
            <th>Bulan</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
            <th>Opsi</th>
        </tr>
    </thead>
    <tbody>
        <?php $rownum=1;?>
        @foreach($detiltrans as $detrans)
            <tr id="{{ 'row_' . $detrans->id }}">
                <td>{{ $rownum++ }}</td>
                <td>{{ $detrans->jenisbiaya->nama }}</td>
                <td>{{ (isset($detrans->bulan) ? ucwords($detrans->bulan->nama) : '-') }}</td>
                <td>{{ $detrans->ket }}</td>
                <td>{{ $detrans->jumlah }}</td>
                <td>
                    <a class=" btn btn-mini btn-warning button-delete-detil" idtrans="{{ $detrans->transmasuk_id }}" iddetil="{{ $detrans->id }}" href="#"><i class="icon-white icon-trash"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>