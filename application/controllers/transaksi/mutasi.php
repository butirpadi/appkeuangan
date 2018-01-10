<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mutasi
 *
 * @author Klik
 */
class Transaksi_Mutasi_Controller extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_mutasi_kas');
    }
    
    public function get_index(){
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $tahunajaranselect = array();
        foreach($tahunajarans as $ta){
            $tahunajaranselect[$ta->id] = $ta->nama;
        }
        
        $this->layout->nest('content', 'transaksi.mutasi.index',array(
            'selecttahunajaran'=>$tahunajaranselect,
            'tahunaktif'=>$tahunaktif
        ));
    }
    
    public function get_new(){
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $tahunajaranselect = array();
        foreach($tahunajarans as $ta){
            $tahunajaranselect[$ta->id] = $ta->nama;
        }
        
        $this->layout->nest('content', 'transaksi.mutasi.new',array(
            'selecttahunajaran'=>$tahunajaranselect,
            'tahunaktif'=>$tahunaktif
        ));
    }
    
    public function post_new(){
        $mutasi = new Mutasi();
        $mutasi->tanggal = date('Y-m-d',strtotime(Input::get('tanggal')));
        $mutasi->tahunajaran_id = Input::get('tahunajaran');
        $mutasi->asal = Input::get('asal');
        $mutasi->tujuan = Input::get('tujuan');
        $jumlah = str_replace('Rp.', '', Input::get('jumlah'));
        $jumlah = str_replace('.', '',$jumlah);
        $jumlah = str_replace(',', '',$jumlah);
        $jumlah = str_replace(' ', '',$jumlah);
        $mutasi->jumlah = $jumlah;
        $mutasi->save();
        
        return Redirect::to('transaksi/mutasi');
    }
    public function get_edit($mutasiId){
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $tahunajaranselect = array();
        foreach($tahunajarans as $ta){
            $tahunajaranselect[$ta->id] = $ta->nama;
        }
        
        $mutasi = Mutasi::find($mutasiId);
        
        $this->layout->nest('content', 'transaksi.mutasi.edit',array(
            'selecttahunajaran'=>$tahunajaranselect,
            'tahunaktif'=>$tahunaktif,
            'mutasi'=>$mutasi
        ));
    }
    
    public function post_edit(){
        $mutasi = Mutasi::find(Input::get('mutasi_id'));
        $mutasi->tanggal = date('Y-m-d',strtotime(Input::get('tanggal')));
        $mutasi->tahunajaran_id = Input::get('tahunajaran');
        $mutasi->asal = Input::get('asal');
        $mutasi->tujuan = Input::get('tujuan');
        $jumlah = str_replace('Rp.', '', Input::get('jumlah'));
        $jumlah = str_replace('.', '',$jumlah);
        $jumlah = str_replace(',', '',$jumlah);
        $jumlah = str_replace(' ', '',$jumlah);
        $mutasi->jumlah = $jumlah;
        $mutasi->save();
        
        return Redirect::to('transaksi/mutasi');
    }
    
    public function get_delete($id = null){
        
        if($id == null){
            $id = Input::get('id');
        }
        
        $mutasi = Mutasi::find($id);
        $mutasi->delete();
        
        return Redirect::to('transaksi/mutasi');
    }
    
    public function get_listmutasi($tahunajaranId){
        $datamutasi = Mutasi::where('tahunajaran_id','=',$tahunajaranId)->get();
        
        return View::make('transaksi.mutasi.listmutasi')
                ->with('datamutasi',$datamutasi);
    }
    
}
