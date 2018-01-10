    @section('custom_script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            
            /**
             * Predefined Function/Statement
             * @type data|String
             */
            jQuery('select[name=asal]').val([]);
            jQuery('select[name=tujuan]').val([]);
            jQuery('select[name=tujuan]').attr('readonly','readonly');
            
            /**
             * set tahunajaran aktif
             */
            var tahunaktifid = "{{ $tahunaktif->id }}";
            jQuery('select[name=tahunajaran] option[value='+ tahunaktifid +']').css('color','white');
            jQuery('select[name=tahunajaran] option[value='+ tahunaktifid +']').css('background-color','green');
            
            /**
             * Set kas tujuan setelah kas awal di pilih
             */
            jQuery('select[name=asal]').change(function(){
                var asal = jQuery(this).val();
                
                if (asal == 'KU'){
                    jQuery('select[name=tujuan]').val('KB');
                }else if(asal == 'KB'){
                    jQuery('select[name=tujuan]').val('KU');
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

<div id="posresult"></div>


<div class="row-fluid sortable ui-sortable">
        <div class="box span12">
            <div class="box-header well" data-original-title="">
                    <h2><i class="icon-share-alt"></i> Mutasi Kas</h2>
                    <div class="box-icon">
                        <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                    </div>
            </div>
            <div class="box-content">
                <?php echo Laravel\Form::open(URL::to('transaksi/mutasi/new'));?>
                <fieldset class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">
                            Tahun Ajaran
                        </label>
                        <div class="controls">
                            <?php echo Laravel\Form::select('tahunajaran', $selecttahunajaran, $tahunaktif->id,array('class'=>'input-medium','required')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">
                            Tanggal
                        </label>
                        <div class="controls">
                            <?php echo Laravel\Form::text('tanggal',date('d-m-Y'),array('class'=>'input-medium datepicker','required')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">
                            Kas Asal
                        </label>
                        <div class="controls">
                            <?php echo Laravel\Form::select('asal',array('KU'=>'Kas Utama','KB'=>'Bank'),null,array('class'=>'input-medium','required')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">
                            Kas Tujuan
                        </label>
                        <div class="controls">
                            <?php echo Laravel\Form::select('tujuan',array('KU'=>'Kas Utama','KB'=>'Bank'),null,array('class'=>'input-medium','required')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">
                            Jumlah
                        </label>
                        <div class="controls">
                            <?php echo Laravel\Form::text('jumlah',null,array('class'=>'input-medium uang','id'=>'jumlah','required','autocomplete' => 'off')); ?>
                        </div>
                    </div>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-primary" id="buttonSimpan">Save</button>
                      <a href="{{ URL::to('transaksi/mutasi') }}" class="btn">Cancel</a>
                    </div>
                </fieldset>
                <?php echo Laravel\Form::close();?>
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