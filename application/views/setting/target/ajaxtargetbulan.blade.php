<?php $rownum = 1;?>
<table class="table table-striped table-bordered">
    <thead>
        <th>No</th>
        <th>Tahun Ajaran</th>
        <th>Target Pencapaian</th>
    </thead>
    <tbody>
        @foreach($tahunajaran as $ta)
        <tr>
            <td>{{ $rownum++ }}</td>
            <td>{{ $ta->nama }}</td>
            <td>
                <?php $target = $jenisbiaya->targetbiayabulanan()->with('jumlah')->where('tahunajaran_id','=',$ta->id)->first(); ?>
                <?php echo \Laravel\Form::text('target_' . $ta->id, ($target ? $target->pivot->jumlah : ''), array('class' => 'input-medium uang','id' => 'target_'.$ta->id,'placeholder' => 'Rp. 0'))?>
                <a href="#" tahunid="{{ $ta->id }}"  class=" btn btn-primary buttonUpdate" >Update</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
    jQuery(document).ready(function(){
        /**
         * Format Rupiah
         */
        jQuery('.uang').on('focus',function(){
            unformatRupiah(jQuery(this).attr('id'));
        });
        jQuery('.uang').on('blur',function(){
            formatRupiah(jQuery(this).attr('id'));
        });
        /**
         * update target bulanan
         */
        jQuery('.buttonUpdate').click(function(){
           var tahunajaran_id = jQuery(this).attr('tahunid');
           var jenisbiaya_id = "{{ $jenisbiaya->id }}"; 
           var jumlah = unformatRupiahVal(jQuery(('#target_' + tahunajaran_id)).attr('value'));
           var postUrl =  "{{ URL::to('setting/target/targetbulanan') }}";
           jQuery.post(
               postUrl,
               {
                   tahunajaranid:tahunajaran_id,
                   jenisbiayaid:jenisbiaya_id,
                   jumlah:jumlah
               }
            ).done(function(data){
                    alert('Data telah berhasil disimpan.');
            }).fail(function(data){});
           
           return false;
        });
        
    });
</script>