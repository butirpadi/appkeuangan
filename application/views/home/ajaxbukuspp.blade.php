<?php $rownum = 1;?>
<?php $grandtotal = 0;?>
@foreach($rekap as $rek)
    <?php $datarek = $rek; ?>
@endforeach

<table>
    <tbody class="table">
        <tr style="border: none;">
            <td><strong>NIS</strong></td>
            <td>: {{ $datarek->nisn }}</td>
            <td><strong>Siswa</strong></td>
            <td>: {{ $datarek->nama }}</td>
            <td><strong>Rombel</strong></td>
            <td>: {{ $datarek->rombel }}</td>
        </tr>
    </tbody>
</table>
<br/>
<div>
    <div>
        @for($i=0;$i< count($bulans); $i++)
                <div class="span1 alert alert-block">
                    <table>
                        <tbody>
                            <tr>
                                <td style="text-align: center!important;">
                                    <?php echo strtoupper($bulans[$i]->nama) ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">
                                    @if($i == 0)
                                        <!--bulan ke 1-->
                                        @if($datarek->bl1)
                                            <span class="label label-success">LUNAS</span>
                                        @else    
                                            <span class="label label-warning">BELUM LUNAS</span>
                                        @endif
                                    @elseif($i == 1)
                                        <!--bulan ke 1-->
                                        @if($datarek->bl2)
                                            <span class="label label-success">LUNAS</span>
                                        @else    
                                            <span class="label label-warning">BELUM LUNAS</span>
                                        @endif
                                    @elseif($i == 2)
                                        <!--bulan ke 1-->
                                        @if($datarek->bl3)
                                            <span class="label label-success">LUNAS</span>
                                        @else    
                                            <span class="label label-warning">BELUM LUNAS</span>
                                        @endif
                                    @elseif($i == 3)
                                        <!--bulan ke 1-->
                                        @if($datarek->bl4)
                                            <span class="label label-success">LUNAS</span>
                                        @else    
                                            <span class="label label-warning">BELUM LUNAS</span>
                                        @endif
                                    @elseif($i == 4)
                                        <!--bulan ke 1-->
                                        @if($datarek->bl5)
                                            <span class="label label-success">LUNAS</span>
                                        @else    
                                            <span class="label label-warning">BELUM LUNAS</span>
                                        @endif
                                    @elseif($i == 5)
                                        <!--bulan ke 1-->
                                        @if($datarek->bl6)
                                            <span class="label label-success">LUNAS</span>
                                        @else    
                                            <span class="label label-warning">BELUM LUNAS</span>
                                        @endif
                                    @elseif($i == 6)
                                        <!--bulan ke 1-->
                                        @if($datarek->bl7)
                                            <span class="label label-success">LUNAS</span>
                                        @else    
                                            <span class="label label-warning">BELUM LUNAS</span>
                                        @endif
                                    @elseif($i == 7)
                                        <!--bulan ke 1-->
                                        @if($datarek->bl8)
                                            <span class="label label-success">LUNAS</span>
                                        @else    
                                            <span class="label label-warning">BELUM LUNAS</span>
                                        @endif
                                    @elseif($i == 8)
                                        <!--bulan ke 1-->
                                        @if($datarek->bl9)
                                            <span class="label label-success">LUNAS</span>
                                        @else    
                                            <span class="label label-warning">BELUM LUNAS</span>
                                        @endif
                                    @elseif($i == 9)
                                        <!--bulan ke 1-->
                                        @if($datarek->bl10)
                                            <span class="label label-success">LUNAS</span>
                                        @else    
                                            <span class="label label-warning">BELUM LUNAS</span>
                                        @endif
                                    @elseif($i == 10)
                                        <!--bulan ke 1-->
                                        @if($datarek->bl11)
                                            <span class="label label-success">LUNAS</span>
                                        @else    
                                            <span class="label label-warning">BELUM LUNAS</span>
                                        @endif
                                    @elseif($i == 11)
                                        <!--bulan ke 1-->
                                        @if($datarek->bl12)
                                            <span class="label label-success">LUNAS</span>
                                        @else    
                                            <span class="label label-warning">BELUM LUNAS</span>
                                        @endif

                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>  
        @endfor      
    </div>
</div>

    