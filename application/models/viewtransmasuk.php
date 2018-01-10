<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of viewtransmasuk
 *
 * @author Klik
 */
class Viewtransmasuk extends Eloquent{
    public static $table = 'view_transmasuk';
    
    public function get_siswa(){
        return ucwords(strtolower($this->get_attribute('siswa')));
    }
}
