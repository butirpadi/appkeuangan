<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of iuran
 *
 * @author root
 */
class Transaksi_Iuran_Controller extends Base_Controller {
    
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
        $tahunajaranselect = array();
        foreach($tahunajarans as $ta){
            $tahunajaranselect[$ta->id] = $ta->nama;
        }
        
        $jenisbiaya = Jenisbiaya::where_in('tipe',array('ITB','ITC','IB'))->get();
        $biayaselect = array();
        foreach($jenisbiaya as $by){
            $biayaselect[$by->id] = $by->nama;
        }
        
        $appset = Appsetting::first();
        
        $this->layout->nest('content', 'transaksi.iuran.index',array(
            'tahunajaranselect'=>$tahunajaranselect,
            'tahunaktif'=>$tahunaktif,
            'biayaselect'=>$biayaselect,
            'appset' => $appset
        ));
    }
    
    public function get_jsonsiswabynisn($tahunajaranid,$nisn){
        $siswa = Vsiswa::where('tahunajaran_id','=',$tahunajaranid)->where('nisn','=',$nisn)->first();
        if ($siswa){
            return eloquent_to_json($siswa);
        }else{
            return '"null"';
        }
    }
    
    public function get_listsiswabynama(){
        $siswa = Vsiswa::where('siswa','like','%'.Input::get('nama').'%')->where('tahunajaran_id','=',Input::get('tahunajaranid'))->get();
        return View::make('transaksi.iuran.ajaxlistsiswa')->with('listsiswa',$siswa);
        
    }
    
    public function get_jsonketentuanbiaya($tahunajaranid,$jenisbiayaid,$tipe,$jenjang='all'){
        if($tipe == 'ITC' || $tipe == 'ITB'){
             $jenisbiaya  = Jenisbiaya::find($jenisbiayaid);
        
            if ($jenisbiaya->perjenjang == 'Y'){
                $ket = Ketentuanbiaya::where('tahunajaran_id','=',$tahunajaranid)
                        ->where('jenisbiaya_id','=',$jenisbiayaid)
                        ->where('jenjang','=',$jenjang)
                        ->first();
            }else{
                $ket = Ketentuanbiaya::where('tahunajaran_id',$tahunajaranid)
                        ->where('jenisbiaya_id','=',$jenisbiayaid)
                        ->first();
            }
        }else if($tipe == 'BTBI'){
            $ket = Ketentuanbiaya::where('tahunajaran_id','=',$tahunajaranid)
                ->where('jenisbiaya_id','=',$jenisbiayaid)
                ->first();
        }
        
        if($ket){
            return eloquent_to_json($ket);
        }else{
            return json_encode('null');
        }
    }
    
    public function get_jsonCekCicilanITC($tahunajaran_id,$siswa_id,$jenisbiaya_id){
        $trans = Vtransmasuk::where('tahunajaran_id','=',$tahunajaran_id)
                ->where('siswa_id','=',$siswa_id)
                ->where('jenisbiaya_id','=',$jenisbiaya_id)
                ->sum('jumlah');
        $jumlah = '{"jumlah":' . $trans .'}';
        if ($trans){
            return json_encode($trans);            
        }else{
            return '"0"';
        }
    }
    
    public function get_jsnGetBiaya($biaya_id){
        $biaya = Jenisbiaya::find($biaya_id);
        if ($biaya){
            return eloquent_to_json($biaya);
        }else{
            return '"null"';
        }
        
    }
    
    public function get_ajaxSisaBulanSelectITB($tahunajaran_id,$jenisbiaya_id,$siswa_id){
        $bulan = DB::query('select * from bulan
                where bulan.id not in (select dtm.bulan_id from detiltransmasuk dtm
                inner join transmasuk tm on dtm.transmasuk_id = tm.id
                where tm.siswa_id = ' . $siswa_id . ' and tm.tahunajaran_id = ' . $tahunajaran_id . ' and dtm.jenisbiaya_id = ' . $jenisbiaya_id . ')
                order by posisi asc');
        foreach ($bulan as $bl){
            $bulanselect[$bl->id] = ucwords($bl->nama);
        }
        
        return \Laravel\Form::select('bulan', $bulanselect, null, array('id'=>'selectBulan','class'=>'input-medium'));
    }
    
    public function post_inserttrans(){
        $this->layout = null;        
        
        $rawDataTrans = Input::get('datatrans');
        $dataTrans = json_decode($rawDataTrans);
        
        $rawDetilTrans = Input::get('detiltrans');
        $detilTrans = json_decode($rawDetilTrans);
        
        $siswa = Siswa::find($dataTrans->siswaid);
                
        $datacetak = '';
        $rownum=1;
        $total = 0;
     
        //insert data transaksi
        DB::connection()->pdo->beginTransaction();
                
            //insert data master transaksi
            $trans_id = DB::table('transmasuk')->insert_get_id(array(
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                'tahunajaran_id'=>$dataTrans->tahunajaranid,
                'siswa_id'=>(isset($dataTrans->siswaid) ? $dataTrans->siswaid : null),
                'tanggal'=> date('Y-m-d',strtotime($dataTrans->tanggal))
                
            ));
            
            //ketetapan jumlah space dari kolom untuk data cetak
                $appset = Appsetting::first();
                $tahunajaran = Tahunajaran::find($dataTrans->tahunajaranid);
                $datacetakbaru="";
                $l_no = 3;
                $l_jenis = 18;
                $l_bulan = 12;
                $l_jumlah = 10;
                $rowkertas = $appset->linekertas;
                $rowsisa = $rowkertas - 18;
                $spaceprinter = $appset->spaceprinter;
                $jumlahitem = 0;
                $user = Auth::retrieve(Session::get('onuser_id'));
                
            //insert detil transaksi    
            foreach($detilTrans->detiltrans as $dt){
                $jenisbiaya = Jenisbiaya::find($dt->biayaid);
                $no="";
                $jenis="";
                $bulan="";
                $jumlah="";
                
                if ($jenisbiaya->tipe == 'ITB'){
                    DB::table('detiltransmasuk')->insert(array(
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                        'transmasuk_id' => $trans_id,
                        'jenisbiaya_id' => $dt->biayaid,
                        'bulan_id'=> $dt->bulanid,
                        'jumlah'=> $dt->jumlah
                    ));
                    
                    //total data cetak
                    $total += $dt->jumlah;
                    //seharusnya pake rownum++ tapi karena diatas sudah dilakukan maka tidak usah lagi
                    $no = $rownum++;
                    $jenis = $jenisbiaya->nama;
                    $bulannya = Bulan::find($dt->bulanid);
                    $bulan = ($bulannya ? ucwords($bulannya->nama) : '-');
                    $jumlah = number_format($dt->jumlah, 0, ',','.');
                    
                    $datacetakbaru .= $no . $this->generate_space($l_no,$no) . $jenis . $this->generate_space($l_jenis,$jenis) . $bulan . $this->generate_space($l_bulan,$bulan) . $this->generate_space(($appset->charcount - strlen($no . $this->generate_space($l_no,$no) . $jenis . $this->generate_space($l_jenis,$jenis) . $bulan . $this->generate_space($l_bulan,$bulan))),$jumlah) . $jumlah .  "\n";
                    
                }else if($jenisbiaya->tipe == 'ITC' || $jenisbiaya->tipe == 'IB'){
                    DB::table('detiltransmasuk')->insert(array(
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                        'transmasuk_id' => $trans_id,
                        'jenisbiaya_id' => $dt->biayaid,
                        'jumlah'=> $dt->jumlah,
                        'ket' => ($dt->keterangan ? $dt->keterangan : 'NULL')
                    ));
                    
                    //total data cetak
                    $total += $dt->jumlah;
                    //seharusnya pake rownum++ tapi karena diatas sudah dilakukan maka tidak usah lagi
                    $no = $rownum;
                    $jenis = $jenisbiaya->nama;
                    $bulan = "-";
                    $jumlah = number_format($dt->jumlah, 0, ',','.');
                    
                    $datacetakbaru .= $no . $this->generate_space($l_no,$no) . $jenis . $this->generate_space($l_jenis,$jenis) . $bulan . $this->generate_space($l_bulan,$bulan) . $this->generate_space($l_jumlah,$jumlah) . $jumlah . "\n";
                }
                
                $jumlahitem +=1;
            }

        //COMMIT
        DB::connection()->pdo->commit();
                  
            
        //----------------CETAK NOTA ---------------
        if($appset->cetaknota == 'Y'){
            //cetak nota
            $tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
            $file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
            $handle = fopen($file, 'w');
            $condensed = Chr(27) . Chr(33) . Chr(4);
            $bold1 = Chr(27) . Chr(69);
            $bold0 = Chr(27) . Chr(70);
            $initialized = chr(27).chr(64);
            $condensed1 = chr(15);
            $condensed0 = chr(18);
            $tanggaltrans = date('d-m-Y',strtotime($dataTrans->tanggal));
            $Data = "";
            $Data  = $initialized;
            $Data .= $condensed1;
            $Data .= $this->generate_space(($appset->charcount - strlen('Tanda Bukti Pembayaran Iuran'))/2,"") . "Tanda Bukti Pembayaran Iuran \n";
            $Data .= $this->generate_space(($appset->charcount - strlen('SD Islam Sabilil Huda'))/2,"") . "SD Islam Sabilil Huda \n";
            $Data .= $this->generate_space(($appset->charcount - strlen('Jl. Singokarso 54 Sumorame, Candi, Sidoarjo'))/2,"") . "Jl. Singokarso 54 Sumorame, Candi, Sidoarjo\n";
            $Data .= $this->generate_space(($appset->charcount - strlen($tahunajaran->nama))/2,"") . $tahunajaran->nama . " \n \n";
            $Data .= "Siswa : " . $siswa->nama  . "\n";
            $Data .= "NIS   : " . $siswa->nisn . $this->generate_space($appset->charcount - strlen("NIS   : " . $siswa->nisn), "Tanggal:" . $tanggaltrans) . "Tanggal:" . $tanggaltrans . " \n";
            $Data .= "-------------------------------------------------------- \n";
            $Data .= "No Jenis Iuran       Bulan" . $this->generate_space($appset->charcount -strlen("No Jenis Iuran       Bulan"), "Jumlah") . "Jumlah \n";
            $Data .= "-------------------------------------------------------- \n";
            $Data .= $datacetakbaru;
            $Data .= "-------------------------------------------------------- \n";
            $Data .= "TOTAL BAYAR" . $this->generate_space($appset->charcount - strlen("TOTAL BAYAR"),"Rp. " . number_format($total, 0, ',','.')) . "Rp. " . number_format($total, 0, ',','.') . " \n";
            $Data .= "-------------------------------------------------------- \n";
            $Data .= $this->generate_space($appset->charcount - strlen('TTD'),"") . "TTD \n";
            $Data .= "\n";
            $Data .= $this->generate_space($appset->charcount - strlen($user->name),"") . $user->name . " \n";
            $Data .= " \n";
            $Data .= $this->generate_space(($appset->charcount - strlen('Nota dianggap sah jika sudah dibubuhi stempel'))/2,"") . "Nota dianggap sah jika sudah dibubuhi stempel \n";
            $Data .= $this->generate_space(($appset->charcount - strlen('dan tanda tangan dari Bagian Keuangan'))/2,"") . "dan tanda tangan dari Bagian Keuangan \n";
            //$Data .= "\n\n\n\n\n\n\n";
            //sisa kertas
            $entercount  =  $rowsisa - $jumlahitem + $spaceprinter;
            for($i=0;$i<$entercount;$i++){
                $Data.=" \n ";
            }
            fwrite($handle, $Data);
            fclose($handle);
            copy($file, $appset->printeraddr);  # Lakukan cetak
            unlink($file);
        }
        
        return \Laravel\Redirect::to('transaksi/iuran');
        
    }
    
    public function generate_space($space,$kata){
        $res="";
        for($i=0;$i<($space - strlen($kata));$i++){
            $res .= " ";
        }
        
        return $res;
    }
    
    public function get_space($space,$kata){
//        $res="";
//        for($i=0;$i<($space - strlen($kata));$i++){
//            $res .= "x";
//        }
        
        $res = "eries" . $this->generate_space($space, $kata) . 'telek';
        
        return $res;
    }
    
    /**
     * percobaan ctak nota
     */
    public function get_cetaknota(){
        $this->layout = null;
        
        $tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
        $file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
        $handle = fopen($file, 'w');
//        $condensed = Chr(27) . Chr(33) . Chr(4);
//        $bold1 = Chr(27) . Chr(69);
//        $bold0 = Chr(27) . Chr(70);
//        $initialized = chr(27).chr(64);
//        $condensed1 = chr(15);
//        $condensed0 = chr(18);
//        $Data  = $initialized;
//        $Data .= $condensed1;
        $Data="";
        $Data .= "Tanda Bukti Pembayaran Iuran\n";
        $Data .= "SD Islam Sabilil Huda\n";
        $Data .= "Jl. Singokarso 54 Sumorame, Candi, Sidoarjo\n";
        $Data .= "------------------------------------------------\n";
        $Data .= "No   Jenis Iuran        Bulan        Jumlah\n";
        $Data .= "------------------------------------------------\n";
        $Data .= "We Love PHP Indonesia\n";
        $Data .= "We Love PHP Indonesia\n";
        $Data .= "We Love PHP Indonesia\n";
        $Data .= "--------------------------\n";
        fwrite($handle, $Data);
        fclose($handle);
        copy($file, "//192.168.0.1/epson_lx_800");  # Lakukan cetak
        unlink($file);
        
        echo 'cetak nota';
    }
    
    public function get_coba(){
       $this->layout = null;
       
       $appset = Appsetting::first();
       printer_open($appset->printeraddr);
    }
    
    public function get_printon(){
        $appset = Appsetting::first();
        $appset->cetaknota = 'Y';
        $appset->save();
        
        return Redirect::to('transaksi/iuran');
    }
    
    public function get_potongan($tahunajaranid,$siswaid,$jenisbiayaid,$bulan=null){
        $this->layout = null;
        $tahunajaran = Tahunajaran::find($tahunajaranid);
        $jenisbiaya = Jenisbiaya::find($jenisbiayaid);
        $siswa = Siswa::find($siswaid);
        $pot;
        
        if($jenisbiaya->tipe == 'ITB'){
            //bulanan
            $pot = $siswa->potonganiuran()->where('tahunajaran_id','=',$tahunajaranid)->where('jenisbiaya_id','=',$jenisbiayaid)->where('bulan_id','=',$bulan)->first();
        }else{
            $pot = $siswa->potonganiuran()->where('tahunajaran_id','=',$tahunajaranid)->where('jenisbiaya_id','=',$jenisbiayaid)->first();
        }
        
        return eloquent_to_json($pot->pivot);
        
    }
    
}