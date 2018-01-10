<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style>
            body{
                width: 500px;
                height: 400px;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Biaya</th>
                    <th>Bulan</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php $rownum=1;?>
                @foreach($detiltrans as $detrans)
                    <tr>
                        <td>{{ $rownum++ }}</td>
                        <td>{{ $detrans->jenisbiaya->nama }}</td>
                        <td>{{ ucwords($detrans->bulan->nama) }}</td>
                        <td>{{ $detrans->keterangan }}</td>
                        <td>{{ $detrans->jumlah }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
