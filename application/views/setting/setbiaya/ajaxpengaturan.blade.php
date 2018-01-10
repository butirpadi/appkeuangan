{{Laravel\Form::open(URL::to('setting/setbiaya'),'POST')}}
<div class="control-group">
    <label class="control-label" ></label>
    <div class="controls">
        <table>
            <tbody>
                <tr>
                    <td>
                        <?php echo Laravel\Form::checkbox('sama', true,false,array('style' => 'margin: 0;padding: 0;')); ?>
            Biaya Sama Tiap Jenjang
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!--cek apakah data tersedia?-->
@if($ketentuanbiaya)
    <!--cek jenis biaya, perjenjang atau bukan-->
    @if($jenisbiaya->perjenjang == 'Y')
        @foreach($ketentuanbiaya as $ket)
            @if($ket->jenjang == 1)
                <div class="control-group">
                    <label class="control-label" >Jenjang 1</label>
                    <div class="controls">
                          {{Form::text('jenjang_1',$ket->jumlah,array('class'=>'input-medium uang','required','placeholder'=>'Rp. 0','id'=>'jenjang_1'))}}
                    </div>
                </div>
            @elseif($ket->jenjang == 2)
                <div class="control-group">
                    <label class="control-label" >Jenjang 2</label>
                    <div class="controls">
                          {{Form::text('jenjang_2',$ket->jumlah,array('class'=>'input-medium uang','required','placeholder'=>'Rp. 0','id'=>'jenjang_2'))}}
                    </div>
                </div>
            @elseif($ket->jenjang == 3)
                <div class="control-group">
                    <label class="control-label" >Jenjang 3</label>
                    <div class="controls">
                          {{Form::text('jenjang_3',$ket->jumlah,array('class'=>'input-medium uang','required','placeholder'=>'Rp. 0','id'=>'jenjang_3'))}}
                    </div>
                </div>
            @elseif($ket->jenjang == 4)
                <div class="control-group">
                    <label class="control-label" >Jenjang 4</label>
                    <div class="controls">
                          {{Form::text('jenjang_4',$ket->jumlah,array('class'=>'input-medium uang','required','placeholder'=>'Rp. 0','id'=>'jenjang_4'))}}
                    </div>
                </div>
            @elseif($ket->jenjang == 5)
                <div class="control-group">
                    <label class="control-label" >Jenjang 5</label>
                    <div class="controls">
                          {{Form::text('jenjang_5',$ket->jumlah,array('class'=>'input-medium uang','required','placeholder'=>'Rp. 0','id'=>'jenjang_5'))}}
                    </div>
                </div>
            @elseif($ket->jenjang == 6)
                <div class="control-group">
                    <label class="control-label" >Jenjang 6</label>
                    <div class="controls">
                          {{Form::text('jenjang_6',$ket->jumlah,array('class'=>'input-medium uang','required','placeholder'=>'Rp. 0','id'=>'jenjang_6'))}}
                    </div>
                </div>
             @endif
        @endforeach
    @else
        @foreach($ketentuanbiaya as $ket)
            <div class="control-group">
                <label class="control-label" >Jumlah</label>
                <div class="controls">
                      {{Form::text('jumlah',$ket->jumlah,array('class'=>'input-medium uang','required','placeholder'=>'Rp. 0','id'=>'jumlah'))}}
                </div>
            </div>
        @endforeach
    @endif
@else
    <!--jika data kosong maka tampilkan input baru-->
    <!--cek jenis biaya, perjenjang atau bukan-->
    @if($jenisbiaya->perjenjang == 'Y')
        
        <div class="control-group">
            <label class="control-label" >Jenjang 1</label>
            <div class="controls">
                  {{Form::text('jenjang_1',null,array('class'=>'input-medium uang','required','placeholder'=>'Rp. 0','id'=>'jenjang_1'))}}
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >Jenjang 2</label>
            <div class="controls">
                  {{Form::text('jenjang_2',null,array('class'=>'input-medium uang','required','placeholder'=>'Rp. 0','id'=>'jenjang_2'))}}
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >Jenjang 3</label>
            <div class="controls">
                  {{Form::text('jenjang_3',null,array('class'=>'input-medium uang','required','placeholder'=>'Rp. 0','id'=>'jenjang_3'))}}
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >Jenjang 4</label>
            <div class="controls">
                  {{Form::text('jenjang_4',null,array('class'=>'input-medium uang','required','placeholder'=>'Rp. 0','id'=>'jenjang_4'))}}
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >Jenjang 5</label>
            <div class="controls">
                  {{Form::text('jenjang_5',null,array('class'=>'input-medium uang','required','placeholder'=>'Rp. 0','id'=>'jenjang_5'))}}
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >Jenjang 6</label>
            <div class="controls">
                  {{Form::text('jenjang_6',null,array('class'=>'input-medium uang','required','placeholder'=>'Rp. 0','id'=>'jenjang_6'))}}
            </div>
        </div>

    @else
        <div class="control-group">
            <label class="control-label" >Jumlah</label>
            <div class="controls">
                  {{Form::text('jumlah',null,array('class'=>'input-medium uang','required','placeholder'=>'Rp. 0','id'=>'jumlah'))}}
            </div>
        </div>
    @endif
@endif

<!--hidden value-->
{{Form::hidden('jenisbiaya_id',$jenisbiaya->id)}}
{{Form::hidden('tahunajaran_id',$tahunajaran->id)}}

<div class="form-actions">
    <button type="submit" class="btn btn-primary" >Save changes</button>
    <button id="btnCancel" type="reset" class="btn" >Cancel</button>
</div>

{{Form::close()}}

<style type="text/css">
    .uang{
        text-align: right;
    }
</style>

<script type="text/javascript">
    jQuery(document).ready(function(){
        var iscek;
        jQuery('input[name=sama]').change(function(){
            iscek = jQuery(this).attr('checked');
            if (iscek == 'checked'){
                //disable other input
                jQuery('input[name=jenjang_2]').attr('readonly','readonly');
                jQuery('input[name=jenjang_3]').attr('readonly','readonly');
                jQuery('input[name=jenjang_4]').attr('readonly','readonly');
                jQuery('input[name=jenjang_5]').attr('readonly','readonly');
                jQuery('input[name=jenjang_6]').attr('readonly','readonly');
            }else{
                jQuery('input[name=jenjang_2]').removeAttr('readonly');
                jQuery('input[name=jenjang_3]').removeAttr('readonly');
                jQuery('input[name=jenjang_4]').removeAttr('readonly');
                jQuery('input[name=jenjang_5]').removeAttr('readonly');
                jQuery('input[name=jenjang_6]').removeAttr('readonly');
            }
        });
        
        jQuery('input[name=jenjang_1]').keypress(function(){
           if (iscek == 'checked'){
               var val = jQuery(this).attr('value');
               jQuery('input[name=jenjang_2]').attr('value',formatRupiahVal(val));
                jQuery('input[name=jenjang_3]').attr('value',formatRupiahVal(val));
                jQuery('input[name=jenjang_4]').attr('value',formatRupiahVal(val));
                jQuery('input[name=jenjang_5]').attr('value',formatRupiahVal(val));
                jQuery('input[name=jenjang_6]').attr('value',formatRupiahVal(val));
           }
        });
        jQuery('input[name=jenjang_1]').change(function(){
           if (iscek == 'checked'){
               var val = jQuery(this).attr('value');
               jQuery('input[name=jenjang_2]').attr('value', formatRupiahVal(val));
                jQuery('input[name=jenjang_3]').attr('value',formatRupiahVal(val));
                jQuery('input[name=jenjang_4]').attr('value',formatRupiahVal(val));
                jQuery('input[name=jenjang_5]').attr('value',formatRupiahVal(val));
                jQuery('input[name=jenjang_6]').attr('value',formatRupiahVal(val));
           }
        });
    })
</script>
    