<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bulanan
 *
 * @author Klik
 */
class Rekap_Bulanan_Controller extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_rekapitulasi_tahunan');
    }
    
    public function get_index(){
         //set assets
        Asset::container('footer')->add('rupiah', 'js/rupiah.js');
                
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $selecttahunajaran = array();
        foreach($tahunajarans as $ta){
            $selecttahunajaran[$ta->id] = $ta->nama;
        }
        
        $bulans = Bulan::order_by('posisi','asc')->get();
        $selectBulan = array();
        foreach($bulans as $bl){
            $selectBulan[$bl->id] = ucwords($bl->nama);
        }
        
        $this->layout->nest('content', 'rekap.bulanan.index',array(
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif,
            'selectTahunajaran'=>$selecttahunajaran,
            'selectBulan'=>$selectBulan
        ));
    }
    
    public function get_printtopdf($tahunajaranId,$bulan){
        $this->layout = null;
        $tahunajaran = Tahunajaran::find($tahunajaranId);
        $trans = DB::query("select tahunajaran,tahunajaran_id,jenisbiaya,jenisbiaya_id,arus, 
            case when arus = 'M' then sum(jumlah) else 0 end as masuk,
            case when arus = 'K' then sum(jumlah) else 0 end as keluar,
            posisi_tahunajaran
            from vtransmasuk 
            where date_format(tanggal,'%m-%Y') = '" . $bulan . "' 
            group by jenisbiaya_id");        
        
        //mutasi dalam bulan tersebut
        $mutasi = DB::query("SELECT * FROM mutasi WHERE tahunajaran_id = " . $tahunajaranId . " AND date_format(tanggal,'%m-%Y') = '" . $bulan ."'" );
        //mutasi keluar sebelum bulan tersebut
        $mutasikeluar = Mutasi::where('asal','=','KU')->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))->sum('jumlah');  //DB::query("select ifnull(sum(jumlah),0) as keluar from mutasi where asal = 'KU' and tanggal < '" . date('Y-m-d',strtotime('01-'.$bulan)) . "'");
        $mutasimasuk = Mutasi::where('asal','=','KB')->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))->sum('jumlah'); //DB::query("select ifnull(sum(jumlah),0) as keluar from mutasi where asal = 'KB' and tanggal < '" . date('Y-m-d',strtotime('01-'.$bulan)) . "'");
        $cashonbank = $mutasikeluar - $mutasimasuk;
        
        //pendapatan sebelum bulan tersebut
        $pendapatanlalu = DB::table('view_transmasuk')
                                ->where('arus','=','M')
                                ->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))
                                ->sum('jumlah');
        $pendapatanlalu += $mutasimasuk;
        //pengeluaran sebelum bulan tersebut
        $pengeluaranlalu = DB::table('view_transmasuk')
                                ->where('arus','=','K')
                                ->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))
                                ->sum('jumlah');
        $pengeluaranlalu += $mutasikeluar;
        
        //get nama bulan indonesia
        $namabulan = date('m',strtotime('01-'.$bulan));
        if($namabulan == '01'){
            $namabulan = 'Januari';
        }else if($namabulan == '02'){
            $namabulan = 'Februari';
        }else if($namabulan == '03'){
            $namabulan = 'Maret';
        }else if($namabulan == '04'){
            $namabulan = 'April';
        }else if($namabulan == '05'){
            $namabulan = 'Mei';
        }else if($namabulan == '06'){
            $namabulan = 'Juni';
        }else if($namabulan == '07'){
            $namabulan = 'Juli';
        }else if($namabulan == '08'){
            $namabulan = 'Agustus';
        }else if($namabulan == '09'){
            $namabulan = 'September';
        }else if($namabulan == '10'){
            $namabulan = 'Oktober';
        }else if($namabulan == '11'){
            $namabulan = 'November';
        }else if($namabulan == '12'){
            $namabulan = 'Desember';
        }
                 
        //set report header setting
        $namasekolah = Setting::first()->nama_skul;
        $alamat = Setting::first()->alamat_skul;
        $namareport = 'Rekapitulasi Keuangan Bulan ' . $namabulan;
        $namareport2 = $tahunajaran->nama;
        $target = Targetpencapaian::where('tahunajaran_id','=',$tahunajaranId)->first();
        
        //pre defined
        $isFirstPage = true;
        $tglcetak = date('d-m-Y [H:i:s]');
        
        //set column with variables
        $colnum = 10;
        $colsumber = 85;
        $colm = 50;
        $colk = 50;
        $coltgl = 30;
        
        //$pdf = new Fpdf('P','mm',array(215,330));
        $pdf = new Sabililhudapdf('P','mm',array(215,330));
        $pdf->setMargins(10,10,10);
        $pdf->AliasNbPages();
        $pdf->setReportTitle($namareport);
        $pdf->setReportSubTitle( $namareport2);
        $pdf->setNamaSekolah($namasekolah);
        $pdf->setAlamat($alamat);
        $pdf->SetAutoPageBreak(true,10);
        $pdf->AddPage();
  
        //create report header
        $pdf->Cell(100,5,'Tahun Ajaran        : ' . $tahunajaran->nama,0,0,'L');
        $pdf->Cell(95,5,'Dicetak pada        : ' . $tglcetak,0,1,'R');
        
        $pdf->ln(5);
        //create table header
        $pdf->SetFont('Courier','',12);
        $pdf->Cell($colnum,8,'NO',1,0,'C');
        $pdf->Cell($colsumber,8,'Biaya',1,0,'C');
        $pdf->Cell($colm,8,'Masuk',1,0,'C');
        $pdf->Cell($colk,8,'Keluar',1,0,'C');
        $pdf->ln();
        
        //create content
        $pdf->SetFont('Courier','',10);
        $rownum = 1;
        $yAxis = 65;
        $totm = 0;
        $totk = 0;
        $totmlalu=0;
        $totklalu=0;
        
        //looping transaksi
        foreach($trans as $tr){            
                $pdf->SetFont('Courier','',10);
                $pdf->Cell($colnum,5,$rownum++,1,0,'R');
                $pdf->Cell($colsumber,5,$tr->jenisbiaya,1,0,'L');
                if($tr->arus == 'M'){
                    $pdf->Cell($colm,5, number_format($tr->masuk, 0, ',', '.'),1,0,'R');
                    $pdf->Cell($colk,5,'-',1,0,'R');
                }else{
                    $pdf->Cell($colm,5, '-',1,0,'R');
                    $pdf->Cell($colk,5,number_format($tr->keluar, 0, ',', '.'),1,0,'R');
                }
                $totm += $tr->masuk;
                $totk += $tr->keluar;
                $pdf->ln();
        }
        //looping Mutasi
        $mutkel=0;
        $mutmas=0;
        $cobnow=0;
        foreach($mutasi as $mt){
                if($mt->asal == 'KU'){
                    //mutasi keluar
                    $mutkel +=  $mt->jumlah;
                    $totk +=  $mt->jumlah;
                    $cobnow +=  $mt->jumlah;
                }else{
                    //mutasi masuk
                    $mutmas +=  $mt->jumlah;
                    $totm +=  $mt->jumlah;
                    $cobnow -=  $mt->jumlah;
                }
        }
        //Mutasi Keluar
        $pdf->SetFont('Courier','',10);
        $pdf->Cell($colnum,5,$rownum++,1,0,'R');
        $pdf->Cell($colsumber,5,'Mutasi Kas ke Bank',1,0,'L');
        $pdf->Cell($colm,5,'-',1,0,'R');
        $pdf->Cell($colk,5, number_format($mutkel, 0, ',', '.'),1,1,'R');
        //Mutasi Masuk
        $pdf->SetFont('Courier','',10);
        $pdf->Cell($colnum,5,$rownum++,1,0,'R');
        $pdf->Cell($colsumber,5,'Mutasi Kas dari Bank',1,0,'L');
        $pdf->Cell($colm,5,number_format($mutmas, 0, ',', '.'),1,0,'R');
        $pdf->Cell($colk,5, '-',1,1,'R');
        
        //cetak garis
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        
        //crate sub total
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(($colnum + $colsumber),7,'Sub Total',1,0,'R');
        //$pdf->SetFont('Courier','B',10);
        $pdf->Cell($colm,7,  number_format($totm, 0, ',', '.'),1,0,'R');
        $pdf->Cell($colk,7,  number_format($totk, 0, ',', '.'),1,1,'R');
        
        //cetak garis
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        
        //crate grand total
        $pdf->Cell(($colnum + $colsumber),7,'Total Pendapatan',1,0,'R');
        $pdf->Cell($colk+$colm,7,  number_format($totm-$totk, 0, ',', '.'),1,1,'R');
        
        //Cash On Bank
        $pdf->Cell(($colnum + $colsumber),7,'Cash On Bank',1,0,'R');
        $pdf->Cell($colk+$colm,7,  number_format($cashonbank+$cobnow, 0, ',', '.'),1,1,'R');
        
        //crate saldo lalu
        $pdf->Cell(($colnum + $colsumber),7,'Saldo Lalu',1,0,'R');
        $pdf->Cell($colk+$colm,7,  number_format($pendapatanlalu-$pengeluaranlalu, 0, ',', '.'),1,1,'R');
        
        //cetak garis
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        
        //crate saldo saat ini
        $pdf->Cell(($colnum + $colsumber),7,'Total Saldo',1,0,'R');
        $pdf->Cell($colk+$colm,7,  number_format(($pendapatanlalu-$pengeluaranlalu)+($totm-$totk)+$cashonbank+$cobnow, 0, ',', '.'),1,1,'R');
        
        //cetak garis
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        
        $pdf->Output('RekapKeuanganTahunan_'.date('YmdHis').'.pdf','D');
    }
    
    
    public function get_printtopdfdetil($tahunajaranId,$bulan){
        $this->layout = null;
        $tahunajaran = Tahunajaran::find($tahunajaranId);
        $trans = DB::query("select * from vtransmasuk where date_format(tanggal,'%m-%Y') = '" . $bulan . "'");  
        
        //mutasi dalam bulan tersebut
        $mutasi = DB::query("SELECT * FROM mutasi WHERE tahunajaran_id = " . $tahunajaranId . " AND date_format(tanggal,'%m-%Y') = '" . $bulan ."'" );
        //mutasi keluar sebelum bulan tersebut
        $mutasikeluar = Mutasi::where('asal','=','KU')->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))->sum('jumlah');  //DB::query("select ifnull(sum(jumlah),0) as keluar from mutasi where asal = 'KU' and tanggal < '" . date('Y-m-d',strtotime('01-'.$bulan)) . "'");
        $mutasimasuk = Mutasi::where('asal','=','KB')->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))->sum('jumlah'); //DB::query("select ifnull(sum(jumlah),0) as keluar from mutasi where asal = 'KB' and tanggal < '" . date('Y-m-d',strtotime('01-'.$bulan)) . "'");
        $cashonbank = $mutasikeluar - $mutasimasuk;
        
        //pendapatan sebelum bulan tersebut
        $pendapatanlalu = DB::table('view_transmasuk')
                                ->where('arus','=','M')
                                ->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))
                                ->sum('jumlah');
        $pendapatanlalu += $mutasimasuk;
        //pengeluaran sebelum bulan tersebut
        $pengeluaranlalu = DB::table('view_transmasuk')
                                ->where('arus','=','K')
                                ->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))
                                ->sum('jumlah');
        $pengeluaranlalu += $mutasikeluar;
        
        //get nama bulan indonesia
        $namabulan = date('m',strtotime('01-'.$bulan));
        if($namabulan == '01'){
            $namabulan = 'Januari';
        }else if($namabulan == '02'){
            $namabulan = 'Februari';
        }else if($namabulan == '03'){
            $namabulan = 'Maret';
        }else if($namabulan == '04'){
            $namabulan = 'April';
        }else if($namabulan == '05'){
            $namabulan = 'Mei';
        }else if($namabulan == '06'){
            $namabulan = 'Juni';
        }else if($namabulan == '07'){
            $namabulan = 'Juli';
        }else if($namabulan == '08'){
            $namabulan = 'Agustus';
        }else if($namabulan == '09'){
            $namabulan = 'September';
        }else if($namabulan == '10'){
            $namabulan = 'Oktober';
        }else if($namabulan == '11'){
            $namabulan = 'November';
        }else if($namabulan == '12'){
            $namabulan = 'Desember';
        }
                 
        //set report header setting
        $namasekolah = Setting::first()->nama_skul;
        $alamat = Setting::first()->alamat_skul;
        $namareport = 'Rekapitulasi Keuangan Bulan ' . $namabulan;
        $namareport2 = $tahunajaran->nama;
        $target = Targetpencapaian::where('tahunajaran_id','=',$tahunajaranId)->first();
        
        //pre defined
        $isFirstPage = true;
        $tglcetak = date('d-m-Y [H:i:s]');
        
        //set column with variables
        $colnum = 12;
        $colsumber = 55;
        $colnis = 13;
        $colsiswa = 70;
        $colbulan = 25;
        $colket = 50;
        $colm = 30;
        $colk = 30;
        $coltgl = 25;
        
        //$pdf = new Fpdf('P','mm',array(215,330));
        $pdf = new Sabililhudapdf('L','mm',array(215,330));
        $pdf->setMargins(10,10,10);
        $pdf->AliasNbPages();
        $pdf->setReportTitle($namareport);
        $pdf->setReportSubTitle( $namareport2);
        $pdf->setNamaSekolah($namasekolah);
        $pdf->setAlamat($alamat);
        $pdf->SetAutoPageBreak(true,10);
        $pdf->AddPage();
  
        //create report header
        $pdf->Cell($colnum + $coltgl+ $colsumber + $colnis+$colsiswa+$colbulan+$colket+$colm,5,'Tahun Ajaran  : ' . $tahunajaran->nama,0,0,'L');
        $pdf->Cell($colk,5,'Dicetak pada  : ' . $tglcetak,0,1,'R');
        
        $pdf->ln(5);
        //create table header
        $pdf->SetFont('Courier','',12);
        $pdf->Cell($colnum,8,'NO',1,0,'C');
        $pdf->Cell($coltgl,8,'TANGGAL',1,0,'C');
        $pdf->Cell($colsumber,8,'BIAYA',1,0,'C');
        $pdf->Cell($colnis,8,'NIS',1,0,'C');
        $pdf->Cell($colsiswa,8,'NAMA SISWA',1,0,'C');
        $pdf->Cell($colbulan,8,'BULAN',1,0,'C');
        $pdf->Cell($colket,8,'KETERANGAN',1,0,'C');        
        $pdf->Cell($colm,8,'PENDAPATAN',1,0,'C');
        $pdf->Cell($colk,8,'PENGELUARAN',1,0,'C');
        $pdf->ln();
        
        //create content
        $pdf->SetFont('Courier','',10);
        $rownum = 1;
        $yAxis = 65;
        $totm = 0;
        $totk = 0;
        $totmlalu=0;
        $totklalu=0;
        
        //looping transaksi
        foreach($trans as $tr){    
                if($pdf->getIsNewPage()){
                    //create table header
                    $pdf->SetFont('Courier','',12);
                    $pdf->Cell($colnum,8,'NO',1,0,'C');
                    $pdf->Cell($coltgl,8,'TANGGAL',1,0,'C');
                    $pdf->Cell($colsumber,8,'BIAYA',1,0,'C');
                    $pdf->Cell($colnis,8,'NIS',1,0,'C');
                    $pdf->Cell($colsiswa,8,'NAMA SISWA',1,0,'C');
                    $pdf->Cell($colbulan,8,'BULAN',1,0,'C');
                    $pdf->Cell($colket,8,'KETERANGAN',1,0,'C');        
                    $pdf->Cell($colm,8,'PENDAPATAN',1,0,'C');
                    $pdf->Cell($colk,8,'PENGELUARAN',1,0,'C');
                    $pdf->ln();
                }
            
                $pdf->SetFont('Courier','',10);
                $pdf->Cell($colnum,5,$rownum++,1,0,'R');
                $pdf->Cell($coltgl,5,date('d-m-Y',strtotime($tr->tanggal)),1,0,'L');
                $pdf->Cell($colsumber,5,$tr->jenisbiaya,1,0,'L');
                $pdf->Cell($colnis,5,($tr->nisn ? $tr->nisn : '-'),1,0,'L');
                $pdf->Cell($colsiswa,5,($tr->siswa ? ucwords(strtolower($tr->siswa)) : '-'),1,0,'L');
                $pdf->Cell($colbulan,5,($tr->bulan ? ucwords($tr->bulan) : '-'),1,0,'L');
                $pdf->Cell($colket,5,($tr->ket ? $tr->ket : '-'),1,0,'L');
                if($tr->arus == 'M'){
                    $pdf->Cell($colm,5, number_format($tr->jumlah, 0, ',', '.'),1,0,'R');
                    $pdf->Cell($colk,5,'-',1,0,'R');
                    $totm += $tr->jumlah;
                }else{
                    $pdf->Cell($colm,5, '-',1,0,'R');
                    $pdf->Cell($colk,5,number_format($tr->jumlah, 0, ',', '.'),1,0,'R');
                    $totk += $tr->jumlah;
                }
                $pdf->ln();
        }
        //looping Mutasi
        $mutkel=0;
        $mutmas=0;
        $cobnow=0;
        foreach($mutasi as $mt){
                if($mt->asal == 'KU'){
                    //Mutasi Keluar
                    $pdf->SetFont('Courier','',10);
                    $pdf->Cell($colnum,5,$rownum++,1,0,'R');
                    $pdf->Cell($coltgl,5,date('d-m-Y',strtotime($mt->tanggal)),1,0,'L');
                    $pdf->Cell($colsumber,5,'Mutasi Kas ke Bank',1,0,'L');
                    $pdf->Cell($colnis,5,'-',1,0,'L');
                    $pdf->Cell($colsiswa,5,'-',1,0,'L');
                    $pdf->Cell($colbulan,5,'-',1,0,'L');
                    $pdf->Cell($colket,5,'-',1,0,'L');
                    $pdf->Cell($colm,5,'-',1,0,'R');
                    $pdf->Cell($colk,5, number_format($mt->jumlah, 0, ',', '.'),1,1,'R');
                    //mutasi keluar
                    $mutkel +=  $mt->jumlah;
                    $totk +=  $mt->jumlah;
                    $cobnow +=  $mt->jumlah;
                }else{
                    //Mutasi Masuk
                    $pdf->SetFont('Courier','',10);
                    $pdf->Cell($colnum,5,$rownum++,1,0,'R');
                    $pdf->Cell($coltgl,5,date('d-m-Y',strtotime($mt->tanggal)),1,0,'L');
                    $pdf->Cell($colsumber,5,'Mutasi Kas dari Bank',1,0,'L');
                    $pdf->Cell($colnis,5,'-',1,0,'L');
                    $pdf->Cell($colsiswa,5,'-',1,0,'L');
                    $pdf->Cell($colbulan,5,'-',1,0,'L');
                    $pdf->Cell($colket,5,'-',1,0,'L');
                    $pdf->Cell($colm,5,number_format($mt->jumlah, 0, ',', '.'),1,0,'R');
                    $pdf->Cell($colk,5, '-',1,1,'R');
                    //mutasi masuk
                    $mutmas +=  $mt->jumlah;
                    $totm +=  $mt->jumlah;
                    $cobnow -=  $mt->jumlah;
                }
        }
        //cetak garis
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        
        //crate sub total
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(($colnum + $coltgl+ $colsumber + $colnis+$colsiswa+$colbulan+$colket),7,'Sub Total',1,0,'R');
        //$pdf->SetFont('Courier','B',10);
        $pdf->Cell($colm,7,  number_format($totm, 0, ',', '.'),1,0,'R');
        $pdf->Cell($colk,7,  number_format($totk, 0, ',', '.'),1,1,'R');
        
        //cetak garis
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        
        //crate grand total
        $pdf->Cell(($colnum + $coltgl+ $colsumber + $colnis+$colsiswa+$colbulan+$colket),7,'Total Pendapatan',1,0,'R');
        $pdf->Cell($colk+$colm,7,  number_format($totm-$totk, 0, ',', '.'),1,1,'R');
        
        //Cash On Bank
        $pdf->Cell(($colnum + $coltgl+ $colsumber + $colnis+$colsiswa+$colbulan+$colket),7,'Cash On Bank',1,0,'R');
        $pdf->Cell($colk+$colm,7,  number_format($cashonbank+$cobnow, 0, ',', '.'),1,1,'R');
        
        //crate saldo lalu
        $pdf->Cell(($colnum + $coltgl+ $colsumber + $colnis+$colsiswa+$colbulan+$colket),7,'Saldo Lalu',1,0,'R');
        $pdf->Cell($colk+$colm,7,  number_format($pendapatanlalu-$pengeluaranlalu, 0, ',', '.'),1,1,'R');
        
        //cetak garis
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        
        //crate saldo saat ini
        $pdf->Cell(($colnum + $coltgl+ $colsumber + $colnis+$colsiswa+$colbulan+$colket),7,'Total Saldo',1,0,'R');
        $pdf->Cell($colk+$colm,7,  number_format(($pendapatanlalu-$pengeluaranlalu)+($totm-$totk)+$cashonbank+$cobnow, 0, ',', '.'),1,1,'R');
        
        //cetak garis
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        
        $pdf->Output('RekapKeuanganTahunan_'.date('YmdHis').'.pdf','D');
    }
      
    
    public function get_ajaxtabel($tahunajaranId,$bulan){
        $tahunajaran = Tahunajaran::find($tahunajaranId);
        $trans = DB::query("select tahunajaran,tahunajaran_id,jenisbiaya,jenisbiaya_id,arus, 
            case when arus = 'M' then sum(jumlah) else 0 end as masuk,
            case when arus = 'K' then sum(jumlah) else 0 end as keluar,
            posisi_tahunajaran
            from vtransmasuk 
            where date_format(tanggal,'%m-%Y') = '" . $bulan . "' 
            group by jenisbiaya_id");        
        
        //mutasi dalam bulan tersebut
        $mutasi = DB::query("SELECT * FROM mutasi WHERE tahunajaran_id = " . $tahunajaranId . " AND date_format(tanggal,'%m-%Y') = '" . $bulan ."'" );
        //mutasi keluar sebelum bulan tersebut
        $mutasikeluar = Mutasi::where('asal','=','KU')->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))->sum('jumlah');  //DB::query("select ifnull(sum(jumlah),0) as keluar from mutasi where asal = 'KU' and tanggal < '" . date('Y-m-d',strtotime('01-'.$bulan)) . "'");
        $mutasimasuk = Mutasi::where('asal','=','KB')->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))->sum('jumlah'); //DB::query("select ifnull(sum(jumlah),0) as keluar from mutasi where asal = 'KB' and tanggal < '" . date('Y-m-d',strtotime('01-'.$bulan)) . "'");
        $cashonbank = $mutasikeluar - $mutasimasuk;
        
        //pendapatan sebelum bulan tersebut
        $pendapatanlalu = DB::table('view_transmasuk')
                                ->where('arus','=','M')
                                ->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))
                                ->sum('jumlah');
        $pendapatanlalu += $mutasimasuk;
        //pengeluaran sebelum bulan tersebut
        $pengeluaranlalu = DB::table('view_transmasuk')
                                ->where('arus','=','K')
                                ->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))
                                ->sum('jumlah');
        $pengeluaranlalu += $mutasikeluar;
        
        return View::make('rekap.bulanan.ajaxtabel')
                ->with('trans',$trans)
                ->with('mutasi',$mutasi)
                ->with('cashonbank',$cashonbank)
                ->with('pendapatanlalu',$pendapatanlalu)
                ->with('pengeluaranlalu',$pengeluaranlalu);
    }
    
    public function get_ajaxtabeldetil($tahunajaranId,$bulan){
        $tahunajaran = Tahunajaran::find($tahunajaranId);
        $trans = DB::query("select * from vtransmasuk where date_format(tanggal,'%m-%Y') = '" . $bulan . "'");  
        
        //mutasi dalam bulan tersebut
        $mutasi = DB::query("SELECT * FROM mutasi WHERE tahunajaran_id = " . $tahunajaranId . " AND date_format(tanggal,'%m-%Y') = '" . $bulan ."'" );
        //mutasi keluar sebelum bulan tersebut
        $mutasikeluar = Mutasi::where('asal','=','KU')->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))->sum('jumlah');  //DB::query("select ifnull(sum(jumlah),0) as keluar from mutasi where asal = 'KU' and tanggal < '" . date('Y-m-d',strtotime('01-'.$bulan)) . "'");
        $mutasimasuk = Mutasi::where('asal','=','KB')->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))->sum('jumlah'); //DB::query("select ifnull(sum(jumlah),0) as keluar from mutasi where asal = 'KB' and tanggal < '" . date('Y-m-d',strtotime('01-'.$bulan)) . "'");
        $cashonbank = $mutasikeluar - $mutasimasuk;
        
        //pendapatan sebelum bulan tersebut
        $pendapatanlalu = DB::table('view_transmasuk')
                                ->where('arus','=','M')
                                ->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))
                                ->sum('jumlah');
        $pendapatanlalu += $mutasimasuk;
        //pengeluaran sebelum bulan tersebut
        $pengeluaranlalu = DB::table('view_transmasuk')
                                ->where('arus','=','K')
                                ->where('tanggal','<',date('Y-m-d',strtotime('01-'.$bulan)))
                                ->sum('jumlah');
        $pengeluaranlalu += $mutasikeluar;
        
        return View::make('rekap.bulanan.ajaxtabeldetil')
                ->with('trans',$trans)
                ->with('mutasi',$mutasi)
                ->with('cashonbank',$cashonbank)
                ->with('pendapatanlalu',$pendapatanlalu)
                ->with('pengeluaranlalu',$pengeluaranlalu);
    }
    
    
}
