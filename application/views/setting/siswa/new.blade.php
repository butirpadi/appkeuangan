<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="{{ URL::to('setting/siswa') }}">Siswa</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">Tambah</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon icon-darkgray icon-contacts"></i> Tambah Siswa</h2>
                        <div class="box-icon">
                            <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                        {{ Laravel\Form::open(null, 'POST', array('class'=>'form-horizontal')) }}
                            <fieldset>
                                <div class="control-group">
                                    <div class="controls">
                                        <?php echo Laravel\Form::checkbox('instant', 0, false, array('style' => 'margin:0;')); ?> Input Cepat
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls" style="background-color: #aae268;padding: 5px;width: 100px;">
                                        <?php echo Laravel\Form::checkbox('mutasi', true, false, array('style' => 'margin:0;')); ?> <strong>MUTASI</strong>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" >Tahun Ajaran</label>
                                    <div class="controls">
                                          {{ Form::select('tahunajaraninput',$selectTahunAjaran,(isset($tahunaktif) ? $tahunaktif->id : null),array('class'=>'tahun')) }}
                                    </div>
                                  </div>
                                  <div class="control-group">
                                    <label class="control-label" >Nomor Induk</label>
                                    <div class="controls">
                                          {{ Form::text('nisn',null,array('class'=>'input-mini','autocomplete' => 'off')) }}
                                    </div>
                                  </div>
                                <div class="control-group">
                                    <label class="control-label" >Nama</label>
                                    <div class="controls">
                                          {{ Form::text('nama',null,array('class'=>'span6','required','autocomplete' => 'off')) }}
                                    </div>
                                  </div>
                                <div class="control-group">
                                    <label class="control-label" >Rombongan Belajar</label>
                                    <div class="controls" id="form-rombel-select" ></div>
                                  </div>
                                  <div class="form-actions">
                                      <button type="submit" class="btn btn-primary" id="buttonSimpan">Save</button>
                                      <a href="{{ URL::to('setting/siswa') }}" class="btn">Cancel</a>
                                  </div>
                            </fieldset>
                          {{ Form::close() }}
                </div>
        </div><!--/span-->

</div><!--/row-->
@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            /**
             * Tampilkan rombel hanya kelas satu saat load
             */
            function showRombel(jenjang){
                var getUrl = "{{ URL::to('setting/siswa/rombelselect') }}" + "/" + jenjang;
                jQuery('#form-rombel-select').load(getUrl,function(){
                   jQuery('select[name=rombel]').val([]); 
                });
            }
            showRombel(1)
            /**
             * checkbox checked
             */
            jQuery('input[name=mutasi]').change(function(){
               var mutasi = jQuery('input[name=mutasi]').attr('checked');
               if(mutasi == 'checked'){
                   //tampilkan semua kelas
                   showRombel('all');
               }else{
                   //tampilkan hanya kelas satu
                   showRombel(1);
               }
            });
            /**
             * buttonSave clicked
             */
             jQuery('#buttonSimpan').click(function(){
                if(jQuery('input[name=instant]').is(':checked')){
                    var nama = jQuery('input[name=nama]').attr('value');
                    var nisn = jQuery('input[name=nisn]').attr('value');
                    var rombel = jQuery('select[name=rombel]').val();
                    var tahunajaran_id = jQuery('select[name=tahunajaraninput]').val();
                    var mutasi = jQuery('input[name=mutasi]').attr('checked');
                    if(mutasi == 'checked'){
                        mutasi = true;
                    }                    
                    //insert with ajax post
                    jQuery.post("{{ URL::to('setting/siswa/new') }}", {
                        nama: nama,
                        nisn: nisn,
                        rombel:rombel,
                        tahunajaraninput:tahunajaran_id,
                        mutasi:mutasi
                    }, function(data) {
                        alert('.:: INFORMASI ::. Data transaksi telah disimpan.');
                        //bersihkan inputan
                        jQuery('input[name=nama]').attr('value','');
                        jQuery('input[name=nisn]').attr('value','');
                        jQuery('select[name=rombel]').val([]);
                        jQuery('input[name=nisn]').focus();
                    });
                    
                    return false;
                }
             });
           
        });
    </script>
@endsection