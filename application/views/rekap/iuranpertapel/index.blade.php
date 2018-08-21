@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            var loader = '<div class="loader"></div>' ;

                /**
                 * set to not selected
                 * set hide
                 * @type String
                 */
                // jQuery('select[name=selectBiaya]').val([]);
                // jQuery('select[name=selectJenjang]').val([]);
                jQuery('select[name=selectRombel]').val([]);
                jQuery('input.form-filter').attr('readonly','readonly');
                jQuery('select.form-filter').attr('disabled','disabled');
                jQuery('button.form-filter').attr('disabled','disabled');

                /**
                 * Tahun ajaran aktif
                 */
                var tahunAktifId = "{{ $tahunaktif->id }}";
                jQuery('select[name=tahunajaran] option[value="' + tahunAktifId + '"]').css('background-color','green');
                jQuery('select[name=tahunajaran] option[value="' + tahunAktifId + '"]').css('color','white');
                // Cetak Report
                $('#btn-cetak-report').click(function(){
                    // convert form data to array
                    var dataForm = $('form[name=form-iuran]').serializeArray();

                    // edit data here
                    // using ES6
                    // data.find(item => item.name === 'entry[body]').value = "something else";
                    // OR using ES5
                    dataForm.forEach(function (item) {
                        // alert(item.name);
                        if (item.name === 'cetak') {
                            // alert('ketemu cetak');
                            // alert(item.value);
                            item.value = 'true';
                            // alert(item.value);
                        }
                    });

                    // then POST
                    // $.post('/post', $.param(data));
                    // alert($.param(data));
                    // alert('posting');
                    // $.post('rekap/iuranpertapel/ajaxtabelrekap', $.param(dataForm), function(){
                    //     alert('sukses');
                    // }).fail(function(){
                    //     alert('gagal');
                    // });
                    // change cetak to true
                    $('input[name=cetak]').val('true');
                    // $.post(
                    //     $('form[name=form-iuran]').attr('action'), 
                    //     $('form[name=form-iuran]').serialize(), 
                    //     function(res){
                    //         alert('sukses');
                    //         // change cetak to false
                    //         $('input[name=cetak]').val('false');
                    // }).fail(function(){
                    //         alert('gagal');
                    // });
                    // return false;
                    $('form[name=form-iuran]').submit();
                    $('input[name=cetak]').val('false');
                });
                /**
                 * Tampilkan Data Rekapitulasi
                 */
                jQuery('#buttonTampil').click(function(){
                    // cek inputan sudah benar atau belum
                    // $('form[name=form-iuran]').submit();
                    
                    // Submit with jquery post
                    var page_res = $.post(
                            $('form[name=form-iuran]').attr('action'), 
                            $('form[name=form-iuran]').serialize(), 
                            function(res){
                                $('#formTabelRekap').html(res);
                                // $('#formTabelRekap').html(loader);
                                
                                // tampiklkan button cetak
                                $('#btn-cetak-report').removeClass('hide');
                        }).fail(function(){
                                alert('gagal');
                        });

                    $('#formTabelRekap').html(loader).load(page_res);
                    
                    return false;
                });
                /**
                 * Cetak Print
                 * @returns {undefined}
                 */
                jQuery('.btn-cetak-no-filter').click(function(){
                        var tahunajaranId = jQuery('select[name=tahunajaran]').val();
                        var jenisbiayaId = jQuery('select[name=selectBiaya]').val();
                        if(jenisbiayaId != null){
                            var printUrl = "{{URL::to('rekap/iurantahunan/printtopdf')}}" + "/" + tahunajaranId + "/" + jenisbiayaId;
                            window.location.href = printUrl;
                        }else{
                            alert('.:PERINGATAN :: Lengkapi data yang kosong.');
                        }
                });
                /**
                 * Cetak Print Filter Jenjang
                 * @returns {undefined}
                 */
                jQuery('.btn-cetak-filter-jenjang').click(function(){
                        var tahunajaranId = jQuery('select[name=tahunajaran]').val();
                        var jenisbiayaId = jQuery('select[name=selectBiaya]').val();
                        var jenjang = jQuery('select[name=selectJenjang]').val();
                        if(jenjang != null){
                            var printUrl = "{{URL::to('rekap/iurantahunan/printtopdffilterjenjang')}}"+"/"+tahunajaranId+"/"+jenisbiayaId+"/"+jenjang;
                            window.location.href = printUrl;
                        }else{
                            alert('.:PERINGATAN :: Lengkapi data yang kosong.');
                        }
                });
                /**
                 * Cetak Print Filter Rombel
                 * @returns {undefined}
                 */
                jQuery('.btn-cetak-filter-rombel').click(function(){
                        var tahunajaranId = jQuery('select[name=tahunajaran]').val();
                        var jenisbiayaId = jQuery('select[name=selectBiaya]').val();
                        var rombel = jQuery('select[name=selectRombel]').val();
                        if(rombel != null){
                            var printUrl = "{{URL::to('rekap/iurantahunan/printtopdffilterrombel')}}"+"/"+tahunajaranId+"/"+jenisbiayaId+"/"+rombel;                            
                            window.location.href = printUrl;
                        }else{
                            alert('.:PERINGATAN :: Lengkapi data yang kosong.');
                        }
                });
                /**
                 * Cetak Print Filter NIS
                 * @returns {undefined}
                 */
                jQuery('.btn-cetak-filter-nis').click(function(){
                        var tahunajaranId = jQuery('select[name=tahunajaran]').val();
                        var jenisbiayaId = jQuery('select[name=selectBiaya]').val();
                        var nis = jQuery('input[name=textNomorInduk]').val();
                        if(nis != ''){
                            var printUrl = "{{URL::to('rekap/iurantahunan/printtopdffilternis')}}"+"/"+tahunajaranId+"/"+jenisbiayaId+"/"+nis;                            
                            window.location.href = printUrl;
                        }else{
                            alert('.:PERINGATAN :: Lengkapi data yang kosong.');
                        }
                });
                /**
                 * Filter by Jenjang
                 * @returns {undefined}
                 */
                jQuery('.btn-filter-by-jenjang').click(function(){
                    var tahunajaranId = jQuery('select[name=tahunajaran]').val();
                    var jenisbiayaId = jQuery('select[name=selectBiaya]').val();
                    var jenjang = jQuery('select[name=selectJenjang]').val();
                    if(jenjang != null){
                        //hidden tabel rekap terlebih dahulu
                        jQuery('#formTabelRekap').empty();
                        //filter by jenjang
                        var loadUrl = "{{ URL::to('rekap/iurantahunan/ajaxtabelrekapfilterjenjang') }}" + "/" + tahunajaranId + "/" + jenisbiayaId + "/" + jenjang;
                        //tampilkan tabel rekapitulasi
                        jQuery('#formTabelRekap').load(loadUrl);

                        //end of filter by biaya
                    }else{
                        showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
                    }
                });
                /**
                 * Filter by Rombel
                 * @returns {undefined}
                 */
                jQuery('.btn-filter-by-rombel').click(function(){
                    var tahunajaranId = jQuery('select[name=tahunajaran]').val();
                    var jenisbiayaId = jQuery('select[name=selectBiaya]').val();
                    var rombel = jQuery('select[name=selectRombel]').val();
                    if(rombel != null){
                        //hidden tabel rekap terlebih dahulu
                        jQuery('#formTabelRekap').empty();
                        //filter by jenjang
                        var loadUrl = "{{ URL::to('rekap/iurantahunan/ajaxtabelrekapfilterrombel') }}" + "/" + tahunajaranId + "/" + jenisbiayaId + "/" + rombel;
                        //tampilkan tabel rekapitulasi
                        jQuery('#formTabelRekap').load(loadUrl);

                        //end of filter by biaya
                    }else{
                        showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
                    }
                });
                /**
                 * Filter by NIS
                 * @returns {undefined}
                 */
                jQuery('.btn-filter-by-nis').click(function(){
                    var tahunajaranId = jQuery('select[name=tahunajaran]').val();
                    var jenisbiayaId = jQuery('select[name=selectBiaya]').val();
                    var nis = jQuery('input[name=textNomorInduk]').val();
                    if(nis != ''){
                        //hidden tabel rekap terlebih dahulu
                        jQuery('#formTabelRekap').empty();
                        //filter by jenjang
                        var loadUrl = "{{ URL::to('rekap/iurantahunan/ajaxtabelrekapfiltersiswa') }}" + "/" + tahunajaranId + "/" + jenisbiayaId + "/" + nis;
                        //tampilkan tabel rekapitulasi
                        jQuery('#formTabelRekap').load(loadUrl);

                        //end of filter by biaya
                    }else{
                        showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
                    }
                });
                // /**
                //  * Reset saat select change
                //  */
                // jQuery('select[name=selectJenjang]').change(function(){
                //         //reset fiter rombel dan siswa
                //         jQuery('select[name=selectRombel]').val([]);
                //         jQuery('input[name=textNomorInduk]').attr('value','');
                //         //reset formTabelRekap
                //         jQuery('#formTabelRekap').empty();
                // });
                // jQuery('select[name=selectRombel]').change(function(){
                //         //reset fiter jenjang dan siswa
                //         jQuery('select[name=selectJenjang]').val([]);
                //         jQuery('input[name=textNomorInduk]').attr('value','');
                //         //reset formTabelRekap
                //         jQuery('#formTabelRekap').empty();
                // });
                // jQuery('input[name=textNomorInduk]').change(function(){
                //         //reset fiter jenjang dan rombel
                //         jQuery('select[name=selectJenjang]').val([]);
                //         jQuery('select[name=selectRombel]').val([]);
                //         //reset formTabelRekap
                //         jQuery('#formTabelRekap').empty();
                // });
               
        });
    </script>
@endsection

@section('custom_style')
    <style type="text/css">
        
        table tbody tr td{
            padding: 5px!important;
        }
        
        table tbody tr td input,table tbody tr td text,table tbody tr td select{
            vertical-align: middle!important;
            margin: 0;
        }
        
        table.table tbody tr td{
            vertical-align: middle;
        }

        table.borderless td,table.borderless th{
            border: none !important;
        }
    </style>
@endsection

<div class="row-fluid sortable ui-sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title="">
            <h2><i class="icon-th"></i> Rekapitulasi Iuran Tahunan</h2>
            <div class="box-icon">
                <!--<a href="#" class="btn btn-minimize "><i class="icon icon-darkgray icon-help"></i></a>-->
            </div>
        </div>
        <div class="box-content">
            <div class="span12">
                <form name="form-iuran" method="POST" action="rekap/iuranpertapel/ajaxtabelrekap" target="_blank" >
                    <table class="table table-condensed borderless"  >
                        <tbody>
                            <tr>
                                <td  >Tahun Ajaran</td>
                                <td>{{\Laravel\Form::select('tahunajaran', $tahunajaranselect,(isset($tahunaktif) ? $tahunaktif->id : null),array('id'=>'selectTahun'))}}</td>
                                <td>Jenis Iuran</td>
                                <td>{{Form::select('selectBiaya',$biayaselect,null,array('id'=>'selectBiaya','required'=>'required'))}}</td>
                                <td>Rombel</td>
                                <td>
                                    {{Form::select('selectRombel',$rombelselect,null,array('id'=>'selectRombel'))}}
                                    <input type="hidden" name="cetak" value="false" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" >
                                    <a name="tampil" class="btn btn-primary" id="buttonTampil" >Tampilkan</a>
                                    <a class="btn btn-success hide" id="btn-cetak-report" >Cetak</a>
                                    <button class="btn btn-danger hide" type="submit"  >Submit</button>
                                </td>                                
                            </tr>
                        </tbody>
                    </table>                
                </form>
            </div>
            
        </div>
    </div><!--/span-->
</div>

<div class="row-fluid sortable ui-sortable" id="tabelrekapitulasi">
    <div class="box span12">
        <div class="box-header well" data-original-title="">
            <h2><i class="icon-th"></i> Tabel Rekapitulasi</h2>
            <div class="box-icon">
                <!--<a href="#" class="btn buttonPrint"><i class="icon-print"></i></a>-->
            </div>
        </div>
        <div class="box-content">
            <div id="formTabelRekap"></div>
        </div>
    </div><!--/span-->
</div>
