<table class="table table-condensed">
    <thead>
        <tr>
            <th>Bulan</th>
            <th>Tgl Bayar</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bulans as $bl)
            <?php $bayar = false; ?>
            <?php $tglbayar = null; ?>
            @foreach($datatrans as $dt)
                @if($dt->bulan_id == $bl->id)
                    <?php $bayar=true; ?>
                    <?php $tglbayar=$dt->tanggal; ?>
                @endif
            @endforeach
            <tr>
                <td>{{ ucwords($bl->nama) }}</td>                
                @if($bayar)
                    <td>
                        {{ date('d-m-Y',strtotime($tglbayar)) }}
                    </td>
                    <td><span class="label label-success">&nbsp;&nbsp;<i class="icon-ok icon-white"></i>&nbsp;&nbsp;</span></td>
                @else
                    <td>
                        -
                    </td>
                    <td><span class="label label-warning">&nbsp;&nbsp;<i class="icon-remove icon-white"></i>&nbsp;&nbsp;</span></td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>