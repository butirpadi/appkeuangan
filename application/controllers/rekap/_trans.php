<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of trans
 *
 * @author root
 */
class Rekap_Trans_Controller extends Base_Controller {
    public function __construct() {
        parent::__construct();
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
        
        $biayas = Biaya::all();
        $biayaselect = array();
        foreach($biayas as $biaya){
            $biayaselect[$biaya->id] = $biaya->nama;
        }
        
        $this->layout->nest('content', 'rekap.trans.index',array(
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif,
            'tahunajaranselect'=>$tahunajaranselect,
            'biayaselect'=>$biayaselect
        ));
    }
    
    public function get_ajaxtrans($tahunajaran_id,$tanggal){
        $trans = Vtranskas::where('tahunajaran_id','=',$tahunajaran_id)
                ->where('tgl','=',$tanggal)
                ->get();
        
        return View::make('rekap.trans.ajaxtrans')->with('trans',$trans);
    }
    
    public function get_ajaxtransrentang($tahunajaran_id, $awal,$akhir){
        $trans = Vtranskas::where('tahunajaran_id','=',$tahunajaran_id)
                ->where('tgl','>=',$awal)
                ->where('tgl','<=',$akhir)
                ->get();
        
        return View::make('rekap.trans.ajaxtrans')->with('trans',$trans);
    }
    
    /**
     * data transaksi dengan range tanggal dan biaya
     * @param type $tahunajaran_id
     * @param type $awal
     * @param type $akhir
     * @param type $biaya_id
     * @return type
     */
    public function get_ajtransrngwitby($tahunajaran_id,$awal,$akhir,$biaya_id){
        $trans = Vtranskas::where('tahunajaran_id','=',$tahunajaran_id)
                ->where('tgl','>=',$awal)
                ->where('tgl','<=',$akhir)
                ->where('biaya_id','=',$biaya_id)
                ->get();
        
        return View::make('rekap.trans.ajaxtrans')->with('trans',$trans);
    }
    /**
     * data transaksi per tanggal dan biaya
     * @param type $tahunajaran_id
     * @param type $tanggal
     * @param type $biaya_id
     * @return type
     */
    public function get_ajtranswitby($tahunajaran_id,$tanggal,$biaya_id){
        $trans = Vtranskas::where('tahunajaran_id','=',$tahunajaran_id)
                ->where('tgl','=',$tanggal)
                ->where('biaya_id','=',$biaya_id)
                ->get();
        
        return View::make('rekap.trans.ajaxtrans')->with('trans',$trans);
    }
    
    /**
     * data transaksi dengan rentang waktu dan filter jenis arus
     * @param type $tahunajaran_id
     * @param type $awal
     * @param type $akhir
     * @param type $arus
     * @return type
     */
    public function get_ajtransrngwitarus($tahunajaran_id,$awal,$akhir,$arus){
        $trans = Vtranskas::where('tahunajaran_id','=',$tahunajaran_id)
                ->where('tgl','>=',$awal)
                ->where('tgl','<=',$akhir)
                ->where('jenis','=',$arus)
                ->get();
        
        return View::make('rekap.trans.ajaxtrans')->with('trans',$trans);
    }
    /**
     * Data transaksi per tanggal dengan filter jenis arus
     * @param type $tahunajaran_id
     * @param type $tanggal
     * @param type $arus
     * @return type
     */
    public function get_ajtranswitarus($tahunajaran_id,$tanggal,$arus){
        $trans = Vtranskas::where('tahunajaran_id','=',$tahunajaran_id)
                ->where('tgl','=',$tanggal)
                ->where('jenis','=',$arus)
                ->get();
        
        return View::make('rekap.trans.ajaxtrans')->with('trans',$trans);
    }
    
    
    
}

?>
