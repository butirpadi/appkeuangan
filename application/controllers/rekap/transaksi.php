<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of transaksi
 *
 * @author root
 */
class Rekap_Transaksi_Controller extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_rekapitulasi_transaksi');
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
        
        $biayas = Jenisbiaya::all();
        $biayaselect = array();
        foreach($biayas as $biaya){
            $biayaselect[$biaya->id] = $biaya->nama;
        }
        
        $this->layout->nest('content', 'rekap.transaksi.index',array(
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif,
            'tahunajaranselect'=>$tahunajaranselect,
            'biayaselect'=>$biayaselect
        ));
    }
    
    public function get_ajaxtabelrekap($tahunajaranid,$awal,$akhir){
        $trans = Vtransmasuk::where('tahunajaran_id','=',$tahunajaranid)
                ->where('tanggal','>=',date('Y-m-d',strtotime($awal)))
                ->where('tanggal','<=',date('Y-m-d',strtotime($akhir)))
                    ->get();
        
        $mutasi = Mutasi::where('tanggal','>=',date('Y-m-d',strtotime($awal)))
                ->where('tanggal','<=',date('Y-m-d',strtotime($akhir)))
                ->get();
        
        //return View::make('rekap.transaksi.ajaxtabelrekap')->with('trans',$trans);
        return View::make('rekap.transaksi.ajaxrekapdetil')
                ->with('trans',$trans)
                ->with('mutasi',$mutasi);
    }
    
    public function get_ajaxrekap($tahunajaranId,$awal,$akhir){
        $trans = DB::query("select vt.tahunajaran_id,vt.tahunajaran,vt.arus,vt.jenisbiaya_id,
            vt.jenisbiaya,sum(vt.jumlah) as jumlah
            from view_transmasuk vt
            where vt.tahunajaran_id = " . $tahunajaranId . "
            and tanggal between '" . date('Y-m-d',strtotime($awal)) . "' and '" . date('Y-m-d',strtotime($akhir)) . "'
            group by vt.jenisbiaya_id");
        
        $mutasi = Mutasi::where('tanggal','>=',date('Y-m-d',strtotime($awal)))
                ->where('tanggal','<=',date('Y-m-d',strtotime($akhir)))
                ->get();
        
        return View::make('rekap.transaksi.ajaxrekap')
                ->with('trans',$trans)
                ->with('mutasi',$mutasi);
    }
    
    public function get_printrekap($tahunajaranId,$awal,$akhir){
        $this->layout = null;
        
        $tahunajaran = Tahunajaran::find($tahunajaranId);
        
        $trans =  $trans = DB::query("select vt.tahunajaran_id,vt.tahunajaran,vt.arus,vt.jenisbiaya_id,
            vt.jenisbiaya,sum(vt.jumlah) as jumlah
            from view_transmasuk vt
            where vt.tahunajaran_id = " . $tahunajaranId . "
            and tanggal between '" . date('Y-m-d',strtotime($awal)) . "' and '" . date('Y-m-d',strtotime($akhir)) . "'
            group by vt.jenisbiaya_id");
        //set report header setting
        $namasekolah = Setting::first()->nama_skul;
        $alamat = Setting::first()->alamat_skul;
        
        if($akhir==$awal){
            $namareport = 'Rekapitulasi Transaksi per Tanggal ' . date('d-m-Y',strtotime($awal));       
        }else{
            $namareport = 'Rekapitulasi Transaksi per Tanggal (' . date('d-m-Y',strtotime($awal)) . ') - (' . date('d-m-Y',strtotime($akhir)) . ')';       
        }
        
        //pre defined
        $isFirstPage = true;
        $tglcetak = date('d-m-Y [H:i:s]');
        
        //set column with variables
        $colnum = 15;
        $colsumber = 100;
        $colm = 40;
        $colk = 40;
        
        $pdf = new Fpdf('P','mm',array(215,330));
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();
        
        //create page header
        $pdf->SetFont('Courier','B',14);
        $pdf->Cell(0,8,$namareport,0,1,'C');
        $pdf->SetFont('Courier','',12);
        $pdf->Cell(0,5,$namasekolah,0,1,'C');
        $pdf->SetFont('Courier','',10);
        $pdf->Cell(0,5,$alamat,0,1,'C');
        $pdf->Cell(0,2,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,1,'','B',1);
        $pdf->ln(5);
        //create report header
        $pdf->Cell($colnum+$colsumber,5,'Tahun Ajaran        : ' . $tahunajaran->nama,0,0,'L');
        $pdf->Cell($colm+$colk,5,'Dicetak pada        : ' . $tglcetak,0,1,'R');
        $pdf->ln(5);
        //create table header
        $pdf->SetFont('Courier','B',11);
        $pdf->Cell($colnum,10,'NO',1,0,'C');
        $pdf->Cell($colsumber,10,'Sumber Dana',1,0,'C');
        $pdf->Cell($colm,10,'Pendapatan (Rp)',1,0,'C');
        $pdf->Cell($colk,10,'Pengeluaran (Rp)',1,0,'C');   
        $pdf->ln();
        
        //create content
        $rownum = 1;
        $yAxis = 65;
        $totm = 0;
        $totk = 0;
        
        
        foreach($trans as $tr){
            $pdf->SetFont('Courier','',9);
            
            $pdf->Cell($colnum,7,$rownum++,1,0,'R');
            $pdf->Cell($colsumber,7,$tr->jenisbiaya ,1,0,'L');
            $pdf->Cell($colm,7,($tr->arus == 'M' ? number_format($tr->jumlah, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colk,7,($tr->arus == 'K' ? number_format($tr->jumlah, 0, ',', '.') : '-'),1,0,'R');
            $pdf->ln();
            
            //set total pengeluaran dan pendapatan
            if($tr->arus == 'M'){
                $totm += $tr->jumlah;
            }else if($tr->arus == 'K'){
                $totk += $tr->jumlah;
            }            
            
            //new page setting
            $yAxis += 10;
            if($isFirstPage){
                $batasAkhirAxis = 265;
            }else{
                $batasAkhirAxis = 310;
            }
            if ($yAxis> $batasAkhirAxis){
                //add new page
                $pdf->AddPage();
                //sub header
                $pdf->SetFont('Courier','',10);
                $pdf->Cell($colnum+$colsumber+$colm,10,$namareport . '  (' . $tglcetak . ') ',0,0,'L'); //page number
                $pdf->Cell($colk,10,'Page ' . $pdf->PageNo(),0,1,'R'); //page number
                //create page header
                $pdf->SetFont('Courier','',12);
                $pdf->Cell($colnum,14,'NO',1,0,'C');
                $pdf->Cell($colsumber,14,'Sumber Dana',1,0,'C');
                //$pdf->Cell($coltgl,7,'Tanggal','T',0,'C');
                $pdf->Cell($colm,14,'Pendapatan (Rp)',1,0,'C');
                $pdf->Cell($colk,14,'Pengeluaran (Rp)',1,0,'C');
                $pdf->Cell($colnum,7,'',0,1,'C');//wrapper right
                $pdf->Cell($colnum,7,'',0,0,'C');//wrapper
                $pdf->Cell($colsumber,7,'',0,0,'C');//wrapper
//                $pdf->SetFont('Courier','',10);
//                $pdf->Cell($coltgl,7,'(tgl-bln-thn)','B',0,'C');
                $pdf->ln();
                
                $yAxis = 65;
                $isFirstPage = false;
            }
        }
        
        //crate grand total
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell($colnum+$colsumber,10,  'TOTAL',1,0,'R');
        $pdf->Cell($colm,10,  number_format($totm, 0, ',', '.'),1,0,'R');
        $pdf->Cell($colk,10,  number_format($totk, 0, ',', '.'),1,1,'R');
                
        $pdf->Output('RekapTransaksiHarian_'.date('YmdHis').'.pdf','D');
    }
    
    public function get_ajaxtabelrekapfilterarus($tahunajaranid,$awal,$akhir,$arus){
         $trans = Vtransmasuk::where('tahunajaran_id','=',$tahunajaranid)
                ->where('tanggal','>=',date('Y-m-d',strtotime($awal)))
                ->where('tanggal','<=',date('Y-m-d',strtotime($akhir)))
                ->where('arus','=',$arus)
                    ->get();
        
         //return View::make('rekap.transaksi.ajaxtabelrekap')->with('trans',$trans);
         return View::make('rekap.transaksi.ajaxrekapdetil')->with('trans',$trans);
    }
    
    
    public function get_ajaxtabelrekapfilterbiaya($tahunajaranid,$awal,$akhir,$biaya){
         $trans = Vtransmasuk::where('tahunajaran_id','=',$tahunajaranid)
                ->where('tanggal','>=',date('Y-m-d',strtotime($awal)))
                ->where('tanggal','<=',date('Y-m-d',strtotime($akhir)))
                ->where('jenisbiaya_id','=',$biaya)
                    ->get();
         
        //return View::make('rekap.transaksi.ajaxtabelrekap')->with('trans',$trans);
        return View::make('rekap.transaksi.ajaxrekapdetil')->with('trans',$trans);
    }
    
    public function get_printtopdf($tahunajaranid,$awal,$akhir){
        $this->layout = null;
        
        $tahunajaran = Tahunajaran::find($tahunajaranid);
        
        $trans = Vtransmasuk::where('tahunajaran_id','=',$tahunajaranid)
                ->where('tanggal','>=',date('Y-m-d',strtotime($awal)))
                ->where('tanggal','<=',date('Y-m-d',strtotime($akhir)))
                    ->get();
        //set report header setting
        $namasekolah = Setting::first()->nama_skul;
        $alamat = Setting::first()->alamat_skul;
        
        if($akhir==$awal){
            $namareport = 'Rekapitulasi Transaksi per Tanggal ' . date('d-m-Y',strtotime($awal));       
        }else{
            $namareport = 'Rekapitulasi Transaksi per Tanggal (' . date('d-m-Y',strtotime($awal)) . ') - (' . date('d-m-Y',strtotime($akhir)) . ')';       
        }
        
        //pre defined
        $isFirstPage = true;
        $tglcetak = date('d-m-Y [H:i:s]');
        
        //set column with variables
        $colnum = 15;
        $colsumber = 40;
        $colnis = 15;
        $colsiswa = 70;
        $colbulan= 25;
        $colket = 50;
        $colm = 35;
        $colk = 35;
        $coltgl = 25;
        
        $pdf = new Fpdf('L','mm',array(215,330));
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();
        
        //create page header
        $pdf->SetFont('Courier','B',16);
        $pdf->Cell(0,8,$namareport,0,1,'C');
        $pdf->SetFont('Courier','',12);
        $pdf->Cell(0,5,$namasekolah,0,1,'C');
        $pdf->SetFont('Courier','',10);
        $pdf->Cell(0,5,$alamat,0,1,'C');
        $pdf->Cell(0,2,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,1,'','B',1);
        $pdf->ln(5);
        //create report header
        $pdf->Cell(155,5,'Tahun Ajaran        : ' . $tahunajaran->nama,0,0,'L');
        $pdf->Cell(155,5,'Dicetak pada        : ' . $tglcetak,0,1,'R');
        $pdf->ln(5);
        //create table header
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell($colnum,10,'NO',1,0,'C');
        $pdf->Cell($colsumber,10,'Sumber Dana',1,0,'C');
        $pdf->Cell($colnis,10,'NIS',1,0,'C');
        $pdf->Cell($colsiswa,10,'Siswa',1,0,'C');
        $pdf->Cell($colbulan,10,'Bulan',1,0,'C');
        $pdf->Cell($colket,10,'Keterangan',1,0,'C');
        $pdf->Cell($coltgl,10,'Tanggal','T',0,'C');
        $pdf->Cell($colm,10,'Masuk (Rp)',1,0,'C');
        $pdf->Cell($colk,10,'Keluar (Rp)',1,0,'C');        
        $pdf->ln();
        
        //create content
        $pdf->SetFont('Courier','',10);
        $rownum = 1;
        $yAxis = 65;
        $totm = 0;
        $totk = 0;
        
        
        foreach($trans as $tr){
            $pdf->SetFont('Courier','',10);
            
            $pdf->Cell($colnum,7,$rownum++,1,0,'R'); //ROWNUM
            $pdf->Cell($colsumber,7,substr($tr->jenisbiaya,0,15),1,0,'L');
            $pdf->Cell($colnis,7,($tr->nisn ? $tr->nisn : '-'),1,0,'L');
            $pdf->Cell($colsiswa,7,substr(($tr->siswa ? $tr->siswa : '-') ,0,30),1,0,'L');
            
            if($tr->tipe == 'ITB'){
                $pdf->Cell($colbulan,7,substr(ucwords($tr->bulan),0,30),1,0,'L');
            }else{
                $pdf->Cell($colbulan,7,substr('-',0,30),1,0,'L');
            }
            if($tr->tipe == 'ITB'){
                $pdf->SetFont('Courier','',8);
                //jika ada potongan
                $tahun = Tahunajaran::find($tr->tahunajaran_id);
                $pot="";
                foreach($tahun->potonganiuran()->where('siswa_id','=',$tr->siswa_id)->where('bulan_id','=',$tr->bulan_id)->get() as $sis){
                     //$pot = 'Potongan ' . ($sis->pivot->jenis == 'BS' ? 'Beasiswa Prestasi' : 'Bantuan Pendidikan') . ' : Rp. ' . number_format($sis->pivot->nilai, 0, ',', '.') . '' ;
                     $pot = 'Pot. ' . ($sis->pivot->jenis == 'BS' ? 'B Pres.' : 'B. Pend.') . ' : ' . number_format($sis->pivot->nilai, 0, ',', '.');
                     //$pot = 'Pot. ' . number_format($sis->pivot->nilai, 0, ',', '.')  ;
                }
                $pdf->Cell($colket,7,$pot,1,0,'L');
            }else{
                $pdf->Cell($colket,7,$tr->ket,1,0,'L');
            }
            $pdf->SetFont('Courier','',10);
            $pdf->Cell($coltgl,7,date('d-m-Y',strtotime($tr->tanggal)),1,0,'L');
            $pdf->Cell($colm,7,($tr->arus == 'M' ? number_format($tr->jumlah, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colk,7,($tr->arus == 'K' ? number_format($tr->jumlah, 0, ',', '.') : '-'),1,0,'R');
            $pdf->ln();
            
            //set total pengeluaran dan pendapatan
            if($tr->arus == 'M'){
                $totm += $tr->jumlah;
            }else if($tr->arus == 'K'){
                $totk += $tr->jumlah;
            }            
            
            //new page setting
            $yAxis += 10;
            if($isFirstPage){
                $batasAkhirAxis = 265;
            }else{
                $batasAkhirAxis = 310;
            }
            if ($yAxis> $batasAkhirAxis){
                //add new page
                $pdf->AddPage();
                //sub header
                $pdf->SetFont('Courier','',10);
                $pdf->Cell($colnum+$colsumber+$colnis+$colsiswa+$colbulan+$colket+$coltgl+$colm,10,$namareport . '  (' . $tglcetak . ') ',0,0,'L'); //page number
                $pdf->Cell($colk,10,'Page ' . $pdf->PageNo(),0,1,'R'); //page number
                //create page header
                $pdf->SetFont('Courier','B',12);
                $pdf->Cell($colnum,10,'NO',1,0,'C');
                $pdf->Cell($colsumber,10,'Sumber Dana',1,0,'C');
                $pdf->Cell($colnis,10,'NIS',1,0,'C');
                $pdf->Cell($colsiswa,10,'Siswa',1,0,'C');
                $pdf->Cell($colbulan,10,'Bulan',1,0,'C');
                $pdf->Cell($colket,10,'Keterangan',1,0,'C');
                $pdf->Cell($coltgl,10,'Tanggal','T',0,'C');
                $pdf->Cell($colm,10,'Masuk (Rp)',1,0,'C');
                $pdf->Cell($colk,10,'Keluar (Rp)',1,0,'C'); 
                $pdf->ln();
                
                $yAxis = 65;
                $isFirstPage = false;
            }
        }
        
        //crate TOTAL
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell(($colnum+$colsumber+$colnis+$colsiswa+$colbulan+$colket+$coltgl),10,'Total',1,0,'C');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell($colm,10,  number_format($totm, 0, ',', '.'),1,0,'R');
        $pdf->Cell($colk,10,  number_format($totk, 0, ',', '.'),1,1,'R');
        //crate TOTAL
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell(($colnum+$colsumber+$colnis+$colsiswa+$colbulan+$colket+$coltgl),10,'Grand Total',1,0,'C');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell($colm+$colk,10,  number_format($totm-$totk, 0, ',', '.'),1,0,'R');
        
                
        $pdf->Output('RekapTransaksiHarian_'.date('YmdHis').'.pdf','D');
    }
    
    
    public function get_printtopdffilterarus($tahunajaranid,$awal,$akhir,$arus){
        $this->layout = null;
        
        $tahunajaran = Tahunajaran::find($tahunajaranid);
        
        $trans = Vtransmasuk::where('tahunajaran_id','=',$tahunajaranid)
                ->where('tanggal','>=',date('Y-m-d',strtotime($awal)))
                ->where('tanggal','<=',date('Y-m-d',strtotime($akhir)))
                ->where('arus','=',$arus)
                    ->get();
        
        //set report header setting
        $namasekolah = Setting::first()->nama_skul;
        $alamat = Setting::first()->alamat_skul;
        
        if($akhir==$awal){
            $namareport = 'Rekapitulasi Transaksi per Tanggal ' . date('d-m-Y',strtotime($awal));       
        }else{
            $namareport = 'Rekapitulasi Transaksi per Tanggal (' . date('d-m-Y',strtotime($awal)) . ') - (' . date('d-m-Y',strtotime($akhir)) . ')';       
        }
        
        //pre defined
        $isFirstPage = true;
        $tglcetak = date('d-m-Y [H:i:s]');
        
        //set column with variables
        $colnum = 15;
        $colsumber = 40;
        $colnis = 15;
        $colsiswa = 70;
        $colbulan= 25;
        $colket = 50;
        $colm = 35;
        $colk = 35;
        $coltgl = 25;
        
        $pdf = new Fpdf('L','mm',array(215,330));
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();
        
        //create page header
        $pdf->SetFont('Courier','B',16);
        $pdf->Cell(0,8,$namareport,0,1,'C');
        $pdf->SetFont('Courier','',12);
        $pdf->Cell(0,5,$namasekolah,0,1,'C');
        $pdf->SetFont('Courier','',10);
        $pdf->Cell(0,5,$alamat,0,1,'C');
        $pdf->Cell(0,2,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,1,'','B',1);
        $pdf->ln(5);
        //create report header
        $pdf->Cell(155,5,'Tahun Ajaran        : ' . $tahunajaran->nama,0,0,'L');
        $pdf->Cell(155,5,'Dicetak pada        : ' . $tglcetak,0,1,'R');
        $pdf->ln(5);
        //create table header
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell($colnum,10,'NO',1,0,'C');
        $pdf->Cell($colsumber,10,'Sumber Dana',1,0,'C');
        $pdf->Cell($colnis,10,'NIS',1,0,'C');
        $pdf->Cell($colsiswa,10,'Siswa',1,0,'C');
        $pdf->Cell($colbulan,10,'Bulan',1,0,'C');
        $pdf->Cell($colket,10,'Keterangan',1,0,'C');
        $pdf->Cell($coltgl,10,'Tanggal','T',0,'C');
        $pdf->Cell($colm,10,'Masuk (Rp)',1,0,'C');
        $pdf->Cell($colk,10,'Keluar (Rp)',1,0,'C');        
        $pdf->ln();
        
        //create content
        $pdf->SetFont('Courier','',10);
        $rownum = 1;
        $yAxis = 65;
        $totm = 0;
        $totk = 0;
        
        
        foreach($trans as $tr){
            $pdf->SetFont('Courier','',10);
            
            $pdf->Cell($colnum,7,$rownum++,1,0,'R'); //ROWNUM
            $pdf->Cell($colsumber,7,substr($tr->jenisbiaya,0,15),1,0,'L');
            $pdf->Cell($colnis,7,($tr->nisn ? $tr->nisn : '-'),1,0,'L');
            $pdf->Cell($colsiswa,7,substr(($tr->siswa ? $tr->siswa : '-') ,0,30),1,0,'L');
            
            if($tr->tipe == 'ITB'){
                $pdf->Cell($colbulan,7,substr(ucwords($tr->bulan),0,30),1,0,'L');
            }else{
                $pdf->Cell($colbulan,7,substr('-',0,30),1,0,'L');
            }
            if($tr->tipe == 'ITB'){
                $pdf->SetFont('Courier','',8);
                //jika ada potongan
                $tahun = Tahunajaran::find($tr->tahunajaran_id);
                $pot="";
                foreach($tahun->potonganiuran()->where('siswa_id','=',$tr->siswa_id)->where('bulan_id','=',$tr->bulan_id)->get() as $sis){
                     //$pot = 'Potongan ' . ($sis->pivot->jenis == 'BS' ? 'Beasiswa Prestasi' : 'Bantuan Pendidikan') . ' : Rp. ' . number_format($sis->pivot->nilai, 0, ',', '.') . '' ;
                     $pot = 'Pot. ' . ($sis->pivot->jenis == 'BS' ? 'B Pres.' : 'B. Pend.') . ' : ' . number_format($sis->pivot->nilai, 0, ',', '.');
                     //$pot = 'Pot. ' . number_format($sis->pivot->nilai, 0, ',', '.')  ;
                }
                $pdf->Cell($colket,7,$pot,1,0,'L');
            }else{
                $pdf->Cell($colket,7,$tr->ket,1,0,'L');
            }
            $pdf->SetFont('Courier','',10);
            $pdf->Cell($coltgl,7,date('d-m-Y',strtotime($tr->tanggal)),1,0,'L');
            $pdf->Cell($colm,7,($tr->arus == 'M' ? number_format($tr->jumlah, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colk,7,($tr->arus == 'K' ? number_format($tr->jumlah, 0, ',', '.') : '-'),1,0,'R');
            $pdf->ln();
            
            //set total pengeluaran dan pendapatan
            if($tr->arus == 'M'){
                $totm += $tr->jumlah;
            }else if($tr->arus == 'K'){
                $totk += $tr->jumlah;
            }            
            
            //new page setting
            $yAxis += 10;
            if($isFirstPage){
                $batasAkhirAxis = 265;
            }else{
                $batasAkhirAxis = 310;
            }
            if ($yAxis> $batasAkhirAxis){
                //add new page
                $pdf->AddPage();
                //sub header
                $pdf->SetFont('Courier','',10);
                $pdf->Cell($colnum+$colsumber+$colnis+$colsiswa+$colbulan+$colket+$coltgl+$colm,10,$namareport . '  (' . $tglcetak . ') ',0,0,'L'); //page number
                $pdf->Cell($colk,10,'Page ' . $pdf->PageNo(),0,1,'R'); //page number
                //create page header
                $pdf->SetFont('Courier','B',12);
                $pdf->Cell($colnum,10,'NO',1,0,'C');
                $pdf->Cell($colsumber,10,'Sumber Dana',1,0,'C');
                $pdf->Cell($colnis,10,'NIS',1,0,'C');
                $pdf->Cell($colsiswa,10,'Siswa',1,0,'C');
                $pdf->Cell($colbulan,10,'Bulan',1,0,'C');
                $pdf->Cell($colket,10,'Keterangan',1,0,'C');
                $pdf->Cell($coltgl,10,'Tanggal','T',0,'C');
                $pdf->Cell($colm,10,'Masuk (Rp)',1,0,'C');
                $pdf->Cell($colk,10,'Keluar (Rp)',1,0,'C'); 
                $pdf->ln();
                
                $yAxis = 65;
                $isFirstPage = false;
            }
        }
        
        //crate grand total
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell(($colnum+$colsumber+$colnis+$colsiswa+$colbulan+$colket+$coltgl),10,'Total',1,0,'C');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell($colm,10,  number_format($totm, 0, ',', '.'),1,0,'R');
        $pdf->Cell($colk,10,  number_format($totk, 0, ',', '.'),1,1,'R');
                
        if($arus == 'M'){
            $pdf->Output('RekapPenerimaanHarian_'.date('YmdHis').'.pdf','D');
        }else{
            $pdf->Output('RekapPengeluaranHarian_'.date('YmdHis').'.pdf','D');
        }
    }
    
    
    public function get_printtopdffilterbiaya($tahunajaranid,$awal,$akhir,$biaya){
        $this->layout = null;

        $tahunajaran = Tahunajaran::find($tahunajaranid);
        $jbiaya = Jenisbiaya::find($biaya);
        
        $trans = Vtransmasuk::where('tahunajaran_id','=',$tahunajaranid)
                ->where('tanggal','>=',date('Y-m-d',strtotime($awal)))
                ->where('tanggal','<=',date('Y-m-d',strtotime($akhir)))
                ->where('jenisbiaya_id','=',$biaya)
                    ->get();
        
              
        //set report header setting
        $namasekolah = Setting::first()->nama_skul;
        $alamat = Setting::first()->alamat_skul;
        
        if($akhir==$awal){
            $namareport = 'Rekapitulasi Transaksi per Tanggal ' . date('d-m-Y',strtotime($awal));       
        }else{
            $namareport = 'Rekapitulasi Transaksi per Tanggal (' . date('d-m-Y',strtotime($awal)) . ') - (' . date('d-m-Y',strtotime($akhir)) . ')';       
        }
        
        //pre defined
        $isFirstPage = true;
        $tglcetak = date('d-m-Y [H:i:s]');
        
        //set column with variables
        $colnum = 15;
        $colsumber = 40;
        $colnis = 15;
        $colsiswa = 70;
        $colbulan= 25;
        $colket = 50;
        $colm = 35;
        $colk = 35;
        $coltgl = 25;
        
        $pdf = new Fpdf('L','mm',array(215,330));
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();
        
        //create page header
        $pdf->SetFont('Courier','B',16);
        $pdf->Cell(0,8,$namareport,0,1,'C');
        $pdf->SetFont('Courier','',12);
        $pdf->Cell(0,5,$namasekolah,0,1,'C');
        $pdf->SetFont('Courier','',10);
        $pdf->Cell(0,5,$alamat,0,1,'C');
        $pdf->Cell(0,2,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,1,'','B',1);
        $pdf->ln(5);
        //create report header
        $pdf->Cell(155,5,'Tahun Ajaran        : ' . $tahunajaran->nama,0,0,'L');
        $pdf->Cell(155,5,'Dicetak pada        : ' . $tglcetak,0,1,'R');
        $pdf->ln(5);
        //create table header
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell($colnum,10,'NO',1,0,'C');
        $pdf->Cell($colsumber,10,'Sumber Dana',1,0,'C');
        $pdf->Cell($colnis,10,'NIS',1,0,'C');
        $pdf->Cell($colsiswa,10,'Siswa',1,0,'C');
        $pdf->Cell($colbulan,10,'Bulan',1,0,'C');
        $pdf->Cell($colket,10,'Keterangan',1,0,'C');
        $pdf->Cell($coltgl,10,'Tanggal','T',0,'C');
        $pdf->Cell($colm,10,'Masuk (Rp)',1,0,'C');
        $pdf->Cell($colk,10,'Keluar (Rp)',1,0,'C');        
        $pdf->ln();
        
        //create content
        $pdf->SetFont('Courier','',10);
        $rownum = 1;
        $yAxis = 65;
        $totm = 0;
        $totk = 0;
        
        
        foreach($trans as $tr){
            $pdf->SetFont('Courier','',10);
            
            $pdf->Cell($colnum,7,$rownum++,1,0,'R'); //ROWNUM
            $pdf->Cell($colsumber,7,substr($tr->jenisbiaya,0,15),1,0,'L');
            $pdf->Cell($colnis,7,($tr->nisn ? $tr->nisn : '-'),1,0,'L');
            $pdf->Cell($colsiswa,7,substr(($tr->siswa ? $tr->siswa : '-') ,0,30),1,0,'L');
            
            if($tr->tipe == 'ITB'){
                $pdf->Cell($colbulan,7,substr(ucwords($tr->bulan),0,30),1,0,'L');
            }else{
                $pdf->Cell($colbulan,7,substr('-',0,30),1,0,'L');
            }
            if($tr->tipe == 'ITB'){
                $pdf->SetFont('Courier','',8);
                //jika ada potongan
                $tahun = Tahunajaran::find($tr->tahunajaran_id);
                $pot="";
                foreach($tahun->potonganiuran()->where('siswa_id','=',$tr->siswa_id)->where('bulan_id','=',$tr->bulan_id)->get() as $sis){
                     //$pot = 'Potongan ' . ($sis->pivot->jenis == 'BS' ? 'Beasiswa Prestasi' : 'Bantuan Pendidikan') . ' : Rp. ' . number_format($sis->pivot->nilai, 0, ',', '.') . '' ;
                     $pot = 'Pot. ' . ($sis->pivot->jenis == 'BS' ? 'B Pres.' : 'B. Pend.') . ' : ' . number_format($sis->pivot->nilai, 0, ',', '.');
                     //$pot = 'Pot. ' . number_format($sis->pivot->nilai, 0, ',', '.')  ;
                }
                $pdf->Cell($colket,7,$pot,1,0,'L');
            }else{
                $pdf->Cell($colket,7,$tr->ket,1,0,'L');
            }
            $pdf->SetFont('Courier','',10);
            $pdf->Cell($coltgl,7,date('d-m-Y',strtotime($tr->tanggal)),1,0,'L');
            $pdf->Cell($colm,7,($tr->arus == 'M' ? number_format($tr->jumlah, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colk,7,($tr->arus == 'K' ? number_format($tr->jumlah, 0, ',', '.') : '-'),1,0,'R');
            $pdf->ln();
            
            //set total pengeluaran dan pendapatan
            if($tr->arus == 'M'){
                $totm += $tr->jumlah;
            }else if($tr->arus == 'K'){
                $totk += $tr->jumlah;
            }            
            
            //new page setting
            $yAxis += 10;
            if($isFirstPage){
                $batasAkhirAxis = 265;
            }else{
                $batasAkhirAxis = 310;
            }
            if ($yAxis> $batasAkhirAxis){
                //add new page
                $pdf->AddPage();
                //sub header
                $pdf->SetFont('Courier','',10);
                $pdf->Cell($colnum+$colsumber+$colnis+$colsiswa+$colbulan+$colket+$coltgl+$colm,10,$namareport . '  (' . $tglcetak . ') ',0,0,'L'); //page number
                $pdf->Cell($colk,10,'Page ' . $pdf->PageNo(),0,1,'R'); //page number
                //create page header
                $pdf->SetFont('Courier','B',12);
                $pdf->Cell($colnum,10,'NO',1,0,'C');
                $pdf->Cell($colsumber,10,'Sumber Dana',1,0,'C');
                $pdf->Cell($colnis,10,'NIS',1,0,'C');
                $pdf->Cell($colsiswa,10,'Siswa',1,0,'C');
                $pdf->Cell($colbulan,10,'Bulan',1,0,'C');
                $pdf->Cell($colket,10,'Keterangan',1,0,'C');
                $pdf->Cell($coltgl,10,'Tanggal','T',0,'C');
                $pdf->Cell($colm,10,'Masuk (Rp)',1,0,'C');
                $pdf->Cell($colk,10,'Keluar (Rp)',1,0,'C'); 
                $pdf->ln();
                
                $yAxis = 65;
                $isFirstPage = false;
            }
        }
        
        //crate TOTAL
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell(($colnum+$colsumber+$colnis+$colsiswa+$colbulan+$colket+$coltgl),10,'Total',1,0,'C');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell($colm,10,  number_format($totm, 0, ',', '.'),1,0,'R');
        $pdf->Cell($colk,10,  number_format($totk, 0, ',', '.'),1,1,'R');
                
        $pdf->Output('Rekap' . $jbiaya->nama .'Harian_' .date('YmdHis').'.pdf','D');
    }
    
    
    
}