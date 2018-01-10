<table class="table table-condensed">
    <thead>
        <tr>
            <th>Tanggal Bayar</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php $total=0; ?>
        @foreach($datatrans as $dt)
            <tr>
                <td>{{ date('d-m-Y',strtotime($dt->tanggal)) }}</td>
                <td class="uang"><?php echo number_format($dt->jumlah, 0, ',', '.'); ?></td>
            </tr>
            <?php $total += $dt->jumlah; ?>
        @endforeach
        <tr style="background-color: orange;color:black;">
            <td><strong>TOTAL BAYAR</strong></td>
            <td class="uang"><strong><?php echo number_format($total, 0, ',', '.'); ?></strong></td>
        </tr>
    </tbody>
</table>