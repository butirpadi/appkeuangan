<?php $rownum = 1; ?>
@foreach($siswas as $sis)
<tr>
    <td>{{ $rownum++ }}</td>
    <td>{{ $sis->nisn }}</td>
    <td>{{ $sis->nama }}</td>
    <td>{{ $sis->rombels()->where('tahunajaran_id','=',$tahunajaran->id)->first()->nama }}</td>
    
    <td>
        <?php $rombellanjut = $sis->rombels()->where('tahunajaran_id','=',$tahunlanjut->id)->first(); ?>
        
        @if($rombellanjut != null)
            <?php echo \Laravel\Form::select('rombellanjut', $selectrombel, ($rombellanjut ? $rombellanjut->id : null),array('class' => 'rombelLanjut','idsiswa' => $sis->id,'disabled')); ?>
        @else
            <?php echo \Laravel\Form::select('rombellanjut', $selectrombel, null,array('class' => 'rombelLanjut','idsiswa' => $sis->id)); ?>
        @endif
    </td>
    <td>
        @if($rombellanjut == null)
            <a class="btn btn-primary btn-mini buttonSimpan" href="#" idsiswa="{{ $sis->id }}" >Simpan</a>
        @endif
    </td>
</tr>
@endforeach

<script type="text/javascript">
    jQuery(document).ready(function(){
       /**
        * buttonSimpan click
        */
        jQuery('.buttonSimpan').click(function(){
            var tahunlanjut = jQuery('select[name=tahunajaranlanjut]').attr('value');
            var idsiswa = jQuery(this).attr('idsiswa');
            var rombel = jQuery('select[idsiswa='+ idsiswa + ']').attr('value');
            
            if(rombel == ''){
                alert('.:: PERINGATAN ::. Lengkapi data yang masih kosong.');
            }else{
                //set naik kelas dengan jQuery post
                jQuery.post("{{ URL::to('setting/kenaikan/naik') }}", {
                    tahunlanjut: tahunlanjut,
                    siswa: idsiswa,
                    rombel:rombel
                }).done(function(data){
                    alert('data telah berhasil disimpan.');
                    jQuery('.buttonSimpan[idsiswa='+idsiswa+']').hide(500); //sembunyikan tombol simpan jika telah berhasil disimpan
                    jQuery('select[idsiswa='+idsiswa+']').attr('disabled','disabled');
                }).fail(function(data){
                    alert('DATA GAGAL DISIMPAN, PERIKSA KEMBALI.');
                });
            }

            return false;
        });
        /**
         * set to not selected untuk select rombel lanjut yang belum di set
         */
         jQuery('select[name=rombellanjut]').each(function(){
            if(jQuery(this).attr('disabled') == 'disabled'){
                //do nothing jika select disabled, ini berarti sudah diset sebelumnya/sudah dilakukan kenaikan kelas
            }else{
                jQuery(this).val([]); //set select element ke not selected
            }
         });
    });
</script>