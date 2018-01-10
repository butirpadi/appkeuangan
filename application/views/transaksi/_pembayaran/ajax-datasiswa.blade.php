@if($siswa)
    <label class="control-label" >Data Siswa</label>
    <div class="controls">
        {{ Form::text('siswa_id',$siswa->id,array('class'=>'input-mini','placeholder'=>'ID','readonly')) }}
        {{ Form::text('nama',$siswa->nama,array('class'=>'input-xlarge','placeholder'=>'Nama Siswa','readonly')) }}
        {{ Form::text('rombel',$siswa->rombel->nama,array('class'=>'input-medium','placeholder'=>'Rombel','readonly')) }}
        {{ Form::hidden('jenjang',$siswa->rombel->jenjang,array('id'=>'textJenjang')) }}
    </div>
@else

@endif
