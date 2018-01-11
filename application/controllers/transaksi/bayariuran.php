<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bayariuran
 *
 * @author Klik
 */
class Transaksi_Bayariuran_Controller extends Base_Controller {
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_transaksi_penerimaan_iuran');
    }
    
    public function get_index(){
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $selecttahunajaran = array();
        foreach($tahunajarans as $ta){
            $selecttahunajaran[$ta->id] = $ta->nama;
        }
        
        $jenisbiaya = Jenisbiaya::where_in('tipe',array('ITB','ITC','IB'))->get();
        $selectbiaya = array();
        foreach($jenisbiaya as $by){
            $selectbiaya[$by->id] = $by->nama;
        }
        
        $appset = Appsetting::first();
        
        $this->layout->nest('content', 'transaksi.bayariuran.index',array(
            'selecttahunajaran'=>$selecttahunajaran,
            'tahunaktif'=>$tahunaktif,
            'selectbiaya'=>$selectbiaya,
            'appset' => $appset
        ));
    }
    
    public function get_dump(){
        $this->layout = null;
        
                
        echo 'dump';
    }
    
    /**
     * Simpan data transaksi
     */
    public function post_new(){
        $this->layout = null;
        
        $trans = json_decode(Input::get('trans'));
        $detiltrans = json_decode(Input::get('detiltrans'));
        
//        echo var_dump($trans);
//        
//        echo '<BR/>';
//        
//        echo var_dump($detiltrans);
//        
//        echo '<BR/>';
        
         //BEGIN TRANSACTION
        DB::connection()->pdo->beginTransaction();
        
            //insert transaksi master
            $transid = DB::table('transmasuk')->insert_get_id(array(
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                'tanggal' => date('Y-m-d',strtotime($trans->tanggal)),
                'tahunajaran_id' => $trans->tahunajaran_id,
                'siswa_id'=> $trans->siswa_id,
                'total'=> $trans->total
            ));
            
            //insert detil transaksi
            for($i=0;$i<count($detiltrans);$i++){
                $jenisbiaya = Jenisbiaya::find($detiltrans[$i]->jenisbiaya_id);
                if ($jenisbiaya->tipe == 'ITB'){
                        DB::table('detiltransmasuk')->insert(array(
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                            'transmasuk_id' => $transid,
                            'jenisbiaya_id' => $detiltrans[$i]->jenisbiaya_id,
                            'bulan_id'=> $detiltrans[$i]->bulan_id,
                            'jumlah'=> $detiltrans[$i]->jumlah,
                            'harus_bayar' => $detiltrans[$i]->harus_bayar,
                            'potongan' => ( isset($detiltrans[$i]->potongan) ? $detiltrans[$i]->potongan : 0),
                            'ket' => (isset($detiltrans[$i]->ket) ? $detiltrans[$i]->ket : null)
                        ));
                }else if($jenisbiaya->tipe == 'ITC'){
                    DB::table('detiltransmasuk')->insert(array(
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                            'transmasuk_id' => $transid,
                            'jenisbiaya_id' => $detiltrans[$i]->jenisbiaya_id,
                            'jumlah'=> $detiltrans[$i]->jumlah,
                            'harus_bayar' => $detiltrans[$i]->harus_bayar,
                            'potongan' => ( isset($detiltrans[$i]->potongan) ? $detiltrans[$i]->potongan : 0),
                            'ket' => (isset($detiltrans[$i]->ket) ? $detiltrans[$i]->ket : null)
                        ));
                }else if($jenisbiaya->tipe == 'IB'){
                    DB::table('detiltransmasuk')->insert(array(
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                            'transmasuk_id' => $transid,
                            'jenisbiaya_id' => $detiltrans[$i]->jenisbiaya_id,
                            'jumlah'=> $detiltrans[$i]->jumlah,
                            'ket' => (isset($detiltrans[$i]->ket) ? $detiltrans[$i]->ket : null)
                        ));
                }
            }
        
         //COMMIT
        DB::connection()->pdo->commit();
        
//        //cetak nota
//        $appset = Appsetting::first();
//        if($appset->cetaknota == 'Y'){
//            $this->cetaknota($transid);
//        }
        
        //return 'ERIES ';
        return $transid;//Redirect::to('transaksi/bayariuran');
    }
    /**
     * Generate sisa spasi dari suatu kata
     * @param type $space
     * @param type $kata
     * @return string
     */
    public function generate_space($space,$kata){
        $res="";
        for($i=0;$i<($space - strlen($kata));$i++){
            $res .= " ";
        }
        
        return $res;
    }
    
    public function get_cetaknota($transid){
            $vtrans = Vtransmasuk::where('id','=',$transid)->first();
            $trans = Transmasuk::with(array('siswa','detiltransmasuks'))->where('id','=',$transid)->first();
            
            $tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
            $file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
            $handle = fopen($file, 'w');
            $condensed = Chr(27) . Chr(33) . Chr(4);
            $bold1 = Chr(27) . Chr(69);
            $bold0 = Chr(27) . Chr(70);
            $initialized = chr(27).chr(64);
            $condensed1 = chr(15);
            $condensed0 = chr(18);
            $tanggaltrans = date('d-m-Y',strtotime($trans->tanggal));
            $appset = Appsetting::first();
            $tahunajaran = Tahunajaran::find($trans->tahunajaran_id);
            $datacetakbaru="";
            $l_no = 3;
            $l_jenis = 10;
            $l_pot = 10;
            $l_bulan = 10;
            $l_jumlah = 10;
            $rowkertas = $appset->linekertas;
            $rowsisa = $rowkertas - 18;
            $spaceprinter = $appset->spaceprinter;
            $jumlahitem = 0;
            $user = Auth::retrieve(Session::get('onuser_id'));
            $total = 0;
            $Data = "";
            $Data  = $initialized;
            $Data .= $condensed1;
            $Data .= $this->generate_space(($appset->charcount - strlen('Tanda Bukti Pembayaran Iuran'))/2,"") . "Tanda Bukti Pembayaran Iuran\n";
            $Data .= $this->generate_space(($appset->charcount - strlen('SD Islam Sabilil Huda'))/2,"") . "SD Islam Sabilil Huda\n";
            $Data .= $this->generate_space(($appset->charcount - strlen('Jl. Singokarso 54 Sumorame, Candi, Sidoarjo'))/2,"") . "Jl. Singokarso 54 Sumorame, Candi, Sidoarjo\n";
            $Data .= $this->generate_space(($appset->charcount - strlen($tahunajaran->nama))/2,"") . $tahunajaran->nama . "\n\n";
            $Data .= "Siswa : " . $trans->siswa->nama . $this->generate_space($appset->charcount - strlen("Siswa : " . $trans->siswa->nama), "Tanggal:" . $tanggaltrans) . "Tanggal:" . $tanggaltrans . "\n";
            $Data .= "NIS   : " . $trans->siswa->nisn  . "\n";
            $rombel = \DB::table('rombelsiswa')
                        ->where('tahunajaran_id','=',$vtrans->tahunajaran_id)
                        ->where('siswa_id','=',$vtrans->siswa_id)
                        ->join('rombel','rombelsiswa.rombel_id','=','rombel.id')
                        ->first(array('rombel.id', 'rombel.nama'));
            $Data .= "Kelas : " . $rombel->nama . "\n";
            $Data .= "--------------------------------------------------------\n";
            $Data .= "No Iuran     Pot       Bulan     " . $this->generate_space($appset->charcount -strlen("No Iuran     Pot       Bulan     "), "Jumlah") . "Jumlah\n";
            $Data .= "--------------------------------------------------------\n";
            $Data .= $datacetakbaru;
            $rownum = 1;
            foreach($trans->detiltransmasuks as $detrans){                
                    $isi_num = $rownum++ .  $this->generate_space($l_no,$rownum);
                    $isi_biaya = $detrans->jenisbiaya->nama . $this->generate_space($l_jenis,$detrans->jenisbiaya->nama);
                    $isi_pot = (isset($detrans->potongan) ? number_format($detrans->potongan, 0, ',', '.') : '-') . $this->generate_space($l_pot,(isset($detrans->potongan) ? number_format($detrans->potongan, 0, ',', '.') : '-'));
                    $isi_bulan = ucwords(($detrans->bulan ? $detrans->bulan->nama : '-')) . $this->generate_space($l_bulan,($detrans->bulan ? $detrans->bulan->nama : '-'));
                    $isi_jumlah = $this->generate_space(($appset->charcount - strlen($isi_num . $isi_biaya . $isi_pot . $isi_bulan)),  number_format($detrans->jumlah, 0, ',', '.')) . number_format($detrans->jumlah, 0, ',', '.');
                        
                $Data .= $isi_num . $isi_biaya . $isi_pot . $isi_bulan . $isi_jumlah . "\n";
                $jumlahitem++;
                $total += $detrans->jumlah;
            }
            $Data .= "--------------------------------------------------------\n";
            $Data .= "TOTAL BAYAR" . $this->generate_space($appset->charcount - strlen("TOTAL BAYAR"),"Rp. " . number_format($total, 0, ',','.')) . "Rp. " . number_format($total, 0, ',','.') . "\n";
            $Data .= "--------------------------------------------------------\n";
            $Data .= $this->generate_space($appset->charcount - strlen('TTD'),"") . "TTD\n";
            $Data .= "\n";
            $Data .= $this->generate_space($appset->charcount - strlen($user->name),"") . $user->name . "\n";
            $Data .= "\n";
            $Data .= $this->generate_space(($appset->charcount - strlen('Nota dianggap sah jika sudah dibubuhi stempel'))/2,"") . "Nota dianggap sah jika sudah dibubuhi stempel\n";
            $Data .= $this->generate_space(($appset->charcount - strlen('dan tanda tangan dari Bagian Keuangan'))/2,"") . "dan tanda tangan dari bagian keuangan\n";
            //sisa kertas
            $entercount  =  $rowsisa - $jumlahitem + $spaceprinter;
            for($i=0;$i<$entercount;$i++){
                $Data.="\n ";
            }

            // return $Data;

            // CETAK NOTA WITH DIREC PRINTING PHP COPY
            $tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
            $file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
            $handle = fopen($file, 'w');
            // echo $Data;
            echo 'print file';
            fwrite($handle, $Data);
            fclose($handle);
            //copy($file, "//localhost/LX-300");  # Lakukan cetak
            copy($file, $appset->printeraddr);  # Lakukan cetak

            // edited on 11/01/2018
            // cek apakah menggunakan win raw print atau copy 
            if($appset->using_winrawprint == 'Y'){
                // using raw printer app
                exec($appset->winrawprint_loc . ' -p "' . $appset->printeraddr . '" '. $file);
                
            }else{
                // using copy
                copy($file, $appset->printeraddr);  # Lakukan cetak                                    
            }

            unlink($file);
            return false;
    }
    public function cetaknota($transid){
            $vtrans = Vtransmasuk::where('id','=',$transid)->first();
            $trans = Transmasuk::with(array('siswa','detiltransmasuks'))->where('id','=',$transid)->first();
            
            $tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
            $file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
            $handle = fopen($file, 'w');
            $condensed = Chr(27) . Chr(33) . Chr(4);
            $bold1 = Chr(27) . Chr(69);
            $bold0 = Chr(27) . Chr(70);
            $initialized = chr(27).chr(64);
            $condensed1 = chr(15);
            $condensed0 = chr(18);
            $tanggaltrans = date('d-m-Y',strtotime($trans->tanggal));
            $appset = Appsetting::first();
            $tahunajaran = Tahunajaran::find($trans->tahunajaran_id);
            $datacetakbaru="";
            $l_no = 3;
            $l_jenis = 10;
            $l_pot = 10;
            $l_bulan = 10;
            $l_jumlah = 10;
            $rowkertas = $appset->linekertas;
            $rowsisa = $rowkertas - 18;
            $spaceprinter = $appset->spaceprinter;
            $jumlahitem = 0;
            $user = Auth::retrieve(Session::get('onuser_id'));
            $total = 0;
            $Data = "";
            $Data  = $initialized;
            $Data .= $condensed1;
            $Data .= $this->generate_space(($appset->charcount - strlen('Tanda Bukti Pembayaran Iuran'))/2,"") . "Tanda Bukti Pembayaran Iuran\n";
            $Data .= $this->generate_space(($appset->charcount - strlen('SD Islam Sabilil Huda'))/2,"") . "SD Islam Sabilil Huda\n";
            $Data .= $this->generate_space(($appset->charcount - strlen('Jl. Singokarso 54 Sumorame, Candi, Sidoarjo'))/2,"") . "Jl. Singokarso 54 Sumorame, Candi, Sidoarjo\n";
            $Data .= $this->generate_space(($appset->charcount - strlen($tahunajaran->nama))/2,"") . $tahunajaran->nama . "\n\n";
            $Data .= "Siswa : " . $trans->siswa->nama . $this->generate_space($appset->charcount - strlen("Siswa : " . $trans->siswa->nama), "Tanggal:" . $tanggaltrans) . "Tanggal:" . $tanggaltrans . "\n";
            $Data .= "NIS   : " . $trans->siswa->nisn  . "\n";
            $rombel = \DB::table('rombelsiswa')
                        ->where('tahunajaran_id','=',$vtrans->tahunajaran_id)
                        ->where('siswa_id','=',$vtrans->siswa_id)
                        ->join('rombel','rombelsiswa.rombel_id','=','rombel.id')
                        ->first(array('rombel.id', 'rombel.nama'));
            $Data .= "Kelas : " . $rombel->nama . "\n";
            $Data .= "--------------------------------------------------------\n";
            $Data .= "No Iuran     Pot       Bulan     " . $this->generate_space($appset->charcount -strlen("No Iuran     Pot       Bulan     "), "Jumlah") . "Jumlah\n";
            $Data .= "--------------------------------------------------------\n";
            $Data .= $datacetakbaru;
            $rownum = 1;
            foreach($trans->detiltransmasuks as $detrans){                
                    $isi_num = $rownum++ .  $this->generate_space($l_no,$rownum);
                    $isi_biaya = $detrans->jenisbiaya->nama . $this->generate_space($l_jenis,$detrans->jenisbiaya->nama);
                    $isi_pot = (isset($detrans->potongan) ? number_format($detrans->potongan, 0, ',', '.') : '-') . $this->generate_space($l_pot,(isset($detrans->potongan) ? number_format($detrans->potongan, 0, ',', '.') : '-'));
                    $isi_bulan = ucwords(($detrans->bulan ? $detrans->bulan->nama : '-')) . $this->generate_space($l_bulan,($detrans->bulan ? $detrans->bulan->nama : '-'));
                    $isi_jumlah = $this->generate_space(($appset->charcount - strlen($isi_num . $isi_biaya . $isi_pot . $isi_bulan)),  number_format($detrans->jumlah, 0, ',', '.')) . number_format($detrans->jumlah, 0, ',', '.');
                        
                $Data .= $isi_num . $isi_biaya . $isi_pot . $isi_bulan . $isi_jumlah . "\n";
                $jumlahitem++;
                $total += $detrans->jumlah;
            }
            $Data .= "--------------------------------------------------------\n";
            $Data .= "TOTAL BAYAR" . $this->generate_space($appset->charcount - strlen("TOTAL BAYAR"),"Rp. " . number_format($total, 0, ',','.')) . "Rp. " . number_format($total, 0, ',','.') . "\n";
            $Data .= "--------------------------------------------------------\n";
            $Data .= $this->generate_space($appset->charcount - strlen('TTD'),"") . "TTD\n";
            $Data .= "\n";
            $Data .= $this->generate_space($appset->charcount - strlen($user->name),"") . $user->name . "\n";
            $Data .= "\n";
            $Data .= $this->generate_space(($appset->charcount - strlen('Nota dianggap sah jika sudah dibubuhi stempel'))/2,"") . "Nota dianggap sah jika sudah dibubuhi stempel\n";
            $Data .= $this->generate_space(($appset->charcount - strlen('dan tanda tangan dari Bagian Keuangan'))/2,"") . "dan tanda tangan dari bagian keuangan\n";
            //sisa kertas
            $entercount  =  $rowsisa - $jumlahitem + $spaceprinter;
            for($i=0;$i<$entercount;$i++){
                $Data.="\n ";
            }
            
            fwrite($handle, $Data);
            fclose($handle);
            copy($file, $appset->printeraddr);  # Lakukan cetak
            unlink($file);
            //return $Data;
            return false;
    }
    
    
    public function get_tahunajaran($id){
        return eloquent_to_json(Tahunajaran::find($id));
    }
    
    public function get_biaya($id){
        return eloquent_to_json(Jenisbiaya::find($id));
    }
    
    public function get_siswa($id){
        return eloquent_to_json(Viewsiswa::find($id));
    }
    
    public function get_siswabynisn($tahunajaranid,$nisn){
        return eloquent_to_json(Viewsiswa::where('nisn','=', $nisn )->where('tahunajaran_id','=',$tahunajaranid)->first());
    }
    
    public function get_viewsiswabynama($tahunajaranid,$nama){
        $listsiswa = Viewsiswa::where('nama','like','%' . $nama . '%')->where('tahunajaran_id','=',$tahunajaranid)->get();
        return View::make('transaksi.bayariuran.ajaxlistsiswa')->with('listsiswa',$listsiswa);
    }
    
    public function get_selectsisabulan($tahunajaranid,$siswaid,$jenisbiayaid){
        $bulan = DB::query('select * from bulan
                where bulan.id not in (select dtm.bulan_id from detiltransmasuk dtm
                inner join transmasuk tm on dtm.transmasuk_id = tm.id
                where tm.siswa_id = ' . $siswaid . ' and tm.tahunajaran_id = ' . $tahunajaranid . ' and dtm.jenisbiaya_id = ' . $jenisbiayaid . ')
                order by posisi asc');
        foreach ($bulan as $bl){
            $selectbulan[$bl->id] = ucwords($bl->nama);
        }
        
        return \Laravel\Form::select('bulan', $selectbulan, null, array('id'=>'selectBulan','class'=>'input-medium'));
    }
    
    public function get_bulan($id){
        return eloquent_to_json(Bulan::find($id));
    }
    
    public function get_ketetapanbiaya($tahunajaranid,$jenisbiayaid,$siswaid){
        $this->layout = null;
        
        if($jenisbiayaid == 1){
            $ket = Viewspp::where('id','=',$siswaid)->where('tahunajaran_id','=',$tahunajaranid)->first();
            //return var_dump($ket[0]);
            return eloquent_to_json($ket);
            //return Response::json($ket[0]);
        }else{
            $tahunajaran = Tahunajaran::find($tahunajaranid);
            $siswa = Siswa::find($siswaid);
            $jenjang = $siswa->rombels()->where('tahunajaran_id','=',$tahunajaranid)->first()->jenjang;
            $ket = $tahunajaran->ketetapanbiaya()->where('jenisbiaya_id','=',$jenisbiayaid)->where('jenjang','=',$jenjang)->first();
            return eloquent_to_json($ket->pivot);
        }
    }
    
    public function get_potongan($tahunajaranid,$jenisbiayaid,$siswaid,$bulanid=null){
        $this->layout = null;
        
        $jenisbiaya = Jenisbiaya::find($jenisbiayaid);
        $siswa = Siswa::find($siswaid);
        $pot;
        if($jenisbiaya->tipe == 'ITB'){
            $pot = $siswa->potonganiuran()->where('tahunajaran_id','=',$tahunajaranid)->where('bulan_id','=',$bulanid)->where('jenisbiaya_id','=',$jenisbiayaid)->first()->pivot;
        }else{
            $pot = $siswa->potonganiuran()->where('tahunajaran_id','=',$tahunajaranid)->where('jenisbiaya_id','=',$jenisbiayaid)->first()->pivot;
        }
        
        return eloquent_to_json($pot);
        //return eloquent_to_json($pot);
    }
    
    public function get_sudahbayar($tahunajaranid, $jenisbiayaid,$siswaid){
        $this->layout = null;
        $jumlah = Vtransmasuk::where('tahunajaran_id','=',$tahunajaranid)
                ->where('jenisbiaya_id','=',$jenisbiayaid)
                ->where('siswa_id','=',$siswaid)
                ->sum('jumlah');
        $jumlahres = '{"jumlah":' . ($jumlah == '' ? '"0"' : '"'.$jumlah.'"') . '}';
        return ($jumlah == '' ? '0' : $jumlah);
    }
    
    public function get_turnon(){
        $appset = Appsetting::first();
        $appset->cetaknota = 'Y';
        $appset->save();
        
        return Redirect::to('transaksi/bayariuran');
    }
    
    public function get_turnoff(){
        $appset = Appsetting::first();
        $appset->cetaknota = 'N';
        $appset->save();
        
        return Redirect::to('transaksi/bayariuran');
    }
    
}
