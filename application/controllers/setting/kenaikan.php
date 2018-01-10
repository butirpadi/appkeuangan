<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kenaikan
 *
 * @author Klik
 */
class Setting_Kenaikan_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_kenaikan_siswa');
    }

    public function get_index() {
        $tahunaktif = Tahunajaran::where('aktif', '=', 'Y')->first();
        $tahunajarans = Tahunajaran::all();
        $selecttahun = array();
        foreach ($tahunajarans as $tahun) {
            $selecttahun[$tahun->id] = $tahun->nama;
        }
        $rombels = Rombel::all();
        $selectrombel = array();
        foreach ($rombels as $rom) {
            $selectrombel[$rom->id] = $rom->nama;
        }
        $this->layout->nest('content', 'setting.kenaikan.index', array(
            'tahunaktif' => $tahunaktif,
            'selecttahun' => $selecttahun,
            'selectrombel' => $selectrombel
        ));
    }

    /**
     * mengembalikan data siswa per jenjang per tahunajaran
     */
    public function get_ajaxdata($tahunajaran_id, $jenjang) {
        $this->layout = null;
        $tahunajaran = Tahunajaran::find($tahunajaran_id);
        $rombels = Rombel::where('jenjang', '=', $jenjang)->get();
        $arrrombel = array();
        foreach ($rombels as $rom) { //data rombel dengan jenjang tersebut di convert ke array
            $arrrombel[count($arrrombel)] = $rom->id;
        }
        if ($jenjang < 6) {
            $rombellanjut = Rombel::where_in('jenjang', array($jenjang, $jenjang + 1))->order_by('jenjang', 'desc')->get();
        } else {
            $rombellanjut = Rombel::where('jenjang', '=', 0)->get();
        }

        $selectrombel = array();
        foreach ($rombellanjut as $rom) {
            $selectrombel[$rom->id] = $rom->nama;
        }
        //$siswas = $tahunajaran->siswas()->where_in('rombel_id',$arrrombel)->get();
        $siswas = $tahunajaran->siswas()->where_in('rombel_id', $arrrombel)->order_by('nisn', 'asc')->get();

        $tahunlanjut = Tahunajaran::where('posisi', '=', $tahunajaran->posisi + 1)->first();

        return View::make('setting.kenaikan.ajaxdata')
                        ->with('siswas', $siswas)
                        ->with('selectrombel', $selectrombel)
                        ->with('tahunlanjut', $tahunlanjut)
                        ->with('tahunajaran', $tahunajaran);
    }

    public function get_tahunajaranlanjut($tahunajaran_id) {
        $tahunajaran = Tahunajaran::find($tahunajaran_id);
        $tahunlanjut = Tahunajaran::where('posisi', '=', $tahunajaran->posisi + 1)->first();
        return eloquent_to_json($tahunlanjut);
    }

    public function post_naik() {

        DB::connection()->pdo->beginTransaction();

        $tahunlanjut = Input::get('tahunlanjut');
        $siswaid = Input::get('siswa');
        $rombelid = Input::get('rombel');

        $siswa = Siswa::find($siswaid);
        $rombel = Rombel::find($rombelid);
        $siswa->rombels()->pivot()->where('tahunajaran_id', '=', $tahunlanjut)->delete(); //delete dulu jika sebelumnya sudah diset
        $siswa->rombels()->attach($rombel, array('tahunajaran_id' => $tahunlanjut)); //insert data baru
        //jenjang_spp juga dinaikkan
        $jenjang_spp_lalu = $siswa->jenjang_spp;
        $jenjang_spp_baru = $jenjang_spp_lalu + 1;
        $siswa->jenjang_spp = $jenjang_spp_baru;
        $siswa->save();
        
        //commit
        DB::connection()->pdo->commit();
        
        return true;
    }

    public function get_cobanaik($tahunnya, $siswanya, $rombelnya) {
        $this->layout = null;
        $tahunlanjut = $tahunnya;
        $siswaid = $siswanya;
        $rombelid = $rombelnya;

        $siswa = Siswa::find($siswaid);
        $rombel = Rombel::find($rombelid);
        $siswa->rombels()->where('tahunajaran_id', '=', $tahunlanjut)->delete(); //delete dulu jika sebelumnya sudah diset
        $siswa->rombels()->attach($rombel, array('tahunajaran_id' => $tahunlanjut));
    }

    public function get_printtopdf($tahunajaran_id, $jenjang) {
        $this->layout = null;
        $tahunajaran = Tahunajaran::find($tahunajaran_id);
        $rombels = Rombel::where('jenjang', '=', $jenjang)->get();
        $arrrombel = array();
        foreach ($rombels as $rom) { //data rombel dengan jenjang tersebut di convert ke array
            $arrrombel[count($arrrombel)] = $rom->id;
        }
        if ($jenjang < 6) {
            $rombellanjut = Rombel::where('jenjang', '=', $jenjang + 1)->get();
        } else {
            $rombellanjut = Rombel::where('jenjang', '=', 0)->get();
        }

        $selectrombel = array();
        foreach ($rombellanjut as $rom) {
            $selectrombel[$rom->id] = $rom->nama;
        }
        $siswas = $tahunajaran->siswas()->where_in('rombel_id', $arrrombel)->get();

        $tahunlanjut = Tahunajaran::where('posisi', '=', $tahunajaran->posisi + 1)->first();

        //generate PDF
        //pre defined
        //set report header setting
        $setting = Setting::first();
        $namasekolah = $setting->nama_skul;
        $alamat = $setting->alamat_skul;
        $namareport = 'Daftar Pembagian Kelas Siswa Jenjang ' . $jenjang . '-SD ke ' . ($jenjang + 1) . '-SD';
        $isFirstPage = true;
        $tglcetak = date('d-m-Y [H:m:s]');

        //set column with variables
        $colnum = 10;
        $colsiswa = 95;
        $colrombel = 45;
        $colnaik = 45;

        $pdf = new Fpdf('P', 'mm', array(215, 330));
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        //create page header
        $pdf->SetFont('Courier', 'B', 16);
        $pdf->Cell(0, 8, $namareport, 0, 1, 'C');
        $pdf->SetFont('Courier', '', 12);
        $pdf->Cell(0, 5, $namasekolah, 0, 1, 'C');
        $pdf->SetFont('Courier', '', 10);
        $pdf->Cell(0, 5, $alamat, 0, 1, 'C');
        $pdf->Cell(0, 2, '', 'B', 1);
        $pdf->Cell(0, 0.1, '', 'B', 1);
        $pdf->Cell(0, 0.1, '', 'B', 1);
        $pdf->Cell(0, 1, '', 'B', 1);
        $pdf->ln(5);
        //create report header
        $pdf->Cell(155, 5, 'Tahun Ajaran        : ' . $tahunlanjut->nama, 0, 0, 'L');
        $pdf->Cell(155, 5, 'Dicetak pada        : ' . $tglcetak, 0, 1, 'R');
        $pdf->ln(5);
        //create table header
        $pdf->SetFont('Courier', '', 12);
        $pdf->Cell($colnum, 10, 'NO', 1, 0, 'C');
        $pdf->Cell($colsiswa, 10, 'Siswa', 1, 0, 'C');
        $pdf->Cell($colrombel, 10, 'Rombel', 1, 0, 'C');
        $pdf->Cell($colnaik, 10, 'Naik ke', 1, 0, 'C');
        $pdf->ln();

        //create content
        $pdf->SetFont('Courier', '', 10);
        $rownum = 1;
        $yAxis = 65;
        $totm = 0;
        $totk = 0;


        foreach ($siswas as $sis) {
            $pdf->SetFont('Courier', '', 10);

            $pdf->Cell($colnum, 5, $rownum++, 1, 0, 'R');
            $pdf->Cell($colsiswa, 5, ucwords(strtolower($sis->nama)), 'B', 0, 'L');
            $pdf->Cell($colrombel, 5, $sis->rombels()->where('tahunajaran_id', '=', $tahunajaran->id)->first()->nama, 1, 0, 'L');
            //cetak rombel lanjut jika sudah diset
            $rombellanjut = $sis->rombels()->where('tahunajaran_id', '=', $tahunlanjut->id)->first();
            if ($rombellanjut != null) {
                $pdf->Cell($colnaik, 5, $rombellanjut->nama, 1, 0, 'L');
            } else {
                $pdf->Cell($colnaik, 5, '', 1, 0, 'L');
            }
            $pdf->ln();

            //new page setting
            $yAxis += 10;
            if ($isFirstPage) {
                $batasAkhirAxis = 570;
            } else {
                $batasAkhirAxis = 620;
            }
            if ($yAxis > $batasAkhirAxis) {
                //add new page
                $pdf->AddPage();
                //sub header
//                $pdf->SetFont('Courier','',10);
//                $pdf->Cell($colnum+$colsiswa+$coltgl+$colm,10,$namareport . '  (' . $tglcetak . ') ',0,0,'L'); //page number
//                $pdf->Cell($colk,10,'Page ' . $pdf->PageNo(),0,1,'R'); //page number
                //create table header
                $pdf->SetFont('Courier', '', 12);
                $pdf->Cell($colnum, 14, 'NO', 1, 0, 'C');
                $pdf->Cell($colsiswa, 14, 'Siswa', 1, 0, 'C');
                $pdf->Cell($colrombel, 7, 'Rombel', 'T', 0, 'C');
                $pdf->Cell($colnaik, 14, 'Naik ke', 1, 0, 'C');
                $pdf->ln();

                $yAxis = 65;
                $isFirstPage = false;
            }
        }

        $pdf->Output('daftarkenaikansiswa_' . date('dmY') . '.pdf', 'D');
    }

}
