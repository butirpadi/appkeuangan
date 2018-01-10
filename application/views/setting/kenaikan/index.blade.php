@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            /**
             * set tahun ajaran aktif
             */
            var tahunaktif_id = "{{ $tahunaktif->id }}";
            jQuery('select[name=tahunajaran] option:[value='+ tahunaktif_id +']').css('background-color','green');
            jQuery('select[name=tahunajaran] option:[value='+ tahunaktif_id +']').css('color','white');
            /**
             * set selected tahun ajaran lanjutan
             */
            jQuery('select[name=tahunajaran]').change(function(){
                jQuery('#tabelData') .empty();
                setTahunLanjut();
            });
            /**
             * Fungsi set tahunajaran lanjut 
             */
            var tahunlanjut;
            var tahunselected_id;
             function setTahunLanjut(){
                 tahunselected_id = jQuery('select[name=tahunajaran]').attr('value');
                 var loadUrl = "{{ URL::to('setting/kenaikan/tahunajaranlanjut') }}" + "/" + tahunselected_id;
                jQuery.get(loadUrl, function(data) {
                    
                }).done(function(data){
                    tahunlanjut = jQuery.parseJSON(data); //get data tahunajaran lanjut with get to JSON
                    if(tahunlanjut != null){
                        jQuery('select[name=tahunajaranlanjut]').val(tahunlanjut.id );//set tahunajaran lanjut
                    }
                }).fail(function(data){
                    tahunlanjut = null;
                    jQuery('select[name=tahunajaranlanjut]').val([]);//set tahunajaran lanjut ke not selected jika data tahunajaran lanjut tidak ditemukan
                });
             }
            
            /**
             * buttonTampil click event
             * menampilkan data siswa
             */
             jQuery('#buttonTampil').click(function(){
                setTahunLanjut(); //set tahun ajaran lanjut jika sebelumnya belum di set
                if(tahunlanjut == null){
                    alert('Data tahun ajaran lanjut tidak tersedia.');
                }else{
                    //tampilkan data siswa
                    var jenjang = jQuery('select[name=jenjang]').attr('value');
                    var loadUrl = "{{ URL::to('setting/kenaikan/ajaxdata') }}" + "/"  + tahunselected_id + "/" + jenjang;
                    jQuery('#tabelData').load(loadUrl);
                }
             });
             /**
              * set on load
              */
             setTahunLanjut();
             /**
              * empty tableData ketika select[name=jenjang] change
              */
             jQuery('select[name=jenjang]').change(function(){
                jQuery('#tabelData') .empty();
             });
             /**
              * cetak data kenaikan siswa
              */
             jQuery('.buttonPrint').click(function(){
                var tahunajaran_id = jQuery('select[name=tahunajaran]').attr('value');
                var jenjang = jQuery('select[name=jenjang]').attr('value');
                var loadUrl = "{{ URL::to('setting/kenaikan/printtopdf') }}" + "/" + tahunajaran_id + "/" + jenjang;
                location.href = loadUrl;
             });
        });
    </script>
@endsection

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon icon-darkgray icon-contacts"></i> Siswa</h2>
                        <div class="box-icon">
                            <a href="#" class="btn btn-round buttonPrint"><i class="icon-print"></i></a>
                        </div>
                </div>
                <div class="box-content">
                    <table class="table table-striped table-bordered">
                        <colgroup>
                            <col style="width: 5%;">
                            <col style="width: 10%;">
                            <col>
                            <col style="width: 15%;">
                            <col style="width: 15%;">
                            <col style="width: 10%;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th colspan="3" style="vertical-align: middle;" >&nbsp;Set Opsi Jenjang dan Tahun Ajaran : <?php echo \Laravel\Form::select('jenjang', array('1' => '1-SD','2' => '2-SD','3' => '3-SD','4' => '4-SD','5' => '5-SD','6' => '6-SD'), null,array('class' => 'input-medium pull-right',)); ?></th>
                                <th><?php echo \Laravel\Form::select('tahunajaran', $selecttahun, $tahunaktif->id,array('class' => 'input-medium')); ?></th>
                                <th><?php echo \Laravel\Form::select('tahunajaranlanjut', $selecttahun, null,array('class' => 'input-medium','disabled')); ?></th>
                                <th><a class="btn btn-primary" id="buttonTampil" >Tampilkan</a></th>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Rombel</th>
                                <th>Naik ke</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="tabelData">
                            
                        </tbody>
                    </table>
                </div>
        </div><!--/span-->

</div><!--/row-->

<style type="text/css">
    table td{
        border: none;
        padding: 5px;
    }
    table select,table input{
        margin: 0;
    }
</style>


			
			
			
