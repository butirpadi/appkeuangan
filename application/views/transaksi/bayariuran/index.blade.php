    @section('custom_script')
    <!--JZERA APPLET-->
    <!-- <applet name="jzebra" code="jzebra.PrintApplet.class" archive="{{ URL::to('packages/jzebra.jar') }}" width="50px" height="50px"> -->
      <!-- Optional, searches for printer with "zebra" in the name on load -->
      <!-- Note:  It is recommended to use applet.findPrinter() instead for ajax heavy applications -->
      <!-- <param name="printer" value="{{ $appset->printeraddr }}"> -->
      <!-- ALL OF THE CACHE OPTIONS HAVE BEEN REMOVED DUE TO A BUG WITH JAVA 7 UPDATE 25 -->
	  <!-- Optional, these "cache_" params enable faster loading "caching" of the applet -->
      <!-- <param name="cache_option" value="plugin"> -->
      <!-- Change "cache_archive" to point to relative URL of jzebra.jar -->
      <!-- <param name="cache_archive" value="./jzebra.jar"> -->
      <!-- Change "cache_version" to reflect current jZebra version -->
      <!-- <param name="cache_version" value="1.4.9.1"> -->
   <!-- </applet> -->
    <!--JZEBRA PRINTING-->    
    <!-- <script type="text/javascript">
            function jzebraDonePrinting() {
                if (applet.getException() != null) {
                   return alert('Error:' + applet.getExceptionMessage());
                }
                //return alert(MSG_SUCCESS);
            }

            function printNota(textforprint) {
                var applet = document.jzebra;
                if (applet != null) {
                   applet.append(textforprint);            
                   applet.print(); // send commands to printer
                }
                //jzebraDonePrinting();
                
            }
    </script> -->
    
    <script type="text/javascript">
        jQuery(document).ready(function(){
            /**
             * Predefined Function/Statement
             * @type data|String
             */
            jQuery('#form-input-pembayaran').hide();
            jQuery('.input-itb').hide();
            jQuery('.input-itc').hide();
            jQuery('.input-ib').hide();
            jQuery('.input-potongan').hide();
            jQuery('.input-bayar').hide();
            jQuery('.input-sudah-bayar').hide();
            jQuery('.input-harus-bayar').hide();
            jQuery('.input-keterangan').hide();
            jQuery('select[name=biaya]').val([]);
            jQuery('.btn-input').hide();
            jQuery('.label-nis').hide();
            /**
             * Global Variable
             * @type String
             */
            var siswa;
            var tahunajaran;
            /**
             * set tahunajaran aktif
             */
            var tahunaktifid = "{{ $tahunaktif->id }}";
            jQuery('select[name=tahunajaran] option[value='+ tahunaktifid +']').css('color','white');
            jQuery('select[name=tahunajaran] option[value='+ tahunaktifid +']').css('background-color','green');
            /**
             * fungsi set data tahunajaran 
             */
            function setTahunajaran(){
                var getTahunUrl = "{{ 'transaksi/bayariuran/tahunajaran' }}" + "/" + jQuery('select[name=tahunajaran]').attr('value');
                //get data siswa
                jQuery.ajaxSetup ({cache: false});
                jQuery.ajax({url:getTahunUrl,dataType:"json",async:false,
                    success:function(data){
                        tahunajaran = data;
                    }}
                );
            }
            jQuery('select[name=tahunajaran]').change(function(){
                setTahunajaran();
                //reset inputan
                resetAll();
            });
            setTahunajaran();
            /**
             * Reset all input 
             */
            function resetAll(){
                jQuery('input[name=nis]').removeAttr('value');
                jQuery('input[name=nama]').removeAttr('value');
                jQuery('input[name=rombel]').removeAttr('value');
                resetInputPembayaran();
                siswa = null;
            }
            function resetInputPembayaran(){
                //jQuery('select[name=biaya]').val([]);
                jQuery('#form-input-pembayaran').hide();
                resetInputITB();
                jQuery('.input-itc').hide();
                jQuery('.input-ib').hide();
                resetBiaya();
            }
            function resetBiaya(){
                jQuery('select[name=biaya]').val([]);
                biaya = null;
                jQuery('input[name=ketbiaya]').removeAttr('value');
                //jQuery('input[name=ketbiaya]').show();
                jQuery('.input-ket-biaya').show();
            }
            function resetInputITB(){
                jQuery('.input-select-bulan').empty();
                jQuery('.input-itb').hide();
                jQuery('input[name=bayar]').removeAttr('value');
                jQuery('.input-bayar').hide();
                jQuery('.input-potongan').hide();
                potongan = null;
                jQuery('.btn-input').hide();
            }
            function resetInputITC(){
                jQuery('input[name=bayar]').removeAttr('value');
                jQuery('.input-bayar').hide();
                jQuery('.input-potongan').hide();
                jQuery('.input-sudah-bayar').hide();
                jQuery('.input-harus-bayar').hide();
                potongan = null;
                jQuery('.btn-input').hide();
            }
            function resetInputIB(){
                jQuery('input[name=bayar]').removeAttr('value');
                jQuery('.input-bayar').hide();
                jQuery('input[name=keterangan]').removeAttr('value');
                jQuery('.input-keterangan').hide();
                jQuery('.btn-input').hide();
            }
            /**
             * Tampilkan data siswa
             */
            jQuery('.btn-cari-nis').click(function(){
                showDataSiswa();
            });
            jQuery('input[name=nis]').keypress(function(e){
                var code = (e.keyCode ? e.keyCode : e.which);
                if(code == 13) { //Enter keycode
                    showDataSiswa();
                }
            });
            function showDataSiswa(){
                    //hide form-input-pembayaran & reset
                    resetInputPembayaran();
                    //clear data siswa 
                    jQuery('input[name=nama]').removeAttr('value');
                    jQuery('input[name=rombel]').removeAttr('value');
                    
                    //show data siswa
                    var nis = jQuery('input[name=nis]').attr('value');
                    var getSiswaUrl = "{{ 'transaksi/bayariuran/siswabynisn' }}" + "/" + tahunajaran.id + "/" + nis;
                    //get data siswa
                    jQuery.ajaxSetup ({cache: false});
                    jQuery.ajax({url:getSiswaUrl,dataType:"json",async:false,
                        success:function(data){
                            siswa = data;
                            //tampilkan ke form
                            jQuery('input[name=nama]').attr('value',siswa.nama);
                            jQuery('input[name=rombel]').attr('value',siswa.rombel);
                            //tampilkan form-input-pembayaran
                            jQuery('#form-input-pembayaran').show(500);
                            //disablekan input NIS & tampilkan label NIS
                            jQuery('input[name=nis]').hide();
                            jQuery('#buttonCariNama').hide();
                            jQuery('.btn-cari-nis').hide();
                            jQuery('.label-nis').text(nis);
                            jQuery('.label-nis').show();
                        },error:function(data){
                            alert('.:: INFORMASI ::. Nomor Induk tidak terdaftar, periksa kembali.');
                        }}
                    );
            }
            /**
             * Pencarian siswa dengan nama 
             */
             jQuery('#buttonCariNama').click(function(){
                //bersihkan inputan form pencarian yang sebelumnya pernah dipake
                jQuery('.form-list-siswa').empty();
                jQuery('input[name=namasiswa]').removeAttr('value');
                //tampilkan form pencarian
                jQuery('#list-siswa-dialog').modal('show');
                //focuskan ke text nama
                jQuery('input[name=namasiswa]').focus();
             });
             /**
              * Fungsi pencarian data siswa dengan nama
              * menampilkan list data siswa dengan pencarian nama
              */
             jQuery('input[name=namasiswa]').keypress(function(e){
                var code = (e.keyCode ? e.keyCode : e.which);
                if(code == 13) { //Enter keycode
                    findSiswa();
                }; 
             });
             jQuery('#btn-cari-siswa').click(function(){
                 findSiswa();
             });
             function findSiswa(){
                var nama = jQuery('input[name=namasiswa]').attr('value');
                var getSiswaUrl = "{{ URL::to('transaksi/bayariuran/viewsiswabynama') }}" + "/" + tahunajaran.id + "/" + nama;
                jQuery('.form-list-siswa').load(getSiswaUrl,function(){
                        /**
                         * tampilkan data siswa yang terpilih ke form
                         */
                        jQuery('.btn-pilih').click(function(){
                            jQuery('input[name=nis]').attr('value',jQuery(this).attr('nis'));
                            jQuery('input[name=nis]').trigger({type: 'keypress',which: 13 // Escape key
                            });
                        });
                });
             };
             /**
              * Get data biaya
              */
             var biaya;
             jQuery('select[name=biaya]').change(function(){
                //reset input dulu
                resetInputITB();
                resetInputITC();
                resetInputIB();
                //predefined
                var biayaid = jQuery(this).attr('value');
                var getBiayaUrl = "{{ URL::to('transaksi/bayariuran/biaya') }}" + "/" + biayaid;
                //get data biaya
                jQuery.ajaxSetup ({cache: false});
                jQuery.ajax({url:getBiayaUrl,dataType:"json",async:false,
                    success:function(data){
                        biaya = data;
                        //tampilkan ketetapan biaya
                        showKetBiaya();
                    },error:function(data){
                        biaya = null;
                    }
                });
             });
            /**
             * Tampilkan ketentuan Biaya
             */
             var ketbiaya;
             function showKetBiaya(){
                if(biaya != null){
                    if(biaya.tipe == 'ITB' || biaya.tipe == 'ITC'){
                            //tampilkan ketentuan biaya
                            var getKetBiayaUrl = "{{ URL::to('transaksi/bayariuran/ketetapanbiaya') }}" + "/" + tahunajaran.id + "/" + biaya.id + "/" + siswa.id;
                            //get data biaya
                            jQuery.ajaxSetup ({cache: false});
                            jQuery.ajax({url:getKetBiayaUrl ,dataType:"json",async:false,
                                success:function(data){
                                    ketbiaya = data;
                                    //set ketetapan biaya ke form
                                    jQuery('input[name=ketbiaya]').attr('value',formatRupiahVal(ketbiaya.jumlah));
                                    //tampilkan input berdasar tipe biaya
                                    if(biaya.tipe == 'ITB'){
                                        showInputITB();
                                    }else if(biaya.tipe == 'ITC'){
                                        showInputITC();
                                    }else{
                                        resetInputITB();
                                    }
                                },error:function(data){
                                    ketbiaya = null;
                                    //remove ketetapan biaya
                                    jQuery('input[name=ketbiaya]').removeAttr('value');
                                    //tampilkan error dialog
                                    alert('.:: PERINGATAN ::. Nilai Biaya belum ditetapkan/ditentukan.');
                                }
                            });
                    }else if(biaya.tipe == 'IB'){
                            //tampilkan input IB
                            showInputIB();
                    }
                }
             }
             /**
              * Tampilkan input biaya ITB
              */
              var bulan;
              var bulanObj;
              function showInputITB(){
                    var getBulanUrl = "{{ URL::to('transaksi/bayariuran/selectsisabulan') }}" + "/" + tahunajaran.id + "/" + siswa.id + "/" + biaya.id;
                    jQuery('.input-select-bulan').load(getBulanUrl,function(){
                        //filter bulan yang sudah di add saat transaksi sekarang
                        if(detiltrans.length > 0){
                            for(i=0;i<detiltrans.length;i++){
                                jQuery('select[name=bulan] option').each(function(){
                                    if ((jQuery(this).attr('value') == detiltrans[i].bulan_id) && (biaya.id == detiltrans[i].jenisbiaya_id) ){
                                        //remove data bulan yang sama dengan data detil transaksi
                                        jQuery("select[name=bulan] option[value=" + detiltrans[i].bulan_id + "]").remove();
                                    }
                                });
                            }
                        }
                        //unselect select bulan
                        jQuery('select[name=bulan]').val([]);
                        //select bulan change, tampilkan potongan
                        jQuery('select[name=bulan]').change(function(){
                            //get & set bulan
                            bulan = jQuery(this).attr('value');
                            var getBulanObjUrl = "{{ URL::to('transaksi/bayariuran/bulan') }}" + "/" + bulan;
                            jQuery.ajaxSetup ({cache: false});
                            jQuery.ajax({url:getBulanObjUrl ,dataType:"json",async:false,success:function(data){bulanObj = data;}});
                            showPotongan();
                            showBayar();
                         });
                    });
                    //show yang sebelumnya di hide
                    jQuery('.input-itb').show();
              }
              /**
               * Tampilkan input biaya ITC
               */
               var sudahdibayar;
               function showInputITC(){
                    //get data sudah dibayar
                    var getSudahBayarUrl = "{{ URL::to('transaksi/bayariuran/sudahbayar') }}" + "/" + tahunajaran.id + "/" + biaya.id + "/" + siswa.id;
                    jQuery.get(getSudahBayarUrl).done(function(data){
                       sudahdibayar = data;

                       //tampilkan sudah dibayar
                      if(sudahdibayar > 0){
                            jQuery('.input-sudah-bayar').show();
                            jQuery('input[name=sudahbayar]').attr('value',formatRupiahVal(sudahdibayar));
                            jQuery('.input-harus-bayar').show();
                            jQuery('input[name=harusbayar]').attr('value',formatRupiahVal(ketbiaya.jumlah - sudahdibayar));
                            jQuery('.input-sudah-bayar').show();
                      }else{
                            jQuery('.input-sudah-bayar').hide();
                            jQuery('input[name=sudahbayar]').removeAttr('value');
                            jQuery('.input-harus-bayar').hide();
                            jQuery('input[name=harusbayar]').removeAttr('value');
                      }
                      //show potongan kalau ada
                      showPotongan();
                      
                      //tampilkan bayar
                      showBayar();
                      
                      //focus ke text baya
                      jQuery('input[name=bayar]').focus();

                    });

                    
               }
               /**
                * Tampilkan input IB
                * Iuran bebas tidak ada ketetapan biaya
                * Ada text keterangan
                */
               function showInputIB(){
                   //sembunyikan input ketbiaya
                   jQuery('.input-ket-biaya').hide();
                   //tampilkan bayar
                    showBayar();
                    //focus ek bayar
                    jQuery('input[name=bayar]').focus();
                    //tampilkan input keterangan
                    jQuery('.input-keterangan').show();
               }
              
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
             * Show potongan biaya dari beasiswa atau bantuan pendidikan
             */
            var potongan;
            function showPotongan(){
                var getPotUrl;
                if(biaya.tipe == 'ITB'){
                    getPotUrl = "{{ URL::to('transaksi/bayariuran/potongan') }}" + "/" + tahunajaran.id + "/" + biaya.id + "/" + siswa.id + "/" + bulan ;
                }else if(biaya.tipe == 'ITC'){
                    getPotUrl = "{{ URL::to('transaksi/bayariuran/potongan') }}" + "/" + tahunajaran.id + "/" + biaya.id + "/" + siswa.id + "/" ;
                }                
                //get potonogan 
                jQuery.ajaxSetup ({cache: false});
                jQuery.ajax({url:getPotUrl ,dataType:"json",async:false,
                    success:function(data){
                        potongan = data;
                        //tampilkan input potongan
                        jQuery('input[name=potongan]').attr('value',formatRupiahVal(potongan.nilai));
                        jQuery('.input-potongan').show();
                    },error:function(data){
                        potongan = JSON.parse('{"nilai":"0"}');
                    }
                });
            }
            /**
             * Show Input Bayar
             */
             function showBayar(){
                if(potongan != null){
                    //tampilkan input bayar                    
                    jQuery('input[name=bayar]').attr('value',formatRupiahVal((ketbiaya.jumlah - potongan.nilai)));
                    // jQuery('input[name=bayar]').attr('readonly','readonly');
                    if(biaya.tipe == 'ITC'){
                        // jQuery('input[name=bayar]').attr('value',formatRupiahVal((ketbiaya.jumlah - potongan.nilai)));
                        jQuery('input[name=bayar]').attr('value','');

                    }
                }else{
                    //reset dan sembunyikan
                    jQuery('input[name=potongan]').removeAttr('value');
                    jQuery('.input-potongan').hide();
                    //tampilkan input bayar
                    if(biaya.tipe == 'ITB'){
                        // jQuery('input[name=bayar]').attr('readonly','readonly');
                        jQuery('input[name=bayar]').attr('value',formatRupiahVal(ketbiaya.jumlah));
                    }else if(biaya.tipe == 'ITC'){
                        // alert('show bayar ITC');
                        // jQuery('input[name=bayar]').removeAttr('readonly');
                        jQuery('input[name=bayar]').removeAttr('value');
                        
                    }else{
                        // jQuery('input[name=bayar]').removeAttr('readonly');
                        jQuery('input[name=bayar]').removeAttr('value');
                    }
                }
                
                jQuery('.input-bayar').show();
                //enable tombol
                jQuery('.btn-input').show();
                
             }
             /**
              * input detil transaksi
              * add detil
              */
             var detiltrans=[];
             var rownum=1;
             var total=0;
             jQuery('.btn-input').click(function(){
                //  cek apakah bayar telah terisi atau belum
                var akan_di_bayar = unformatRupiahVal($('input[name=bayar]').val());
                if (akan_di_bayar > 0) {
                    //add detiltrans ke dalam array
                    var newrow;
                    if(biaya.tipe == 'ITB'){
                        if (potongan.nilai > 0){
                            //alert(JSON.stringify(potongan));
                            var ketPotongan;
                            if(potongan.jenis == 'BS'){
                                ketPotongan='Beasiswa Prestasi (' + potongan.ket + ')';
                            }else{
                                ketPotongan='Bantuan Pendidikan(' + potongan.ket + ')';
                            }
                            //jika ada potongan
                            detiltrans[detiltrans.length] = {"rownum":rownum,"jenisbiaya_id":biaya.id,"bulan_id":bulan,"harus_bayar":ketbiaya.jumlah,"jumlah":(ketbiaya.jumlah - potongan.nilai),"potongan":potongan.nilai,"ket":potongan.ket};
                            newrow = '<tr id="row_' + (rownum) + '"><td class="angka">'+ rownum +'</td><td>' + ucwords(biaya.nama) + '</td><td>' +  ucwords(bulanObj.nama) + '</td><td class="uang">' + formatRupiahVal(ketbiaya.jumlah) + '</td><td class="uang">' + formatRupiahVal(potongan.nilai) + '</td><td>' + ketPotongan + '</td><td class="uang">' + formatRupiahVal(ketbiaya.jumlah - potongan.nilai) + '</td><td><a rownum="' + rownum + '" class="btn btn-mini btn-warning btn-delete-detil">Delete</a></td></tr>';
                            //set total
                            total += parseInt(ketbiaya.jumlah - potongan.nilai);
                        }else if(potongan.nilai == 0 || potongan == null ){
                            detiltrans[detiltrans.length] = {"rownum":rownum,"jenisbiaya_id":biaya.id,"bulan_id":bulan,"harus_bayar":ketbiaya.jumlah,"jumlah":ketbiaya.jumlah};
                            newrow = '<tr id="row_' + (rownum) + '"><td class="angka">'+ rownum +'</td><td>' + ucwords(biaya.nama) + '</td><td>' +  ucwords(bulanObj.nama) + '</td><td class="uang">' + formatRupiahVal(ketbiaya.jumlah) + '</td><td class="uang">0</td><td>-</td><td class="uang">' + formatRupiahVal(ketbiaya.jumlah) + '</td><td><a rownum="' + rownum + '" class="btn btn-mini btn-warning btn-delete-detil">Delete</a></a></td></tr>';
                            //set total
                            total += parseInt(ketbiaya.jumlah);
                        }
                        
                        //reset tabel inputan
                        resetInputITB();
                        resetBiaya();
                        //tampilkan ke dalam tabel form
                        jQuery('#tabel-transaksi').append(newrow);
                        //tampilkan total
                        jQuery('.form-total').text(formatRupiahVal(total));
                        //rownum plus plus
                        rownum++;
                    }else if(biaya.tipe == 'ITC'){
                        var jumlah = unformatRupiahVal(jQuery('input[name=bayar]').attr('value'));
                        
                        if(jumlah > parseInt(ketbiaya.jumlah - sudahdibayar - parseInt(potongan.nilai))){
                            alert('.:: PERINGANTAN ::. Jumlah bayar melebihi ketentuan.');
                        }else{
                            if (potongan != null){
                                var ketPotongan;
                                if(potongan.jenis == 'BS'){
                                    ketPotongan='Beasiswa Prestasi (' + potongan.ket + ')';
                                }else{
                                    ketPotongan='Bantuan Pendidikan(' + potongan.ket + ')';
                                }
                                //jika ada potongan
                                detiltrans[detiltrans.length] = {"rownum":rownum,"jenisbiaya_id":biaya.id,"harus_bayar":ketbiaya.jumlah,"jumlah":jumlah,"potongan":potongan.nilai,"ket":potongan.ket};
                                newrow = '<tr id="row_' + (rownum) + '"><td class="angka">'+ rownum +'</td><td>' + ucwords(biaya.nama) + '</td><td>-</td><td class="uang">' + formatRupiahVal(ketbiaya.jumlah) + '</td><td class="uang">' + formatRupiahVal(potongan.nilai) + '</td><td>' + ketPotongan + '</td><td class="uang">' + formatRupiahVal(jumlah) + '</td><td><a rownum="' + rownum + '" class="btn btn-warning btn-delete-detil btn-mini">Delete</a></td></tr>';
                                //set total
                                total += parseInt(jumlah);
                            }else{
                                detiltrans[detiltrans.length] = {"rownum":rownum,"jenisbiaya_id":biaya.id,"harus_bayar":ketbiaya.jumlah,"jumlah":jumlah};
                                newrow = '<tr id="row_' + (rownum) + '"><td class="angka">'+ rownum +'</td><td>' + ucwords(biaya.nama) + '</td><td style="text-align:center;">-</td><td class="uang">' + formatRupiahVal(ketbiaya.jumlah) + '</td><td class="uang">0</td><td style="text-align:center;">-</td><td class="uang">' + formatRupiahVal(jumlah) + '</td><td><a rownum="' + rownum + '" class="btn btn-warning btn-delete-detil btn-mini">Delete</a></td></tr>';
                                //set total
                                total += parseInt(jumlah);
                            }
                            //reset tabel inputan
                            resetInputITC();
                            resetBiaya();     
                            //tampilkan ke dalam tabel form
                                jQuery('#tabel-transaksi').append(newrow);
                                //tampilkan total
                                jQuery('.form-total').text(formatRupiahVal(total));
                                //rownum plus plus
                                rownum++;
                        }
                    }else if(biaya.tipe == 'IB'){
                            var jumlah = parseInt(unformatRupiahVal(jQuery('input[name=bayar]').attr('value')));
                            var ket = jQuery('input[name=keterangan]').attr('value');
                            detiltrans[detiltrans.length] = {"rownum":rownum,"jenisbiaya_id":biaya.id,"jumlah":jumlah,"ket":ket};
                            newrow = '<tr id="row_' + (rownum) + '"><td class="angka">'+ rownum +'</td><td>' + ucwords(biaya.nama) + '</td><td style="text-align:center;">-</td><td class="uang">' + formatRupiahVal(jumlah) + '</td><td style="text-align:center;">-</td><td>' + ket + '</td><td class="uang">' + formatRupiahVal(jumlah) + '</td><td><a rownum="' + rownum + '" class="btn btn-warning btn-delete-detil btn-mini">Delete</a></td></tr>';
                            //set total
                            total += parseInt(jumlah);
                            //reset
                            resetInputIB();
                            resetBiaya();
                            //tampilkan ke dalam tabel form
                            jQuery('#tabel-transaksi').append(newrow);
                            //tampilkan total
                            jQuery('.form-total').text(formatRupiahVal(total));
                            //rownum plus plus
                            rownum++;
                            
                    }

                    resetInputITC();
                    resetInputITB();
                    resetInputIB();
                }else{
                    alert('ERROR. Jumlah Bayar tidak sesuai.');
                }
                 
             });
             /**
              * Hapus data detil transaksi
              * @param {type} val
              * @returns {@exp;val@pro;slice@call;@call;toUpperCase}              
              */
              jQuery('.btn-delete-detil').live('click',function(){
                var rownum4del =  jQuery(this).attr('rownum');
                
                detiltrans = $.grep(detiltrans, function (el, i) {
                    // do your normal code on el
                    if(el.rownum == rownum4del){
                        //hapus row tabel
                        jQuery('#row_'+rownum4del).hide(500);
                        //recalculate total
                        total -= parseInt(el.jumlah);
                        //tampilkan total
                        jQuery('.form-total').text(formatRupiahVal(total));
                        
                        return false; //remove item
                    }

                    return true; // keep the element in the array
                });
                
                return false;
              });
              /**
               * Simpan Transaksi
               * @param {type} val
               * @returns {@exp;val@pro;slice@call;@call;toUpperCase}
               */
              jQuery('#btn-simpan').click(function(){
                  //confirmasi cetak nota
                  if(confirm('Cetak NOTA ??? JANGAN LUPA NYALAKAN PRINTER!!')){
                      var turnOn = "{{ URL::to('transaksi/bayariuran/turnon') }}";
                      jQuery.get(turnOn).done(function(){
                          simpanTransaksi(true);
                      });
                  }else{
                      //matikan fitur cetak
                      var turnOff = "{{ URL::to('transaksi/bayariuran/turnoff') }}";
                      jQuery.get(turnOff).done(function(){
                          simpanTransaksi(false);
                      });
                  }
              });
              
              function simpanTransaksi(cetakNota){
                    //show loading page
                    jQuery('#loading-modal').modal('show');

                    if(parseInt(detiltrans.length) > 0){
                              var trans = {"tanggal":jQuery('input[name=tanggal]').attr('value'),"tahunajaran_id":tahunajaran.id,"siswa_id":siswa.id,"total":total};
                              jQuery.post("{{ URL::to('transaksi/bayariuran/new') }}", {
                                  detiltrans: JSON.stringify(detiltrans),
                                  trans: JSON.stringify(trans)
                              }).fail(function(data){
                                  jQuery('#loading-modal').modal('hide');
                                  alert('.:: ERROR ::. DATA GAGAL UNTUK DISIMPAN. PERIKSA KEMBALI, KEMUNGKINAN PRINTER BELUM NYALA, ATAU JIKA TIDAK MENGGUNAKAN PRINTER, MATIKAN FITUR CETAK NOTA.');
  //                                jQuery('#posresult').html(data);
                              }).done(function(data){
                                    if(cetakNota){
                                        var textforprint;
                                        var getTextUrl = "{{ URL::to('transaksi/bayariuran/cetaknota') }}" + "/" + data;
                                        jQuery.ajax({url:getTextUrl,async:false,
                                            success:function(data){
                                                // textforprint = data;
                                                // printNota(textforprint);
                                            }
                                        });
                                    }
                                    
                                    jQuery('#loading-modal').modal('hide');
                                    alert('.:: INFORMASI ::. Data transaksi telah disimpan.');
                                    location.reload();
                                    
                                    
                              });
                    }else{
                        alert('.:: PERINGATAN ::. Tidak ada data yang disimpan.');
                    }
              }
            
            /**
             * Capitalized words
             * @param {type} val
             * @returns {@exp;val@pro;slice@call;@call;toUpperCase}
             */
            function ucwords(val){
                return val[0].toUpperCase() + val.slice(1);
            };
             
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
        .uang,.angka{
            text-align: right!important;
        }
        table thead tr th{
            text-align: center!important;
            background-color: #7FB93F;
            color:white;
        }
        
    </style>
@endsection

<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">Penerimaan Iuran</a>
                </li>
        </ul>
</div>-->

<div id="posresult"></div>

<div id="loading-panel">
</div>

@if($appset->cetaknota == 'N')
<!--<div class="alert alert-error alert-print">
        <strong>Cetak Nota Tidak Aktif!</strong> Untuk mengaktifkan klik tombol ini. 
        <a class="btn btn-success btn-print-on" href="{{ URL::to('transaksi/bayariuran/turnon') }}" >TurnOn</a>
</div>-->
@endif

<div class="row-fluid sortable ui-sortable">
        <div class="box span12">
            <div class="box-header well" data-original-title="">
                    <h2><i class="icon-share-alt"></i> Penerimaan Iuran</h2>
                    <div class="box-icon">
                        <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                    </div>
            </div>
            <div class="box-content">
                <div class="row-fluid">
                    <div class="span8">
                        <table >
                            <tbody>
                                <tr>
                                    <td>Tahun Ajaran</td>
                                    <td>
                                        <?php echo Laravel\Form::select('tahunajaran', $selecttahunajaran, $tahunaktif->id,array('class' => 'input-medium')); ?>
                                        &nbsp; Tanggal &nbsp;
                                        <?php echo Laravel\Form::text('tanggal', date('d-m-Y'), array('class'=>'input-small datepicker')); ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    
                                </tr>
                                <tr>
                                    <td>Nomor Induk</td>
                                    <td colspan="2">
                                        <span class="label label-success label-nis"></span>
                                        <div class="input-append pull-left" style="margin-right: 5px;">
                                            <input class="input-mini" type="text" name="nis" placeholder="NIS" autocomplete="off" autofocus required ><button class="btn btn-primary btn-cari-nis" type="button"><i class="icon-white icon-search" ></i></button>
                                        </div>
                                        <?php echo Laravel\Form::text('nama', null, array('class' => 'input-xlarge','placeholder' => 'Nama Siswa','readonly')); ?>
                                        <?php echo Laravel\Form::text('rombel', null, array('class' => 'input-large','placeholder' => 'Rombel','readonly')); ?>
                                        <a href="#" class="btn btn-primary" id="buttonCariNama" ><i class="icon-white icon-user"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="span4">
                        <table class="pull-right">
                            <tbody>
                                <tr>
                                    <td>
                                        <div style="background-color: orange;color:darkred;padding: 10px;width: 200px;text-align: right;" >
                                            <h4 style="font-size: 20px;" class="alert-heading form-total">Rp. 0</h4>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a style="width: 200px;font-weight: bold;" class="btn btn-primary" id="btn-simpan">SIMPAN</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="box-content">
                        <div class="breadcrumb" id="form-input-pembayaran">
                            <p><strong>Input data pembayaran:</strong></p>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Jenis Biaya</td>
                                        <td>
                                            <?php echo Laravel\Form::select('biaya', $selectbiaya,null,array('class' => 'input-medium')); ?>
                                        </td>
                                        <td class="input-ket-biaya">Biaya</td>
                                        <td class="input-ket-biaya">
                                            <?php echo Laravel\Form::text('ketbiaya', null, array('class' => 'input-small uang','readonly','id'=>'textketbiaya'));?>
                                        </td>
                                        <td class="input-itb">Bulan</td>
                                        <td class="input-itb input-select-bulan"></td>
                                        <td class="input-potongan">Potongan</td>
                                        <td class="input-potongan">
                                            <?php echo Laravel\Form::text('potongan', null, array('class' => 'input-small uang','readonly','id'=>'textpotongan'));?>
                                        </td>
                                        <td class="input-sudah-bayar">Telah Dibayar</td>
                                        <td class="input-sudah-bayar">
                                            <?php echo Laravel\Form::text('sudahbayar', null, array('class' => 'input-small uang','readonly','id'=>'sudahbayar'));?>
                                        </td>
                                        <td class="input-harus-bayar">Harus Dibayar</td>
                                        <td class="input-harus-bayar">
                                            <?php echo Laravel\Form::text('harusbayar', null, array('class' => 'input-small uang','readonly','id'=>'harusbayar'));?>
                                        </td>
                                        <td class="input-bayar">Bayar</td>
                                        <td class="input-bayar">
                                            <?php echo Laravel\Form::text('bayar', null, array('class' => 'input-small uang','id'=>'textbayar','autocomplete' => 'off'));?>
                                        </td>
                                        <td class="input-keterangan">Keterangan</td>
                                        <td class="input-keterangan">
                                            <?php echo Laravel\Form::text('keterangan', null, array('class' => 'input-large','id'=>'keterangan','autocomplete' => 'off'));?>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-input" ><i class="icon-white icon-arrow-down" ></i> Input</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="form-detil-transaksi">
                            <table class="table table-striped table-bordered">
                                <colgroup>
                                    <col style="width: 50px;">
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                    <col style="width: 50px;">
                                </colgroup>
                                <thead>
                                    <th>No</th>
                                    <th>Biaya</th>
                                    <th>Bulan</th>
                                    <th>Biaya Satuan</th>
                                    <th>Potongan</th>
                                    <th>Keterangan</th>
                                    <th>Sub Total</th>
                                    <th>Opsi</th>
                                </thead>
                                <tbody id="tabel-transaksi">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/span-->
</div>
<!--dialog/modal untuk pencarian data siswa menggunakan namanya-->
<div class="modal hide fade" id="list-siswa-dialog">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">Data Siswa</h3>
        </div>
        <div class="modal-body">
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
            <div id="modal-custom-message" class="form-list-siswa" >
                
            </div>
        </div>
        <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">OK</a>
                <!--<a href="#" class="btn btn-primary">OK</a>-->
        </div>
</div>

<!--LOADING MODAL-->
<div class="modal hide fade" id="loading-modal">
    <div class="modal-body center">
        <label>Menyimpan data pembayaran ke dalam Database, silahkan tunggu...</label>
        <?php echo Laravel\HTML::image('img/ajax-loaders/ajax-loader-7.gif'); ?>
    </div>
</div>