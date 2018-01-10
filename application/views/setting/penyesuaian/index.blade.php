@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            
            /**
             * Set tahun ajaran aktif
             */
            function setTahunAjaranAktif(){
                var tahunaktif_id = "{{ $tahunaktif->id }}";
                jQuery('#selectTahun option[value=' + tahunaktif_id + ']').css('background-color','green');
                jQuery('#selectTahun option[value=' + tahunaktif_id + ']').css('color','white');
            }
            setTahunAjaranAktif();
            
            /**
             * cari data siswa dengan NIS
             */
            var siswa;
            var sppsiswa;
            jQuery('.btn-cari-nis').click(function(){
                var nis = jQuery('input[name=nis]').val();
                var tahun = jQuery('select[name=tahunajaran]').val();
                
                if(nis != ''){
                    //get siswa
                    var getSiswaUrl = "{{ URL::to('setting/penyesuaian/siswabynis') }}" + "/" + tahun + "/" + nis;
                    jQuery.ajax({url:getSiswaUrl,dataType:"json",async:false,cache: false,
                        success:function(data){
                          siswa = data;
                          //set siswa to form
                          jQuery('input[name=nama]').val(siswa.siswa);
                          jQuery('input[name=rombel]').val(siswa.rombel);
                          jQuery('input[name=jenjang]').val(siswa.jenjang + '-SD');
                        },
                        error:function(data){
                            alert('Data Siswa tidak ditemukan.');
                            jQuery('input[name=nama]').val('');
                            jQuery('input[name=rombel]').val('');
                            jQuery('input[name=jenjang]').val('');
                        }
                    });
                    
                    //get nilai spp
                    var getSppUrl = "{{ URL::to('setting/penyesuaian/sppsiswa') }}" + "/" + tahun + "/" + nis;
                    jQuery.ajax({url:getSppUrl,dataType:"json",async:false,cache: false,
                        success:function(data){
                          sppsiswa = data;
                          //set siswa to form
                          jQuery('input[name=spp]').val(formatRupiahVal(sppsiswa.jumlah));
                        },
                        error:function(data){
                            jQuery('input[name=spp]').val('');
                        }
                    });
                }else{
                    alert('Lengkapi data yang kosong');
                }
            });
            
            /**
             * get nilai spp penyesuaian
             */
             var nilaispp;
             jQuery('select[name=jenjang_sesuai],select[name=mutasi]').val([]);
             jQuery('select[name=jenjang_sesuai]').change(function(){
                    var jenjang = jQuery('select[name=jenjang_sesuai]').val();
                    var tahun = jQuery('select[name=tahunajaran]').val();
                    var getNilaiUrl = "{{ URL::to('setting/penyesuaian/nilaispp') }}" + "/" + tahun + "/" + jenjang;
                    jQuery.ajax({url:getNilaiUrl,dataType:"json",async:false,cache: false,
                        success:function(data){
                          nilaispp = data;
                          //set siswa to form
                          jQuery('input[name=nilai_sesuai]').val(formatRupiahVal(nilaispp.jumlah));
                        },
                        error:function(data){
                            jQuery('input[name=nilai_sesuai]').val('');
                        }
                    });
             });
             
             /**
              * simpan penyesuaian
              */
              jQuery('.btn-simpan').click(function(){
                    if (siswa != null){
                        var jenjang_sesuai = jQuery('select[name=jenjang_sesuai]').val();
                        var postPenyesuaian = "{{ URL::to('setting/penyesuaian/penyesuaian') }}";
                        var mutasi = jQuery('select[name=mutasi]').val();
                         jQuery.post(postPenyesuaian, {
                                siswa_id: siswa.siswa_id,
                                jenjang_sesuai: jenjang_sesuai,
                                jenjang_awal: siswa.jenjang,
                                mutasi : mutasi
                            }).done(function(data){
                                //masuk ke halamn utama
                                alert('Data penyesuaian telah disimpan');
                                jQuery('#form-check').html(data);
                            }).fail(function(data){
                                alert('Data gagal disimpan, perikasa kembali');
                                jQuery('#form-check').html(data);
                            });
                    }else{
                        alert('Lengkapi data yang kosong');
                    }
              });
            
        });
    </script>
@endsection
<div id="form-check"></div>
<div class="row-fluid sortable">
        <div class="box span8">
                <div class="box-header well" data-original-title>
                    <h2><i class="icon-list-alt"></i> Penyesuaian Nilai SPP </h2>
                        <div class="box-icon">
                            <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    <div class="row-fluid">
                            <fieldset class="form-horizontal">
                                <div class="control-group">
                                    <label class="control-label" >Tahun Ajaran</label>
                                    <div class="controls">
                                          {{\Laravel\Form::select('tahunajaran', $selectTahunajaran,(isset($tahunaktif) ? $tahunaktif->id : null),array('id'=>'selectTahun','style'=>'width:125px;margin:0;'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" >NIS</label>
                                    <div class="controls">
                                          {{ Form::text('nis',null,array('class'=>'input-mini','autofocus','autocomplete' => 'off')) }}
                                          <a class="btn btn-primary btn-cari-nis"><i class="icon-search icon-white "></i></a>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" >Nama</label>
                                    <div class="controls">
                                          {{ Form::text('nama',null,array('class'=>'input-xxlarge','autocomplete' => 'off')) }}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" >Rombel</label>
                                    <div class="controls">
                                          {{ Form::text('rombel',null,array('class'=>'input-xxlarge','autocomplete' => 'off')) }}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" >Jenjang</label>
                                    <div class="controls">
                                          {{ Form::text('jenjang',null,array('class'=>'input-medium','autocomplete' => 'off')) }}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" >Nilai Bayar SPP</label>
                                    <div class="controls">
                                          {{ Form::text('spp',null,array('class'=>'input-medium uang','autocomplete' => 'off')) }}
                                    </div>
                                </div>
                            </fieldset>
                            
                            <legend>PENYESUAIAN</legend>
                            <fieldset>
                                Sesuaikan nilai SPP siswa di atas dengan nilai SPP jenjang : 
                                <?php echo Form::select('jenjang_sesuai',array('1'=>'1-SD','2'=>'2-SD','3'=>'3-SD','4'=>'4-SD','5'=>'5-SD','6'=>'6-SD'),null,array('class'=>'input-medium')) ?>
                                yaitu sebesar <?php echo Form::text('nilai_sesuai',null,array('class'=>'input-medium uang')) ?>
                                <br/>
                                Siswa Mutasi ? <?php echo Form::select('mutasi',array('Y'=>'YA','N'=>'TIDAK'),null,array('class'=>'input-medium select-mutasi')); ?>
                                <br/>
                                <a class="btn btn-primary btn-simpan"><i class="icon icon-white icon-save"></i> Simpan</a>
                            </fieldset>
                    </div>
                </div>
        </div><!--/span-->
        <div class="box span4">
                <div class="box-header well" data-original-title>
                    <h2><i class="icon-list-alt"></i> Histori Penyesuaian </h2>
                        <div class="box-icon">
                            <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    <div class="row-fluid">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>SPP Disesuaikan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datapenyesuaian as $dp)
                                <tr>
                                    <td>{{ $dp->nisn }}</td>
                                    <td>{{ $dp->nama }}</td>
                                    <td class="uang"><?php echo number_format( $dp->spp_disesuaikan,0, ',', '.'); ?></td>
                                    <td><a class="btn btn-warning btn-mini" href="{{ URL::to('setting/penyesuaian/delete' . '/' . $dp->id) }}"><i class="icon-trash icon-white"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div><!--/span-->

</div><!--/row-->