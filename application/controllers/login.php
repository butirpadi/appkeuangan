<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author root
 */
class Login_Controller extends Base_Controller {
    public function __construct() {
        parent::__construct();
        
        //filter PEMBAJAKAN
        //$this->filter('before', 'snkey');
    }
    
    public function get_index(){
        Auth::logout();
        Session::flush();
        
        $this->layout = null;
        return View::make('login.index');
    }
    
    public function post_index(){
        $this->layout = null;
        
        $creds = array(
            'username' => Input::get('username'),
            'password' => Input::get('password'));
        
        try
        {
            Auth::attempt($creds);
            
            //set user log session
            $user = \Verify\Models\User::where('username','=',Input::get('username'))->first();
            Session::put('onuser_id',$user->id);
            Session::put('onusername',$user->username);
            Session::put('islogin',true);
            
            return Redirect::to('home');
        } 
        catch(Exception $e)
        {
            //Return Redirect::to('login')->with('login_errors',true);
            return Response::error('404');
        }
    }
    
    public function get_logout(){
        Auth::logout();
        Session::flush();
        return Redirect::to('login');
    }
    
}
