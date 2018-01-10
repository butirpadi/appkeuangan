<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rekapharian
 *
 * @author Klik
 */
class Datarekap_Rekapharian_Controller extends Base_Controller {
    
    public $report_title = 'REKAPITULASI TRANSAKSI HARIAN';
    public $report_sub_title = 'SD ISLAM SABILIL HUDA';
    public $report_second_sub_title = 'Jl. Singokarso 54 Sumorame Candi Sidoarjo 61271 Telp. 031-8061169';
    
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');    
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
        
        $this->layout->nest('content', 'datarekap.harian.index',array(
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif,
            'selectTahunajaran'=>$selecttahunajaran
        ));
    }
    
    public function get_datarekapdetil($tahunId,$awal,$akhir){
        $this->layout = null;
        $datarekap = DB::table('view_transmasuk')->where('tahunajaran_id','=',$tahunId)->where_between('tanggal',date('Y-m-d',strtotime($awal)),date('Y-m-d',strtotime($akhir)))->order_by('tanggal','asc')->get();
        
        return View::make('datarekap.harian.datarekapdetil')
                ->with('datarekap',$datarekap)
                ->with('awal',$awal)
                ->with('akhir',$akhir);
    }
    
    public function get_datarekapgroup($tahunId,$awal,$akhir){
        $this->layout = null;
        $datarekap = DB::query("select vt.tahunajaran_id,vt.tahunajaran,vt.jenisbiaya_id,vt.jenisbiaya,vt.arus,sum(vt.jumlah) as jumlah 
                            from view_transmasuk vt where tahunajaran_id = " . $tahunId . " and tanggal between '" . date('Y-m-d',strtotime($awal)) . "' and '" . date('Y-m-d',strtotime($akhir)) . "'
                            group by (vt.jenisbiaya_id)");
        
        return View::make('datarekap.harian.datarekapgroup')
                ->with('datarekap',$datarekap)
                ->with('awal',$awal)
                ->with('akhir',$akhir);
    }
    
    public function get_printgroup($tahunId,$awal,$akhir){
        $this->layout = null;
        $datarekap = DB::query("select vt.tahunajaran_id,vt.tahunajaran,vt.jenisbiaya_id,vt.jenisbiaya,vt.arus,sum(vt.jumlah) as jumlah 
                            from view_transmasuk vt where tahunajaran_id = " . $tahunId . " and tanggal between '" . date('Y-m-d',strtotime($awal)) . "' and '" . date('Y-m-d',strtotime($akhir)) . "'
                            group by (vt.jenisbiaya_id)");
        
        /**
         * Printing
         */
        $pdf = new Tcpdf('P','mm','A4',true, 'UTF-8', false);
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        // page setting
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(true, 10);
        
        // add a page
        $pdf->AddPage();
        
        // set header font
        $pdf->SetFont('courier', '', 12);
        // set content
        $pdf->Cell(0, 0, $this->report_title , 0, 1, 'C');
        $pdf->SetFont('courier', '', 12);
        $pdf->Cell(0, 0, $this->report_sub_title, 0, 1, 'C');
        $pdf->SetFont('courier', '', 8);
        $pdf->Cell(0, 0, $this->report_second_sub_title, 0, 1, 'C');
        $pdf->Cell(0, 0, '', 'B', 1);
        $pdf->ln(5);
        // content keternagan
        $pdf->SetFont('courier', '', 8);
        $periodestr = 'Periode : ' . $awal . ' / ' . $akhir;
        $pdf->Cell(($pdf->GetStringWidth($periodestr)+10), 0, $periodestr, 0, 0, 'L');
        $dicetakstr = 'Dicetak tanggal : ' . date('d-m-Y');
        $pdf->Cell(0, 0, $dicetakstr, 0, 1, 'R');
        $pdf->ln();
        //table setting
        $tb_hd_h = 8;
        $tb_rw_h = 4;
        $tb_col_no = 10;
        $tb_col_by = 90;
        $tb_col_pd = 45;
        $tb_col_pg = 45;
        $pdf->SetFont('courier', 'B', 8);
        // table header
        $pdf->Cell($tb_col_no, $tb_hd_h, 'NO', 1,0,'C');
        $pdf->Cell($tb_col_by, $tb_hd_h, 'BIAYA', 1,0,'C');
        $pdf->Cell($tb_col_pd, $tb_hd_h, 'PENDAPATAN', 1,0,'C');
        $pdf->Cell($tb_col_pg, $tb_hd_h, 'PENGELUARAN', 1,1,'C');
        // table rows
        $rownum = 1;
        $pdf->SetFont('courier', '', 8);
        $pendapatan = 0;
        $pengeluaran = 0;
        foreach($datarekap as $dr){
            $pdf->Cell($tb_col_no, $tb_rw_h, $rownum++, 1,0,'R');
            $pdf->Cell($tb_col_by, $tb_rw_h, ucwords($dr->jenisbiaya), 1,0,'L');
            $pdf->Cell($tb_col_pd, $tb_rw_h, ($dr->arus == 'M' ? number_format($dr->jumlah,0,',','.') : '-'), 1,0,'R');
            $pdf->Cell($tb_col_pg, $tb_rw_h, ($dr->arus == 'K' ? number_format($dr->jumlah,0,',','.') : '-'), 1,1,'R');
            
            if($dr->arus == 'M'){
                $pendapatan += $dr->jumlah;
            }else{
                $pengeluaran += $dr->jumlah;
            } 
        }    
        // row grand total
        $pdf->SetFont('courier', 'B', 8);
        $pdf->Cell($tb_col_no + $tb_col_by, $tb_rw_h, 'TOTAL', 1,0,'C');
        $pdf->Cell($tb_col_pd, $tb_rw_h, number_format($pendapatan,0,',','.') , 1,0,'R');
        $pdf->Cell($tb_col_pg, $tb_rw_h, number_format($pengeluaran,0,',','.') , 1,1,'R');
        
        //print keterangan
        $pdf->ln(5);
        $pdf->Cell(0, 0, 'K E T E R A N G A N' , 0 , 1, 'L');
        $pdf->ln();
        $pdf->Cell(50, 0, 'PENDAPATAN' , 0 , 0, 'L'); $pdf->Cell(10, 0, 'Rp.' , 0 , 0, 'R'); $pdf->Cell(50, 0, number_format($pendapatan,0,',','.') , 0 , 1, 'R');
        $pdf->Cell(50, 0, 'PENGELUARAN' , 0 , 0, 'L'); $pdf->Cell(10, 0, 'Rp.' , 0 , 0, 'R'); $pdf->Cell(50, 0, number_format($pengeluaran,0,',','.') , 'B' , 1, 'R');
        $pdf->Cell(50, 0, 'S E L I S I H' , 0 , 0, 'L'); $pdf->Cell(10, 0, 'Rp.' , 0 , 0, 'R'); $pdf->Cell(50, 0, number_format($pendapatan - $pengeluaran,0,',','.') , 0 , 1, 'R');
        
        
        $pdf->Output('RekapitulasiTransaksi_' . date('d_m_Y') . '.pdf','D');
    }
    
    function printDetilOneDay($tahunId,$tgl){
        $this->layout = null;
        $datarekap = DB::table('view_transmasuk')->where('tahunajaran_id','=',$tahunId)->where('tanggal','=',date('Y-m-d',strtotime($tgl)))->order_by('tanggal','asc')->get();
        
        /**
         * Printing
         */
        $pdf = new Tcpdf('P','mm','A4',true, 'UTF-8', false);
        // remove default header/footer
        $pdf->setPrintHeader(false);
        
        $pdf->setFooterMargin(10);
        // page setting
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(true, 15);
        
        // add a page
        $pdf->AddPage();
        
        // set header font
        $pdf->SetFont('courier', '', 12);
        // set content
        $pdf->Cell(0, 0, $this->report_title  , 0, 1, 'C');
        $pdf->SetFont('courier', '', 12);
        $pdf->Cell(0, 0, $this->report_sub_title, 0, 1, 'C');
        $pdf->SetFont('courier', '', 8);
        $pdf->Cell(0, 0, $this->report_second_sub_title, 0, 1, 'C');
        $pdf->Cell(0, 0, '', 'B', 1);
        $pdf->ln();
        // content keternagan
        $pdf->SetFont('courier', '', 8);
        $periodestr = 'Tanggal : ' . $tgl;
        $pdf->Cell(($pdf->GetStringWidth($periodestr)+10), 0, $periodestr, 0, 0, 'L');
        $dicetakstr = 'Dicetak tanggal : ' . date('d-m-Y');
        $pdf->Cell(0, 0, $dicetakstr, 0, 1, 'R');
        $pdf->ln();
        //table setting
//        $tb_hd_h = 7;
//        $tb_rw_h = 4;
//        $tb_col_no = 10;
//        $tb_col_nis = 10;
//        $tb_col_by = 35;
//        $tb_col_sw = 65;
//        $tb_col_ket = 20;
//        $tb_col_pd = 25;
//        $tb_col_pg = 25;
        
        $tb_hd_h = 7;
        $tb_rw_h = 4;
        $tb_col_no = 8;
        $tb_col_nis = 8;
        $tb_col_by = 30;
        $tb_col_sw = 55;
        $tb_col_kls = 19;
        $tb_col_ket = 20;
        $tb_col_pd = 25;
        $tb_col_pg = 25;
        
        $pdf->SetFont('courier', 'B', 9);
        // table header
//        $pdf->Cell($tb_col_no, $tb_hd_h, 'NO', 1,0,'C');
//        $pdf->Cell($tb_col_by, $tb_hd_h, 'BIAYA', 1,0,'C');
//        $pdf->Cell($tb_col_nis, $tb_hd_h, 'NIS', 1,0,'C');
//        $pdf->Cell($tb_col_sw, $tb_hd_h, 'SISWA', 1,0,'C');
//        $pdf->Cell($tb_col_ket, $tb_hd_h, 'KET', 1,0,'C');
//        $pdf->Cell($tb_col_pd, $tb_hd_h, 'PENDAPATAN', 1,0,'C');
//        $pdf->Cell($tb_col_pg, $tb_hd_h, 'PENGELUARAN', 1,1,'C');
        
        $pdf->Cell($tb_col_no, $tb_hd_h, 'NO', 1,0,'C');
        $pdf->Cell($tb_col_by, $tb_hd_h, 'BIAYA', 1,0,'C');
        $pdf->Cell($tb_col_nis, $tb_hd_h, 'NIS', 1,0,'C');
        $pdf->Cell($tb_col_sw, $tb_hd_h, 'SISWA', 1,0,'C');
        $pdf->Cell($tb_col_kls, $tb_hd_h, 'ROMBEL', 1,0,'C');
        $pdf->Cell($tb_col_ket, $tb_hd_h, 'KET', 1,0,'C');
        $pdf->Cell($tb_col_pd, $tb_hd_h, 'PENDAPATAN', 1,0,'C');
        $pdf->Cell($tb_col_pg, $tb_hd_h, 'PENGELUARAN', 1,1,'C');
        // table rows
        $rownum = 1;
        $pdf->SetFont('courier', '', 8);
        $pendapatan = 0;
        $pengeluaran = 0;
        $pageHeader = false;
        foreach($datarekap as $dr){
            
            if($rownum == 2){
                if($pageHeader == false){
                    $pdf->setPrintHeader(true);
                    $pdf->SetMargins(10, 15, 10);
                    $pdf->setHeaderFont(array('courier','',7));
                    $pdf->setHeaderMargin(5);
                    $pdf->setHeaderData('', '', 'Rekapitulasi Transaksi Harian','Periode : ' . $tgl );
                    $pageHeader = true;
                }
            }
            
            $pdf->Cell($tb_col_no, $tb_rw_h, $rownum++, 1,0,'R');
            $def_font_size = 8;
            $biayaStr = $dr->jenisbiaya . ($dr->bulan_id ? ' / ' . ucwords($dr->bulan) : '');
            while($pdf->GetStringWidth($biayaStr) >  $tb_col_by){
                $pdf->SetFont('courier', '', $def_font_size--);
            }
            $pdf->Cell($tb_col_by, $tb_rw_h, $biayaStr, 1,0,'L');
            //kembalikan ukuran font
            $pdf->SetFont('courier', '', 8);
            // print Nomor Induk Siswa
            $pdf->Cell($tb_col_nis, $tb_rw_h, $dr->nisn, 1,0,'L');
            //looping untuk menentukan besar kecilnya tulisan
            //looping untuk menentukan besar kecilnya tulisan nama
            $def_font_size = 8;
            while($pdf->GetStringWidth($dr->siswa) >  $tb_col_sw){
                $def_font_size--;
            }            
            $pdf->SetFont('courier', '', $def_font_size);
            $pdf->Cell($tb_col_sw, $tb_rw_h, ($dr->siswa != '' ? $dr->siswa : '-'), 1,0,'L');
            
            //--CETAK KOLOM ROMBEL----------------------------------
                $def_font_size = 8;
                $rombelsiswa = DB::table('rombelsiswa')
                            ->where('siswa_id','=',$dr->siswa_id)
                            ->where('tahunajaran_id','=',$dr->tahunajaran_id)
                            ->first();
                $rombelnya=null;
                if($rombelsiswa){
                    $rombelnya = Rombel::find($rombelsiswa->rombel_id);
                    while($pdf->GetStringWidth(substr($rombelnya->nama,0,10)) >  $tb_col_kls){
                        $pdf->SetFont('courier', '', $def_font_size--);
                    } 
                }            
                $pdf->Cell($tb_col_kls, $tb_rw_h, ($rombelnya ? substr($rombelnya->nama,0,10) : '-'), 1,0,'L');
            //------------------------------------------------------
            
            //looping untuk menentukan besar kecilnya tulisan
            $def_font_size = 8;
            while($pdf->GetStringWidth($dr->ket) >  $tb_col_ket){
                $pdf->SetFont('courier', '', $def_font_size--);
            }            
            $pdf->Cell($tb_col_ket, $tb_rw_h, ($dr->ket != '' ? $dr->ket : '-'), 1,0,'L');
            
            //kembalikan ukuran font
            $pdf->SetFont('courier', '', 8);
            $pdf->Cell($tb_col_pd, $tb_rw_h, ($dr->arus == 'M' ? number_format($dr->jumlah,0,',','.') : '-'), 1,0,'R');
            $pdf->Cell($tb_col_pg, $tb_rw_h, ($dr->arus == 'K' ? number_format($dr->jumlah,0,',','.') : '-'), 1,1,'R');
            
            if($dr->arus == 'M'){
                $pendapatan += $dr->jumlah;
            }else{
                $pengeluaran += $dr->jumlah;
            } 
        }    
        // row grand total
        $pdf->SetFont('courier', 'B', 9);
        $pdf->Cell($tb_col_no + $tb_col_nis + $tb_col_by + $tb_col_ket + $tb_col_sw + $tb_col_kls, $tb_rw_h, 'TOTAL', 1,0,'C');
        $pdf->Cell($tb_col_pd, $tb_rw_h, number_format($pendapatan,0,',','.') , 1,0,'R');
        $pdf->Cell($tb_col_pg, $tb_rw_h, number_format($pengeluaran,0,',','.') , 1,1,'R');
        
        //print keterangan
        $pdf->ln(5);
        $pdf->Cell(0, 0, 'K E T E R A N G A N' , 0 , 1, 'L');
        $pdf->ln();
        $pdf->Cell(50, 0, 'PENDAPATAN' , 0 , 0, 'L'); $pdf->Cell(10, 0, 'Rp.' , 0 , 0, 'R'); $pdf->Cell(50, 0, number_format($pendapatan,0,',','.') , 0 , 1, 'R');
        $pdf->Cell(50, 0, 'PENGELUARAN' , 0 , 0, 'L'); $pdf->Cell(10, 0, 'Rp.' , 0 , 0, 'R'); $pdf->Cell(50, 0, number_format($pengeluaran,0,',','.') , 'B' , 1, 'R');
        $pdf->Cell(50, 0, 'S E L I S I H' , 0 , 0, 'L'); $pdf->Cell(10, 0, 'Rp.' , 0 , 0, 'R'); $pdf->Cell(50, 0, number_format($pendapatan - $pengeluaran,0,',','.') , 0 , 1, 'R');
        
        $pdf->Output('RekapitulasiTransaksi_' . date('d_m_Y') . '.pdf','D');
    }
    
    public function get_printdetil($tahunId,$awal,$akhir){
        if($awal == $akhir){
            $this->printDetilOneDay($tahunId, $awal);
        }else{
                $this->layout = null;
                $datarekap = DB::table('view_transmasuk')
                            ->where('tahunajaran_id','=',$tahunId)
                            ->where_between('tanggal',date('Y-m-d',strtotime($awal)),date('Y-m-d',strtotime($akhir)))
                            ->order_by('tanggal','asc')
                            ->get();

                /**
                 * Printing
                 */
                $pdf = new Tcpdf('P','mm','A4',true, 'UTF-8', false);
                // remove default header/footer
                $pdf->setPrintHeader(false);

                $pdf->setFooterMargin(10);
                // page setting
                $pdf->SetMargins(10, 10, 10);
                $pdf->SetAutoPageBreak(true, 15);

                // add a page
                $pdf->AddPage();

                // set header font
                $pdf->SetFont('courier', '', 12);
                // set content
                $pdf->Cell(0, 0, $this->report_title  , 0, 1, 'C');
                $pdf->SetFont('courier', '', 12);
                $pdf->Cell(0, 0, $this->report_sub_title, 0, 1, 'C');
                $pdf->SetFont('courier', '', 8);
                $pdf->Cell(0, 0, $this->report_second_sub_title, 0, 1, 'C');
                $pdf->Cell(0, 0, '', 'B', 1);
                $pdf->ln(5);
                // content keternagan
                $pdf->SetFont('courier', '', 8);
                $periodestr = 'Periode : ' . $awal . ' / ' . $akhir;
                $pdf->Cell(($pdf->GetStringWidth($periodestr)+10), 0, $periodestr, 0, 0, 'L');
                $dicetakstr = 'Dicetak tanggal : ' . date('d-m-Y');
                $pdf->Cell(0, 0, $dicetakstr, 0, 1, 'R');
                $pdf->ln();
                //table setting
                $tb_hd_h = 7;
                $tb_rw_h = 4;
                $tb_col_no = 8;
                $tb_col_nis = 8;
                $tb_col_tgl = 15;
                $tb_col_by = 30;
                $tb_col_sw = 40;
                $tb_col_kls = 19;
                $tb_col_ket = 20;
                $tb_col_pd = 25;
                $tb_col_pg = 25;
                
                $pdf->SetFont('courier', 'B', 9);
                // table header
                $pdf->Cell($tb_col_no, $tb_hd_h, 'NO', 1,0,'C');
                $pdf->Cell($tb_col_tgl, $tb_hd_h, 'TGL', 1,0,'C');
                $pdf->Cell($tb_col_by, $tb_hd_h, 'BIAYA', 1,0,'C');
                $pdf->Cell($tb_col_nis, $tb_hd_h, 'NIS', 1,0,'C');
                $pdf->Cell($tb_col_sw, $tb_hd_h, 'SISWA', 1,0,'C');
                $pdf->Cell($tb_col_kls, $tb_hd_h, 'ROMBEL', 1,0,'C');
                $pdf->Cell($tb_col_ket, $tb_hd_h, 'KET', 1,0,'C');
                $pdf->Cell($tb_col_pd, $tb_hd_h, 'PENDAPATAN', 1,0,'C');
                $pdf->Cell($tb_col_pg, $tb_hd_h, 'PENGELUARAN', 1,1,'C');
                // table rows
                $rownum = 1;
                $pdf->SetFont('courier', '', 8);
                $pendapatan = 0;
                $pengeluaran = 0;
                $pageHeader = false;
                foreach($datarekap as $dr){
                    
                    //----CETAK PAGE HEADER UNTUK HALAMAN SETELAH HALAMAN 1----------
                        if($rownum == 2){
                            if($pageHeader == false){
                                $pdf->setPrintHeader(true);
                                $pdf->SetMargins(10, 15, 10);
                                $pdf->setHeaderFont(array('courier','',7));
                                $pdf->setHeaderMargin(5);
                                $pdf->setHeaderData('', '', 'Rekapitulasi Transaksi Harian','Periode : ' . $awal . ' / ' . $akhir);
                                $pageHeader = true;
                            }
                        }
                        $pdf->Cell($tb_col_no, $tb_rw_h, $rownum++, 1,0,'R');
                        //ganti ukuran font lebih kecil
                        $pdf->SetFont('courier', '', 6);
                        $pdf->Cell($tb_col_tgl, $tb_rw_h, date('d-m-Y',strtotime($dr->tanggal)), 1,0,'L');
                    //-----------------------------------------------------

                    //--CETAK KOLOM BIAYA---------------------------------
                        $def_font_size = 8;
                        $biayaStr = $dr->jenisbiaya . ($dr->bulan_id ? '/' . ucwords($dr->bulan) : '');
                        while($pdf->GetStringWidth($biayaStr) >  $tb_col_by){
                            $pdf->SetFont('courier', '', $def_font_size--);
                        }
                        $pdf->Cell($tb_col_by, $tb_rw_h, $biayaStr, 1,0,'L');
                    //-----------------------------------------------------
                    
                    //----kembalikan ukuran font---------------------------
                        $pdf->SetFont('courier', '', 8);
                    //-----------------------------------------------------
                    
                    //--CETAK KOLOM NIS------------------------------------
                        $pdf->Cell($tb_col_nis, $tb_rw_h, $dr->nisn, 1,0,'L');
                    //-----------------------------------------------------
                    
                    //--CETAK KOLOM SISWA----------------------------------
                        $def_font_size = 8;
                        while($pdf->GetStringWidth($dr->siswa) >  $tb_col_sw){
                            $pdf->SetFont('courier', '', $def_font_size--);
                        }            
                        $pdf->Cell($tb_col_sw, $tb_rw_h, ($dr->siswa != '' ? $dr->siswa : '-'), 1,0,'L');
                    //-----------------------------------------------------
                        
                    //--CETAK KOLOM ROMBEL----------------------------------
                        $def_font_size = 8;
                        $rombelsiswa = DB::table('rombelsiswa')
                                    ->where('siswa_id','=',$dr->siswa_id)
                                    ->where('tahunajaran_id','=',$dr->tahunajaran_id)
                                    ->first();
                        $rombelnya=null;
                        if($rombelsiswa){
                            $rombelnya = Rombel::find($rombelsiswa->rombel_id);
                            while($pdf->GetStringWidth(substr($rombelnya->nama,0,10)) >  $tb_col_kls){
                                $pdf->SetFont('courier', '', $def_font_size--);
                            } 
                        }            
                        $pdf->Cell($tb_col_kls, $tb_rw_h, ($rombelnya ? substr($rombelnya->nama,0,10) : '-'), 1,0,'L');
                    //------------------------------------------------------
                    
                    //--CETAK KOLOM KETERANGAN----------------------------------
                        $def_font_size = 8;
                        while($pdf->GetStringWidth($dr->ket) >  $tb_col_ket){
                            $pdf->SetFont('courier', '', $def_font_size--);
                        }            
                        $pdf->Cell($tb_col_ket, $tb_rw_h, ($dr->ket != '' ? $dr->ket : '-'), 1,0,'L');
                    //-----------------------------------------------------    
                    
                    //--CETAK KOLOM PENDAPATAN----------------------------------
                        $def_font_size = 8;
                        $pendapatanStr = number_format($dr->jumlah,0,',','.');
                        while($pdf->GetStringWidth($pendapatanStr) >  $tb_col_pd){
                            $def_font_size--;
                        }
                        $pdf->SetFont('courier', '', $def_font_size);
                        $pdf->Cell($tb_col_pd, $tb_rw_h, ($dr->arus == 'M' ? $pendapatanStr : '-'), 1,0,'R');
                    //-----------------------------------------------------
                        
                    //--CETAK KOLOM PENGELUARAN----------------------------------    
                        $def_font_size = 8;
                        $pengeluaranStr = number_format($dr->jumlah,0,',','.');
                        while($pdf->GetStringWidth($pengeluaranStr) >  $tb_col_pd){
                            $def_font_size--;
                        }
                        $pdf->SetFont('courier', '', $def_font_size);
                        $pdf->Cell($tb_col_pd, $tb_rw_h, ($dr->arus == 'K' ? $pengeluaranStr : '-'), 1,1,'R');
                    //-----------------------------------------------------

                    //---TAMPUNG DATA TOTAL PENDAPATAN DAN PENGELUARAN---
                        if($dr->arus == 'M'){
                            $pendapatan += $dr->jumlah;
                        }else{
                            $pengeluaran += $dr->jumlah;
                        } 
                    //-----------------------------------------------------
                }
                //------ END LOOPING CETAK DATA TRANSAKSI --------------------------------
                
                //-----CETAK ROW/BARIS GRAND TOTAL
                    $pdf->SetFont('courier', 'B', 9);
                    $pdf->Cell($tb_col_no + $tb_col_tgl + $tb_col_by + $tb_col_nis + $tb_col_sw + $tb_col_kls + $tb_col_ket, $tb_rw_h, 'TOTAL', 1,0,'C');
                    $pdf->Cell($tb_col_pd, $tb_rw_h, number_format($pendapatan,0,',','.') , 1,0,'R');
                    $pdf->Cell($tb_col_pg, $tb_rw_h, number_format($pengeluaran,0,',','.') , 1,1,'R');
                //-----------------------------------------------------
                
                //-----CETAK ROW/BARIS KETERANGAN--------------------------
                    $pdf->ln(5);
                    $pdf->Cell(0, 0, 'K E T E R A N G A N' , 0 , 1, 'L');
                    $pdf->ln();
                    $pdf->Cell(50, 0, 'PENDAPATAN' , 0 , 0, 'L'); $pdf->Cell(10, 0, 'Rp.' , 0 , 0, 'R'); $pdf->Cell(50, 0, number_format($pendapatan,0,',','.') , 0 , 1, 'R');
                    $pdf->Cell(50, 0, 'PENGELUARAN' , 0 , 0, 'L'); $pdf->Cell(10, 0, 'Rp.' , 0 , 0, 'R'); $pdf->Cell(50, 0, number_format($pengeluaran,0,',','.') , 'B' , 1, 'R');
                    $pdf->Cell(50, 0, 'S E L I S I H' , 0 , 0, 'L'); $pdf->Cell(10, 0, 'Rp.' , 0 , 0, 'R'); $pdf->Cell(50, 0, number_format($pendapatan - $pengeluaran,0,',','.') , 0 , 1, 'R');
                //-----------------------------------------------------

                $pdf->Output('RekapitulasiTransaksi_' . date('d_m_Y') . '.pdf','D');
            
        }
        
    }
    
}
