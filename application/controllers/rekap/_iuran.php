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
class Rekap_Iuran_Controller extends Base_Controller {
    
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
        
        $this->layout->nest('content', 'rekap.iuran.index',array(
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif,
            'tahunajaranselect'=>$tahunajaranselect,
            'biayaselect'=>$biayaselect
        ));
    }
}
