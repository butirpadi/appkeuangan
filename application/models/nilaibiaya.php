<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of nilaibiaya
 *
 * @author root
 */
class Nilaibiaya extends Eloquent{
    public static $table = 'nilaibiaya';
    
    public function biaya(){
        return $this->belongs_to('biaya');
    }
    
    public function tahunajaran(){
        return $this->belongs_to('tahunajaran');
    }
}

?>
