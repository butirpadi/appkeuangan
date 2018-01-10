<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rombel
 *
 * @author root
 */
class Setting_Rombel_Controller extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_rombel');
    }
    
    public function get_index(){
        $rombels = Rombel::order_by('jenjang','asc')->get();
        $this->layout->nest('content', 'setting.rombel.index',array('rombels'=>$rombels));
    }
    
    public function get_new(){
        $this->layout->nest('content', 'setting.rombel.new');
    }
    
    public function post_new(){
        $rombel = new Rombel();
        $rombel->nama = str_replace("'", '`', Input::get('nama'));
        $rombel->jenjang = Input::get('jenjang');
        $rombel->save();
        
        return \Laravel\Redirect::to('setting/rombel');
    }
    
    public function get_edit($rombel_id){
        $rombel = Rombel::find($rombel_id);
        $this->layout->nest('content', 'setting.rombel.edit',array('rombel'=>$rombel));
    }
    
    public function post_edit(){
        $rombel = Rombel::find(Input::get('rombel_id'));
        $rombel->nama = str_replace("'", '`', Input::get('nama'));
        $rombel->jenjang = Input::get('jenjang');
        $rombel->save();
        
        return \Laravel\Redirect::to('setting/rombel');
    }
}
