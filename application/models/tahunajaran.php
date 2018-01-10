<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tahunajaran
 *
 * @author root
 */
class Tahunajaran extends Eloquent{
    public static $table = 'tahunajaran';
    
    public function nilaibiayas(){
        return $this->has_many('nilaibiaya');
    }
    
    public function targetpencapaian(){
        return $this->has_one('targetpencapaian');
    }
    
    public function siswas(){
        return $this->has_many_and_belongs_to('siswa','rombelsiswa')->with(array('rombel_id'));
    }
    
    public function targetbiayabulanan(){
        return $this->has_many_and_belongs_to('jenisbiaya','target_bulanan')->with('jumlah');
    }
    
    public function potongans(){
        return $this->has_many('potongan');
    }
    
    public function potonganiuran(){
        return $this->has_many_and_belongs_to('siswa','potongan')->with(array('bulan_id','jenisbiaya_id','disc','nilai','ket','jenis'));
    }
    
    public function ketetapanbiaya(){
        return $this->has_many_and_belongs_to('jenisbiaya','ketentuanbiaya')->with(array('jenjang','jumlah'));
    }
}
