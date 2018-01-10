@section('custom_script')
<script type="text/javascript">
    jQuery(document).ready(function(){
       /**
        * set to not selected
        */ 
       jQuery('select[name=aktif]').val([]);
    });
</script>
@endsection

<!--<div>
        <ul class="breadcrumb">
                <li>
                        <a href="{{ URL::to('home') }}">Home</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="{{ URL::to('setting/tahunajaran') }}">Tahun Ajaran</a> <span class="divider">/</span>
                </li>
                <li>
                        <a href="#">Tambah</a>
                </li>
        </ul>
</div>-->

<div class="row-fluid sortable">
        <div class="box span12">
                <div class="box-header well" data-original-title>
                        <h2><i class="icon-edit"></i> Tambah Tahun Ajaran</h2>
                        <div class="box-icon">
                            <!--<a href="#" class="btn btn-setting btn-round"><i class="icon icon-darkgray icon-help"></i></a>-->
                        </div>
                </div>
                <div class="box-content">
                    {{ Laravel\Form::open(URL::to('setting/tahunajaran/new'), 'POST', array('class'=>'form-horizontal')) }}
                        <fieldset>
                              <div class="control-group">
                                <label class="control-label" for="typeahead">Nama</label>
                                <div class="controls">
                                      {{ Form::text('nama',null,array('class'=>'span6 typeahead','required','autocomplete'=>'off')) }}
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="date01">Aktif</label>
                                <div class="controls">
                                    <?php $aktif = array('Y'=>'Aktif','N'=>'Non Aktif') ?>
                                    {{ Laravel\Form::select('aktif', $aktif) }}
                                </div>
                              </div>
                              <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ URL::to('setting/tahunajaran') }}" type="reset" class="btn">Cancel</a>
                              </div>
                        </fieldset>
                      {{ Form::close() }}
                </div>
        </div><!--/span-->

</div><!--/row-->





