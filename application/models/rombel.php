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
class Rombel extends Eloquent{
    
    public static $table = 'rombel';
    
    public function siswas(){
        return $this->has_many('siswa');
    }
    
    public function datasiswas(){
        return $this->has_many_and_belongs_to('siswa','rombelsiswa')->with(array('tahunajaran_id'));
    }
}

?>
