<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of histori
 *
 * @author root
 */
class Transaksi_Histori_Controller extends Base_Controller {
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_histori_transaksi');
    }
    
    public function get_index(){
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $tahunajaranselect = array();
        foreach($tahunajarans as $ta){
            $tahunajaranselect[$ta->id] = $ta->nama;
        }
        $appset = Appsetting::first();
        
        $this->layout->nest('content', 'transaksi.histori.index',array('tahunajarans'=>$tahunajarans,'tahunaktif'=>$tahunaktif,'tahunajaranselect'=>$tahunajaranselect,'appset'=>$appset));
    }
    
    public function get_ajaxtransaksi($tahunajaranid,$awal,$akhir){
        $trans = Transmasuk::with('detiltransmasuks')
                ->where('tahunajaran_id','=',$tahunajaranid)
                ->where('tanggal','>=',date('Y-m-d',strtotime($awal)))
                ->where('tanggal','<=',date('Y-m-d',strtotime($akhir)))
                ->get();
        return View::make('transaksi.histori.ajaxtransaksi')->with('trans',$trans);
    }
    
    public function get_detilhistori($transaksi_id){
        $detiltrans = Detiltransmasuk::with(array('transmasuk','jenisbiaya','bulan'))->where('transmasuk_id','=',$transaksi_id)->get();
        return View::make('transaksi.histori.ajaxdetiltransaksi')->with('detiltrans',$detiltrans);
    }
    
    public function post_canceldetil(){
        $detiltrans = Detiltransmasuk::find(Input::get('id'));
        $detiltrans->delete();
        
        $detilcount = Detiltransmasuk::where('transmasuk_id','=',Input::get('transmasuk_id'))->count();
        if ($detilcount < 1){
            $transmasuk = Transmasuk::find(Input::get('transmasuk_id'));
            $transmasuk->delete();
        }
        
        return Laravel\Redirect::to('transaksi/histori');
    }
    
    public function get_deletetrans(){
        $transid = Input::get('trans_id');
        //BEGIN TRANSACTION
        DB::connection()->pdo->beginTransaction();
            //delete detils
            DB::query('delete from detiltransmasuk where transmasuk_id = ' . $transid);
            //delete transmasuk 
            DB::query('delete from transmasuk where id = ' . $transid);
         //COMMIT
        DB::connection()->pdo->commit();
        
        return Laravel\Redirect::to('transaksi/histori');
    }
    
    public function post_cetaknota(){
            $transid = Input::get('trans_id');
            $vtrans = Vtransmasuk::where('id','=',$transid)->get();
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
            $Data .= "Siswa : " . $trans->siswa->nama  . "\n";
            $Data .= "NIS   : " . $trans->siswa->nisn . $this->generate_space($appset->charcount - strlen("NIS   : " . $trans->siswa->nisn), "Tanggal:" . $tanggaltrans) . "Tanggal:" . $tanggaltrans . "\n";
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
            
            return true;
    }

    public function post_cetaknotadirect(){
        $transid = Input::get('trans_id');
            $vtrans = Vtransmasuk::where('id','=',$transid)->get();
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
            $Data .= "Siswa : " . $trans->siswa->nama  . "\n";
            $Data .= "NIS   : " . $trans->siswa->nisn . $this->generate_space($appset->charcount - strlen("NIS   : " . $trans->siswa->nisn), "Tanggal:" . $tanggaltrans) . "Tanggal:" . $tanggaltrans . "\n";
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

            // echo $Data;

            $tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
            $file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
            $handle = fopen($file, 'w');
            // $condensed = Chr(27) . Chr(33) . Chr(4);
            // $bold1 = Chr(27) . Chr(69);
            // $bold0 = Chr(27) . Chr(70);
            // $initialized = chr(27).chr(64);
            // $condensed1 = chr(15);
            // $condensed0 = chr(18);
            // $Data  = $initialized;
            // $Data .= $condensed1;
            // $Data .= "================================================================================\n";
            // $Data .= "  ".$bold1."UD Hasil Mancing".$bold0."      |\n";
            // $Data .= "  ".$bold1."Ngaban Rt 5 RW 2 ".$bold0."      |\n";
            // $Data .= "  ".$bold1."Tanggulangin, Sidoarjo 61272".$bold0."      |\n";
            // $Data .= "================================================================================\n";
            // $Data .= "Kepada : " . $data->customer . " \n";
            // $Data .= "Pekerjaan : " . $data->pekerjaan . "\n";
            // $Data .= "Alamat : " . $data->alamat_pekerjaan . ', ' . $data->desa . "\n";
            // $Data .= "         " . $data->kecamatan . ', ' . $data->kabupaten . "\n";
            
            // $Data .= "--------------------------\n";

            // echo $Data;
            echo 'print file';
            fwrite($handle, $Data);
            fclose($handle);
            //copy($file, "//localhost/LX-300");  # Lakukan cetak
            copy($file, $appset->printeraddr);  # Lakukan cetak
            unlink($file);
    }
    
    public function post_cetaknotajzebra(){
            $transid = Input::get('trans_id');
            $vtrans = Vtransmasuk::where('id','=',$transid)->get();
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
            $Data .= "Siswa : " . $trans->siswa->nama  . "\n";
            $Data .= "NIS   : " . $trans->siswa->nisn . $this->generate_space($appset->charcount - strlen("NIS   : " . $trans->siswa->nisn), "Tanggal:" . $tanggaltrans) . "Tanggal:" . $tanggaltrans . "\n";
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
            
//            fwrite($handle, $Data);
//            fclose($handle);
//            copy($file, $appset->printeraddr);  # Lakukan cetak
//            unlink($file);
            return $Data;
    }
    
    public function generate_space($space,$kata){
        $res="";
        for($i=0;$i<($space - strlen($kata));$i++){
            $res .= " ";
        }
        
        return $res;
    }
    
    
}
