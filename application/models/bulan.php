<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bulan
 *
 * @author root
 */
class Bulan extends Eloquent{
    public static $table = 'bulan';
    
    public function bukuspps(){
        return $this->has_many('bukuspp');
    }
    
    public function detiltransmasuks(){
        return $this->has_many('detiltransmasuk');
    }
    
    public function potongans(){
        return $this->has_many('potongan');
    }
}
