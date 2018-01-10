<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of role
 *
 * @author root
 */
class Setting_Role_Controller extends Base_Controller{
    
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_user_group');
    }
    
    public function get_index(){
        $datarole = \Verify\Models\Role::with('permissions')->get();
        $datapermission = \Verify\Models\Permission::all();
        
        $this->layout->nest('content', 'setting.role.index',array('datarole'=>$datarole,'datapermission'=>$datapermission));
    }
    
    public function post_index(){
        //add new Role
        $role = new \Verify\Models\Role();
        $role->name = Input::get('name');
        $role->save();
        
        $role->permissions()->sync(Input::get('permissions'));
        
        return Redirect::to('setting/role');
    }
    
//    public function get_new(){
//        $datapermission = \Verify\Models\Permission::all();
//        
//        $this->layout->nest('content', 'role.new',array('datapermission'=>$datapermission));
//    }
//    
//    public function post_new(){
//        $role = new \Verify\Models\Role();
//        $role->name = Input::get('name');
//        $role->save();
//        
//        $role->permissions()->sync(Input::get('permissions'));
//        
//        return Redirect::to('role');
//        
//    }
    
    public function get_edit($role_id){
        $datapermission = \Verify\Models\Permission::all();
        $role = \Verify\Models\Role::find($role_id);
        
        $this->layout->nest('content', 'setting.role.edit',array('datapermission'=>$datapermission,'role'=>$role));
    }
    
    public function post_edit(){
        $role = \Verify\Models\Role::find(Input::get('role_id'));
        $role->name = Input::get('name');
        $role->save();
        
        $role->permissions()->sync(Input::get('permissions'));
        
        return Redirect::to('setting/role');
    }
    
    public function get_delete($role_id){
        $role = \Verify\Models\Role::find($role_id);
        $role->permissions()->delete();
        $role->delete();
        
        return Redirect::to('setting/role');
    }
    
}
