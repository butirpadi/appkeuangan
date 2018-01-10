<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of potongan
 *
 * @author Klik
 */
class Potongan extends Eloquent{
    public static $table = 'potongan';
    
    public function siswa(){
        return $this->belongs_to('siswa');
    }
    public function tahunajaran(){
        return $this->belongs_to('tahunajaran');
    }
    public function bulan(){
        return $this->belongs_to('bulan');
    }
}
