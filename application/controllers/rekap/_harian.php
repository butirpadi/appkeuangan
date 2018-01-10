<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of harian
 *
 * @author root
 */
class Rekap_Harian_Controller extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_index(){
        Asset::container('footer')->add('rupiah', 'js/rupiah.js');
        
        
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $biayas = Biaya::where('iuran','=','Y')->get();
        $rombels = Rombel::all();
        
        $rombelselect = array('all'=>'Semua');
        foreach($rombels as $romb){
            $rombelselect[$romb->id] = $romb->nama;
        }
        
        $taselect = array();
        foreach($tahunajarans as $ta){
            $taselect[$ta->id] = $ta->nama;
        }
        
        $byselect = array();
        foreach($biayas as $by){
            $byselect[$by->id] = $by->nama;
        }
        
        $this->layout->nest('content', 'rekap.harian.index',array(
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif,
            'biayas'=>$biayas,
            'taselect'=>$taselect,
            'byselect'=>$byselect,
            'rombelselect'=>$rombelselect
                ));
    }
    
    public function get_ajaxselectbiaya($jenis_arus = 'all'){
        $selectBiaya = array('all'=>'Semua');
        
        if ($jenis_arus == 'all'){
            $biayas = Biaya::all();
        }else{
            $biayas = Biaya::where('jenis','=',$jenis_arus)->get();
        }
        
        foreach($biayas as $by){
            $selectBiaya[$by->id]  =$by->nama;
        }
        
        return \Laravel\Form::select('selectBiaya', $selectBiaya, null, array('id'=>'selectBiaya'));
    }
    
    public function get_ajaxtabelrekap($tahunajaran_id,$tanggal, $jenis_kas, $biaya_id, $rombel_id = 'all', $siswa_id = 'all',$group = false){
        $this->layout = null;
        
        if ($jenis_kas == 'all' && $biaya_id == 'all'){
            if ($group){
                $trans = DB::query('select tahunajaran_id,tahunajaran,biaya_id,biaya,jenis,iuran,sum(total) as total from vtranskas group by biaya_id');
            }else{
                $trans = Vtranskas::where('tahunajaran_id','=',$tahunajaran_id)
                    ->where('tgl','=',$tanggal)
                    ->get();
            }
        }else if($jenis_kas == 'all'){
            $trans = Vtranskas::where('tahunajaran_id','=',$tahunajaran_id)
                    ->where('tgl','=',$tanggal)
                    ->where('biaya_id','=',$biaya_id)->get();
        }else{
            if ($biaya_id == 'all'){
                $trans = Vtranskas::where('tahunajaran_id','=',$tahunajaran_id)
                        ->where('tgl','=',$tanggal)
                        ->where('jenis','=',$jenis_kas)->get();
            }else{
                
                $biaya = Biaya::find($biaya_id);
                
                if ($biaya->iuran == 'Y'){
                    if($rombel_id == 'all' && $siswa_id == 'all'){
                        $trans = Vtranskas::where('tahunajaran_id','=',$tahunajaran_id)
                            ->where('tgl','=',$tanggal)
                            ->where('jenis','=',$jenis_kas)
                            ->where('biaya_id','=',$biaya_id)
                            ->get();
                    }else if($rombel_id != 'all' && $siswa_id == 'all'){
                        $trans = Vtranskas::where('tahunajaran_id','=',$tahunajaran_id)
                            ->where('tgl','=',$tanggal)
                            ->where('jenis','=',$jenis_kas)
                            ->where('biaya_id','=',$biaya_id)
                            ->where
                            ->get();
                    }
                }else{
                    $trans = Vtranskas::where('tahunajaran_id','=',$tahunajaran_id)
                            ->where('tgl','=',$tanggal)
                            ->where('jenis','=',$jenis_kas)
                            ->where('biaya_id','=',$biaya_id)
                            ->get();
                }
                
                
                
            }
        }
        
        if ($group){
            return View::make('rekap.harian.ajax-tabelrekapgroup')->with('trans',$trans);
        }else{
            return View::make('rekap.harian.ajax-tabelrekap')->with('trans',$trans);
        }
        
    }
    
    public function get_ajaxtabelrekapgroup($tahunajaran_id,$tanggal,$jeniskas,$jenisbiaya){
        $this->layout = null;
        echo 'pret';
    }
    
}
