<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tahunan
 *
 * @author root
 */
class Rekap_Tahunan_Controller extends Base_Controller {
    
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
        $tahunajaranselect = array();
        foreach($tahunajarans as $ta){
            $tahunajaranselect[$ta->id] = $ta->nama;
        }
        
        $biayas = Jenisbiaya::where('tipe','=','ITB')->get();
        $biayaselect = array();
        foreach($biayas as $biaya){
            $biayaselect[$biaya->id] = $biaya->nama;
        }
        
        $rombels = Rombel::order_by('jenjang','asc')->get(); 
        $rombelselect = array();
        foreach($rombels as $rom){
            $rombelselect[$rom->id] = $rom->nama;
        }
        
        $this->layout->nest('content', 'rekap.tahunan.index',array(
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif,
            'tahunajaranselect'=>$tahunajaranselect,
            'biayaselect'=>$biayaselect,
            'rombelselect'=>$rombelselect
        ));
    }
    
    public function get_ajaxtabel($tahunajaran_id){
        $this->layout = null;
        //$trans = Vtransmasuk::where('tahunajaran_id','=',$tahunajaran_id)->get();
        $trans = DB::query("select tahunajaran,tahunajaran_id,jenisbiaya,jenisbiaya_id,arus, 
            case when arus = 'M' then sum(jumlah) else 0 end as masuk,
            case when arus = 'K' then sum(jumlah) else 0 end as keluar,
            posisi_tahunajaran
            from vtransmasuk 
            group by tahunajaran_id,jenisbiaya_id");
        $tahunajaran = Tahunajaran::find($tahunajaran_id);
        $targetpencapaian = Targetpencapaian::where('tahunajaran_id','=',$tahunajaran_id)->first();
        
        //mutasi dalam tahun tersebut
        $mutasi = DB::query("SELECT * FROM mutasi WHERE tahunajaran_id = " . $tahunajaran_id);
        //mutasi keluar sebelum tahun tersebut
        $mutasikeluar = DB::table('mutasi')
                        ->join('tahunajaran', 'mutasi.tahunajaran_id', '=', 'tahunajaran.id')
                        ->where('tahunajaran.posisi','<',$tahunajaran->posisi)
                        ->where('mutasi.asal','=','KU')
                        ->sum('mutasi.jumlah');
        $mutasimasuk = DB::table('mutasi')
                        ->join('tahunajaran', 'mutasi.tahunajaran_id', '=', 'tahunajaran.id')
                        ->where('tahunajaran.posisi','<',$tahunajaran->posisi)
                        ->where('mutasi.asal','=','KB')
                        ->sum('mutasi.jumlah');
        $cashonbank = $mutasikeluar - $mutasimasuk;
                
                
        return View::make('rekap.tahunan.ajaxtabel')
                ->with('trans',$trans)
                ->with('tahunajaran',$tahunajaran)
                ->with('targetpencapaian',$targetpencapaian)
                ->with('mutasi',$mutasi)
                ->with('mutasikeluar',$mutasikeluar)
                ->with('mutasimasuk',$mutasimasuk)
                ->with('cashonbank',$cashonbank)
                ;
        
    }
    
    public function get_printtopdf($tahunajaranid){
        $this->layout = null;
        
        $tahunajaran = Tahunajaran::find($tahunajaranid);
        
        $trans = DB::query("select tahunajaran,tahunajaran_id,jenisbiaya,jenisbiaya_id,arus, 
            case when arus = 'M' then sum(jumlah) else 0 end as masuk,
            case when arus = 'K' then sum(jumlah) else 0 end as keluar,
            posisi_tahunajaran
            from vtransmasuk 
            group by tahunajaran_id,jenisbiaya_id");
        //set report header setting
        $namasekolah = Setting::first()->nama_skul;
        $alamat = Setting::first()->alamat_skul;
        $namareport = 'Rekapitulasi Keuangan per Tahun Ajaran ' . $tahunajaran->nama;
        $target = Targetpencapaian::where('tahunajaran_id','=',$tahunajaranid)->first();
        
        //pre defined
        $isFirstPage = true;
        $tglcetak = date('d-m-Y [H:i:s]');
        
        //set column with variables
        $colnum = 10;
        $colsumber = 85;
        $colm = 50;
        $colk = 50;
        $coltgl = 30;
        
        $pdf = new Fpdf('P','mm',array(215,330));
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
        $pdf->Cell(100,5,'Tahun Ajaran        : ' . $tahunajaran->nama,0,0,'L');
        $pdf->Cell(95,5,'Dicetak pada        : ' . $tglcetak,0,1,'R');
        
        $pdf->ln(5);
        //create table header
        $pdf->SetFont('Courier','',12);
        $pdf->Cell($colnum,8,'NO',1,0,'C');
        $pdf->Cell($colsumber,8,'Jenis Biaya',1,0,'C');
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
        
        foreach($trans as $tr){
            
            if($tr->posisi_tahunajaran == $tahunajaran->posisi){
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
            
            if($tr->posisi_tahunajaran <$tahunajaran->posisi){
                $totmlalu += $tr->masuk;
                $totklalu += $tr->keluar;
            }
            
            //new page setting
            $yAxis += 10;
            
            if($isFirstPage){
                $batasAkhirAxis = 185;
            }else{
                $batasAkhirAxis = 230;
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
                $pdf->Cell($colnum,8,'NO',1,0,'C');
                $pdf->Cell($colsumber,8,'Jenis Biaya',1,0,'C');
                $pdf->Cell($colm,8,'Masuk',1,0,'C');
                $pdf->Cell($colk,8,'Keluar',1,0,'C');
                $pdf->ln();
                
                $yAxis = 65;
                $isFirstPage = false;
            }
        }
        
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
        //$pdf->SetFont('Courier','B',12);
        $pdf->Cell(($colnum + $colsumber),7,'Total Pendapatan',1,0,'R');
        //$pdf->SetFont('Courier','B',10);
        $pdf->Cell($colk+$colm,7,  number_format($totm-$totk, 0, ',', '.'),1,1,'R');
        
        //crate saldo lalu
        //$pdf->SetFont('Courier','B',12);
        $pdf->Cell(($colnum + $colsumber),7,'Saldo Lalu',1,0,'R');
        //$pdf->SetFont('Courier','B',10);
        $pdf->Cell($colk+$colm,7,  number_format($totmlalu-$totklalu, 0, ',', '.'),1,1,'R');
        
        //cetak garis
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        
        //crate saldo saat ini
        $pdf->Cell(($colnum + $colsumber),7,'Total Saldo',1,0,'R');
        $pdf->Cell($colk+$colm,7,  number_format(($totmlalu-$totklalu)+($totm-$totk), 0, ',', '.'),1,1,'R');
        
//        //crate target pencapaian
//        $pdf->Cell(($colnum + $colsumber),7,'Target Pencapaian',1,0,'R');
//        $pdf->Cell($colk+$colm,7,  number_format($target->jumlah, 0, ',', '.'),1,1,'R');
        
        //cetak garis
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        
//        //crate selisi
//        $pdf->Cell(($colnum + $colsumber),7,'Selisih Target',1,0,'R');
//        $pdf->Cell($colk+$colm,7,  number_format(($target->jumlah-(($totmlalu-$totklalu)+($totm-$totk))), 0, ',', '.'),1,1,'R');
                
        $pdf->Output('RekapKeuanganTahunan_'.date('YmdHis').'.pdf','D');
    }
}
