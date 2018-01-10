<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of profiler
 *
 * @author root
 */
class Setting_Profiler_Controller extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        //filter login
        $this->filter('before', 'auth');
    }
    
    public function get_index(){
        $user = Auth::retrieve(Session::get('onuser_id'));
        $this->layout->nest('content', 'setting.profiler.index',array('user'=>$user));
    }
    
    public function post_update(){
        $user = \Verify\Models\User::find(Input::get('user_id'));
//        $user->username = Input::get('username');
        $user->name = Input::get('name');
        
        if (Input::get('password') != ''){
            //update password
            $user->password = Input::get('password');
        }
        
        $user->save();
        
        return Redirect::to('setting/profiler');
    }
}
