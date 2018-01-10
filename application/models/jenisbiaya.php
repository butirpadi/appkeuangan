<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jenisbiaya
 *
 * @author root
 */
class Jenisbiaya extends Eloquent{
    public static $table = 'jenisbiaya';
    
    public function ketentuanbiaya(){
        return $this->has_one('ketentuanbiaya');
    }
    
    public function detiltransmasuks(){
        return $this->has_many('detiltransmasuk');
    }
    
    public function targetbiayabulanan(){
        return $this->has_many_and_belongs_to('tahunajaran','target_bulanan')->with('jumlah');
    }
    
    public function ketetapanbiaya(){
        return $this->has_many_and_belongs_to('tahunajaran','ketentuanbiaya')->with(array('jenjang','jumlah'));
    }
}

?>
