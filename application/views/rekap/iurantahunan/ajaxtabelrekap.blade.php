<?php $rownum = 1;?>
<?php $grandtotal = 0;?>
<table class="table table-striped table-bordered bootstrap-datatable " >
    <thead>
            <tr>
                <th rowspan="2" style="vertical-align: middle; text-align: center;" >No</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >NISN</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >Nama</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >Rombel</th>
                <th colspan="12" style="vertical-align: middle;text-align: center;" >{{ $jenisbiaya->nama }} (Rp)</th>
                <th rowspan="2" style="vertical-align: middle;text-align: center;" >TOTAL (Rp)</th>
            </tr>
            <tr>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[0]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[1]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[2]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[3]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[4]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[5]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[6]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[7]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[8]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[9]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[10]->nama,0,3) }}</th>
                <th style="vertical-align: middle;text-align: center;text-transform: capitalize;">{{ substr($bulans[11]->nama,0,3) }}</th>
            </tr>
    </thead>   

    <tbody>
        @foreach($rekap as $rek)
            <tr>
                <td class="nomer">{{ $rownum++ }}</td>
                <td>{{ $rek->nisn }}</td>
                <td>{{ $rek->nama }}</td>
                <td>{{ $rek->rombel }}</td>
                <td class="uang">
                    @if($rek->bl1)
                        <?php echo number_format($rek->bl1, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->bl2)
                        <?php echo number_format($rek->bl2, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->bl3)
                        <?php echo number_format($rek->bl3, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->bl4)
                        <?php echo number_format($rek->bl4, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->bl5)
                        <?php echo number_format($rek->bl5, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->bl6)
                        <?php echo number_format($rek->bl6, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->bl7)
                        <?php echo number_format($rek->bl7, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->bl8)
                        <?php echo number_format($rek->bl8, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->bl9)
                        <?php echo number_format($rek->bl9, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->bl10)
                        <?php echo number_format($rek->bl10, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->bl11)
                        <?php echo number_format($rek->bl11, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->bl12)
                        <?php echo number_format($rek->bl12, 0, ',', '.'); ?>
                    @else
                        -
                    @endif
                </td>
                <td class="uang">
                    @if($rek->total)
                        <?php echo number_format($rek->total, 0, ',', '.'); ?>
                        <?php $grandtotal += $rek->total?>
                    @else
                        0
                    @endif
                </td>
            </tr>
        @endforeach
        <tr style="font-weight: bold;font-size: large;">
            <td colspan="16" style="text-align: center;">GRAND TOTAL</td>
            <td class="uang"><?php echo number_format($grandtotal, 0, ',', '.'); ?></td>
        </tr>
            
    </tbody>
</table>

<style type="text/css">
    .uang,.nomer{
        text-align: right!important;
    }
</style>
    