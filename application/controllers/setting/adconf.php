<?php

/*
 * By Eries Hermanto
 * Logikamedia
 * Ngaban RT 5 RW 2 No. 15, Tanggulangin, Sidoarjo
 * 085-330-114-055 (SMS/Whatsapp ON)
 */

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adconf
 *
 * @author LM
 */
class Setting_Adconf_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter adconf
        $user = Auth::retrieve(Session::get('onuser_id'));
        $this->filter('before', 'adconf:'.$user->username);
    }
    
    public function get_index(){
        $appset = Appsetting::first();
        //applocker
        $applockers = Applocker::order_by('tanggal','asc')->get();
        $this->layout->nest('content', 'setting.adconf.index',array('appset'=>$appset,'applockers'=>$applockers));
    }
    
    public function post_mysqldumppath(){
        $appset = Appsetting::first();
        $appset->mysqldumppath = Input::get('mysqldumppath');
        $appset->save();
        
        return Redirect::to('setting/adconf');
    }
    
    public function post_applocker(){
        $applocker = new Applocker();
        $applocker->tanggal = date('Y-m-d',strtotime(Input::get('tanggal')));
        $applocker->lunas = Input::get('lunas');
        $applocker->save();
        
        return Redirect::to('setting/adconf');
    }
    
    public function post_applocker_update(){
        $applocker = Applocker::find(Input::get('applocker_id'));
        $applocker->tanggal = date('Y-m-d',strtotime(Input::get('tanggal'.Input::get('applocker_id'))));
        $applocker->lunas = Input::get('lunas'.Input::get('applocker_id'));
        $applocker->save();
        
        return Redirect::to('setting/adconf');
    }
    
    public function post_printer(){
        $appset = Appsetting::find(Input::get('appset_id'));
        $appset->linekertas = Input::get('linekertas');
        $appset->spaceprinter = Input::get('spaceprinter');
        $appset->charcount = Input::get('charcount');
        $appset->save();
        
        return Redirect::to('setting/adconf');
    }
    
    public function get_applocker_delete($applocker_id){
        $applock =  Applocker::find($applocker_id);
        $applock->delete();
        return Redirect::to('setting/adconf');
    }
    
    public function get_lunasi($status){
        $appset = Appsetting::first();
        $appset->lunas = $status;
        $appset->save();
        return Redirect::to('setting/adconf');
    }
            
    
}