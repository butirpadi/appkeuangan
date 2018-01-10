<table class="table table-striped table-bordered bootstrap-datatable datatable">
    <colgroup>
        <col class="con1" style="align: center; width: 50px;"/>
        <col class="con0" />
        <col class="con1" />
        <col class="con0" />
        <col class="con1" />
        <col class="con0" style="align: center;width: 100px; " />
    </colgroup>
  <thead>
      <tr>
          <th>No</th>
          <th>Tanggal</th>
          <th>Asal</th>
          <th>Tujuan</th>
          <th>Jumlah (Rp.)</th>
          <th>Opsi</th>
      </tr>
  </thead>   
  <tbody>
      <?php $rownum = 1;?>
      @foreach($datamutasi as $mutasi)
      <tr id="row_{{$rownum}}">
                <td>{{ $rownum }}</td>
                <td >{{ date('d-m-Y',strtotime($mutasi->tanggal)) }}</td>
                <td >
                    @if($mutasi->asal == 'KU')
                        Kas Utama
                    @elseif($mutasi->asal == 'KB')
                        Bank
                    @endif
                </td>
                <td >
                    @if($mutasi->tujuan == 'KU')
                        Kas Utama
                    @elseif($mutasi->tujuan == 'KB')
                        Bank
                    @endif
                </td>
                <td class="uang"><?php echo number_format($mutasi->jumlah, 0, ',', '.');?></td>
                <td class="center">
                    <a class="btn btn-mini btn-success" href="{{ URL::to('transaksi/mutasi/edit'.'/'.$mutasi->id) }}" data-rel="tooltip" data-original-title="edit" >Edit</i></a>
                    <a rownumber="{{ $rownum }}" mutasiId="{{ $mutasi->id }}" class="btn btn-mini btn-warning btn-hapus" href="{{ URL::to('transaksi/mutasi/delete'.'/'.$mutasi->id) }}" data-rel="tooltip" data-original-title="hapus" >Delete</i></a>
                </td>
        </tr>
        <?php $rownum++; ?>
      @endforeach
  </tbody>
</table>

<script type="text/javascript">
    jQuery(document).ready(function(){
            /**
              * delete beasiswa/potongan
              */
             jQuery('.btn-hapus').click(function(){
                 if(confirm('Anda akan menghapus data ini?')){
                        var id = jQuery(this).attr('mutasiId');
                        var rownumber = jQuery(this).attr('rownumber');
                        var delUrl = "{{ URL::to('transaksi/mutasi/delete') }}";
                        jQuery.get(delUrl,{id:id}).done(function(){
                            //remove row item
                            jQuery('#row_'+ parseInt(rownumber)).hide(250);
                        }).fail(function(){
                            alert('.::PERINGATAN::. Data gagal dihapus.');
                        });
                 }
                 
                 return false;
            }) ;
    })
</script>