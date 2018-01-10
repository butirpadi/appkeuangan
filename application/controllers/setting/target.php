<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of target
 *
 * @author Klik
 */
class Setting_Target_Controller extends Base_Controller {
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_target_pencapaian');
    }
    
    public function get_index(){
        $iurans = Jenisbiaya::where_in('tipe',array('ITB','ITC','IB'))->get();
        $selectjenisbiaya = array();
        foreach($iurans as $data){
            $selectjenisbiaya[$data->id] = $data->nama;
        }
        $this->layout->nest('content', 'setting.target.index',array('selectjenisbiaya'=>$selectjenisbiaya));
    }
    
    public function post_targetbulanan(){
        $tahunajaran = Tahunajaran::find(Input::get('tahunajaranid'));
        $jenisbiaya = Jenisbiaya::find(Input::get('jenisbiayaid'));
        $jumlah = Input::get('jumlah');
        
        //delete data sebelumnya
        $target = $tahunajaran->targetbiayabulanan()->where('jenisbiaya_id','=',$jenisbiaya->id)->first();
        if($target){
            $target->pivot->jumlah = $jumlah;
            $target->pivot->save();
        }else{
            //$tahunajaran->targetbiayabulanan()->where('jenisbiaya_id','=',$jenisbiaya->id)->delete();
            $tahunajaran->targetbiayabulanan()->attach($jenisbiaya,array('jumlah' => $jumlah));
        }
        
        return true;
    }
    
    public function get_ajaxtargetbulanan($jenisbiaya_id){
        $jenisbiaya = Jenisbiaya::find($jenisbiaya_id);
        $tahunajaran = Tahunajaran::with('targetbiayabulanan')->get();
        return View::make('setting.target.ajaxtargetbulan')
                ->with('jenisbiaya',$jenisbiaya)
                ->with('tahunajaran',$tahunajaran);
    }
    
    public function post_targetpencapaian(){
        $tahunajaran_id = Input::get('tahun_id');
        $jumlah = Input::get('jumlah');
        
        $target = Targetpencapaian::where('tahunajaran_id','=',$tahunajaran_id)->first();
        
        if($target){
            //do nothing
        }else{
            $target = new Targetpencapaian();
        }
        
        $target->jumlah = $jumlah;
        $target->tahunajaran_id = $tahunajaran_id;
        $target->save();
        
        return Redirect::to('setting/target');
    }
    
}
