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
class Bukuspp extends Eloquent {
    public static $table = 'bukuspp';
    
    public function bulan(){
        return $this->belongs_to('bulan');
    }
}

?>
