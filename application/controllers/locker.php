<?php

/*
 * By Eries Hermanto
 * Logikamedia
 * Ngaban RT 5 RW 2 No. 15, Tanggulangin, Sidoarjo
 * 085-330-114-055 (SMS/Whatsapp ON)
 */

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of locker
 *
 * @author LM
 */
class Locker_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function get_index(){
        return View::make('locker.index');
    }
}
