<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author root
 */
class Setting_User_Controller extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_user');
    }
    
    public function get_index(){
        $datauser = \Verify\Models\User::with('roles')->where('username','!=','eries')->get();
        $datarole = \Verify\Models\Role::all();
        $roleselect = array();
        foreach($datarole as $role){
            $roleselect[$role->id] = $role->name;
        }
        $this->layout->nest('content', 'setting.user.index',array('datauser'=>$datauser,'roleselect'=>$roleselect));
    }
    
    public function get_new(){
        $datauser = \Verify\Models\User::with('roles')->where('username','!=','eries')->get();
        $datarole = \Verify\Models\Role::all();
        $roleselect = array();
        foreach($datarole as $role){
            $roleselect[$role->id] = $role->name;
        }
        $this->layout->nest('content', 'setting.user.new',array('datauser'=>$datauser,'roleselect'=>$roleselect));
    }
    
    public function post_new(){
         $user = new \Verify\Models\User();
        $user->username = Input::get('username');
        $user->email = Input::get('username').'@simas.ad';
        $user->password = Input::get('password');
        $user->name = Input::get('nama');
        $user->verified = 1;
        $user->save();
        
        $user->roles()->sync(array(Input::get('roles')));
        
        return Redirect::to('setting/user');
    }
    
//    public function get_new(){
//        $datarole = \Verify\Models\Role::all();
//        $selectrole = array();
//        foreach($datarole as $role){
//            $selectrole[$role->id] = $role->name;
//        }
//        
//        $this->layout->nest('content', 'user.new',array('datarole'=>$datarole,'selectrole'=>$selectrole));
//    }
//    
//    public function post_new(){
//        $user = new \Verify\Models\User();
//        $user->username = Input::get('username');
//        $user->email = Input::get('username').'@simastab.dev';
//        $user->password = Input::get('password');
//        $user->verified = 1;
//        $user->save();
//        
//        $user->roles()->sync(array(Input::get('roles')));
//        
//        return Redirect::to('user');
//    }
    
    public function get_edit($user_id){
        $datarole = \Verify\Models\Role::all();
        $selectrole = array();
        foreach($datarole as $role){
            $selectrole[$role->id] = $role->name;
        }
        
        $user = \Verify\Models\User::find($user_id);
        
        $this->layout->nest('content', 'setting.user.edit',array('datarole'=>$datarole,'selectrole'=>$selectrole,'user'=>$user));
    }
    
    public function post_edit(){
        $user = \Verify\Models\User::find(Input::get('user_id'));
        $user->username = Input::get('username');
        $user->name = Input::get('nama');
        
        if (Input::get('password') != ''){
            //update password
            $user->password = Input::get('password');
        }
        
        $user->save();
        
        $user->roles()->sync(array(Input::get('roles')));
        
        return Redirect::to('setting/user');
    }
    
    public function get_delete($user_id){
        $user = \Verify\Models\User::find($user_id);
        
        $user->roles()->delete();
        
        $user->delete();
        
        return Redirect::to('setting/user');
    }
    
}
