<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pengaturanbiaya
 *
 * @author root
 */
class Setting_Pengaturanbiaya_Controller extends Base_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function get_index(){
        $biayas = Biaya::where('tentu','=','Y')->get();
        //$biayas = Biaya::all();
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        
        $taselect = array(''=>'Pilih tahun ajaran');
        foreach($tahunajarans as $ta){
            $taselect[$ta->id] = $ta->nama;
        }
        
        $biayaselect = array(''=>'Pilih jenis biaya');
        foreach($biayas as $biaya){
            $biayaselect[$biaya->id] = $biaya->nama;
        }
        
        $this->layout->nest('content', 'setting.pengaturanbiaya.index',array(
            'biayas'=>$biayas,
            'biayaselect'=>$biayaselect,
            'taselect'=>$taselect,
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif
                ));
    }
    
    public function get_ajaxindex($biaya_id,$tahunajaran_id){
        $biaya = Biaya::find($biaya_id);
        $tahunajaran = Tahunajaran::find($tahunajaran_id);
        
        if($biaya->perjenjang == 'Y'){
            $nilaibiayas = Nilaibiaya::where('biaya_id','=',$biaya_id)
                ->where('tahunajaran_id','=',$tahunajaran_id)
                ->get();
        }else{
            $nilaibiayas = Nilaibiaya::where('biaya_id','=',$biaya_id)
                ->where('tahunajaran_id','=',$tahunajaran_id)
                ->first();
        }        
        
        return View::make('setting.pengaturanbiaya.ajax-index')
                ->with('nilaibiayas',$nilaibiayas)
                ->with('biaya',$biaya)
                ->with('tahunajaran',$tahunajaran);
    }
    
    public function post_edit(){
        $this->layout= null;
        
        $biaya = Biaya::find(Input::get('biaya_id'));
        $tahunajaran = Tahunajaran::find(Input::get('tahunajaran_id'));
        
        //validasi dulu
                
        
        if ($biaya->perjenjang == 'Y'){
            //update perjenjang biaya
            
            $nilaibiaya = Nilaibiaya::where('biaya_id','=',$biaya->id)
                ->where('tahunajaran_id','=',$tahunajaran->id)
                ->count();
            
            if ($nilaibiaya>0){
                //update data yang telah ada
                $nilaibiaya = Nilaibiaya::where('biaya_id','=',$biaya->id)
                ->where('tahunajaran_id','=',$tahunajaran->id)
                        ->get();
                
                foreach($nilaibiaya as $nb){
                    //update per item
                    DB::connection()->pdo->beginTransaction();
                    
                    if($nb->jenjang == 1){
                        DB::table('nilaibiaya')
                                ->where('tahunajaran_id','=',$tahunajaran->id)
                                ->where('biaya_id','=',$biaya->id)
                                ->where('jenjang','=',1)
                                ->update(array('jumlah'=>Input::get('jenjang_1')));
                    }elseif($nb->jenjang == 2){
                        DB::table('nilaibiaya')
                                ->where('tahunajaran_id','=',$tahunajaran->id)
                                ->where('biaya_id','=',$biaya->id)
                                ->where('jenjang','=',2)
                                ->update(array('jumlah'=>Input::get('jenjang_2')));
                    }elseif($nb->jenjang == 3){
                        DB::table('nilaibiaya')
                                ->where('tahunajaran_id','=',$tahunajaran->id)
                                ->where('biaya_id','=',$biaya->id)
                                ->where('jenjang','=',3)
                                ->update(array('jumlah'=>Input::get('jenjang_3')));
                    }elseif($nb->jenjang == 4){
                        DB::table('nilaibiaya')
                                ->where('tahunajaran_id','=',$tahunajaran->id)
                                ->where('biaya_id','=',$biaya->id)
                                ->where('jenjang','=',4)
                                ->update(array('jumlah'=>Input::get('jenjang_4')));
                    }elseif($nb->jenjang == 5){
                        DB::table('nilaibiaya')
                                ->where('tahunajaran_id','=',$tahunajaran->id)
                                ->where('biaya_id','=',$biaya->id)
                                ->where('jenjang','=',5)
                                ->update(array('jumlah'=>Input::get('jenjang_5')));
                    }elseif($nb->jenjang == 6){
                        DB::table('nilaibiaya')
                                ->where('tahunajaran_id','=',$tahunajaran->id)
                                ->where('biaya_id','=',$biaya->id)
                                ->where('jenjang','=',6)
                                ->update(array('jumlah'=>Input::get('jenjang_6')));
                    }
                            
                    //commit
                    DB::connection()->pdo->commit();
                }
                
            }else{
                //simpan data baru nilai biaya perjenjang
                DB::connection()->pdo->beginTransaction();
                //insert biaya baru jenjang 1
                $nilaibiaya = array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>$tahunajaran->id,
                    'biaya_id'=>$biaya->id,
                    'jenjang' => 1,
                    'jumlah' => Input::get('jenjang_1')
                );
                DB::table('nilaibiaya')->insert($nilaibiaya);

                //insert biaya baru jenjang 2
                $nilaibiaya = array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>$tahunajaran->id,
                    'biaya_id'=>$biaya->id,
                    'jenjang' => 2,
                    'jumlah' => Input::get('jenjang_2')
                );
                DB::table('nilaibiaya')->insert($nilaibiaya);

                //insert biaya baru jenjang 3
                $nilaibiaya = array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>$tahunajaran->id,
                    'biaya_id'=>$biaya->id,
                    'jenjang' => 3,
                    'jumlah' => Input::get('jenjang_3')
                );
                DB::table('nilaibiaya')->insert($nilaibiaya);

                //insert biaya baru jenjang 4
                $nilaibiaya = array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>$tahunajaran->id,
                    'biaya_id'=>$biaya->id,
                    'jenjang' => 4,
                    'jumlah' => Input::get('jenjang_4')
                );
                DB::table('nilaibiaya')->insert($nilaibiaya);

                //insert biaya baru jenjang 5
                $nilaibiaya = array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>$tahunajaran->id,
                    'biaya_id'=>$biaya->id,
                    'jenjang' => 5,
                    'jumlah' => Input::get('jenjang_5')
                );
                DB::table('nilaibiaya')->insert($nilaibiaya);

                //insert biaya baru jenjang 6
                $nilaibiaya = array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>$tahunajaran->id,
                    'biaya_id'=>$biaya->id,
                    'jenjang' => 6,
                    'jumlah' => Input::get('jenjang_6')
                );
                DB::table('nilaibiaya')->insert($nilaibiaya);

                //commit
                DB::connection()->pdo->commit();
            }
            
            return \Laravel\Redirect::to('setting/pengaturanbiaya');
            
        }else{
            //update nonjenjang biaya
            
            $nilaibiaya = Nilaibiaya::where('biaya_id','=',$biaya->id)
                ->where('tahunajaran_id','=',$tahunajaran->id)
                ->count();
            
            if($nilaibiaya > 0){
                //update yang telah ada
                $nilaibiaya = Nilaibiaya::where('biaya_id','=',$biaya->id)
                    ->where('tahunajaran_id','=',$tahunajaran->id)
                    ->first();
                $nilaibiaya->jumlah = Input::get('jumlah');
                $nilaibiaya->save();
            }else{
                //simpan data baru
                $nilaibiaya = new Nilaibiaya();
                $nilaibiaya->tahunajaran_id = $tahunajaran->id;
                $nilaibiaya->biaya_id = $biaya->id;
                $nilaibiaya->jumlah = Input::get('jumlah');
                $nilaibiaya->save();
            }
            
            return \Laravel\Redirect::to('setting/pengaturanbiaya');
        }
    }
    
    public function get_new(){
        $biayas = Biaya::all();
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        
        $taselect = array();
        foreach($tahunajarans as $ta){
            $taselect[$ta->id] = $ta->nama;
        }
        
        $biayaselect = array(''=>'Pilih jenis biaya');
        foreach($biayas as $biaya){
            $biayaselect[$biaya->id] = $biaya->nama;
        }
        
        $this->layout->nest('content', 'setting.pengaturanbiaya.new',array(
            'biayas'=>$biayas,
            'biayaselect'=>$biayaselect,
            'taselect'=>$taselect,
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif
                ));
    }
    
    public function post_new(){
        $this->layout = null;
        //let's validate
        
        $biaya = Biaya::find(Input::get('biaya'));
        $inputs = Input::all();
        
        if($biaya->perjenjang =='Y'){
            //validasi perjenjang
            $rules = array(
                'biaya'=>'required|numeric',
                'tahunajaran'=>'required|numeric',
                'jenjang_1'=>'required|numeric',
                'jenjang_2'=>'required|numeric',
                'jenjang_3'=>'required|numeric',
                'jenjang_4'=>'required|numeric',
                'jenjang_5'=>'required|numeric',
                'jenjang_6'=>'required|numeric'
            );
        }else{
            //validasi non jenjang
            $rules = array(
                'biaya'=>'required|numeric',
                'tahunajaran'=>'required|numeric',
                'jumlah'=>'required|numeric'
            );
        }
        
        //validate
        $validation = Validator::make($inputs,$rules);
        
        if($validation->fails()){
            //jika validasi gagal kembali ke halaman input
            return \Laravel\Redirect::to('setting/pengaturanbiaya/new')
                    ->with_errors($validation)
                    ->with_input();
        }else{
            //Simpan data jika validasi lolos
            if ($biaya->perjenjang =='Y'){
                //simpan data menggunakan transaction
                DB::connection()->pdo->beginTransaction();
                //insert biaya baru jenjang 1
                $biaya = array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>Input::get('tahunajaran'),
                    'biaya_id'=>Input::get('biaya'),
                    'jenjang' => 1,
                    'jumlah' => Input::get('jenjang_1')
                );
                DB::table('nilaibiaya')->insert($biaya);

                //insert biaya baru jenjang 2
                $biaya = array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>Input::get('tahunajaran'),
                    'biaya_id'=>Input::get('biaya'),
                    'jenjang' => 2,
                    'jumlah' => Input::get('jenjang_2')
                );
                DB::table('nilaibiaya')->insert($biaya);

                //insert biaya baru jenjang 3
                $biaya = array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>Input::get('tahunajaran'),
                    'biaya_id'=>Input::get('biaya'),
                    'jenjang' => 3,
                    'jumlah' => Input::get('jenjang_3')
                );
                DB::table('nilaibiaya')->insert($biaya);

                //insert biaya baru jenjang 4
                $biaya = array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>Input::get('tahunajaran'),
                    'biaya_id'=>Input::get('biaya'),
                    'jenjang' => 4,
                    'jumlah' => Input::get('jenjang_4')
                );
                DB::table('nilaibiaya')->insert($biaya);

                //insert biaya baru jenjang 5
                $biaya = array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>Input::get('tahunajaran'),
                    'biaya_id'=>Input::get('biaya'),
                    'jenjang' => 5,
                    'jumlah' => Input::get('jenjang_5')
                );
                DB::table('nilaibiaya')->insert($biaya);

                //insert biaya baru jenjang 6
                $biaya = array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>Input::get('tahunajaran'),
                    'biaya_id'=>Input::get('biaya'),
                    'jenjang' => 6,
                    'jumlah' => Input::get('jenjang_6')
                );
                DB::table('nilaibiaya')->insert($biaya);

                //commit
                DB::connection()->pdo->commit();


            }else{
                $nilaibiaya = new Nilaibiaya();
                $nilaibiaya->tahunajaran_id = Input::get('tahunajaran');
                $nilaibiaya->biaya_id = Input::get('biaya');
                $nilaibiaya->jumlah = Input::get('jumlah');
                $nilaibiaya->save();
            }

            return Redirect::to('setting/pengaturanbiaya');
            
        }
        
    }
    
    
}
