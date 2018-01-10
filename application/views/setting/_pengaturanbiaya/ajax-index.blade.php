{{ Laravel\Form::open(URL::to('setting/pengaturanbiaya/edit'),'POST') }}

@if($biaya->perjenjang == 'Y')
    @if(count($nilaibiayas)>0)
        <!--Jika sebelumnya telah ada dalam database/telah disetting sebelumnya-->
        @foreach($nilaibiayas as $nb)
            @if($nb->jenjang == 1)
                <div {{ $errors->has('jenjang_1') ? 'class="control-group error"' : 'class="control-group"' }}>
                    <label class="control-label" >Jenjang 1</label>
                    <div class="controls">
                        Rp. {{ Form::text('jenjang_1',(Input::old('jenjang_1') ? Input::old('jenjang_1') : $nb->jumlah),array('class'=>'input-medium','required')) }}
                        <span class="help-inline"> {{ $errors->has('jenjang_1') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
                    </div>
                </div>
            @elseif($nb->jenjang == 2)
                <div {{ $errors->has('jenjang_2') ? 'class="control-group error"' : 'class="control-group"' }}>
                    <label class="control-label" >Jenjang 2</label>
                    <div class="controls">
                        Rp. {{ Form::text('jenjang_2',(Input::old('jenjang_2') ? Input::old('jenjang_2') : $nb->jumlah ),array('class'=>'input-medium','required')) }}
                        <span class="help-inline"> {{ $errors->has('jenjang_2') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
                    </div>
                </div>
            @elseif($nb->jenjang == 3)
                <div {{ $errors->has('jenjang_3') ? 'class="control-group error"' : 'class="control-group"' }}>
                    <label class="control-label" >Jenjang 3</label>
                    <div class="controls">
                        Rp. {{ Form::text('jenjang_3',(Input::old('jenjang_3') ? Input::old('jenjang_3') : $nb->jumlah),array('class'=>'input-medium','required')) }}
                        <span class="help-inline"> {{ $errors->has('jenjang_3') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
                    </div>
                </div>
            @elseif($nb->jenjang == 4)
                <div {{ $errors->has('jenjang_4') ? 'class="control-group error"' : 'class="control-group"' }}>
                    <label class="control-label" >Jenjang 4</label>
                    <div class="controls">
                        Rp. {{ Form::text('jenjang_4',(Input::old('jenjang_4') ? Input::old('jenjang_4') : $nb->jumlah),array('class'=>'input-medium','required')) }}
                        <span class="help-inline"> {{ $errors->has('jenjang_4') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
                    </div>
                </div>
            @elseif($nb->jenjang == 5)
                <div {{ $errors->has('jenjang_5') ? 'class="control-group error"' : 'class="control-group"' }}>
                    <label class="control-label" >Jenjang 5</label>
                    <div class="controls">
                        Rp. {{ Form::text('jenjang_5',(Input::old('jenjang_5') ? Input::old('jenjang_5') : $nb->jumlah),array('class'=>'input-medium','required')) }}
                        <span class="help-inline"> {{ $errors->has('jenjang_5') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
                    </div>
                </div>
            @elseif($nb->jenjang == 6)
                <div {{ $errors->has('jenjang_6') ? 'class="control-group error"' : 'class="control-group"' }}>
                    <label class="control-label" >Jenjang 6</label>
                    <div class="controls">
                        Rp. {{ Form::text('jenjang_6',(Input::old('jenjang_6') ? Input::old('jenjang_6') : $nb->jumlah),array('class'=>'input-medium','required')) }}
                        <span class="help-inline"> {{ $errors->has('jenjang_6') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <!--Setting baru-->
        <div {{ $errors->has('jenjang_1') ? 'class="control-group error"' : 'class="control-group"' }}>
            <label class="control-label" >Jenjang 1</label>
            <div class="controls">
                Rp. {{ Form::text('jenjang_1',Input::old('jenjang_1') ,array('class'=>'input-medium','required')) }}
                <span class="help-inline"> {{ $errors->has('jenjang_1') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
            </div>
        </div>
        <div {{ $errors->has('jenjang_2') ? 'class="control-group error"' : 'class="control-group"' }}>
            <label class="control-label" >Jenjang 2</label>
            <div class="controls">
                Rp. {{ Form::text('jenjang_2',Input::old('jenjang_2'),array('class'=>'input-medium','required')) }}
                <span class="help-inline"> {{ $errors->has('jenjang_2') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
            </div>
        </div>
        <div {{ $errors->has('jenjang_3') ? 'class="control-group error"' : 'class="control-group"' }}>
            <label class="control-label" >Jenjang 3</label>
            <div class="controls">
                Rp. {{ Form::text('jenjang_3',Input::old('jenjang_3'),array('class'=>'input-medium','required')) }}
                <span class="help-inline"> {{ $errors->has('jenjang_3') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
            </div>
        </div>
        <div {{ $errors->has('jenjang_4') ? 'class="control-group error"' : 'class="control-group"' }}>
            <label class="control-label" >Jenjang 4</label>
            <div class="controls">
                Rp. {{ Form::text('jenjang_4',Input::old('jenjang_4') ,array('class'=>'input-medium','required')) }}
                <span class="help-inline"> {{ $errors->has('jenjang_4') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
            </div>
        </div>
        <div {{ $errors->has('jenjang_5') ? 'class="control-group error"' : 'class="control-group"' }}>
            <label class="control-label" >Jenjang 5</label>
            <div class="controls">
                Rp. {{ Form::text('jenjang_5',Input::old('jenjang_5') ,array('class'=>'input-medium','required')) }}
                <span class="help-inline"> {{ $errors->has('jenjang_5') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
            </div>
        </div>
        <div {{ $errors->has('jenjang_6') ? 'class="control-group error"' : 'class="control-group"' }}>
            <label class="control-label" >Jenjang 6</label>
            <div class="controls">
                Rp. {{ Form::text('jenjang_6',Input::old('jenjang_6') ,array('class'=>'input-medium','required')) }}
                <span class="help-inline"> {{ $errors->has('jenjang_6') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
            </div>
        </div>
    @endif
@else
    @if(count($nilaibiayas)>0)
        <div {{ $errors->has('jumlah') ? 'class="control-group error"' : 'class="control-group"' }}>
            <label class="control-label" >Jumlah</label>
            <div class="controls">
                {{ Form::text('jumlah',(Input::old('jumlah') ? Input::old('jumlah') : $nilaibiayas->jumlah),array('class'=>'input-medium','required')) }}
                <span class="help-inline"> {{ $errors->has('jumlah') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
            </div>
        </div>
    @else
        <div {{ $errors->has('jumlah') ? 'class="control-group error"' : 'class="control-group"' }}>
            <label class="control-label" >Jumlah</label>
            <div class="controls">
                {{ Form::text('jumlah',Input::old('jumlah'),array('class'=>'input-medium','required')) }}
                <span class="help-inline"> {{ $errors->has('jumlah') ? 'Tidak boleh kosong dan harus numeric' : '' }}</span>
            </div>
        </div>
    @endif
@endif

<!--hidden value-->
{{ Form::hidden('biaya_id',$biaya->id) }}
{{ Form::hidden('tahunajaran_id',$tahunajaran->id) }}

<div class="form-actions">
    <button type="submit" class="btn btn-primary" >Save changes</button>
    <button id="btnCancel" type="reset" class="btn" >Cancel</button>
</div>

{{ Form::close() }}

<script type="text/javascript">
    jQuery(document).ready(function(){
       //close formKetentuan
                jQuery('#btnCancel').click(function(){
                    jQuery('#tabelKetentuan').hide(300);
                }); 
    });
</script>