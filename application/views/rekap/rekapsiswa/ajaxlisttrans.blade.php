<table class="table table-condensed datatable">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Biaya</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datatrans as $dt)
            <tr>
                <td>{{ date('d-m-Y',strtotime($dt->tanggal)) }}</td>
                <td>
                    {{ ucwords($dt->jenisbiaya) }}
                    @if($dt->bulan != '')
                        {{ '[ '. ucwords($dt->bulan) . ' ]' }}
                    @endif
                </td>
                <td class="uang"><?php echo number_format($dt->jumlah, 0, ',', '.'); ?></td>
            </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
    jQuery(document).ready(function(){
        $('.datatable').dataTable({
                "bFilter" : false,               
                "bLengthChange": false,
                "bInfo": false,
                "sPaginationType": "bootstrap",
                "iDisplayLength": 6,
                "aLengthMenu": [[ 6], [ 6]],
                "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                }
        } );
    })
</script>