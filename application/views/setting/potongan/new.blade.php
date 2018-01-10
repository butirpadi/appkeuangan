<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="{{ URL::to('setting/potongan') }}">Beasiswa & Bantuan</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">Tambah</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon-edit"></i> Tambah Data Beasiswa & Bantuan</h2>
                        <div class="box-icon">
                            <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    {{ Laravel\Form::open(URL::to('setting/potongan/new'), 'POST', array('class'=>'form-horizontal')) }}
                        <fieldset>
                            <?php echo \Laravel\Form::hidden('siswa_id', null); ?>
                              <div class="control-group">
                                <label class="control-label" for="typeahead">Tahun Ajaran</label>
                                <div class="controls">
                                      <?php echo \Laravel\Form::select('tahunajaran', $selecttahunajaran, $tahunaktif->id); ?>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="typeahead">Siswa</label>
                                <div class="controls">
                                    <!--NIS-->
                                    <?php echo \Laravel\Form::text('nis', null, array('class' => 'input-mini','placeholder' => 'NIS','autofocus','autocomplete' => 'off','required')) ?>
                                    <button id="buttonSearchNis" class="btn btn-primary"><i class="icon-search icon-white"></i></button>
                                    <?php echo \Laravel\Form::text('nama', null, array('class' => 'input-xlarge','placeholder' => 'Nama Siswa','readonly')) ?>
                                    <a id="buttonSearch" class="btn btn-primary"><i class="icon-user icon-white"></i></a>
                                    <?php echo \Laravel\Form::text('rombel', null, array('class' => 'input-medium','placeholder' => 'Rombel','readonly')) ?>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" >Iuran</label>
                                <div class="controls">
                                    <div class="row-fluid">
                                        <div class="span3"><?php echo \Laravel\Form::select('jenisbiaya', $selectjenisbiaya);?></div>
                                        <div class="span3 alert alert-block" id="form-biaya-info" ><h4 class="alert-heading" id="biaya-info"></h4></div>
                                    </div>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" >Jumlah Potongan</label>
                                <div class="controls">
                                    Dalam Persen
                                    <?php echo \Laravel\Form::text('disc',null,array('class' => 'input-mini angka','placeholder' => '%','autocomplete'=>'off','required')); ?>
                                    atau Dalam Rupiah
                                    <?php echo \Laravel\Form::text('nilai',null,array('class' => 'input-small uang','placeholder' => 'Rp.0','id' => 'nilai','autocomplete'=>'off','required')); ?>
                                    <span style="color: red;">* isikan salah satu (dalam persen atau dalam rupiah)</span>
                                    </div>
                              </div>
                            <div class="control-group">
                                <label class="control-label" >Sisa yang dibayar</label>
                                <div class="controls">
                                    <div class="row-fluid">
                                        <?php echo \Laravel\Form::text('bayar',null,array('class' => 'input-small uang','placeholder' => 'Rp.0','id' => 'bayar','autocomplete'=>'off','required')); ?>
                                        <span style="color: red;">* JUMLAH SISA IURAN YANG HARUS DIBAYAR OLEH SISWA SETELAH MENDAPAT POTONGAN DI ATAS.</span>
                                    </div>
                                </div>
                              </div>
                              <div class="control-group" id="form-bulanan">
                                <label class="control-label" >Bulan</label>
                                <div class="controls" id="form-list-bulan">
                                    
                                </div>
                              </div>
                              <div class="control-group" >
                                <label class="control-label" >Jenis</label>
                                <div class="controls" >
                                    <?php echo \Laravel\Form::select('jenis',array('BP' => 'Bantuan Pendidikan','BS' => 'Beasiswa Prestasi')); ?>
                                </div>
                              </div>
                              <div class="control-group" >
                                <label class="control-label" >Keterangan</label>
                                <div class="controls" >
                                    <?php echo \Laravel\Form::text('keterangan',null,array('class' => 'input-xxlarge','autocomplete'=>'off')); ?>
                                </div>
                              </div>
                              <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ URL::to('setting/potongan') }}" type="reset" class="btn">Cancel</a>
                              </div>
                        </fieldset>
                      {{ Form::close() }}
                </div>
        </div><!--/span-->

</div><!--/row-->

<div class="modal hide fade" id="list-siswa-dialog">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Data Siswa</h3>
        </div>
        <div class="modal-body">
            <?php echo \Laravel\Form::open() ?>
            <table class="table table-striped" >
                <tbody>
                    <tr >
                        <td style="border-top: none!important;">Nama</td>
                        <td style="border-top: none!important;">
                            <?php echo \Laravel\Form::text('namasiswa',null,array('class' => 'input-large','autofocus','autocomplete' => 'off'));  ?>
                            <button type='submit' href="#" id="btn-cari-siswa" class="btn btn-primary"><i class="icon-white icon-search"></i></button>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php echo \Laravel\Form::close();?>
            <div id="modal-custom-message" class="form-list-siswa" >
                
            </div>
        </div>
        <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">OK</a>
                <!--<a href="#" class="btn btn-primary">OK</a>-->
        </div>
</div>

@section('custom_script')
<script type="text/javascript">
    jQuery(document).ready(function(){
        /**
         * Predefined Form
         */
        jQuery('select[name=jenisbiaya]').val([]);
        jQuery('select[name=jenis]').val([]);
        var siswa;
        var jenisbiaya;
        jQuery('#form-bulanan').hide();
        jQuery('#form-biaya-info').hide();
        /**
         * cari siswa
         */
        jQuery('#buttonSearch').click(function(){
            //tampilkan form pencarian siswa
            jQuery('.form-list-siswa').empty();
            jQuery('input[name=namasiswa]').removeAttr('value')
            jQuery('input[name=namasiswa]').focus();

            jQuery('#list-siswa-dialog').modal('show');
            
            return false;
        });
        /**
         * fungsi set data siswa ke form
         */
        function setSiswaToForm(){
            jQuery('input[name=nis]').attr('value',siswa.nisn);
            jQuery('input[name=nama]').attr('value',siswa.nama);
            jQuery('input[name=siswa_id]').attr('value',siswa.id);
            jQuery('input[name=rombel]').attr('value',siswa.rombel);
        }
        /**
         * Cari siswa berdasar Normo Induk (NIS)
         */
        jQuery('#buttonSearchNis').click(function(){
            //clean siswa text
            jQuery('input[name=nama]').removeAttr('value');
            
            var nis = jQuery('input[name=nis]').attr('value');
            var tahunajaranid = jQuery('select[name=tahunajaran]').attr('value');            
            var getUrl = "{{ URL::to('setting/potongan/siswabynis') }}" + "/" + tahunajaranid + "/" + nis;
            jQuery.ajaxSetup ({cache: false});
            jQuery.ajax({
                url:getUrl,dataType:"json",async:false,
                success:function(data){
                    siswa = data;
                    //set siswa to form
                    setSiswaToForm();
                    //focus ke select biaya
                    jQuery('select[name=jenisbiaya]').focus();
                    //disablked NIS
                    jQuery('input[name=nis]').attr('readonly','readonly');
                },
                error:function(data){
                    alert('.:: INFO : Data Siswa tidak ditemukan.');
                }
            });
           
            return false;
        });
        /**
         * button cari siswa dialog
         */
        jQuery('#btn-cari-siswa').click(function(){
            var nama = jQuery('input[name=namasiswa]').attr('value');
            var getUrl = "{{ URL::to('setting/potongan/listsiswa') }}" ;
            var tahunajaranid = jQuery('select[name=tahunajaran]').attr('value');
            jQuery.get(getUrl,{
                nama:nama,
                tahunajaranid:tahunajaranid
            }).done(function(data){
                //tampilkan list siswa
                jQuery('.form-list-siswa').html(data);
                //tombol pilih click
                //masukkan data siswa yang dipilih ke form 
                jQuery('.btn-pilih').click(function(){
                    //set siswa json
                    siswa = {"rombel":jQuery(this).attr('rombel'),"nisn":jQuery(this).attr('nisn'),"nama":jQuery(this).attr('siswa'),"id":jQuery(this).attr('siswaid'),"jenjang":jQuery(this).attr('jenjang')};
                    //set siswa
                    setSiswaToForm();
                    //set forcus to select jenis biaya
                    jQuery('select[name=jenisbiaya]').focus();
                    //disablked NIS
                    jQuery('input[name=nis]').attr('readonly','readonly');
                });
                
                //tampilkan data bulanan yang belum di bayar pada tahun yang ditentukan
            });
            
            return false;
        });
        /**
         * Tampilkan data biaya
         */
         jQuery('select[name=jenisbiaya]').change(function(){
            if(siswa == null){
                alert('.:: PERINGATAN : Lengkapi Data Siswa yang masih kosong.');
                jQuery('input[name=nis]').focus();
                jQuery('select[name=jenisbiaya]').val([]);
            }else{
                //set jenisbiaya
                var jenisbiayaid = jQuery('select[name=jenisbiaya]').val();
                var tahunajaranid = jQuery('select[name=tahunajaran]').val();
                
                var getURL = "{{ URL::to('setting/potongan/jenisbiaya') }}" + "/" + jenisbiayaid + "/" + siswa.jenjang + "/" + tahunajaranid + "/" + siswa.id;
                
                //get jenisbiaya
                jQuery.ajaxSetup ({cache: false});
                jQuery.ajax({
                    url:getURL,dataType:"json",async:false,
                    success:function(data){
                        jenisbiaya = data;
                        //set nilai jenisbiaya di form
                        jQuery('#biaya-info').text(formatRupiahVal(jenisbiaya.jumlah));
                        jQuery('#form-biaya-info').show();
                        //FOCUS KE text potongan
                        jQuery('input[name=disc]').focus();
                        //jika jenis biaya adalah bulanan maka tampilkan pilihan bulanan
                        if(jenisbiaya.tipe == 'ITB'){
                            //tampilkan input bulanan
                            var getBulanUrl = "{{ URL::to('setting/potongan/sisabulan') }}" + "/" + tahunajaranid + "/" + jenisbiayaid + "/" + siswa.id;
                            jQuery('#form-list-bulan').load(getBulanUrl);
                            jQuery('#form-bulanan').show(500);
                        }else{
                            jQuery('#form-list-bulan').empty();
                            jQuery('#form-bulanan').hide();
                        }
                        
                    },
                    error:function(data){
                        alert('.::ERROR::. DATA TIDAK DAPAT DITAMPILKAN...');
                        //reset select biaya
                        jQuery('select[name=jenisbiaya]').val([]);
                        jQuery('#form-list-bulan').empty();
                        jQuery('#form-bulanan').hide();
                        jQuery('#biaya-info').empty();
                        jQuery('#form-biaya-info').hide();
                    }
                });
            }
         });
         /**
          * perhitungan discount
          */
          jQuery('input[name=disc]').change(function(){
            if(jenisbiaya == null){
                alert('...ERROR :: LENGKAPI DATA YANG MASIH KOSONG...')
            }else{
                var disc = jQuery(this).val();
                var nilai = parseInt(jenisbiaya.jumlah) * parseInt(disc) / parseInt(100);
                var sisa = parseInt(jenisbiaya.jumlah) - parseInt(nilai);
                //set nilai
                jQuery('input[name=nilai]').attr('value',formatRupiahVal(nilai));
                jQuery('input[name=bayar]').attr('value',formatRupiahVal(sisa));
                //disable textbox lainnya
                jQuery('input[name=nilai]').attr('readonly','readonly');
                jQuery('input[name=bayar]').attr('readonly','readonly');
            }
            
          });
          /**
          * perhitungan discount dari nilai
          */
          jQuery('input[name=nilai]').change(function(){
            if(jenisbiaya == null){
                alert('...ERROR :: LENGKAPI DATA YANG MASIH KOSONG...')
            }else{
                var nilai = jQuery(this).val();
                var disc = 100 * nilai / jenisbiaya.jumlah;
                var sisa = parseInt(jenisbiaya.jumlah) - parseInt(nilai);
                //set nilai
                jQuery('input[name=disc]').attr('value',disc);
                jQuery('input[name=bayar]').attr('value',formatRupiahVal(sisa));
                //disable textbox lainnya
                jQuery('input[name=disc]').attr('readonly','readonly');
                jQuery('input[name=bayar]').attr('readonly','readonly');
            }
            
          });
          /**
          * perhitungan sisa yang harus di bayar
          */
          jQuery('input[name=bayar]').change(function(){
            if(jenisbiaya == null){
                alert('...ERROR :: LENGKAPI DATA YANG MASIH KOSONG...')
            }else{
                var sisa = jQuery(this).val();
                var disc = (jenisbiaya.jumlah - sisa) * 100 / jenisbiaya.jumlah;
                var nilai = disc * jenisbiaya.jumlah / 100;

                //set nilai
                jQuery('input[name=disc]').attr('value',disc);
                jQuery('input[name=nilai]').attr('value',formatRupiahVal(nilai));
                //disable textbox lainnya
                jQuery('input[name=disc]').attr('readonly','readonly');
                jQuery('input[name=nilai]').attr('readonly','readonly');
            }
            
          });
          /**
            * format rupiah di input uang
            */
            jQuery('.uang').on('focus',function(){
                unformatRupiah(jQuery(this).attr('id'));
            });
            jQuery('.uang').on('blur',function(){
                formatRupiah(jQuery(this).attr('id'));
            });
         
         
    });
</script>
@endsection

@section('custom_style')
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
        .uang, .angka{
            text-align: right;
        }
        
    </style>
@endsection




