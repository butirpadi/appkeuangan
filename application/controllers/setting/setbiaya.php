<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of setbiaya
 *
 * @author root
 */
class Setting_Setbiaya_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();

        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_biaya');
    }

    public function get_index(){
        $jenisbiayas = Jenisbiaya::where('tipe','!=','BBBI')->get();
        $biayaselect = array();
        foreach($jenisbiayas as $biaya){
            $biayaselect[$biaya->id] = $biaya->nama;
        }

        // $tahunajarans = Tahunajaran::all();
        $tahunajarans = Tahunajaran::order_by('posisi', 'desc')->get();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();

        $tahunselect = array();
        foreach($tahunajarans as $ta){
            $tahunselect[$ta->id] = $ta->nama;
        }

        $this->layout->nest('content', 'setting.setbiaya.index',array(
            'jenisbiayas'=>$jenisbiayas,
            'biayaselect'=>$biayaselect,
            'tahunselect'=>$tahunselect,
            'tahunajarans'=>$tahunajarans,
            'tahunaktif'=>$tahunaktif
                ));
    }

    public function post_index(){
        $this->layout = null;

        $jenisbiaya = Jenisbiaya::find(Input::get('jenisbiaya_id'));
        $tahunajaran = Tahunajaran::find(Input::get('tahunajaran_id'));

        if($jenisbiaya->perjenjang == 'Y'){
            //jika biaya merupakan biaya perjenjang
            $ketbiaya = Ketentuanbiaya::where('tahunajaran_id','=',Input::get('tahunajaran_id'))
                        ->where('jenisbiaya_id','=',Input::get('jenisbiaya_id'))
                        ->get();
            if($ketbiaya){
                //update per item
                DB::connection()->pdo->beginTransaction();

                //jenjang 1
                DB::table('ketentuanbiaya')
                        ->where('tahunajaran_id','=',$tahunajaran->id)
                        ->where('jenisbiaya_id','=',$jenisbiaya->id)
                        ->where('jenjang','=',1)
                        ->update(array(
                           'jumlah'=>  str_replace(' ','',str_replace('.','', str_replace('Rp. ', '', Input::get('jenjang_1'))))
                        ));
                //jenjang 2
                DB::table('ketentuanbiaya')
                        ->where('tahunajaran_id','=',$tahunajaran->id)
                        ->where('jenisbiaya_id','=',$jenisbiaya->id)
                        ->where('jenjang','=',2)
                        ->update(array(
                           'jumlah'=>  str_replace(' ','',str_replace('.','', str_replace('Rp. ', '', Input::get('jenjang_2'))))
                        ));
                //jenjang 3
                DB::table('ketentuanbiaya')
                        ->where('tahunajaran_id','=',$tahunajaran->id)
                        ->where('jenisbiaya_id','=',$jenisbiaya->id)
                        ->where('jenjang','=',3)
                        ->update(array(
                           'jumlah'=>  str_replace(' ','',str_replace('.','', str_replace('Rp. ', '', Input::get('jenjang_3'))))
                        ));
                //jenjang 4
                DB::table('ketentuanbiaya')
                        ->where('tahunajaran_id','=',$tahunajaran->id)
                        ->where('jenisbiaya_id','=',$jenisbiaya->id)
                        ->where('jenjang','=',4)
                        ->update(array(
                           'jumlah'=>  str_replace(' ','',str_replace('.','', str_replace('Rp. ', '', Input::get('jenjang_4'))))
                        ));
                //jenjang 5
                DB::table('ketentuanbiaya')
                        ->where('tahunajaran_id','=',$tahunajaran->id)
                        ->where('jenisbiaya_id','=',$jenisbiaya->id)
                        ->where('jenjang','=',5)
                        ->update(array(
                           'jumlah'=>  str_replace(' ','',str_replace('.','', str_replace('Rp. ', '', Input::get('jenjang_5'))))
                        ));
                //jenjang 6
                DB::table('ketentuanbiaya')
                        ->where('tahunajaran_id','=',$tahunajaran->id)
                        ->where('jenisbiaya_id','=',$jenisbiaya->id)
                        ->where('jenjang','=',6)
                        ->update(array(
                           'jumlah'=>  str_replace(' ','',str_replace('.','', str_replace('Rp. ', '', Input::get('jenjang_6'))))
                        ));

                //commit
                DB::connection()->pdo->commit();
            }else{
                //insert data baru
                DB::connection()->pdo->beginTransaction();

                DB::table('ketentuanbiaya')->insert(array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>$tahunajaran->id,
                    'jenisbiaya_id'=>$jenisbiaya->id,
                    'jenjang'=>1,
                    'jumlah'=>str_replace(' ','',str_replace('.','', str_replace('Rp. ', '', Input::get('jenjang_1'))))
                ));

                DB::table('ketentuanbiaya')->insert(array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>$tahunajaran->id,
                    'jenisbiaya_id'=>$jenisbiaya->id,
                    'jenjang'=>2,
                    'jumlah'=>str_replace(' ','',str_replace('.','', str_replace('Rp. ', '', Input::get('jenjang_2'))))
                ));

                DB::table('ketentuanbiaya')->insert(array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>$tahunajaran->id,
                    'jenisbiaya_id'=>$jenisbiaya->id,
                    'jenjang'=>3,
                    'jumlah'=>str_replace(' ','',str_replace('.','', str_replace('Rp. ', '', Input::get('jenjang_3'))))
                ));

                DB::table('ketentuanbiaya')->insert(array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>$tahunajaran->id,
                    'jenisbiaya_id'=>$jenisbiaya->id,
                    'jenjang'=>4,
                    'jumlah'=>str_replace(' ','',str_replace('.','', str_replace('Rp. ', '', Input::get('jenjang_4'))))
                ));

                DB::table('ketentuanbiaya')->insert(array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>$tahunajaran->id,
                    'jenisbiaya_id'=>$jenisbiaya->id,
                    'jenjang'=>5,
                    'jumlah'=>str_replace(' ','',str_replace('.','', str_replace('Rp. ', '', Input::get('jenjang_5'))))
                ));

                DB::table('ketentuanbiaya')->insert(array(
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'tahunajaran_id'=>$tahunajaran->id,
                    'jenisbiaya_id'=>$jenisbiaya->id,
                    'jenjang'=>6,
                    'jumlah'=>str_replace(' ','',str_replace('.','', str_replace('Rp. ', '', Input::get('jenjang_6'))))
                ));

                DB::connection()->pdo->commit();

            }

        }else{
            $ketbiaya = Ketentuanbiaya::where('tahunajaran_id','=',Input::get('tahunajaran_id'))
                    ->where('jenisbiaya_id','=',Input::get('jenisbiaya_id'))
                    ->first();

            if ($ketbiaya){
                //update
                $ketbiaya->jumlah = str_replace(' ','',str_replace('.','', str_replace('Rp. ', '', Input::get('jumlah'))));
                $ketbiaya->save();
            }else{
                //insert
                $newketbiaya = new Ketentuanbiaya();
                $newketbiaya->tahunajaran_id = $tahunajaran->id;
                $newketbiaya->jenisbiaya_id = $jenisbiaya->id;
                $newketbiaya->jumlah = str_replace(' ','',str_replace('.','', str_replace('Rp. ', '', Input::get('jumlah'))));
                $newketbiaya->save();

            }

        }

        return Redirect::to('setting/setbiaya');
    }

    public function get_ajaxpengaturan($tahunajaran_id,$jenisbiaya_id){
        $this->layout = null;

        $jenisbiaya = Jenisbiaya::find($jenisbiaya_id);
        $ketentuanbiaya = Ketentuanbiaya::where('jenisbiaya_id','=',$jenisbiaya_id)
                ->where('tahunajaran_id','=',$tahunajaran_id)
                ->get();
        $tahunajaran = Tahunajaran::find($tahunajaran_id);

        return View::make('setting.setbiaya.ajaxpengaturan')
                ->with('jenisbiaya',$jenisbiaya)
                ->with('ketentuanbiaya',$ketentuanbiaya)
                ->with('tahunajaran',$tahunajaran);

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


}
