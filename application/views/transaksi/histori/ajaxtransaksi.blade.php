<?php $rownum = 1;?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" >
    <colgroup>
        <col style="width: 50px;">
        <col style="width: 150px;">
        <col style="width: 100px;">
        <col>
        <col>
        <col>
        <col>
        <col>
        <col style="width: 125px;">        
    </colgroup>
      <thead>
              <tr>
                  <th style="vertical-align: middle; text-align: center;" >No</th>
                  <th style="vertical-align: middle;text-align: center;" >Tanggal</th>
                  <th style="vertical-align: middle;text-align: center;" >Arus</th>
                  <th style="vertical-align: middle;text-align: center;" >Siswa</th>
                  <th style="vertical-align: middle;text-align: center;" >NIS</th>
                  <th style="vertical-align: middle;text-align: center;" >Rombel</th>
                  <th style="vertical-align: middle;text-align: center;" >Keterangan</th>
                  <th style="vertical-align: middle;text-align: center;" >Total (Rp)</th>
                  <th style="vertical-align: middle;text-align: center;" >Opsi</th>
              </tr>
      </thead>   

      <tbody >
          @if(count($trans)>0)
            @foreach($trans as $tr)
                <tr id="row_{{ $tr->id }}">
                      <td>{{ $rownum++ }}</td>
                      <td>{{ date('d-m-Y',strtotime($tr->tanggal)) }}</td>
                      <td style="text-align: center;">
                          @if($tr->arus == 'M')
                            <span class="label label-success">PENERIMAAN</span>
                          @elseif($tr->arus == 'K')
                            <span class="label label-warning">PENGELUARAN</span>
                          @endif
                      </td>
                      <td>
                          @if($tr->siswa)
                            {{ $tr->siswa->nama }}
                          @else
                            -
                          @endif
                      </td>
                      <td>
                          @if($tr->siswa)
                            {{ $tr->siswa->nisn }}
                          @else
                            -
                          @endif
                      </td>
                      <td>
                            <?php $sis = $tr->siswa ?>
                            @if($sis)
                                {{ $sis->rombels()->where('tahunajaran_id','=',$tr->tahunajaran_id)->first()->nama }}
                            @else
                                -
                            @endif
                          
                      </td>
                      <td>
                          <?php $detrans = $tr->detiltransmasuks; ?>
                          @foreach($detrans as $det)
                            @if($det->ket != '')
                                {{ $det->jenisbiaya->nama .'[' . $det->ket . ']' . ', ' }} 
                            @else
                                {{ $det->jenisbiaya->nama . ', ' }} 
                            @endif
                          @endforeach
                          {{ '..' }}
                      </td>
                      <td class="uang" style="text-align: right;" >
                          <?php $total = 0;?>
                          @foreach($tr->detiltransmasuks as $det)
                            <?php $total += $det->jumlah; ?>
                          @endforeach
                          {{ $total }}
                      </td>
                      <td>
                          <a class="btn btn-mini btn-success buttonPreview" href="#" idtrans="{{ $tr->id }}" data-rel="tooltip" data-original-title="detil transaksi"><i class="icon-white icon-search"></i></a>
                           @if($tr->siswa)
                            <a class=" btn btn-mini btn-info buttonPrint" href="#" idtrans="{{ $tr->id }}" data-rel="tooltip" data-original-title="Cetak Nota"><i class="icon-white icon-print"></i></a>
                          @endif
                          <a class=" btn btn-mini btn-warning btn-delete-trans" href="#" idtrans="{{ $tr->id }}" data-rel="tooltip" data-original-title="Hapus Transaksi"><i class="icon-white icon-trash"></i></a>
                      </td>
                  </tr>
                @endforeach
          @else
<!--                <tr>
                    <td colspan="6" style="text-align: center;">
                        {{ 'Tidak ada data yang ditemukan' }}
                    </td>
                </tr>-->
          @endif
      </tbody>
</table>

<script>
    jQuery(document).ready(function(){
            /**
             * Cetak Nota Transaksi
             */
            jQuery('.buttonPrint').click(function(){
                var transaksi_id = jQuery(this).attr('idtrans');
                
                if (confirm('Anda akan mencetak nota untuk transaksi ini?')){
                    // var loadUrl = "{{ URL::to('transaksi/histori/cetaknotajzebra') }}";
                    // //cetak nota with post
                    // jQuery.post(loadUrl, {
                    //     trans_id : transaksi_id
                    // }).done(function(data){
                    //     //print using jzebra
                    //     printNota(data);
                    //     alert('Cetak nota sedang di proses');
                        
                    // }).fail(function(data){
                    //     alert('NOTA GAGAL DICETAK');
                    // });

                    // create Nota with direct print PHP COPY
                    // form = $('<form>').attr('action','transaksi/histori/cetaknotadirect').attr('method','POST');
                    // form.append($('<input>').attr('name','trans_id').val(transaksi_id));
                    // $('body').append(form);
                    // form.submit();
                    
                    // jQuery.post('transaksi/histori/cetaknotadirect', {
                    //     trans_id : transaksi_id
                    // }).done(function(data){
                    //     alert('Cetak nota sedang di proses');
                    // }).fail(function(data){
                    //     // alert('NOTA GAGAL DICETAK');
                    // });

                    var form = $('<form>').attr('target','_blank').attr('method','post').attr('action','transaksi/histori/cetaknotadirect').append($('<input>').attr('type','hidden').attr('name','trans_id').val(transaksi_id));
                    $('body').append(form);
                    form.submit();

                    alert('Cetak nota sedang di proses');

                    // $.post(loadUrl,{
                    //   trans_id : transaksi_id
                    // },function(data){
                    //   alert(data);
                    //   alert('Cetak nota sedang di proses.');
                    // }).fail(function(data){
                    //   alert(data);
                    //     alert('NOTA GAGAL DICETAK');
                    // });
                }
               return false;
            });
            /**
             * Hapus Transaksi
             */
             jQuery('.btn-delete-trans').click(function(){
                var transaksi_id = jQuery(this).attr('idtrans');
                
                if (confirm('Anda akan menghapus data transaksi ini?')){
                    var loadUrl = "{{ URL::to('transaksi/histori/deletetrans') }}";
                    //cetak nota with post
                    jQuery.get(loadUrl, {
                        trans_id : transaksi_id
                    }).done(function(data){
                        alert('.:: INFO ::. Data telah dihapus.');
                        jQuery('#row_'+transaksi_id).hide(500);
                    }).fail(function(data){
                        alert('.:: ERROR ::. Data gagal dihapus.');
                    });
                }
                
                return false;
             });
    });
</script>

<div id="ajaxRes"></div>
    