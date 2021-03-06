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
             * Fungsi format rupiah untuk class uang 
             */
             function formatToRupiah(){
                jQuery('.uang').each(function(){
                    var uang = jQuery(this).text();
                    uang = jQuery.trim(uang);
                    uang = formatRupiahVal(uang);
                    uang  = uang.replace('Rp. ','');
                    uang  = uang.replace('(','- ');
                    uang  = uang.replace(')','');
                    jQuery(this).text(uang);
                });
             }
             /**
              * buttonTampil click event
              */
             jQuery('#buttonTampil').click(function(){
                //tampilkan table rekap
                    var tahunajaran_id = jQuery('#selectTahun').attr('value');
                    jQuery.ajaxSetup ({cache: false});
                    var loadUrl = "{{ URL::to('rekap/tahunan/ajaxtabel') }}" + "/" + tahunajaran_id ;
                    
                    //tampilkan tabel rekapitulasi
                    jQuery('#tabelrekap').load(loadUrl,function(){
                        //format rupiah
                        formatToRupiah();
                    });
             });
             /**
              * buttonPrint event clicked
              * Printe data ke file PDF
              */
             jQuery('.buttonPrint').click(function(){
                    var tahunajaran_id = jQuery('#selectTahun').attr('value');
                    jQuery(this).attr('href',"{{URL::to('rekap/tahunan/printtopdf')}}"+"/"+tahunajaran_id);
                    //redirect
                    window.location.href = jQuery(this).attr('href');
                    
                return false;
             });
             
        });
    </script>
@endsection

@section('custom_style')
    <style type="text/css">
        table td{
            vertical-align: middle;
            padding: 5px;
        }
        table td input{
            vertical-align: middle!important;
            margin:0!important;
            padding: 0!important;
        }
    </style>
@endsection


<!--                        <div>
				<ul class="breadcrumb">
					<li>
						<a href="{{ URL::to('home') }}">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Rekapitulasi Keuangan Tahunan</a>
					</li>
				</ul>
			</div>-->

                        <div class="row-fluid sortable ui-sortable">
                            <div class="box span12">
                                <div class="box-header well" data-original-title="">
                                    <h2><i class="icon-th"></i> Rekapitulasi Keuangan Tahunan</h2>
                                    <div class="box-icon">
                                        <!--<a href="#" class="btn xbuttonPrint"><i class="icon-print"></i></a>-->
                                    </div>
                                </div>
                                <div class="box-content">
                                    <div class="span12">
                                        <div class="box-content">
                                            <fieldset>
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>Tahun Ajaran</td>
                                                            <td>{{\Laravel\Form::select('tahunajaran', $tahunajaranselect,(isset($tahunaktif) ? $tahunaktif->id : null),array('id'=>'selectTahun','style'=>'width:125px;margin:0;'))}}</td>
                                                            <td>
                                                                <a href="#" class="btn btn-primary" id="buttonTampil">Tampilkan</a>
                                                                <a href="#" class="btn btn-success buttonPrint" >Cetak</a>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </fieldset>
                                            <br/>
                                            <div id="tabelrekap">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--/span-->
                        </div>
