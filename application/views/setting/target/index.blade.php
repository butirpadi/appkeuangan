@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){   
            /**
             * Format uang on load
             */
            function formatRupiahOnLoad(){
                jQuery('.uang').each(function(){
                    formatRupiah(jQuery(this).attr('id'));
                });
            }
            formatRupiahOnLoad();
            /**
            * format rupiah di input uang
            */
            jQuery('.uang').on('focus',function(){
                unformatRupiah(jQuery(this).attr('id'));
            });
            jQuery('.uang').on('blur',function(){
                formatRupiah(jQuery(this).attr('id'));
            });
            /**
             * Update target pencapaian
             */
            jQuery('.buttonUpdate').click(function(){
               var target_id = jQuery(this).attr('id');
               var tahun_id = jQuery(this).attr('tahunid');
               var jumlah = jQuery('input[name='+target_id+']').attr('value');
               var unformat_jumlah = unformatRupiahVal(jumlah);
               //update target with jquery post
               jQuery.post("{{ URL::to('setting/target/targetpencapaian') }}", {
                    tahun_id: tahun_id,
                    jumlah: unformat_jumlah
                }).fail(function(data){
                    alert('DATA GAGAL UNTUK DISIMPAN. PERIKSA KEMBALI.');
                }).done(function(){
                    alert('Data telah berhasil di update.');
                    //location.reload();
                });
            });
            /**
             * TARGET PENCAPAIAN BULANAN
             */
             jQuery('.buttonSet').click(function(){
                //tampilkan data pencapaian
                var tahunajaran_id = jQuery('select[name=targetjenisbiaya]').attr('value');
                var loadUrl = "{{ URL::to('setting/target/ajaxtargetbulanan') }}" + "/" + tahunajaran_id;
                jQuery('#formTargetBulanan').load(loadUrl,function(){
                    formatRupiahOnLoad();
                });
             });
             /**
              * Select TargetJenisBiaya change
              */
             jQuery('select[name=targetjenisbiaya]').change(function(){
                //clear formTarget 
                jQuery('#formTargetBulanan').empty();
             });
             /**
              * Restore database
              */
             jQuery('.btn-restore').click(function(){
                 var upload = jQuery('input[name=fileupload]').attr('value');
                 if (upload == ''){
                     alert('.:: Peringatan ::. Pilih file backup.');
                    return false;
                 }
             });
        });
    </script>
@endsection

<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">System Setting</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable ui-sortable">
        <div class="box span12">
            <div class="box-header well" data-original-title="">
                <h2><i class="icon-cog"></i> Target Pencapaian Per Bulan</h2>
                <div class="box-icon">
                    <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                </div>
            </div>
            <div class="box-content">
                <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo \Laravel\Form::select('targetjenisbiaya', $selectjenisbiaya,null,array('style'=>'margin:0;')); ?>
                                    <a href="#" class="btn btn-primary buttonSet"  >Set</a>
                                </td>
                            </tr>
                            <tr>
                                <td id="formTargetBulanan"></td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </div><!--/span-->
</div>


<style type="text/css">
    table tr td{
        padding: 5px;
    }
    table tbody tr td select,table tbody tr td input{
        margin:0!important;
    }

    table tbody tr td{
        vertical-align: middle!important;
        /*border:thin solid red;*/
    }
    .uang{
        text-align: right;
    }

</style>