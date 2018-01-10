<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of viewsiswa
 *
 * @author Klik
 */
class Viewsiswa extends Eloquent{
    public static $table = 'view_siswa';
    
    public function get_nama(){
        return ucwords(strtolower($this->get_attribute('nama')));
    }
}
