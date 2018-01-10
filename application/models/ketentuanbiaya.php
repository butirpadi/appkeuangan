<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of biayatetap
 *
 * @author root
 */
class Ketentuanbiaya extends Eloquent{
    public static $table = 'ketentuanbiaya';
    
    public function jenisbiaya(){
        return $this->belongs_to('jenisbiaya');
    }
}

?>
