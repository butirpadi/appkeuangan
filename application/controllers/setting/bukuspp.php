<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bukuspp
 *
 * @author root
 */
class Setting_Bukuspp_Controller extends Base_Controller {
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_bulan');
    }
    
    public function get_index(){
        $bulans = Bulan::order_by('posisi','asc')->get();
        $this->layout->nest('content', 'setting.bukuspp.index',array('bulans'=>$bulans));
    }
    
    public function get_shiftup($bulan_id){
        $bulan = Bulan::find($bulan_id);
        if ($bulan->posisi > 1){
            $prevbulan = Bulan::where('posisi','=',$bulan->posisi-1)->first();
            $bulan->posisi = $bulan->posisi-1;
            $bulan->save();
            $prevbulan->posisi = $prevbulan->posisi+1;            
            $prevbulan->save();
        }
        
        return Redirect::to('setting/bukuspp');
    }
    
    public function get_shiftdown($bulan_id){
        $bulan = Bulan::find($bulan_id);
        if ($bulan->posisi < 12){
            $nextbulan = Bulan::where('posisi','=',$bulan->posisi+1)->first();
            $bulan->posisi = $bulan->posisi+1;
            $bulan->save();
            $nextbulan->posisi = $nextbulan->posisi-1;            
            $nextbulan->save();
        }
        
        return Redirect::to('setting/bukuspp');
    }
}
