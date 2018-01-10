<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detiltransmasuk
 *
 * @author root
 */
class Detiltransmasuk extends Eloquent{
    
    public static $table = 'detiltransmasuk';
    
    public function transmasuk(){
        return $this->belongs_to('transmasuk')->with(array('jumlah','ket'));
    }
    
    public function jenisbiaya(){
        return $this->belongs_to('jenisbiaya');
    }
    
    public function bulan(){
        return $this->belongs_to('bulan');
    }
}
