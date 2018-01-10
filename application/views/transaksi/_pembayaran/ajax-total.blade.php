 <div style="margin: 5px;background-color: yellow;padding: 10px;" >
    <!--hidden total biaya-->
    {{ Form::hidden('total',$nilaibiaya->jumlah) }}
    <label style="font-size: 1.5em;">Total Biaya</label>
    <br/>
    <span id="labelTotal" style="font-size: 3em;float: right;">{{ $nilaibiaya->jumlah }}</span>
    <div class="clear clearfix"></div
    <br/>
    <br/>
</div>