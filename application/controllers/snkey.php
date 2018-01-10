<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of snkey
 *
 * @author Eries
 */
class Snkey_Controller extends Base_Controller {
    public function get_index(){
        return View::make('snkey.index');
    }
    
    public function post_index(){
        $this->layout=null;
        if(md5(Input::get('auth')) != '9a15fbc1a0e5302f5ea2e2b72ba0627b'){
            echo 'Your AUTH is not falid';
        }else{
            echo 'Your SNKEY : <br/>' . \Laravel\Form::textarea('snkey', base64_encode(Input::get('snkey')));
        }
        
    }
}

?>
