<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kas
 *
 * @author root
 */
class Transaksi_Kas_Controller extends Base_Controller {
    public function __construct() {
        parent::__construct();
        
        $this->filter('before', 'auth');
    }
    
    public function get_index(){
        Asset::container('footer')->add('rupiah', 'js/rupiah.js');
                
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $biayas = Biaya::where('iuran','=','N')->get();
        //$biayas = Biaya::all();

        $taselect = array();
        foreach($tahunajarans as $ta){
            $taselect[$ta->id] = $ta->nama;
        }

        $byselect = array();
        foreach($biayas as $by){
            $byselect[$by->id] = $by->nama;
        }

        $this->layout->nest('content', 'transaksi.kas.index',array(
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif,
            'biayas'=>$biayas,
            'taselect'=>$taselect,
            'byselect'=>$byselect
                ));
    }
    
    public function post_index(){
        $this->layout = null;
        
        $trans = new Transkas();
        $trans->tahunajaran_id = Input::get('tahunajaran');
        $trans->biaya_id = Input::get('biaya');
        $trans->tgl = Input::get('tgl');
        
        $jml =  str_replace('Rp. ', '', Input::get('jumlah'));
        $jml = str_replace('.', '', $jml);
        $jml = str_replace(' ', '', $jml);
        
        $trans->total = $jml;
        $trans->ket = Input::get('ket');
        $trans->save();

        return Redirect::to('transaksi/kas');
    }
    
    public function get_ajaxjeniskas($biaya_id){
        
        $biaya = Biaya::where('id','=',$biaya_id)->first();
        
        if ($biaya->jenis == 'M'){
            return '<span class="label label-success">kas masuk</span>';
        }elseif ($biaya->jenis == 'K'){
            return '<span class="label label-warning">kas keluar</span>';
        }
    }
    
    public function get_ajaxnilaibiaya($tahunajaran_id,$biaya_id){
        $nilai = Nilaibiaya::where('tahunajaran_id','=',$tahunajaran_id)
                ->where('biaya_id','=',$biaya_id)
                ->first();
        if ($nilai){
            return \Laravel\Form::hidden('nilaibiaya', $nilai->jumlah,array('id'=>'hidenilai'));
        }else{
            return \Laravel\Form::hidden('nilaibiaya', 'null',array('id'=>'hidenilai'));
        }
    }
    
    public function get_ajaxnilaitentu($biaya_id){
        $biaya = Biaya::find($biaya_id);
        if ($biaya){
            if($biaya->tentu == 'Y'){
                return \Laravel\Form::hidden('nilaitentu', 'Y',array('id'=>'hidetentu'));
            }else{
                return \Laravel\Form::hidden('nilaitentu', 'N',array('id'=>'hidetentu'));
            }
        }else{
            return \Laravel\Form::hidden('nilalitentu', 'N',array('id'=>'hidetentu'));
        }
    }
}

