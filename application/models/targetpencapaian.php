<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of targetpencapaian
 *
 * @author Klik
 */
class Targetpencapaian extends Eloquent{
    public static $table = 'target_pencapaian';
    
    public function tahunajaran(){
        return $this->belongs_to('tahunajaran');
    }
    
}
