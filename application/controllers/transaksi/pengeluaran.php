<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pengeluaran
 *
 * @author root
 */
class Transaksi_Pengeluaran_Controller extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_transaksi_pengeluaran');
    }
    
    public function get_index(){
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $tahunajaranselect = array();
        foreach($tahunajarans as $ta){
            $tahunajaranselect[$ta->id] = $ta->nama;
        }
        
        $jenisbiaya = Jenisbiaya::where_in('tipe',array('BBBI','BTBI'))
                ->where('arus','=','K')->get();
        $biayaselect = array();
        foreach($jenisbiaya as $by){
            $biayaselect[$by->id] = $by->nama;
        }
        
        $this->layout->nest('content', 'transaksi.pengeluaran.index',array(
            'tahunajaranselect'=>$tahunajaranselect,
            'tahunaktif'=>$tahunaktif,
            'biayaselect'=>$biayaselect
        ));
    }
    
    public function get_jsnGetBiaya($biaya_id){
        $biaya = Jenisbiaya::find($biaya_id);
        if ($biaya){
            return eloquent_to_json($biaya);
        }else{
            return '"null"';
        }
        
    }
    
    public function get_jsonketentuanbiaya($tahunajaranid,$jenisbiayaid,$tipe,$jenjang='all'){
        if($tipe == 'ITC' || $tipe == 'ITB'){
             $jenisbiaya  = Jenisbiaya::find($jenisbiayaid);
        
            if ($jenisbiaya->perjenjang == 'Y'){
                $ket = Ketentuanbiaya::where('tahunajaran_id','=',$tahunajaranid)
                        ->where('jenisbiaya_id','=',$jenisbiayaid)
                        ->where('jenjang','=',$jenjang)
                        ->first();
            }else{
                $ket = Ketentuanbiaya::where('tahunajaran_id',$tahunajaranid)
                        ->where('jenisbiaya_id','=',$jenisbiayaid)
                        ->first();
            }
        }else if($tipe == 'BTBI'){
            $ket = Ketentuanbiaya::where('tahunajaran_id','=',$tahunajaranid)
                ->where('jenisbiaya_id','=',$jenisbiayaid)
                ->first();
        }
        
        if($ket){
            return eloquent_to_json($ket);
        }else{
            return json_encode('null');
        }
    }
    
    public function post_inserttrans(){
        $rawDataTrans = Input::get('datatrans');
        $dataTrans = json_decode($rawDataTrans);
        
        $rawDetilTrans = Input::get('detiltrans');
        $detilTrans = json_decode($rawDetilTrans);
                
        
        //insert data transaksi
        DB::connection()->pdo->beginTransaction();
                
            //insert data master transaksi
            $trans_id = DB::table('transmasuk')->insert_get_id(array(
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                'tahunajaran_id'=>$dataTrans->tahunajaranid,
                'tanggal'=>date('Y-m-d',strtotime($dataTrans->tanggal)),
                'arus'=>'K'
            ));
            
            //insert detil transaksi
            foreach($detilTrans->detiltrans as $dt){
                DB::table('detiltransmasuk')->insert(array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'transmasuk_id' => $trans_id,
                    'jenisbiaya_id' => $dt->biayaid,
                    'jumlah'=> $dt->jumlah,
                    'ket'=> $dt->keterangan
                ));
            }

        //commit
        DB::connection()->pdo->commit();
        
        return \Laravel\Redirect::to('transaksi/pengeluaran');
        
    }
    
    
}
