<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bajak
 *
 * @author Klik
 */
class Bajak_Controller extends Base_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_index(){
        $reqkey = \Laravel\Session::get('reqkey');
        return View::make('bajak.index')->with('reqkey',$reqkey);
    }
    
    public function post_index(){
        $this->layout = null;
        $snkey = Input::get('snkey');        
        $appset = Appsetting::first();
        $appset->sn_key = $snkey;
        $appset->save();
        
        return Redirect::to('home');
    }
    
}
