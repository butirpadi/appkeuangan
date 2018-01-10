<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pembayaran
 *
 * @author root
 */
class Transaksi_Pembayaran_Controller extends Base_Controller {
    public function __construct() {
        parent::__construct();
        
        $this->filter('before', 'auth');
        
        Asset::container('footer')->add('rupiah', 'js/rupiah.js');
    }
    
    public function get_index(){
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $biayas = Biaya::where('iuran','=','Y')->get();
        
        $taselect = array(''=>'Pilih tahun ajaran');
        foreach($tahunajarans as $ta){
            $taselect[$ta->id] = $ta->nama;
        }
        
        $byselect = array(''=>'Pilih jenis biaya');
        foreach($biayas as $by){
            $byselect[$by->id] = $by->nama;
        }
        
        $this->layout->nest('content', 'transaksi.pembayaran.index',array(
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif,
            'biayas'=>$biayas,
            'taselect'=>$taselect,
            'byselect'=>$byselect
                ));
    }
    
    public function post_index(){
        $this->layout = null;
        
        //Begin transaction
        DB::connection()->pdo->beginTransaction();          
        
        //insert transaksi
        $trans = array(
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
            'tgl' => Input::get('tgl'),
            'tahunajaran_id'=>Input::get('tahunajaran'),
            'biaya_id' => Input::get('biaya'),
            'siswa_id'=>Input::get('siswa_id'),
            'total' => Input::get('total')
        );
        $trans_id = DB::table('transkas')->insert_get_id($trans);
        
        //insert bukuspp
        $bukuspp = array(
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
            'siswa_id'=>Input::get('siswa_id'),
            'tahunajaran_id'=>Input::get('tahunajaran'),
            'bulan_id'=>Input::get('bulan'),
            'tgl_bayar'=>Input::get('tgl'),
            'status'=>'L',
            'transkas_id'=>$trans_id
        );
        DB::table('bukuspp')->insert($bukuspp);
        
//        //cetak nota pembayaran
//        $tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
//        $file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
//        $handle = fopen($file, 'w');
//        $condensed = Chr(27) . Chr(33) . Chr(4);
//        $bold1 = Chr(27) . Chr(69);
//        $bold0 = Chr(27) . Chr(70);
//        $initialized = chr(27).chr(64);
//        $condensed1 = chr(15);
//        $condensed0 = chr(18);
//        $Data  = $initialized;
//        $Data .= $condensed1;
//        $Data .= "==========================\n";
//        $Data .= "|     ".$bold1."OFIDZ MAJEZTY".$bold0."      |\n";
//        $Data .= "==========================\n";
//        $Data .= "Ofidz Majezty is here\n";
//        $Data .= "We Love PHP Indonesia\n";
//        $Data .= "We Love PHP Indonesia\n";
//        $Data .= "We Love PHP Indonesia\n";
//        $Data .= "We Love PHP Indonesia\n";
//        $Data .= "We Love PHP Indonesia\n";
//        $Data .= "--------------------------\n";
//        fwrite($handle, $Data);
//        fclose($handle);
//       // copy($file, "//ERIES-PC/Canon Inkjet iP1900 series");  # Lakukan cetak
//        unlink($file);
                
        //commit
        DB::connection()->pdo->commit();
        
        return Redirect::to('transaksi/pembayaran');
    }


    public function get_ajaxdatasiswa($nisn){
        $this->layout=null;
        
        $siswa = Siswa::where('nisn','=',$nisn)->first();
        return View::make('transaksi.pembayaran.ajax-datasiswa')
                ->with('siswa',$siswa);
    }
    
    public function get_ajaxjenisbiaya($biaya_id){
        $this->layout = null;
        
        $biaya = Biaya::find($biaya_id);
        
        return Laravel\Form::hidden('jenisbiaya', $biaya->nama,array('id'=>'hidejenisbiaya'));
    }
    
    /**
     * Mengembalikan nilai total SPP
     * @param type $tahunajaran_id
     * @param type $biaya_id
     * @param type $jenjang
     * @return type
     */
    public function get_ajaxtotal($tahunajaran_id,$biaya_id,$jenjang='x'){
        if($jenjang == 'x'){
            $nilaibiaya = Nilaibiaya::where('tahunajaran_id','=',$tahunajaran_id)
                ->where('biaya_id','=',$biaya_id)
                ->first();
            return View::make('transaksi.pembayaran.ajax-total')
                    ->with('nilaibiaya',$nilaibiaya);
        }else{
            $nilaibiaya = Nilaibiaya::where('tahunajaran_id','=',$tahunajaran_id)
                ->where('biaya_id','=',$biaya_id)
                ->where('jenjang','=',$jenjang)
                ->first();
            return View::make('transaksi.pembayaran.ajax-total')
                    ->with('nilaibiaya',$nilaibiaya);
        }
    }
    
    public function get_ajaxbukuspp($siswa_id,$tahunajaran_id){
        $this->layout = null;
        
        $bukuspp = Bukuspp::where('siswa_id','=',$siswa_id)
                ->where('tahunajaran_id','=',$tahunajaran_id)
                ->get();
        $sisabulan = DB::query('select * from bulan where bulan.id not in (select bulan_id from bukuspp where siswa_id = ' . $siswa_id .' and tahunajaran_id = ' . $tahunajaran_id . ') order by posisi asc');
        
        $bulanselect = array(''=>'Pilih bulan','x'=>'--------------------------------');
        foreach($sisabulan as $bln){
            $bulanselect[$bln->id] = $bln->nama;
        }
        
        return View::make('transaksi.pembayaran.ajax-bukuspp')
                ->with('bukuspp',$bukuspp)
                ->with('bulanselect',$bulanselect)
                ->with('sisabulan',$sisabulan);
    }
    
    public function get_oct($nisn){
        $this->layout = null;
        
        $siswa = Siswa::where('nisn','=',$nisn)->first();
        $tahunajaran = Tahunajaran::where('aktif','=','Y')->first();
        $biaya = Biaya::where('nama','=','SPP')->first();
        $nilaibiaya = Nilaibiaya::where('tahunajaran_id','=',$tahunajaran->id)
                            ->where('biaya_id','=',$biaya->id)
                            ->where('jenjang','=',$siswa->rombel->jenjang)
                            ->first();
        $belumbayar = DB::query("select * from bulan where id not in(select bulan_id from bukuspp
                 where siswa_id = " . $siswa->id . " and tahunajaran_id = " . $tahunajaran->id . " ) limit 1");
        
        echo var_dump($belumbayar);
        
//        //Begin transaction
//        DB::connection()->pdo->beginTransaction();          
//        
//        //insert transaksi
//        $trans = array(
//            'created_at'=>date('Y-m-d H:i:s'),
//            'updated_at'=>date('Y-m-d H:i:s'),
//            'tgl' => date('Y-m-d'),
//            'tahunajaran_id'=>$tahunajaran->id,
//            'biaya_id' => $biaya->id,
//            'siswa_id'=>$siswa->id,
//            'total' => $nilaibiaya->jumlah
//        );
//        $trans_id = DB::table('transkas')->insert_get_id($trans);
//        
//        //insert bukuspp
//        $bukuspp = array(
//            'created_at'=>date('Y-m-d H:i:s'),
//            'updated_at'=>date('Y-m-d H:i:s'),
//            'siswa_id'=>$siswa->id,
//            'tahunajaran_id'=>$tahunajaran->id,
//            'bulan_id'=>Input::get('bulan'),
//            'tgl_bayar'=>Input::get('tgl'),
//            'status'=>'L',
//            'transkas_id'=>$trans_id
//        );
//        DB::table('bukuspp')->insert($bukuspp);
    }
}

?>
