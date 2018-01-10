<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of transmasuk
 *
 * @author root
 */
class Transmasuk extends Eloquent{
    public static $table = 'transmasuk';
    
    public function detiltransmasuks(){
        return $this->has_many('detiltransmasuk');
    }
    
    public function siswa(){
        return $this->belongs_to('siswa');
    }
    
}
