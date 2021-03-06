@section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            /**
             * Members Variable
             */
            var tahunajaran;
            var tahunaktifid = "{{ $tahunaktif->id }}";
            /**
             * Set tahun ajaran aktif
             */
            jQuery('select[name=tahunajaran] option[value=' + tahunaktifid + ']').css('color','white');
            jQuery('select[name=tahunajaran] option[value=' + tahunaktifid + ']').css('background-color','green');
            /**
             * tampilkan data beasiswa
             */
            jQuery('#buttonTampil').click(function(){
                //get data tahunajaran JSON
                var tahunid = jQuery('select[name=tahunajaran]').attr('value');
                var getUrl = "{{ URL::to('setting/potongan/tahunajaran') }}" + "/" + tahunid;
                jQuery.ajaxSetup ({cache: false});
                  jQuery.ajax({
                      url:getUrl,dataType:"json",async:false,
                      success:function(data){
                        tahunajaran = data;
                      }
                  });
                // Load data potongan
                var getListUrl = "{{ URL::to('setting/potongan/listpotongan') }}" + "/" + tahunid;
                jQuery('#tabelData').load(getListUrl,function(){
                    //reinitiate datatable
                    $('#table-data').dataTable({
                                "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
                                "sPaginationType": "bootstrap",
                                "iDisplayLength": 50,
                                "aLengthMenu": [[ 50, 100, -1], [ 50, 100, "All"]],
                                "oLanguage": {
                                "sLengthMenu": "_MENU_ records per page"
                                }
                        } );
                    formatToRupiah();
                });
            });
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
              * delete beasiswa/potongan
              */
             jQuery('.buttonDelete').live("click",function(){
                 if(confirm('Anda akan menghapus data ini?')){
                        var id = jQuery(this).attr('potid');
                        var rownumber = jQuery(this).attr('rownumber');
                        var delUrl = 'setting/potongan/delete/'+id; 
                        // alert(delUrl);
                        // jQuery.get(delUrl,{id:id}).done(function(){
                        //     //remove row item
                        //     jQuery('#row_'+ parseInt(rownumber)).hide(250);
                        // }).fail(function(){
                        //     alert('.::PERINGATAN::. Data gagal dihapus.');
                        // });
                        var tbrow = $(this).parent().parent();
                        // tbrow.hide();

                        $.get(delUrl,null,function(){
                            //remove row item
                            // jQuery('#row_'+ parseInt(rownumber)).hide(250);
                            // $('#table-data').row( tbrow )
                            //                 .remove()
                            //                 .draw();
                            tbrow.fadeOut(250,function(){
                                tbrow.remove();
                            });
                        }).fail(function(){
                            alert('.::PERINGATAN::. Data gagal dihapus.');
                        });
                 }
                }) ;
            
            
        });
    </script>
@endsection
<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">Beasiswa & Bantuan</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon icon-darkgray icon-contacts"></i> Beasiswa & Bantuan</h2>
                        <div class="box-icon">
                            <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    <div class="row-fluid">
                        <div class="span8">
                            <table class="form table-striped">
                                <tbody>
                                    <tr>
                                        <td>Tahun Ajaran</td>
                                        <td>{{ \Laravel\Form::select('tahunajaran', $selecttahunajaran,(isset($tahunaktif) ? $tahunaktif->id : null),array('class'=>'input-medium tahun')) }}</td>
                                        <td><a href="#" id="buttonTampil" class="btn btn-primary">Tampilkan</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="span4">
                            <a href="{{ URL::To('setting/potongan/new') }}" class="btn btn-primary pull-right"><i class="icon-white icon-plus"></i> Tambah</a>
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <div id="tabelData"></div>
                </div>
        </div><!--/span-->

</div><!--/row-->

<style type="text/css">
    table.form td{
        border: none;
        padding: 5px;
    }
    table.form select{
        margin: 0;
    }
</style>





