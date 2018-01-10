<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siswa
 *
 * @author root
 */
class Siswa extends Eloquent{
    public static $table = 'siswa';
    
    public function get_nama(){
        return ucwords(strtolower($this->get_attribute('nama')));
    }
    
    public function set_nama(){
        $this->set_attribut('nama', ucwords(strtolower($this->get_attribute('nama'))));
    }
    
    public function rombel(){
        return $this->belongs_to('rombel');
    }
    
    public function transmasuks(){
        return $this->has_man('transmasuk');
    }
    
    public function rombels(){
        return $this->has_many_and_belongs_to('rombel','rombelsiswa')->with(array('tahunajaran_id'));
    }
    
    public function tahunajarans(){
        return $this->has_many_and_belongs_to('tahunajaran','rombelsiswa')->with(array('rombel_id'));
    }
    
    public function potongans(){
        return $this->has_many('potongan');
    }
    
    public function potonganiuran(){
        return $this->has_many_and_belongs_to('tahunajaran','potongan')->with(array('bulan_id','jenisbiaya_id','disc','nilai','ket','jenis'));
    }
    
}