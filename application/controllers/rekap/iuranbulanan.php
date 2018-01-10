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
class Rekap_Iuranbulanan_Controller extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_rekapitulasi_bulanan');
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
        
        $bulans = Bulan::order_by('posisi','asc')->get();
        $selectbulan = array();
        foreach($bulans as $bl){
            $selectbulan[$bl->id] = ucwords($bl->nama);
        }
        
        $jenisbiaya = Jenisbiaya::where_in('tipe',array('ITB','ITC','IB'))->get();
        $selectbiaya = array();
        foreach($jenisbiaya as $jb){
            $selectbiaya[$jb->id] = ucwords($jb->nama);
        }
        
        $this->layout->nest('content', 'rekap.iuranbulanan.index',array(
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif,
            'tahunajaranselect'=>$tahunajaranselect,
            'selectbulan'=>$selectbulan,
            'selectbiaya'=>$selectbiaya
        ));
    }
    
    public function get_ajaxtabel($tahunajaran_id,$jenisbiaya_id,$tanggal,$detil){
        $this->layout = null;
        
        $tahunajaran = Tahunajaran::find($tahunajaran_id);
        $jenisbiaya = Jenisbiaya::find($jenisbiaya_id);
        $awal = date('d-m-Y',strtotime('01-'.$tanggal));
        $akhir = date("t-m-Y", strtotime('01-'.$tanggal) ) ;
        $detilnya = $detil;
        $pencapaian = $tahunajaran->targetbiayabulanan()->where('jenisbiaya_id','=',$jenisbiaya_id)->first();
        
        $trans = Transmasuk::with('detiltransmasuks')
                ->where('tahunajaran_id','=',$tahunajaran_id)
                ->where('tanggal','>=',$awal)
                ->where('tanggal','<=',$akhir)
                ->get();
        
        return View::make('rekap.iuranbulanan.ajaxtabel')
                ->with('tahunajaran',$tahunajaran)
                ->with('jenisbiaya',$jenisbiaya)
                ->with('detil',$detilnya)
                ->with('pencapaian',$pencapaian)
                ->with('trans',$trans);
        
    }
    
    public function get_printtopdf($tahunajaran_id,$jenisbiaya_id,$tanggal,$detil){
        $this->layout = null;
        
        $tahunajaran = Tahunajaran::find($tahunajaran_id);
        $jenisbiaya = Jenisbiaya::find($jenisbiaya_id);
        $awal = date('d-m-Y',strtotime('01-'.$tanggal));
        $akhir = date("t-m-Y", strtotime('01-'.$tanggal) ) ;
        $detilnya = $detil;
        $pencapaian = $tahunajaran->targetbiayabulanan()->where('jenisbiaya_id','=',$jenisbiaya_id)->first();
        
        $trans = Transmasuk::with('detiltransmasuks')
                ->where('tahunajaran_id','=',$tahunajaran_id)
                ->where('tanggal','>=',$awal)
                ->where('tanggal','<=',$akhir)
                ->get();
        
        //generate PDF
        //pre defined
        //set report header setting
        $setting = Setting::first();
        $namasekolah = $setting->nama_skul;
        $alamat = $setting->alamat_skul;
        $namareport = 'Rekapitulasi Iuran Bulan '. date('M',strtotime('01-'.$tanggal));;       
        $isFirstPage = true;
        $tglcetak = date('d-m-Y [H:i:s]');
        
        //set column with variables
        $colnum = 10;
        $colsiswa = 140;
        $colrombel = 45;
        
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
        $pdf->Cell($colnum+$colsiswa,5,'Tahun Ajaran        : ' . $tahunajaran->nama,0,0,'L');
        $pdf->Cell($colrombel,5,'Dicetak pada        : ' . $tglcetak,0,1,'R');
        $pdf->ln(5);
        //create table header
        $pdf->SetFont('Courier','',12);
        $pdf->Cell($colnum,10,'NO',1,0,'C');
        $pdf->Cell($colsiswa,10,'Jenis Biaya',1,0,'C');
        $pdf->Cell($colrombel,10,'Jumlah',1,0,'C');
        $pdf->ln();
        
        //create content
        $pdf->SetFont('Courier','',10);
        $rownum = 1;
        $yAxis = 65;
        $total=0;
        
        foreach($trans as $tr){
            $detrans = $tr->detiltransmasuks()->where('jenisbiaya_id','=',$jenisbiaya->id)->get();
            $total += $tr->detiltransmasuks()->where('jenisbiaya_id','=',$jenisbiaya->id)->sum('jumlah');
            foreach($detrans as $det){
                if($detil == 'true'){
                    $pdf->SetFont('Courier','',10);

                    $pdf->Cell($colnum,5,$rownum++,1,0,'R');
                    $pdf->Cell($colsiswa,5,$jenisbiaya->nama . ' [' . $tr->siswa->nama . '] [' . date('d-m-Y',strtotime($tr->tanggal)) .']','B',0,'L');
                    $pdf->Cell($colrombel,5,number_format($det->jumlah, 0, ',', '.'),1,0,'R');
                    $pdf->ln();
                    //set total
                    $total += $det->jumlah;

                    //new page setting
                    $yAxis += 10;
                    if($isFirstPage){
                        $batasAkhirAxis = 570;
                    }else{
                        $batasAkhirAxis = 620;
                    }
                    if ($yAxis > $batasAkhirAxis){
                        //add new page
                        $pdf->AddPage();
                        //sub header
        //                $pdf->SetFont('Courier','',10);
        //                $pdf->Cell($colnum+$colsiswa+$coltgl+$colm,10,$namareport . '  (' . $tglcetak . ') ',0,0,'L'); //page number
        //                $pdf->Cell($colk,10,'Page ' . $pdf->PageNo(),0,1,'R'); //page number
                        //create table header
                        $pdf->SetFont('Courier','',12);
                        $pdf->Cell($colnum,10,'NO',1,0,'C');
                        $pdf->Cell($colsiswa,10,'Jenis Biaya',1,0,'C');
                        $pdf->Cell($colrombel,10,'Jumlah',1,0,'C');
                        $pdf->ln();

                        $yAxis = 65;
                        $isFirstPage = false;
                    }
                }
            }
        }
        
        //cetak total
        if($detil == 'false'){
            //cetak satu row
            $pdf->SetFont('Courier','',10);
            $pdf->Cell($colnum,5,1 ,1,0,'L');
            $pdf->Cell($colsiswa,5,'Total Penerimaan '.$jenisbiaya->nama ,1,0,'L');
            $pdf->Cell($colrombel,5, number_format($total, 0, ',', '.'),1,0,'R');
            $pdf->ln();
        }
        //cetak total
        if($detil=='true'){
            $pdf->SetFont('Courier','B',10);
            $pdf->Cell($colsiswa+$colnum,5,'TOTAL' ,1,0,'R');
            $pdf->Cell($colrombel,5,number_format($total, 0, ',', '.'),1,0,'R');
            $pdf->ln();
        }
        //cetak pencapaian
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell($colnum+$colsiswa,5,'Target Pencapaian' ,1,0,'R');
        $pdf->Cell($colrombel,5,($pencapaian ? number_format($pencapaian->pivot->jumlah, 0, ',', '.') : '-'),1,0,'R');
        $pdf->ln();
        //selisih target
        //cetak pencapaian
        $pdf->Cell($colnum+$colsiswa,5,'Selisih Target' ,1,0,'R');
        $pdf->Cell($colrombel,5,($pencapaian ? number_format($total - $pencapaian->pivot->jumlah, 0, ',', '.') : '-'),1,0,'R');
        $pdf->ln();
                
        $pdf->Output('RekapIuranBulan_'.date('YmdHis').'.pdf','D');
    }
    
}
