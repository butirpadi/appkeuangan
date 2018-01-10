<table class="table table-striped table-bordered bootstrap-datatable tablesiswa">
  <thead>
      <tr>
          <th>No</th>
          <th>Nomor Induk</th>
          <th>Nama</th>
          <th>Jenjang</th>
          <th>Status</th>
          <th>Mutasi</th>
          <th>Rombongan Belajar</th>
          <th>Opsi</th>
      </tr>
  </thead>   
  <tbody>
      <?php $rownum = 1;?>
      @foreach($siswas as $siswa)
        <tr>
                <td>{{ $rownum++ }}</td>
                <td class="center">{{ $siswa->nisn }}</td>
                <td class="center">{{ $siswa->siswa }}</td>
                <td class="center">{{ $siswa->jenjang }}</td>
                <td class="center">
                        @if($siswa->aktif == 'Y')
                            <span class="label label-success">AKTIF</span>
                        @else
                            <span class="label label-warning">TIDAK AKTIF</span>
                        @endif
                </td>
                <td class="center" style="text-align: center;">
                    @if($siswa->mutasi == 'Y')
                        <span class="label label-success">MUTASI</span>
                    @else
                        -
                    @endif
                </td>
                <td class="center">{{ $siswa->rombel }}</td>
                <td class="center">
                    <a class="btn btn-warning btn-mini" href="{{ URL::to('setting/siswa/edit'.'/'.$siswa->siswa_id . '/' . $tahunajaran->id) }}" data-rel="tooltip" data-original-title="edit" >Edit</a>&nbsp;
                    <!--<a class="btn btn-mini btn-danger" href="{{ URL::to('setting/siswa/delete'.'/'.$siswa->siswa_id) }}" data-rel="tooltip" data-original-title="hapus" >Non Aktifkan!</a>-->
                </td>
        </tr>
      @endforeach
  </tbody>
</table>
