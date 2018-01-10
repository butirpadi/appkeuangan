<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vsiswa
 *
 * @author root
 */
class Vsiswa extends Eloquent{
    public static $table = 'vsiswa';
    
    public function get_siswa(){
        return ucwords(strtolower($this->get_attribute('siswa')));
    }
}