<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bulanan
 *
 * @author root
 */
class Laporan_Bulanan_Controller extends Base_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function get_index(){
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $biayas = Biaya::all();
        
        $taselect = array();
        foreach($tahunajarans as $ta){
            $taselect[$ta->id] = $ta->nama;
        }
        
        $byselect = array();
        foreach($biayas as $by){
            $byselect[$by->id] = $by->nama;
        }
        
        $this->layout->nest('content', 'laporan.bulanan.index',array(
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif,
            'biayas'=>$biayas,
            'taselect'=>$taselect,
            'byselect'=>$byselect
                ));
    }
}

?>
