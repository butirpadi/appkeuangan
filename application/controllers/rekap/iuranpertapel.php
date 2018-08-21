<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of iuranbulanan
 *
 * @author Klik
 */
class Rekap_Iuranpertapel_Controller extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        //filter login
        $this->filter('before', 'auth');
        // //filter permission
        // $this->filter('before', 'permission:manage_rekapitulasi_bulanan');
    }
    
    public function get_index(){
         //set assets
        Asset::container('footer')->add('rupiah', 'js/rupiah.js');
                
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $tahunajaranselect = array();
        foreach($tahunajarans as $ta){
            $tahunajaranselect[$ta->id] = $ta->nama;
        }
        
        $biayas = Jenisbiaya::where('tipe','!=','ITB')
                                ->where('tipe', '!=', 'BBBI')
                                ->where('tipe', '!=', 'BTBI')
                                ->get();
        $biayaselect = array();
        foreach($biayas as $biaya){
            $biayaselect[$biaya->id] = $biaya->nama;
        }
        
        $rombels = Rombel::order_by('jenjang','asc')->get(); 
        $rombelselect = array();
        foreach($rombels as $rom){
            $rombelselect[$rom->id] = $rom->nama;
        }
        
        $this->layout->nest('content', 'rekap.iuranpertapel.index',array(
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif,
            'tahunajaranselect'=>$tahunajaranselect,
            'biayaselect'=>$biayaselect,
            'rombelselect'=>$rombelselect
        ));
    }

    public function post_ajaxtabelrekap(){
        $data = \DB::table('view_transaksi_siswa')->get();
        $tapel = \Input::get('tahunajaran');
        $biaya = \Input::get('selectBiaya');
        $rombel = \Input::get('selectRombel');
        $cetak = \Input::get('cetak');

        $jenisbiayaObj = Jenisbiaya::find($biaya);
        $rombelObj = Rombel::find($rombel);
        $tahunajaranObj = Tahunajaran::find($tapel);
        
        if ($rombel == ''){
            $rombel = 'true';
        }else{
            $rombel = 'rombel_id = ' . $rombel;
        }

        if ($biaya == ''){
            $biaya = 'true';
        }else{
            $biaya = 'jenisbiaya_id = ' . $biaya;
        }

        // $data = \DB::query('select * from view_transaksi_siswa 
        //                 where tahunajaran_id = ' . $tapel . ' and ' . $biaya . ' and ' . $rombel . ' group by siswa_id');
        $data = \DB::query('select  nisn,siswa_id,siswa,bulan_id,rombel,
        (
            select sum(vt.jumlah) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            and extract(month from vt.tanggal) = 1
        ) as januari,
        (
            select sum(vt.jumlah) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            and extract(month from vt.tanggal) = 2
        ) as februari,
        (
            select sum(vt.jumlah) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            and extract(month from vt.tanggal) = 3
        )as maret,
        (
            select sum(vt.jumlah) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            and extract(month from vt.tanggal) = 4
        )as april,
        (
            select sum(vt.jumlah) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            and extract(month from vt.tanggal) = 5
        ) as mei,
        (
            select sum(vt.jumlah) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            and extract(month from vt.tanggal) = 6
        ) as juni,
        (
            select sum(vt.jumlah) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            and extract(month from vt.tanggal) = 7
        ) as juli,
        (
            select sum(vt.jumlah) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            and extract(month from vt.tanggal) = 8
        ) as agustus,
        (
            select sum(vt.jumlah) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            and extract(month from vt.tanggal) = 9
        ) as september,
        (
            select sum(vt.jumlah) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            and extract(month from vt.tanggal) = 10
        ) as oktober,
        (
            select sum(vt.jumlah) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            and extract(month from vt.tanggal) = 11
        ) as november,
        (
            select sum(vt.jumlah) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            and extract(month from vt.tanggal) = 12
        ) as desember,
        (select sum(vt.jumlah) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            ) as total_bayar,
        (select sum(vt.potongan) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            ) as potongan,
        harus_bayar,
        (harus_bayar - (select sum(vt.potongan) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            ) - (select sum(vt.jumlah) 
            from view_transaksi_siswa as vt 
            where vt.tahunajaran_id = view_transaksi_siswa.tahunajaran_id 
            and vt.rombel_id = view_transaksi_siswa.rombel_id
            and vt.jenisbiaya_id = view_transaksi_siswa.jenisbiaya_id
            and vt.siswa_id = view_transaksi_siswa.siswa_id
            )) as amount_due
        from view_transaksi_siswa
        where tahunajaran_id = ' . $tapel . 
        ' and ' . $biaya . 
        ' and ' . $rombel . 
        ' group by siswa_id
        order by nisn, rombel_id');
        
        $bulan = Bulan::order_by('posisi','asc')->get();
        $bulans = array();
        foreach ($bulan as $bul){
            $bulans[count($bulans)] = $bul;
        }
        
        
        
        // echo 'Val Cetak : ' . $cetak;

        if($cetak === 'false'){
            return View::make('rekap.iuranpertapel.ajaxtabelrekap')
                        ->with('data',$data)
                        ->with('bulans',$bulans)
                        ->with('rombel',$rombelObj)
                        ->with('jenisbiaya',$jenisbiayaObj);
        }else{
            // echo 'show report pdf';
            // echo \Input::get('selectRombel');
            // echo \Input::get('selectRombel');
            $this->cetakPdf($data, $rombelObj, $jenisbiayaObj, $tahunajaranObj);
        }
        
    }

    public function cetakPdf($rekap, $rombel, $jenisbiaya, $tahunajaran){
        $this->layout = null;
        //setting for page
        if($rombel){
            $colnum = 6;
            $colnisn = 6;
            $colnama = 42;
            $colrombel = 30;
            $colbl = 14;
            $coltotal = 16;
        }else{
            $colnum = 10;
            $colnisn = 10;
            $colnama = 100;
            $colrombel = 58;
            $colbl = 12;
            $coltotal = 27;
        }

        $tglcetak = date('d-m-Y [H:i:s]');
        // $font = 'Courier';
        
        $pdf = new Fpdf('L','mm','A4');
        $pdf->SetMargins(5,5,5);
        $pdf->SetAutoPageBreak(true, 5);
        $pdf->AddPage();
        // //create page header
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,8,'REKAPITULASI PEMBAYARAN ' . strtoupper($jenisbiaya->nama),0,1,'C');
        $pdf->SetFont('Arial','',10);
        // $pdf->Cell(0,5,$namasekolah,0,1,'C');
        // $pdf->SetFont('Courier','',10);
        // $pdf->Cell(0,5,$alamat,0,1,'C');
        // $pdf->Cell(0,2,'','B',1);
        // $pdf->Cell(0,0.1,'','B',1);
        // $pdf->Cell(0,0.1,'','B',1);
        // $pdf->Cell(0,1,'','B',1);
        // $pdf->ln(5);
        // //create report header
        $pdf->Cell(35,5,'Tahun Ajaran' ,0,0,'L');
        $pdf->Cell(100,5,' :  ' .  $tahunajaran->nama,0,0,'L');
        $pdf->Cell(35,5,'Tanggal Cetak',0,0,'L');
        $pdf->Cell(100,5,' :  ' . $tglcetak,0,1,'L');
        if($rombel){
            $pdf->Cell(35,5,'Rombongan Belajar',0,0,'L');
            $pdf->Cell(100,5,' :  ' . $rombel->nama,0,1,'L');
        }
        $pdf->ln(5);
        //create table header
        $pdf->SetFont('Arial','',8);
        $pdf->Cell($colnum,10,'NO',1,0,'C');
        $pdf->Cell($colnisn,10,'NIS',1,0,'C');
        $pdf->Cell($colnama,10,'Nama',1,0,'C');
        if(!$rombel){
            $pdf->Cell($colrombel,10,'Rombel',1,0,'C');
        }
        if($rombel){
            $pdf->Cell((12 * $colbl),5,'Pembayaran/Bulan',1,0,'C');
        }
        if($rombel){
            $pdf->Cell($coltotal,10,'Bayar',1,0,'C');
            $pdf->Cell($coltotal,10,'Wajib',1,0,'C');
            $pdf->Cell($coltotal,10,'Pot',1,0,'C');
            $pdf->Cell($coltotal,10,'Sisa',1,0,'C');
        }else{
            $pdf->Cell($coltotal,10,'Bayar',1,0,'C');
            $pdf->Cell($coltotal,10,'Kewajiban',1,0,'C');
            $pdf->Cell($coltotal,10,'Potongan',1,0,'C');
            $pdf->Cell($coltotal,10,'Sisa',1,0,'C');
        }

        $pdf->Cell(5,5,'',0,1,'C'); //column kosong untuk mengakali turun separuh kotak
        $pdf->Cell($colnum,5,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NO
        $pdf->Cell($colnisn,5,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NISN
        $pdf->Cell($colnama,5,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom Nama
        if(!$rombel){
            $pdf->Cell($colrombel,5,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom rombel
        }
        //create bulan table header
        if($rombel){
            $bulans = Bulan::order_by('posisi','asc')->get();
            foreach($bulans as $bl){
                $namabulan = ucwords(substr($bl->nama, 0, 3));
                // $namabulan = '1.000.000';
                $pdf->Cell($colbl,5, $namabulan ,1,0,'C');
            }
        }

        $pdf->ln();
        
        
        //create content
        // $pdf->SetFont('Courier','',10);
        $rownum = 1;
        $yAxis = 65;
        $grandtotal = 0;
        $sum_harus_bayar =0;
        $sum_potongan =0;
        $sum_amount_due =0;
        $isFirstPage = true;
        $pagenum = 1;
        
        foreach($rekap as $rek){
            // $pdf->SetFont('Courier','',10);
            $pdf->Cell($colnum,5,$rownum++,1,0,'R'); 
            $pdf->Cell($colnisn,5,$rek->nisn,1,0,'L'); 
            $pdf->Cell($colnama,5,substr(ucwords(strtolower($rek->siswa)),0,30),1,0,'L');
            // $pdf->SetFont('Courier','',9);
            if(!$rombel){
                $pdf->Cell($colrombel,5,substr($rek->rombel,0,17),1,0,'L');
            }
            if($rombel){
                // $pdf->SetFont('Courier','',7);
                $pdf->Cell($colbl,5,($rek->juli ? number_format($rek->juli, 0, ',', '.') : '-'),1,0,'R');
                $pdf->Cell($colbl,5,($rek->agustus ? number_format($rek->agustus, 0, ',', '.') : '-'),1,0,'R');
                $pdf->Cell($colbl,5,($rek->september ? number_format($rek->september, 0, ',', '.') : '-'),1,0,'R');
                $pdf->Cell($colbl,5,($rek->oktober ? number_format($rek->oktober, 0, ',', '.') : '-'),1,0,'R');
                $pdf->Cell($colbl,5,($rek->november ? number_format($rek->november, 0, ',', '.') : '-'),1,0,'R');
                $pdf->Cell($colbl,5,($rek->desember ? number_format($rek->desember, 0, ',', '.') : '-'),1,0,'R');
                $pdf->Cell($colbl,5,($rek->januari ? number_format($rek->januari, 0, ',', '.') : '-'),1,0,'R');
                $pdf->Cell($colbl,5,($rek->februari ? number_format($rek->februari, 0, ',', '.') : '-'),1,0,'R');
                $pdf->Cell($colbl,5,($rek->maret ? number_format($rek->maret, 0, ',', '.') : '-'),1,0,'R');
                $pdf->Cell($colbl,5,($rek->april ? number_format($rek->april, 0, ',', '.') : '-'),1,0,'R');
                $pdf->Cell($colbl,5,($rek->mei ? number_format($rek->mei, 0, ',', '.') : '-'),1,0,'R');
                $pdf->Cell($colbl,5,($rek->juni ? number_format($rek->juni, 0, ',', '.') : '-'),1,0,'R');
            }
            // $pdf->SetFont('Courier','',10);
            $pdf->Cell($coltotal,5,($rek->total_bayar ? number_format($rek->total_bayar, 0, ',', '.')  : '0'),1,0,'R');
            $pdf->Cell($coltotal,5,($rek->harus_bayar ? number_format($rek->harus_bayar, 0, ',', '.')  : '0'),1,0,'R');
            $pdf->Cell($coltotal,5,($rek->potongan ? number_format($rek->potongan, 0, ',', '.')  : '0'),1,0,'R');
            $pdf->Cell($coltotal,5,($rek->amount_due ? number_format($rek->amount_due, 0, ',', '.')  : '0'),1,1,'R');
            $grandtotal += $rek->total_bayar;
            $sum_harus_bayar += $rek->harus_bayar;
            $sum_potongan += $rek->potongan;
            $sum_amount_due += $rek->amount_due;
            
            $yAxis += 5;
            if($isFirstPage){
                $batasAkhirAxis = 205;
            }else{
                $batasAkhirAxis = 230;
            }
            
            //set page num counter
            $pagenum++;
            
            // if ($yAxis> $batasAkhirAxis){
            //     //add new page
            //     $pdf->AddPage();
            //     //sub header
            //     $pdf->SetFont('Courier','',10);
            //     $pdf->Cell($colnum+$colnisn+$colnama+$colrombel+(12 * $colbl),10,$namareport . '  (' . $tglcetak . ') ',0,0,'L'); //page number
            //     $pdf->Cell($coltotal,10,'Page ' . $pdf->PageNo(),0,1,'R'); //page number
            //     //create table header
            //     $pdf->SetFont('Courier','',12);
            //     $pdf->Cell($colnum,14,'NO',1,0,'C');
            //     $pdf->Cell($colnisn,14,'NISN',1,0,'C');
            //     $pdf->Cell($colnama,14,'Nama',1,0,'C');
            //     $pdf->Cell($colrombel,14,'Rombel',1,0,'C');
            //     $pdf->Cell((12 * $colbl),7,$jenisbiaya->nama . '(Rp. ' . number_format($ketentuanbiaya->jumlah, 0, ',', '.') . ')',1,0,'C');
            //     $pdf->Cell($coltotal,14,'Total (Rp)',1,0,'C');
            //     $pdf->Cell(5,7,'',0,1,'C'); //column kosong untuk mengakali turun separuh kotak
            //     $pdf->Cell($colnum,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NO
            //     $pdf->Cell($colnisn,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NISN
            //     $pdf->Cell($colnama,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom Nama
            //     $pdf->Cell($colrombel,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom rombel
                
            //     foreach($bulan as $bl){
            //         $pdf->Cell($colbl,7, ucwords(substr($bl->nama, 0, 3)) ,1,0,'C');
            //     }
            //     $pdf->ln();
                
            //     $yAxis = 65;
            //     $isFirstPage = false;
            // }
        }
        
        //crate grand total
        $pdf->SetFont('Arial','B',8);
        if($rombel){
            $pdf->Cell(($colnum + $colnisn + $colnama  + (12 * $colbl)),10,'Grand Total',1,0,'C');
        }else{
            $pdf->Cell(($colnum + $colnisn + $colnama + $colrombel),10,'Grand Total',1,0,'C');
        }
        // $pdf->SetFont('Courier','B',10);
        $pdf->Cell($coltotal,10,  number_format($grandtotal, 0, ',', '.'),1,0,'R');
        $pdf->Cell($coltotal,10,  number_format($sum_harus_bayar, 0, ',', '.'),1,0,'R');
        $pdf->Cell($coltotal,10,  number_format($sum_potongan, 0, ',', '.'),1,0,'R');
        $pdf->Cell($coltotal,10,  number_format($sum_amount_due, 0, ',', '.'),1,1,'R');
        
                
        $pdf->Output('RekapIuranPerTapel' . '_'.date('YmdHis').'.pdf','I');
        exit();
    }
    
}
