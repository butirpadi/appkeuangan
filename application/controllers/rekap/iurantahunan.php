<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of iurantahunan
 *
 * @author root
 */
class Rekap_Iurantahunan_Controller extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_rekapitulasi_iuran');
    }
    
    public function get_coba(){
        $this->layout = null;
         $bulan = Bulan::order_by('posisi','asc')->get();
        $bulans = array();
        foreach ($bulan as $bul){
            $bulans[count($bulans)] = $bul;
        }
        echo $bulans[0]->nama;
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
        
//        $this->layout->nest('content', 'rekap.iurantahunan.index',array(
//            'tahunajarans'=>$tahunajarans,
//            'tahunaktif'=>$tahunaktif,
//            'tahunajaranselect'=>$tahunajaranselect,
//            'biayaselect'=>$biayaselect,
//            'rombelselect'=>$rombelselect
//        ));
//        
        $this->layout->nest('content', 'rekap.iurantahunan.main',array(
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif,
            'tahunajaranselect'=>$tahunajaranselect,
            'biayaselect'=>$biayaselect,
            'rombelselect'=>$rombelselect
        ));
    }
    
     public function get_printtopdffilterrombel($tahunajaranid,$biayaid,$rombel){
        $this->layout = null;
        
        $bulan = Bulan::order_by('posisi','asc')->get();
        $bulans = array();
        foreach ($bulan as $bul){
            $bulans[count($bulans)] = $bul;
        }
        
        $jenisbiaya = Jenisbiaya::find($biayaid);
        $ketentuanbiaya = Ketentuanbiaya::where('tahunajaran_id','=',$tahunajaranid)
                ->where('jenisbiaya_id','=',$jenisbiaya->id)
                ->first();
        $tahunajaran = Tahunajaran::find($tahunajaranid);
        $rombelnya = Rombel::find($rombel);
        
        $namasekolah = Setting::first()->nama_skul;
        $alamat = Setting::first()->alamat_skul;
        $namareport = 'Rekapitulasi Penerimaan ' . $jenisbiaya->nama . ' Siswa Per TA. ' . $tahunajaran->nama;
        $tglcetak = date('d-m-Y [H:i:s]');
        
        $rekap = DB::query('select s.id,s.nisn,s.nama,r.id as rombel_id,r.nama as rombel,r.jenjang,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 1 and vt.siswa_id = s.id) as bl1,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 2 and vt.siswa_id = s.id) as bl2,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 3 and vt.siswa_id = s.id) as bl3,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 4 and vt.siswa_id = s.id) as bl4,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 5 and vt.siswa_id = s.id) as bl5,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 6 and vt.siswa_id = s.id) as bl6,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 7 and vt.siswa_id = s.id) as bl7,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 8 and vt.siswa_id = s.id) as bl8,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 9 and vt.siswa_id = s.id) as bl9,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 10 and vt.siswa_id = s.id) as bl10,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 11 and vt.siswa_id = s.id) as bl11,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 12 and vt.siswa_id = s.id) as bl12,
            (select sum(vt.jumlah) from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.siswa_id = s.id) as total
            from siswa as s inner join  rombelsiswa rs on s.id = rs.siswa_id inner join rombel as r on r.id = rs.rombel_id
            where rombel_id = ' . $rombel . ' and rs.tahunajaran_id='.$tahunajaranid);
        
        //setting for page
        $colnum = 11;
        $colnisn = 12;
        $colnama = 75;
        $colrombel = 35;
        $colbl = 12;
        $coltotal = 35;
        $tglcetak = date('d-m-Y [H:i:s]');
        $font = 'Courier';
        
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
        $pdf->Cell(155,5,'Rombongan Belajar   : ' . $rombelnya->nama,0,1,'L');
        $pdf->ln(5);
        //create table header
        $pdf->SetFont('Courier','',12);
        $pdf->Cell($colnum,14,'NO',1,0,'C');
        $pdf->Cell($colnisn,14,'NIS',1,0,'C');
        $pdf->Cell($colnama,14,'Nama',1,0,'C');
        $pdf->Cell($colrombel,14,'Rombel',1,0,'C');
        $pdf->Cell((12 * $colbl),7,$jenisbiaya->nama . '(Rp. ' . number_format($ketentuanbiaya->jumlah, 0, ',', '.') . ')',1,0,'C');
        $pdf->Cell($coltotal,14,'Total (Rp)',1,0,'C');
        $pdf->Cell(5,7,'',0,1,'C'); //column kosong untuk mengakali turun separuh kotak
        $pdf->Cell($colnum,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NO
        $pdf->Cell($colnisn,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NISN
        $pdf->Cell($colnama,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom Nama
        $pdf->Cell($colrombel,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom rombel
        //create bulan table header
        foreach($bulan as $bl){
            $pdf->Cell($colbl,7, ucwords(substr($bl->nama, 0, 3)) ,1,0,'C');
        }
        $pdf->ln();
        
        
        //create content
        $pdf->SetFont('Courier','',10);
        $rownum = 1;
        $yAxis = 65;
        $grandtotal = 0;
        $isFirstPage = true;
        $pagenum = 1;
        
        foreach($rekap as $rek){
            $pdf->SetFont('Courier','',10);
            $pdf->Cell($colnum,5,$rownum++,1,0,'R'); 
            $pdf->Cell($colnisn,5,$rek->nisn,1,0,'L'); 
            $pdf->Cell($colnama,5,substr(ucwords(strtolower($rek->nama)),0,30),1,0,'L');
            $pdf->SetFont('Courier','',9);
            $pdf->Cell($colrombel,5,substr($rek->rombel,0,17),1,0,'L');
            $pdf->SetFont('Courier','',7);
            $pdf->Cell($colbl,5,($rek->bl1 ? number_format($rek->bl1, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl2 ? number_format($rek->bl2, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl3 ? number_format($rek->bl3, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl4 ? number_format($rek->bl4, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl5 ? number_format($rek->bl5, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl6 ? number_format($rek->bl6, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl7 ? number_format($rek->bl7, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl8 ? number_format($rek->bl8, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl9 ? number_format($rek->bl9, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl10 ? number_format($rek->bl10, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl11 ? number_format($rek->bl11, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl12 ? number_format($rek->bl12, 0, ',', '.') : '-'),1,0,'R');
            $pdf->SetFont('Courier','',10);
            $pdf->Cell($coltotal,5,($rek->total ? number_format($rek->total, 0, ',', '.')  : '0'),1,1,'R');
            $grandtotal += $rek->total;
            
            $yAxis += 5;
            if($isFirstPage){
                $batasAkhirAxis = 205;
            }else{
                $batasAkhirAxis = 230;
            }
            
            //set page num counter
            $pagenum++;
            
            if ($yAxis> $batasAkhirAxis){
                //add new page
                $pdf->AddPage();
                //sub header
                $pdf->SetFont('Courier','',10);
                $pdf->Cell($colnum+$colnisn+$colnama+$colrombel+(12 * $colbl),10,$namareport . '  (' . $tglcetak . ') ',0,0,'L'); //page number
                $pdf->Cell($coltotal,10,'Page ' . $pdf->PageNo(),0,1,'R'); //page number
                //create table header
                $pdf->SetFont('Courier','',12);
                $pdf->Cell($colnum,14,'NO',1,0,'C');
                $pdf->Cell($colnisn,14,'NISN',1,0,'C');
                $pdf->Cell($colnama,14,'Nama',1,0,'C');
                $pdf->Cell($colrombel,14,'Rombel',1,0,'C');
                $pdf->Cell((12 * $colbl),7,$jenisbiaya->nama . '(Rp. ' . number_format($ketentuanbiaya->jumlah, 0, ',', '.') . ')',1,0,'C');
                $pdf->Cell($coltotal,14,'Total (Rp)',1,0,'C');
                $pdf->Cell(5,7,'',0,1,'C'); //column kosong untuk mengakali turun separuh kotak
                $pdf->Cell($colnum,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NO
                $pdf->Cell($colnisn,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NISN
                $pdf->Cell($colnama,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom Nama
                $pdf->Cell($colrombel,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom rombel
                
                foreach($bulan as $bl){
                    $pdf->Cell($colbl,7, ucwords(substr($bl->nama, 0, 3)) ,1,0,'C');
                }
                $pdf->ln();
                
                $yAxis = 65;
                $isFirstPage = false;
            }
        }
        
        //crate grand total
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell(($colnum + $colnisn + $colnama + $colrombel + (12 * $colbl)),10,'Grand Total',1,0,'C');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell($coltotal,10,  number_format($grandtotal, 0, ',', '.'),1,1,'R');
        
                
        $pdf->Output('RekapPenerimaanIuranTahunan' . $rombelnya->nama .  '_'.date('YmdHis').'.pdf','D');
    }
    
    /**
     * print ke pdf dengan gilter jenjang
     * @param type $tahunajaranid
     * @param type $biayaid
     * @param type $jenjang
     */
    public function get_printtopdffilterjenjang($tahunajaranid,$biayaid,$jenjang){
        $this->layout = null;
        
        $bulan = Bulan::order_by('posisi','asc')->get();
        $bulans = array();
        foreach ($bulan as $bul){
            $bulans[count($bulans)] = $bul;
        }
        
        $jenisbiaya = Jenisbiaya::find($biayaid);
        $ketentuanbiaya = Ketentuanbiaya::where('tahunajaran_id','=',$tahunajaranid)
                ->where('jenisbiaya_id','=',$jenisbiaya->id)
                ->first();
        $tahunajaran = Tahunajaran::find($tahunajaranid);
        
        
        $namasekolah = Setting::first()->nama_skul;
        $alamat = Setting::first()->alamat_skul;
        $namareport = 'Rekapitulasi Penerimaan ' . $jenisbiaya->nama . ' Siswa Per TA. ' . $tahunajaran->nama;
        
        $rekap = DB::query('select s.id,s.nisn,s.nama,r.id as rombel_id,r.nama as rombel,r.jenjang,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 1 and vt.siswa_id = s.id) as bl1,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 2 and vt.siswa_id = s.id) as bl2,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 3 and vt.siswa_id = s.id) as bl3,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 4 and vt.siswa_id = s.id) as bl4,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 5 and vt.siswa_id = s.id) as bl5,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 6 and vt.siswa_id = s.id) as bl6,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 7 and vt.siswa_id = s.id) as bl7,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 8 and vt.siswa_id = s.id) as bl8,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 9 and vt.siswa_id = s.id) as bl9,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 10 and vt.siswa_id = s.id) as bl10,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 11 and vt.siswa_id = s.id) as bl11,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 12 and vt.siswa_id = s.id) as bl12,
            (select sum(vt.jumlah) from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.siswa_id = s.id) as total
            from siswa as s inner join  rombelsiswa rs on s.id = rs.siswa_id inner join rombel as r on r.id = rs.rombel_id
            where jenjang = ' . $jenjang . ' and rs.tahunajaran_id='.$tahunajaranid);
                
        //setting for page
        // full width = 360
        $colnum = 11;
        $colnisn = 12;
        $colnama = 75;
        $colrombel = 35;
        $colbl = 12;
        $coltotal = 35;
        $tglcetak = date('d-m-Y [H:i:s]');
        $font = 'Courier';
        
        $pdf = new Fpdf('L','mm',array(215,330));
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();
        //create page header
        $pdf->SetFont($font,'B',16);
        $pdf->Cell(0,8,$namareport,0,1,'C');
        $pdf->SetFont($font,'',12);
        $pdf->Cell(0,5,$namasekolah,0,1,'C');
        $pdf->SetFont($font,'',10);
        $pdf->Cell(0,5,$alamat,0,1,'C');
        $pdf->Cell(0,2,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,1,'','B',1);
        $pdf->ln(5);
        //create report header
        $pdf->Cell(155,5,'Tahun Ajaran      : ' . $tahunajaran->nama,0,0,'L');
        $pdf->Cell(155,5,'Dicetak pada      : ' . $tglcetak,0,1,'R');
        $pdf->Cell(155,5,'Tingkat Jenjang   : ' . $jenjang,0,1,'L');
        $pdf->ln(5);
        //create table header
        $pdf->SetFont($font,'',12);
        $pdf->Cell($colnum,14,'NO',1,0,'C');
        $pdf->Cell($colnisn,14,'NISN',1,0,'C');
        $pdf->Cell($colnama,14,'Nama',1,0,'C');
        $pdf->Cell($colrombel,14,'Rombel',1,0,'C');
        $pdf->Cell((12 * $colbl),7,$jenisbiaya->nama . '(Rp. ' . number_format($ketentuanbiaya->jumlah, 0, ',', '.') . ')',1,0,'C');
        $pdf->Cell($coltotal,14,'Total (Rp)',1,0,'C');
        $pdf->Cell(5,7,'',0,1,'C'); //column kosong untuk mengakali turun separuh kotak
        $pdf->Cell($colnum,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NO
        $pdf->Cell($colnisn,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NISN
        $pdf->Cell($colnama,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom Nama
        $pdf->Cell($colrombel,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom rombel
        
        //create bulan table header
        foreach($bulan as $bl){
            $pdf->Cell($colbl,7, ucwords(substr($bl->nama, 0, 3)) ,1,0,'C');
        }
        $pdf->ln();
        
        //create content
        $pdf->SetFont('Courier','',10);
        $rownum = 1;
        $yAxis = 65;
        $grandtotal = 0;
        $isFirstPage = true;
        $pagenum = 1;
        
        
        foreach($rekap as $rek){
            $pdf->SetFont('Courier','',10);
            $pdf->Cell($colnum,5,$rownum++,1,0,'R'); 
            $pdf->Cell($colnisn,5,$rek->nisn,1,0,'L'); 
            $pdf->Cell($colnama,5,substr(ucwords(strtolower($rek->nama)),0,30),1,0,'L');
            $pdf->SetFont('Courier','',9);
            $pdf->Cell($colrombel,5,substr($rek->rombel,0,17),1,0,'L');
            $pdf->SetFont('Courier','',7);
            $pdf->Cell($colbl,5,($rek->bl1 ? number_format($rek->bl1, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl2 ? number_format($rek->bl2, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl3 ? number_format($rek->bl3, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl4 ? number_format($rek->bl4, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl5 ? number_format($rek->bl5, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl6 ? number_format($rek->bl6, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl7 ? number_format($rek->bl7, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl8 ? number_format($rek->bl8, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl9 ? number_format($rek->bl9, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl10 ? number_format($rek->bl10, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl11 ? number_format($rek->bl11, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl12 ? number_format($rek->bl12, 0, ',', '.') : '-'),1,0,'R');
            $pdf->SetFont('Courier','',10);
            $pdf->Cell($coltotal,5,($rek->total ? number_format($rek->total, 0, ',', '.')  : '0'),1,1,'R');
            $grandtotal += $rek->total;
            
            $yAxis += 5;
            if($isFirstPage){
                $batasAkhirAxis = 205;
            }else{
                $batasAkhirAxis = 230;
            }
            
            //set page num counter
            $pagenum++;
            
            if ($yAxis> $batasAkhirAxis){
                //add new page
                $pdf->AddPage();
                //sub header
                $pdf->SetFont('Courier','',10);
                $pdf->Cell($colnum+$colnisn+$colnama+$colrombel+(12 * $colbl),10,$namareport . '  (' . $tglcetak . ') ',0,0,'L'); //page number
                $pdf->Cell($coltotal,10,'Page ' . $pdf->PageNo(),0,1,'R'); //page number
                //create table header
                $pdf->SetFont('Courier','',12);
                $pdf->Cell($colnum,14,'NO',1,0,'C');
                $pdf->Cell($colnisn,14,'NISN',1,0,'C');
                $pdf->Cell($colnama,14,'Nama',1,0,'C');
                $pdf->Cell($colrombel,14,'Rombel',1,0,'C');
                $pdf->Cell((12 * $colbl),7,$jenisbiaya->nama . '(Rp. ' . number_format($ketentuanbiaya->jumlah, 0, ',', '.') . ')',1,0,'C');
                $pdf->Cell($coltotal,14,'Total (Rp)',1,0,'C');
                $pdf->Cell(5,7,'',0,1,'C'); //column kosong untuk mengakali turun separuh kotak
                $pdf->Cell($colnum,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NO
                $pdf->Cell($colnisn,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NISN
                $pdf->Cell($colnama,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom Nama
                $pdf->Cell($colrombel,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom rombel
                
                foreach($bulan as $bl){
                    $pdf->Cell($colbl,7, ucwords(substr($bl->nama, 0, 3)) ,1,0,'C');
                }
                $pdf->ln();
                
                $yAxis = 65;
                $isFirstPage = false;
            }
        }
        
        //crate grand total
        $pdf->SetFont($font,'B',12);
        $pdf->Cell(($colnum + $colnisn + $colnama + $colrombel + (12 * $colbl)),10,'Grand Total',1,0,'C');
        $pdf->SetFont($font,'B',10);
        $pdf->Cell($coltotal,10,  number_format($grandtotal, 0, ',', '.'),1,1,'R');
                
        $pdf->Output('RekapPenerimaanIuranTahunanPerJenjang_'.date('YmdHis').'.pdf','D');
    }
    
    /**
     * print to pdf without filter
     * @param type $tahunajaranid
     * @param type $biayaid
     */
    public function get_printtopdf($tahunajaranid,$biayaid){
        $this->layout = null;
        
        $bulan = Bulan::order_by('posisi','asc')->get();
        $bulans = array();
        foreach ($bulan as $bul){
            $bulans[count($bulans)] = $bul;
        }
        
        $jenisbiaya = Jenisbiaya::find($biayaid);
        $ketentuanbiaya = Ketentuanbiaya::where('tahunajaran_id','=',$tahunajaranid)
                ->where('jenisbiaya_id','=',$jenisbiaya->id)
                ->first();
        $tahunajaran = Tahunajaran::find($tahunajaranid);
        
        
        $namasekolah = Setting::first()->nama_skul;
        $alamat = Setting::first()->alamat_skul;
        $namareport = 'Rekapitulasi Penerimaan ' . $jenisbiaya->nama . ' Siswa Per TA. ' . $tahunajaran->nama;
        
        $rekap = DB::query('select s.id,s.nisn,s.nama,r.id as rombel_id,r.nama as rombel,r.jenjang,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 1 and vt.siswa_id = s.id) as bl1,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 2 and vt.siswa_id = s.id) as bl2,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 3 and vt.siswa_id = s.id) as bl3,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 4 and vt.siswa_id = s.id) as bl4,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 5 and vt.siswa_id = s.id) as bl5,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 6 and vt.siswa_id = s.id) as bl6,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 7 and vt.siswa_id = s.id) as bl7,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 8 and vt.siswa_id = s.id) as bl8,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 9 and vt.siswa_id = s.id) as bl9,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 10 and vt.siswa_id = s.id) as bl10,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 11 and vt.siswa_id = s.id) as bl11,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 12 and vt.siswa_id = s.id) as bl12,
            (select sum(vt.jumlah) from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.siswa_id = s.id) as total
            from siswa as s inner join  rombelsiswa rs on s.id = rs.siswa_id inner join rombel as r on r.id = rs.rombel_id where rs.tahunajaran_id='.$tahunajaranid);
                
        //setting for page
        // full width = 360
        $colnum = 11;
        $colnisn = 12;
        $colnama = 75;
        $colrombel = 35;
        $colbl = 12;
        $coltotal = 35;
        $tglcetak = date('d-m-Y [H:i:s]');
        
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
        $pdf->Cell(155,5,'Tahun Ajaran      : ' . $tahunajaran->nama,0,0,'L');
        $pdf->Cell(155,5,'Dicetak pada      : ' . $tglcetak,0,1,'R');
        $pdf->ln(5);
        //create table header
        $pdf->SetFont('Courier','',12);
        $pdf->Cell($colnum,14,'NO',1,0,'C');
        $pdf->Cell($colnisn,14,'NIS',1,0,'C');
        $pdf->Cell($colnama,14,'Nama',1,0,'C');
        $pdf->Cell($colrombel,14,'Rombel',1,0,'C');
        $pdf->Cell((12 * $colbl),7,$jenisbiaya->nama . '(Rp. ' . number_format($ketentuanbiaya->jumlah, 0, ',', '.') . ')',1,0,'C');
        $pdf->Cell($coltotal,14,'Total (Rp)',1,0,'C');
        $pdf->Cell(5,7,'',0,1,'C'); //column kosong untuk mengakali turun separuh kotak
        $pdf->Cell($colnum,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NO
        $pdf->Cell($colnisn,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NISN
        $pdf->Cell($colnama,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom Nama
        $pdf->Cell($colrombel,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom rombel
        
        //create bulan table header
        foreach($bulan as $bl){
            $pdf->Cell($colbl,7, ucwords(substr($bl->nama, 0, 3)) ,1,0,'C');
        }
        $pdf->ln();
        
        //create content
        $pdf->SetFont('Courier','',10);
        $rownum = 1;
        $yAxis = 65;
        $grandtotal = 0;
        $isFirstPage = true;
        $pagenum = 1;
        
        foreach($rekap as $rek){
            $pdf->SetFont('Courier','',10);
            $pdf->Cell($colnum,5,$rownum++,1,0,'R'); 
            $pdf->Cell($colnisn,5,$rek->nisn,1,0,'L'); 
            $pdf->Cell($colnama,5,substr(ucwords(strtolower($rek->nama)),0,30),1,0,'L');
            $pdf->SetFont('Courier','',9);
            $pdf->Cell($colrombel,5,substr($rek->rombel,0,17),1,0,'L');
            $pdf->SetFont('Courier','',7);
            $pdf->Cell($colbl,5,($rek->bl1 ? number_format($rek->bl1, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl2 ? number_format($rek->bl2, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl3 ? number_format($rek->bl3, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl4 ? number_format($rek->bl4, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl5 ? number_format($rek->bl5, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl6 ? number_format($rek->bl6, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl7 ? number_format($rek->bl7, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl8 ? number_format($rek->bl8, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl9 ? number_format($rek->bl9, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl10 ? number_format($rek->bl10, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl11 ? number_format($rek->bl11, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl12 ? number_format($rek->bl12, 0, ',', '.') : '-'),1,0,'R');
            $pdf->SetFont('Courier','',10);
            $pdf->Cell($coltotal,5,($rek->total ? number_format($rek->total, 0, ',', '.')  : '0'),1,1,'R');
            $grandtotal += $rek->total;
            
            $yAxis += 5;
            if($isFirstPage){
                $batasAkhirAxis = 205;
            }else{
                $batasAkhirAxis = 230;
            }
            
            //set page num counter
            $pagenum++;
            
            if ($yAxis> $batasAkhirAxis){
                //add new page
                $pdf->AddPage();
                //sub header
                $pdf->SetFont('Courier','',10);
                $pdf->Cell($colnum+$colnisn+$colnama+$colrombel+(12 * $colbl),10,$namareport . '  (' . $tglcetak . ') ',0,0,'L'); //page number
                $pdf->Cell($coltotal,10,'Page ' . $pdf->PageNo(),0,1,'R'); //page number
                //create table header
                $pdf->SetFont('Courier','',12);
                $pdf->Cell($colnum,14,'NO',1,0,'C');
                $pdf->Cell($colnisn,14,'NISN',1,0,'C');
                $pdf->Cell($colnama,14,'Nama',1,0,'C');
                $pdf->Cell($colrombel,14,'Rombel',1,0,'C');
                $pdf->Cell((12 * $colbl),7,$jenisbiaya->nama . '(Rp. ' . number_format($ketentuanbiaya->jumlah, 0, ',', '.') . ')',1,0,'C');
                $pdf->Cell($coltotal,14,'Total (Rp)',1,0,'C');
                $pdf->Cell(5,7,'',0,1,'C'); //column kosong untuk mengakali turun separuh kotak
                $pdf->Cell($colnum,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NO
                $pdf->Cell($colnisn,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NISN
                $pdf->Cell($colnama,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom Nama
                $pdf->Cell($colrombel,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom rombel
                
                foreach($bulan as $bl){
                    $pdf->Cell($colbl,7, ucwords(substr($bl->nama, 0, 3)) ,1,0,'C');
                }
                $pdf->ln();
                
                $yAxis = 65;
                $isFirstPage = false;
            }
        }
        
        //crate grand total
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell(($colnum + $colnisn + $colnama + $colrombel + (12 * $colbl)),10,'Grand Total',1,0,'C');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell($coltotal,10,  number_format($grandtotal, 0, ',', '.'),1,1,'R');
                
        $pdf->Output('RekapPenerimaanIuranTahunan_'.date('YmdHis').'.pdf','D');
    }
    /**
     * print to pdf without filter
     * @param type $tahunajaranid
     * @param type $biayaid
     */
    public function get_printtopdffilternis($tahunajaranid,$biayaid,$nis){
        $this->layout = null;
        
        $bulan = Bulan::order_by('posisi','asc')->get();
        $bulans = array();
        foreach ($bulan as $bul){
            $bulans[count($bulans)] = $bul;
        }
        
        $jenisbiaya = Jenisbiaya::find($biayaid);
        $ketentuanbiaya = Ketentuanbiaya::where('tahunajaran_id','=',$tahunajaranid)
                ->where('jenisbiaya_id','=',$jenisbiaya->id)
                ->first();
        $tahunajaran = Tahunajaran::find($tahunajaranid);
        
        
        $namasekolah = Setting::first()->nama_skul;
        $alamat = Setting::first()->alamat_skul;
        $namareport = 'Rekapitulasi Penerimaan ' . $jenisbiaya->nama . ' Siswa Per TA. ' . $tahunajaran->nama;
        
        $rekap = DB::query('select s.id,s.nisn,s.nama,r.id as rombel_id,r.nama as rombel,r.jenjang,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 1 and vt.siswa_id = s.id) as bl1,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 2 and vt.siswa_id = s.id) as bl2,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 3 and vt.siswa_id = s.id) as bl3,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 4 and vt.siswa_id = s.id) as bl4,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 5 and vt.siswa_id = s.id) as bl5,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 6 and vt.siswa_id = s.id) as bl6,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 7 and vt.siswa_id = s.id) as bl7,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 8 and vt.siswa_id = s.id) as bl8,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 9 and vt.siswa_id = s.id) as bl9,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 10 and vt.siswa_id = s.id) as bl10,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 11 and vt.siswa_id = s.id) as bl11,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 12 and vt.siswa_id = s.id) as bl12,
            (select sum(vt.jumlah) from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.siswa_id = s.id) as total
            from siswa as s inner join  rombelsiswa rs on s.id = rs.siswa_id inner join rombel as r on r.id = rs.rombel_id where s.nisn = ' . $nis . ' and rs.tahunajaran_id='.$tahunajaranid);
                
        //setting for page
        // full width = 360
        $colnum = 11;
        $colnisn = 12;
        $colnama = 75;
        $colrombel = 35;
        $colbl = 12;
        $coltotal = 35;
        $tglcetak = date('d-m-Y [H:i:s]');
        
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
        $pdf->Cell(155,5,'Tahun Ajaran      : ' . $tahunajaran->nama,0,0,'L');
        $pdf->Cell(155,5,'Dicetak pada      : ' . $tglcetak,0,1,'R');
        $pdf->ln(5);
        //create table header
        $pdf->SetFont('Courier','',12);
        $pdf->Cell($colnum,14,'NO',1,0,'C');
        $pdf->Cell($colnisn,14,'NIS',1,0,'C');
        $pdf->Cell($colnama,14,'Nama',1,0,'C');
        $pdf->Cell($colrombel,14,'Rombel',1,0,'C');
        $pdf->Cell((12 * $colbl),7,$jenisbiaya->nama . '(Rp. ' . number_format($ketentuanbiaya->jumlah, 0, ',', '.') . ')',1,0,'C');
        $pdf->Cell($coltotal,14,'Total (Rp)',1,0,'C');
        $pdf->Cell(5,7,'',0,1,'C'); //column kosong untuk mengakali turun separuh kotak
        $pdf->Cell($colnum,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NO
        $pdf->Cell($colnisn,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NISN
        $pdf->Cell($colnama,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom Nama
        $pdf->Cell($colrombel,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom rombel
        
        //create bulan table header
        foreach($bulan as $bl){
            $pdf->Cell($colbl,7, ucwords(substr($bl->nama, 0, 3)) ,1,0,'C');
        }
        $pdf->ln();
        
        //create content
        $pdf->SetFont('Courier','',10);
        $rownum = 1;
        $yAxis = 65;
        $grandtotal = 0;
        $isFirstPage = true;
        $pagenum = 1;
        
        foreach($rekap as $rek){
            $pdf->SetFont('Courier','',10);
            $pdf->Cell($colnum,5,$rownum++,1,0,'R'); 
            $pdf->Cell($colnisn,5,$rek->nisn,1,0,'L'); 
            $pdf->Cell($colnama,5,substr(ucwords(strtolower($rek->nama)),0,30),1,0,'L');
            $pdf->SetFont('Courier','',9);
            $pdf->Cell($colrombel,5,substr($rek->rombel,0,17),1,0,'L');
            $pdf->SetFont('Courier','',7);
            $pdf->Cell($colbl,5,($rek->bl1 ? number_format($rek->bl1, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl2 ? number_format($rek->bl2, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl3 ? number_format($rek->bl3, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl4 ? number_format($rek->bl4, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl5 ? number_format($rek->bl5, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl6 ? number_format($rek->bl6, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl7 ? number_format($rek->bl7, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl8 ? number_format($rek->bl8, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl9 ? number_format($rek->bl9, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl10 ? number_format($rek->bl10, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl11 ? number_format($rek->bl11, 0, ',', '.') : '-'),1,0,'R');
            $pdf->Cell($colbl,5,($rek->bl12 ? number_format($rek->bl12, 0, ',', '.') : '-'),1,0,'R');
            $pdf->SetFont('Courier','',10);
            $pdf->Cell($coltotal,5,($rek->total ? number_format($rek->total, 0, ',', '.')  : '0'),1,1,'R');
            $grandtotal += $rek->total;
            
            $yAxis += 5;
            if($isFirstPage){
                $batasAkhirAxis = 205;
            }else{
                $batasAkhirAxis = 230;
            }
            
            //set page num counter
            $pagenum++;
            
            if ($yAxis> $batasAkhirAxis){
                //add new page
                $pdf->AddPage();
                //sub header
                $pdf->SetFont('Courier','',10);
                $pdf->Cell($colnum+$colnisn+$colnama+$colrombel+(12 * $colbl),10,$namareport . '  (' . $tglcetak . ') ',0,0,'L'); //page number
                $pdf->Cell($coltotal,10,'Page ' . $pdf->PageNo(),0,1,'R'); //page number
                //create table header
                $pdf->SetFont('Courier','',12);
                $pdf->Cell($colnum,14,'NO',1,0,'C');
                $pdf->Cell($colnisn,14,'NISN',1,0,'C');
                $pdf->Cell($colnama,14,'Nama',1,0,'C');
                $pdf->Cell($colrombel,14,'Rombel',1,0,'C');
                $pdf->Cell((12 * $colbl),7,$jenisbiaya->nama . '(Rp. ' . number_format($ketentuanbiaya->jumlah, 0, ',', '.') . ')',1,0,'C');
                $pdf->Cell($coltotal,14,'Total (Rp)',1,0,'C');
                $pdf->Cell(5,7,'',0,1,'C'); //column kosong untuk mengakali turun separuh kotak
                $pdf->Cell($colnum,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NO
                $pdf->Cell($colnisn,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom NISN
                $pdf->Cell($colnama,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom Nama
                $pdf->Cell($colrombel,7,'',0,0,'C'); //column kosong untuk mengakali dibawah kolom rombel
                
                foreach($bulan as $bl){
                    $pdf->Cell($colbl,7, ucwords(substr($bl->nama, 0, 3)) ,1,0,'C');
                }
                $pdf->ln();
                
                $yAxis = 65;
                $isFirstPage = false;
            }
        }
        
        //crate grand total
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell(($colnum + $colnisn + $colnama + $colrombel + (12 * $colbl)),10,'Grand Total',1,0,'C');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell($coltotal,10,  number_format($grandtotal, 0, ',', '.'),1,1,'R');
                
        $pdf->Output('RekapPenerimaanIuranTahunan_NIS_' . $nis . '_' .date('YmdHis').'.pdf','D');
    }
    
    public function get_ajaxtabelrekap($tahunajaranid,$biayaid){
        $rekap = DB::query('select s.id,s.nisn,s.nama,r.id as rombel_id,r.nama as rombel,r.jenjang,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 1 and vt.siswa_id = s.id) as bl1,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 2 and vt.siswa_id = s.id) as bl2,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 3 and vt.siswa_id = s.id) as bl3,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 4 and vt.siswa_id = s.id) as bl4,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 5 and vt.siswa_id = s.id) as bl5,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 6 and vt.siswa_id = s.id) as bl6,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 7 and vt.siswa_id = s.id) as bl7,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 8 and vt.siswa_id = s.id) as bl8,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 9 and vt.siswa_id = s.id) as bl9,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 10 and vt.siswa_id = s.id) as bl10,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 11 and vt.siswa_id = s.id) as bl11,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 12 and vt.siswa_id = s.id) as bl12,
            (select sum(vt.jumlah) from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.siswa_id = s.id) as total
            from siswa as s inner join  rombelsiswa rs on s.id = rs.siswa_id inner join rombel as r on r.id = rs.rombel_id where rs.tahunajaran_id='.$tahunajaranid);
        
        $bulan = Bulan::order_by('posisi','asc')->get();
        $bulans = array();
        foreach ($bulan as $bul){
            $bulans[count($bulans)] = $bul;
        }
        
        $jenisbiaya = Jenisbiaya::find($biayaid);
        
        return View::make('rekap.iurantahunan.ajaxtabelrekap')
                ->with('rekap',$rekap)
                ->with('bulans',$bulans)
                ->with('jenisbiaya',$jenisbiaya);
    }
    
    public function get_ajxhistotranssiswa($nisn){
        $tahunajaranid = Tahunajaran::where('aktif','=','Y')->first()->id;
        $biayaid = Appsetting::first()->biaya_id;
        
        $rekap = DB::query('select s.id,s.nisn,s.nama,r.id as rombel_id,r.nama as rombel,r.jenjang,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 1 and vt.siswa_id = s.id) as bl1,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 2 and vt.siswa_id = s.id) as bl2,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 3 and vt.siswa_id = s.id) as bl3,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 4 and vt.siswa_id = s.id) as bl4,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 5 and vt.siswa_id = s.id) as bl5,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 6 and vt.siswa_id = s.id) as bl6,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 7 and vt.siswa_id = s.id) as bl7,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 8 and vt.siswa_id = s.id) as bl8,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 9 and vt.siswa_id = s.id) as bl9,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 10 and vt.siswa_id = s.id) as bl10,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 11 and vt.siswa_id = s.id) as bl11,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 12 and vt.siswa_id = s.id) as bl12,
            (select sum(vt.jumlah) from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.siswa_id = s.id) as total
            from siswa as s inner join  rombelsiswa rs on s.id = rs.siswa_id inner join rombel as r on r.id = rs.rombel_id where s.nisn = ' . $nisn . ' and rs.tahunajaran_id='.$tahunajaranid);
        
        $bulan = Bulan::order_by('posisi','asc')->get();
        $bulans = array();
        foreach ($bulan as $bul){
            $bulans[count($bulans)] = $bul;
        }
        
        $jenisbiaya = Jenisbiaya::find($biayaid);
        
        return View::make('home.ajaxbukuspp')->with('rekap',$rekap)->with('bulans',$bulans)->with('jenisbiaya',$jenisbiaya);
    }
    
    public function get_ajaxtabelrekapfiltersiswa($tahunajaranid,$biayaid,$nisn){
        $rekap = DB::query('select s.id,s.nisn,s.nama,r.id as rombel_id,r.nama as rombel,r.jenjang,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 1 and vt.siswa_id = s.id) as bl1,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 2 and vt.siswa_id = s.id) as bl2,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 3 and vt.siswa_id = s.id) as bl3,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 4 and vt.siswa_id = s.id) as bl4,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 5 and vt.siswa_id = s.id) as bl5,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 6 and vt.siswa_id = s.id) as bl6,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 7 and vt.siswa_id = s.id) as bl7,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 8 and vt.siswa_id = s.id) as bl8,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 9 and vt.siswa_id = s.id) as bl9,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 10 and vt.siswa_id = s.id) as bl10,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 11 and vt.siswa_id = s.id) as bl11,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 12 and vt.siswa_id = s.id) as bl12,
            (select sum(vt.jumlah) from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.siswa_id = s.id) as total
            from siswa as s inner join  rombelsiswa rs on s.id = rs.siswa_id inner join rombel as r on r.id = rs.rombel_id where s.nisn = ' . $nisn . ' and rs.tahunajaran_id='.$tahunajaranid);
        
        $bulan = Bulan::order_by('posisi','asc')->get();
        $bulans = array();
        foreach ($bulan as $bul){
            $bulans[count($bulans)] = $bul;
        }
        
        $jenisbiaya = Jenisbiaya::find($biayaid);
        
        return View::make('rekap.iurantahunan.ajaxtabelrekap')->with('rekap',$rekap)->with('bulans',$bulans)->with('jenisbiaya',$jenisbiaya);
    }
    
    public function get_ajaxtabelrekapfilterrombel($tahunajaranid,$biayaid,$rombel){
        $rekap = DB::query('select s.id,s.nisn,s.nama,r.id as rombel_id,r.nama as rombel,r.jenjang,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 1 and vt.siswa_id = s.id) as bl1,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 2 and vt.siswa_id = s.id) as bl2,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 3 and vt.siswa_id = s.id) as bl3,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 4 and vt.siswa_id = s.id) as bl4,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 5 and vt.siswa_id = s.id) as bl5,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 6 and vt.siswa_id = s.id) as bl6,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 7 and vt.siswa_id = s.id) as bl7,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 8 and vt.siswa_id = s.id) as bl8,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 9 and vt.siswa_id = s.id) as bl9,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 10 and vt.siswa_id = s.id) as bl10,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 11 and vt.siswa_id = s.id) as bl11,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 12 and vt.siswa_id = s.id) as bl12,
            (select sum(vt.jumlah) from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.siswa_id = s.id) as total
            from siswa as s inner join  rombelsiswa rs on s.id = rs.siswa_id inner join rombel as r on r.id = rs.rombel_id where rombel_id = ' . $rombel . ' and rs.tahunajaran_id='.$tahunajaranid);
        
        $bulan = Bulan::order_by('posisi','asc')->get();
        $bulans = array();
        foreach ($bulan as $bul){
            $bulans[count($bulans)] = $bul;
        }
        
        $jenisbiaya = Jenisbiaya::find($biayaid);
        
        return View::make('rekap.iurantahunan.ajaxtabelrekap')->with('rekap',$rekap)->with('bulans',$bulans)->with('jenisbiaya',$jenisbiaya);
    }
    
    public function get_ajaxtabelrekapfilterjenjang($tahunajaranid,$biayaid,$jenjang){
        $rekap = DB::query('select s.id,s.nisn,s.nama,r.id as rombel_id,r.nama as rombel,r.jenjang,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 1 and vt.siswa_id = s.id) as bl1,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 2 and vt.siswa_id = s.id) as bl2,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 3 and vt.siswa_id = s.id) as bl3,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 4 and vt.siswa_id = s.id) as bl4,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 5 and vt.siswa_id = s.id) as bl5,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 6 and vt.siswa_id = s.id) as bl6,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 7 and vt.siswa_id = s.id) as bl7,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 8 and vt.siswa_id = s.id) as bl8,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 9 and vt.siswa_id = s.id) as bl9,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 10 and vt.siswa_id = s.id) as bl10,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 11 and vt.siswa_id = s.id) as bl11,
            (select vt.jumlah from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.posisi = 12 and vt.siswa_id = s.id) as bl12,
            (select sum(vt.jumlah) from vtransmasuk as vt where vt.tahunajaran_id = ' . $tahunajaranid . ' and vt.jenisbiaya_id =  ' . $biayaid . ' and vt.siswa_id = s.id) as total
            from siswa as s inner join  rombelsiswa rs on s.id = rs.siswa_id inner join rombel as r on r.id = rs.rombel_id where jenjang = ' . $jenjang . ' and rs.tahunajaran_id='.$tahunajaranid);
        
        $bulan = Bulan::order_by('posisi','asc')->get();
        $bulans = array();
        foreach ($bulan as $bul){
            $bulans[count($bulans)] = $bul;
        }
        
        $jenisbiaya = Jenisbiaya::find($biayaid);
        
        return View::make('rekap.iurantahunan.ajaxtabelrekap')->with('rekap',$rekap)->with('bulans',$bulans)->with('jenisbiaya',$jenisbiaya);
    }
    
}