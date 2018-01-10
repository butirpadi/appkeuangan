    @section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            /**
             * Disable dulu segala inputan
             * @type @exp;@call;jQuery@call;attr|@exp;data@pro;id
             */
            jQuery('#selectBiaya').attr('disabled','disabled');
            jQuery('#textCicilan').attr('readonly','readonly');
            jQuery('#formITC').hide();
            jQuery('#formITB').hide();
            jQuery('#formIB').hide();
            /**
             * bersihkan dulu data yang nampak
             */
            jQuery('#textNama').attr('value','');
            jQuery('#textRombel').attr('value','');
            /**
             * Global Variable 
             * @type @exp;@call;jQuery@call;attr
             */
            var nisn;
            var siswa;
            var biaya;
            var transArray = [];
            var jsonTrans = '{"detiltrans":[]}';
            var tahunajaranid;
            
            var detilTrans = [];
            var rowDetilTrans=1;
            var total=0;
            /**
             * jadikan tahun ajaran aktif menjadi berwarna hijau
             */
            jQuery('#selectTahun option:selected').css('background-color','green');
            jQuery('#selectTahun option:selected').css('color','white');
            /**
             * set ke not selected selectJenisBiaya
             */
            jQuery('#selectBiaya').val([]);
            /**
             * buttonSearch click event
             */
            jQuery('#buttonSearch').click(function(){
              //sembunyikan dulu kalo sebelumnya sudah pernah di load
              nisn = jQuery('#textNisn').attr('value');
              tahunajaranid = jQuery('select[name=tahunajaran]').val();
              //disable kan inputan
                jQuery('#selectBiaya').attr('disabled','disabled');
                //return to not selected
                jQuery('#selectBiaya').val([]);
                //hidden formITC/ITB
                jQuery('#formITC').hide();
                jQuery('#formITB').hide();
                
                
              if (nisn != ''){
                  //set data siswa
                  var getSiswaIdURL = "{{ URL::to('transaksi/iuran/jsonsiswabynisn') }}" + "/" + tahunajaranid + "/" + nisn;
                  jQuery.ajaxSetup ({cache: false});
                  jQuery.ajax({
                      url:getSiswaIdURL,   
                      dataType:"json",
                      async:false,
                      success:function(data){
                        siswa = data;
                        //set data siswa
                        if (siswa.siswa != null){
                            jQuery('#textNama').attr('value',siswa.siswa);
                            jQuery('#textRombel').attr('value',siswa.rombel);
                            //enablekan inputan
                            jQuery('#selectBiaya').removeAttr('disabled');
                            jQuery('#selectBiaya').focus();
                        }else{
                            jQuery('#textNama').removeAttr('value');
                            jQuery('#textRombel').removeAttr('value');
                            //disable kan inputan
                            jQuery('#selectBiaya').attr('disabled','disabled');
                            //return to not selected
                            jQuery('#selectBiaya').val([]);
                            //hidden formITC/ITB
                            jQuery('#formITC').hide();
                            jQuery('#formITB').hide();
                        }
                        
                      }
                  });
                  
              }else{
                    //disable kan inputan
                    jQuery('#selectBiaya').attr('disabled','disabled');
                  //tampilkan pesan peringatan
                  showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
              }
              
              return false;
           });
           /**
            * selectBiaya change event 
            */
           jQuery('#selectBiaya').change(function(){
                var biaya_id = jQuery(this).attr('value');
                var tahunajaran_id = jQuery('#selectTahun').attr('value');
                //get jenis biaya
                jQuery.ajaxSetup ({cache: false});
                var getBiayaObjUrl = "{{ URL::to('transaksi/iuran/jsnGetBiaya') }}" + "/" + biaya_id;
                jQuery.ajax({
                    url:getBiayaObjUrl,   
                    dataType:"json",
                    async:false,
                    success:function(data){
                      biaya = data;
                    }
                });
                //get potongan jika ada potongan
                var getPotUrl;
                
                //get jumlah ketentuan biaya
                var ketITC;
                if (biaya.tipe == 'ITC'){
                    //tampilkan form ITC
                    jQuery('#formITC').show();
                    //sembunyikan formITB & formIB
                    jQuery('#formITB').hide();
                    jQuery('#formIB').hide();
                    
                    var getKetentuanBiayaITC = "{{ URL::to('transaksi/iuran/jsonketentuanbiaya') }}" + "/" + tahunajaran_id + "/" + biaya_id + "/ITC/" + siswa.jenjang;
                    jQuery.ajaxSetup ({cache: false});
                    jQuery.ajax({
                        url:getKetentuanBiayaITC,   
                        dataType:"json",
                        async:false,
                        success:function(data){
                          ketITC = data;
                        }
                    });                    
                    //tampilkan jumlah ketetapan biaya
                    jQuery('#textKetetapanBiaya').attr('value',formatRupiahVal(ketITC.jumlah));
                    //tampikan jumlah cicilan yang telah di cicil
                    var cicilanITCurl = "{{ URL::to('transaksi/iuran/jsonCekCicilanITC') }}" + "/" + tahunajaran_id + "/" + siswa.siswa_id + "/" + biaya.id;
                    var sudahDibayar;
                    jQuery.ajaxSetup ({cache: false});
                    jQuery.ajax({
                        url:cicilanITCurl,   
                        dataType:"json",
                        async:false,
                        success:function(data){
                          sudahDibayar = data;
                        }
                    });
                    //tampilkan cicilan
                    jQuery('#textSudahDibayar').attr('value',formatRupiahVal(sudahDibayar));
                    //enablekan textBayar
                    jQuery('#textBayar').removeAttr('readonly');
                    jQuery('#textBayar').focus();
                    
                    //tampilkan potongan
                    getPotUrl = "{{ URL::to('transaksi/iuran/potongan') }}" + "/" + tahunajaran_id + "/" + siswa.siswa_id + "/" + biaya.id;
                    alert(getPotUrl);
                }else if(biaya.tipe == 'ITB'){
                    //tampilkan form ITB
                    jQuery('#formITB').show();
                    //sembunyikan formITC & formIB
                    jQuery('#formITC').hide();
                    jQuery('#formIB').hide();
                    //proces ITB
                    //get tarif ITB
                    var ketITB;
                    var getKetITBurl = "{{ URL::to('transaksi/iuran/jsonketentuanbiaya') }}" + "/" + tahunajaran_id + "/" + biaya.id + "/ITB/" + siswa.jenjang;
                    jQuery.ajaxSetup ({cache: false});
                    jQuery.ajax({
                        url:getKetITBurl,   
                        dataType:"json",
                        async:false,
                        success:function(data){
                          ketITB = data;
                        }
                    });
                    //set biaya ketetapan
                    jQuery('#textKetBiayaITB').attr('value',formatRupiahVal(ketITB.jumlah));
                    //load selectBulan
                    jQuery.ajaxSetup ({cache: false});
                    var loadUrl = "{{ URL::to('transaksi/iuran/ajaxSisaBulanSelectITB') }}" + "/" + tahunajaran_id + "/" + biaya.id + "/" + siswa.siswa_id;
                    jQuery('#formSelectBulan').load(loadUrl,function(){
                        //kurangi bulan jika pada detil sudah ada
                        jQuery('#selectBulan option').each(function(){
                           for ($i=0;$i<detilTrans.length;$i++){
                               if (jQuery(this).attr('value') == detilTrans[$i].bulanid){
                                   //remove data bulan yang sama dengan data detil transaksi
                                   jQuery("#selectBulan option[value='" + detilTrans[$i].bulanid + "']").remove();
                               }
                           }
                        });
                        jQuery('#selectBulan').val([]);
                        //tampilkan potongan
                        var bulanid;
                        jQuery('#selectBulan').change(function(){
                            bulanid = jQuery(this).attr('value');
                            getPotUrl = "{{ URL::to('transaksi/iuran/potongan') }}" + "/" + tahunajaran_id + "/" + siswa.siswa_id + "/" + biaya.id + "/" + bulanid;
                            alert(getPotUrl);
                        });
                    });
                }else if(biaya.tipe = 'IB'){
                    //show form IB
                    jQuery('#formIB').show();
                    //sembunyikan formITB & ITC
                    jQuery('#formITC').hide();
                    jQuery('#formITB').hide();
                    //focus ke textBiayaID
                    jQuery('#textBiayaIB').focus();
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
            /**
             * Fungsi insert data transaksi
             */
            function addDetilTransaction(biayanya,bulannya,jumlahnya){
                //simpan kedalam array of json
                var jsonTransItem;
                if(biayanya.tipe == 'IB'){
                    jsonTransItem = {"biayaid":biayanya.id,"bulanid":bulannya,"jumlah":jumlahnya,"rownum":rowDetilTrans,"keterangan":jQuery('input[name=ketIB]').attr('value')};
                }else{
                    jsonTransItem = {"biayaid":biayanya.id,"bulanid":bulannya,"jumlah":jumlahnya,"rownum":rowDetilTrans};
                }
                
                detilTrans[detilTrans.length] = jsonTransItem;
                //hitung total
                total = parseInt(total) + parseInt(jumlahnya);
                //tampilkan total ke element
                jQuery('#formTotal').text(formatRupiahVal(total));
                //masukkan detil transaksi ke dalam tabel element
                //create new row for table
                if (biayanya.tipe == 'ITB'){
                    var newRow = "<tr id='row_" + rowDetilTrans + "' ><td>" + biayanya.nama + "</td><td>" + jQuery('#selectBulan option:selected').text() + "</td><td>-</td><td style='text-align:right;'>" + formatRupiahVal(jumlahnya) + "</td><td><a tag='" + rowDetilTrans + "' href='#' class='btn btn-warning linkDelete'><i class='icon-trash icon-white'></i></a></td></tr>";
                }else if(biayanya.tipe == 'ITC'){
                    var newRow = "<tr id='row_" + rowDetilTrans + "' ><td>" + biayanya.nama + "</td><td>-</td><td>-</td><td style='text-align:right;' >" + formatRupiahVal(jumlahnya) + "</td><td><a tag='" + rowDetilTrans + "' href='#' class='btn btn-warning linkDelete'><i class='icon-trash icon-white'></i></a></td></tr>";
                }else if(biayanya.tipe == 'IB'){
                    var newRow = "<tr id='row_" + rowDetilTrans + "' ><td>" + biayanya.nama + "</td><td>-</td><td>" + jQuery('input[name=ketIB]').attr('value') + "</td><td style='text-align:right;' >" + formatRupiahVal(jumlahnya) + "</td><td><a tag='" + rowDetilTrans + "' href='#' class='btn btn-warning linkDelete'><i class='icon-trash icon-white'></i></a></td></tr>";
                }                
                
                //insert new row to table
                jQuery('#tabelTransaksi').append(newRow);
                
                //rownum step up
                rowDetilTrans +=1;

            }
            /**
             * buttonInputITB click event
             */
            jQuery('#buttonInputITB').click(function(){
//                var jenis = jQuery('#selectBiaya option:selected').text();
//                var jenis_id = jQuery('#selectBiaya').attr('value');
//                var bulan = jQuery('#selectBulan option:selected').text();
                var bulan_id = jQuery('#selectBulan').attr('value');
                var jumlah = unformatRupiahVal(jQuery('#textKetBiayaITB').attr('value'));
                //insert detil transaksi ke array of json
                addDetilTransaction(biaya,bulan_id,jumlah)
                
                //reset input
                jQuery('#selectBiaya').val([]);
                jQuery('#textKetBiayaITB').removeAttr('value');
                 //hide formITC/ITB
                jQuery('#formITC').hide();
                jQuery('#formITB').hide();
                
                return false;
            });
            /**
             * buttonInput click event
             */
            jQuery('#buttonInput').click(function(){
                if(unformatRupiahVal(jQuery('#textBayar').attr('value')) != ''){
                    var jumlah = unformatRupiahVal(jQuery('#textBayar').attr('value')) ;
                    var sisaBayar = unformatRupiahVal(jQuery('#textKetetapanBiaya').attr('value')) - unformatRupiahVal(jQuery('#textSudahDibayar').attr('value'));

                    if (jumlah > sisaBayar){
                        showMessage('PERINGATAN','Jumlah Bayar lebih besar dari biaya yang ditetapkan.');
                    }else{
                        //add data transaksi
                        addDetilTransaction(biaya,"-",jumlah)
                        //reset input
                        jQuery('#textBayar').removeAttr('value');
                        jQuery('#buttonResetInput').click();
                        jQuery('#selectBiaya').val([]);
                        //hide formITC/ITB
                        jQuery('#formITC').hide();
                        jQuery('#formITB').hide();
                    };
                }else{
                    showMessage('PERINGATAN','Lengkapi data yang masih kosong.;')
                }
                
                
               return false;
            });
            /**
             * Check Out transaksi & Simpan pembayaran
             */
            jQuery('#buttonSimpan').click(function(){
                if(detilTrans.length > 0){
                    var atJsonString = '{"detiltrans":[';
                    var endJsonString = ']}';
                    var dataTransJson = {"tahunajaranid":jQuery('#selectTahun').attr('value'), "siswaid":siswa.siswa_id,"tanggal":jQuery('#textTanggal').attr('value')};
                    var dataTransJsonString = JSON.stringify(dataTransJson);
                    
                    //create JSON String from array data transaksi (detilTrans)
                    for($i=0;$i<detilTrans.length;$i++){    
                        atJsonString = atJsonString + JSON.stringify(detilTrans[$i]);
                                                
                        //tambahkan koma setiap json 
                        if ($i < (detilTrans.length-1) ){
                            atJsonString = atJsonString + ',';
                        }
                    }
                    
                    atJsonString = atJsonString + endJsonString;
//                    
//                    alert(atJsonString);
//                    alert(dataTransJsonString);
                    
                    jQuery.post("{{ URL::to('transaksi/iuran/inserttrans') }}", {
                        detiltrans: atJsonString,
                        datatrans: dataTransJsonString                        
                    }).fail(function(data){
                        alert('DATA GAGAL UNTUK DISIMPAN. PERIKSA KEMBALI.');
                    }).done(function(data){
                        alert('Data transaksi telah disimpan.');
                        location.reload();
                        //jQuery('#postres').html(data);
                    });
                }else{
                    showMessage('PERINGATAN','Data transaksi masih kosong.');
                }   
                                  
            });
            /**
             * Input IB
             */
             jQuery('#buttonInputIB').click(function(){
                //cek jumlah sudah di isi atau belum
                var jumlah = unformatRupiahVal(jQuery('#textBiayaIB').attr('value'));
                if(jumlah == ''){
                    showMessage('PERINGATAN','Lengkapi data yang masih kosong.');
                }else{
                    //insert detil transaksi
                    addDetilTransaction(biaya,'-',jumlah);
                    //reset
                    jQuery('#textBiayaIB').removeAttr('value');
                    //hide form
                    jQuery('#formIB').hide();
                    jQuery('#selectBiaya').val([]);
                    jQuery('#selectBiaya').focus();
                }
                return false;
             });
            /**
             * linkDelete click event 
             */
             jQuery('a.linkDelete').live('click',function(e){
                e.preventDefault();
                
                var rowNumForDel = jQuery(this).attr('tag');
                var totalForDel;
                
                //delete from array
                for($i=0;$i<detilTrans.length;$i++){
                    if(detilTrans[$i].rownum == rowNumForDel){
                        totalForDel = detilTrans[$i].jumlah;
                        detilTrans.splice($i,1);
                        break;
                    }
                }
                
                //hapus row
                var rowid = "#row_"+rowNumForDel;
                jQuery(rowid).remove();
                //rubah total
                //hitung total
                total = parseInt(total) - parseInt(totalForDel);
                //tampilkan total ke element
                jQuery('#formTotal').text(formatRupiahVal(total));
                
                return false;
            });
            
            /**
             * Pencarian siswa dengan nama
             */
            jQuery('#buttonSearchByNama').click(function(){
                jQuery('.form-list-siswa').empty();
                jQuery('input[name=namasiswa]').removeAttr('value')
                jQuery('input[name=namasiswa]').focus();
                
                jQuery('#list-siswa-dialog').modal('show');
                
            });
            /**
             * menampilkan list hasil pencarian siswa
             */
            jQuery('#btn-cari-siswa').click(function(){
                var nama = jQuery('input[name=namasiswa]').attr('value');
                var getUrl = "{{ URL::to('transaksi/iuran/listsiswabynama') }}" ;
                var tahunajaranid = jQuery('select[name=tahunajaran]').attr('value');
                jQuery.get(getUrl,{
                    nama:nama,
                    tahunajaranid:tahunajaranid
                }).done(function(data){
                    jQuery('.form-list-siswa').html(data);
                    
                    //tombol pilih click
                    //masukkan data siswa yang dipilih ke form transaksi
                    jQuery('.btn-pilih').click(function(){
                        var nisn = jQuery(this).attr('nisn');
                        jQuery('#textNisn').attr('value',nisn);
                        //click button search
                        jQuery('#buttonSearch').click();
                    });
                });
                
                return false;
            });
            /**
             * Printer On
             */
             jQuery('.btn-print-on').click(function(){
             var getUrl = "{{ URL::to('transaksi/iuran/printon') }}";
                jQuery.get(getUrl).done(function(){
                    alert('.:: INFORMASI ::. Cetak Nota telah diaktifkan.')
                    //hide alert
                    jQuery('.alert-print').hide();
                });
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
        .uang{
            text-align: right;
        }
        
    </style>
@endsection

<div id="postres"></div>
    
<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">Penerimaan Iuran</a>
                </li>
        </ul>
</div>
@if($appset->cetaknota == 'N')
<div class="alert alert-error alert-print">
        <strong>Cetak Nota Tidak Aktif!</strong> Untuk mengaktifkan klik tombol ini. 
        <a class="btn btn-success btn-print-on" >TurnOn</a>
</div>
@endif

<div class="row-fluid sortable ui-sortable">
        <div class="box span12">
            <div class="box-header well" data-original-title="">
                    <h2><i class="icon-share-alt"></i> Penerimaan Iuran</h2>
                    <div class="box-icon">
                        <a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>
                    </div>
            </div>
            <div class="box-content">
                <div class="row-fluid">
                    <div class="span8">
                        {{ Form::open() }}
                        <table>
                            <tbody>
                                <tr>
                                    <td>Tahun Ajaran</td>
                                    <td colspan="3">{{ \Laravel\Form::select('tahunajaran', $tahunajaranselect,(isset($tahunaktif) ? $tahunaktif->id : null),array('id'=>'selectTahun')) }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Induk</td>
                                    <td>
                                            {{ \Laravel\Form::text('nisn',null,array('id'=>'textNisn','class'=>'input-mini','autofocus','placeholder'=>'NIS','autocomplete'=>'off')) }}
                                            <button class="btn btn-primary" id="buttonSearch" ><i class="icon-white icon-search"></i></button>
                                            <a class="btn btn-primary" id="buttonSearchByNama" ><i class="icon-white icon-user"></i></a>
                                    </td>
                                    <td id="formDataSiswa">
                                        {{ Form::text('nama',null,array('id'=>'textNama','class'=>'input-large','readonly')) }}
                                        {{ Form::text('rombel',null,array('id'=>'textRombel','class'=>'input-medium','readonly')) }}
                                    </td>

                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        {{ Form::close() }}
                    </div><!--span6-->
                    <div class="span4">
                        <div class="pull-right">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>{{ \Laravel\Form::text(' tanggal', date('d-m-Y'), array('id'=>'textTanggal','class'=>'input-medium datepicker','style'=>'text-align:right')) }}</td>
                                        <td rowspan="2">
                                            <button class="btn btn-primary" type="reset" id="buttonSimpan" style="height: 100px;width: 100px;" >SIMPAN <i class="icon-white icon-chevron-right"></i></button>
                                        </td>
                                    </tr>
                                    <tr style="font-size: x-large;">
                                        <td>
                                            TOTAL
                                        </td>
                                        <td  style="text-align: right; color: white;">
                                                <p id="formTotal" style="background-color: orangered;padding: 10px; ">
                                                    Rp. 0
                                                </>
                                        </td> 
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!--span6-->
                </div> <!--row fluid-->
                <div class="breadcrumb" style="background: none;border: none;border-bottom: thin solid #DDDDDD;"></div>
                <div class="row-fluid">
                    <div class="breadcrumb">
                        {{ Form::open(null,null,array('id'=>'formInputTransaksi')) }}
                        <table>
                            <tbody>
                                <tr>
                                    <td><strong>Input data pembayaran : &nbsp;</strong></td>
                                    <td>Jenis Biaya</td>
                                    <td>{{ \Laravel\Form::select('biaya', $biayaselect,null,array('id'=>'selectBiaya')) }}</td>
                                    <td id="formITC">
                                        <table class="">
                                            <tbody>
                                                <tr>
                                                    <td>Biaya</td>
                                                    <td>{{ \Laravel\Form::text('ketetapanBiaya', null,array('id'=>'textKetetapanBiaya','readonly','class'=>'input-small uang','placeholder'=>'Rp. 0')) }}</td>
                                                    <td>Potongan</td>
                                                    <td>{{ \Laravel\Form::text('potonganITC', null,array('readonly','class'=>'input-small uang','placeholder'=>'Rp. 0')) }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td rowspan="2">
                                                        <button style="height: 50px;" class="btn btn-primary" id="buttonInput" ><i class="icon-white icon-plus"></i> Input</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Sudah Dibayar</td>
                                                    <td>{{ \Laravel\Form::text('sudadibayar', null,array('id'=>'textSudahDibayar','readonly','class'=>'input-small uang','placeholder'=>'Rp. 0')) }}</td>
                                                    <td>Harus Dibayar</td>
                                                    <td>{{ \Laravel\Form::text('harusbayarITC', null,array('readonly','class'=>'input-small uang','placeholder'=>'Rp. 0')) }}</td>
                                                    <td>Bayar</td>
                                                    <td>
                                                        {{ \Laravel\Form::text('bayar', null,array('id'=>'textBayar','class'=>'input-small uang','placeholder'=>'Rp. 0')) }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td id="formITB">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Biaya</td>
                                                    <td>{{ \Laravel\Form::text('ketBiayaITB', null,array('id'=>'textKetBiayaITB','readonly','class'=>'input-small uang','placeholder'=>'Rp. 0')) }}</td>
                                                    <td>Bulan</td>
                                                    <td id="formSelectBulan"></td>
                                                    <td>
                                                        <button class="btn btn-primary" id="buttonInputITB" ><i class="icon-white icon-plus"></i> Input</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td id="formIB">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Jumlah</td>
                                                    <td>
                                                        {{ \Laravel\Form::text('biayaIB', null,array('id'=>'textBiayaIB','class'=>'input-small uang','placeholder'=>'Rp. 0')) }}
                                                        {{ \Laravel\Form::text('ketIB', null,array('id'=>'textKetIB','class'=>'input-xlarge','placeholder'=>'Keterangan')) }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary" id="buttonInputIB" ><i class="icon-white icon-plus"></i> Input</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        {{ Form::close() }}
                    </div>
                    <br/>
                    <div>
                        <table class="table table-bordered">
                            <colgroup>
                                <col/>
                                <col/>
                                <col/>
                                <col/>
                                <col style="width: 12px;"/>
                            </colgroup>

                            <thead>
                                <tr>
                                    <th>Jenis Biaya</th>
                                    <th>Bulan</th>
                                    <th>Keterangan</th>
                                    <th>Sub Total</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabelTransaksi">
                            </tbody>
                        </table>
                    </div>
                </div><!--row-fluid-->
            </div>
        </div><!--/span-->
</div>

<div id="formTest">
    
</div>

<div class="modal hide fade" id="list-siswa-dialog">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Data Siswa</h3>
        </div>
        <div class="modal-body">
            <?php echo \Laravel\Form::open();?>
            <table class="table table-striped" >
                <tbody>
                    <tr >
                        <td style="border-top: none!important;">Nama</td>
                        <td style="border-top: none!important;">
                            <?php echo \Laravel\Form::text('namasiswa',null,array('class' => 'input-large','autofocus','autocomplete'=>'off'));  ?>
                            <button id="btn-cari-siswa" class="btn btn-primary"><i class="icon-white icon-search"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php echo \Laravel\Form::close(); ?>
            <div id="modal-custom-message" class="form-list-siswa" >
                
            </div>
        </div>
        <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">OK</a>
                <!--<a href="#" class="btn btn-primary">OK</a>-->
        </div>
</div>