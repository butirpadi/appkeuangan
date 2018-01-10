@foreach($bulan as $bl)
<div class="span2" style="margin: 0;">
    <?php echo \Laravel\Form::checkbox('bulan[]', $bl->id, false); ?> 
    {{ ucwords($bl->nama)  }}
</div>
@endforeach