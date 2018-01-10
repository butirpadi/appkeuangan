<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of biaya
 *
 * @author root
 */
class Setting_Biaya_Controller extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_biaya');
    }
    
    public function get_index(){
        $jenisbiaya = Jenisbiaya::all();
        $this->layout->nest('content', 'setting.biaya.index',array('jenisbiaya'=>$jenisbiaya));
    }
    
    public function get_new(){
        $this->layout->nest('content', 'setting.biaya.new');
    }
    
    public function post_new(){
        $this->layout = null;
        
        $tetap = Input::get('tetap');
        $iuran = Input::get('iuran');
        $bulanan = Input::get('bulanan');
        $jenjang = Input::get('jenjang');
        $arus = Input::get('arus');
                
        $jenisbiaya = new Jenisbiaya();
        $jenisbiaya->nama = Input::get('nama');
        $jenisbiaya->arus = $arus;
        
        if($arus == 'K'){
            $jenisbiaya->tipe = 'BBBI';
            $jenisbiaya->perjenjang = 'N';
        }else{
            if($tetap == 'tetap'){
                if($iuran == 'iuran'){
                    //biaya tetap
                    if($bulanan == 'bulanan'){
                        $jenisbiaya->tipe = 'ITB';
                        $jenisbiaya->perjenjang = 'Y';
//                        if($jenjang == 'beda' ){
//                            $jenisbiaya->perjenjang = 'Y';
//                        }else{
//                            $jenisbiaya->perjenjang = 'N';
//                        }
                    }else{
                        $jenisbiaya->tipe = 'ITC';
                        $jenisbiaya->perjenjang = 'Y';
//                        if($jenjang == 'beda' ){
//                            $jenisbiaya->perjenjang = 'Y';
//                        }else{
//                            $jenisbiaya->perjenjang = 'N';
//                        }
                    }
                }else{
                    $jenisbiaya->tipe = 'BTBI';
                    $jenisbiaya->perjenjang = 'N';
                }
            }else{
                //biaya bebas
                 if($iuran == 'iuran'){
                    $jenisbiaya->tipe = 'IB';
                }else{
                    $jenisbiaya->tipe = 'BBBI';
                }
            }
            
        }
        
        
        $jenisbiaya->save();
        
        return Laravel\Redirect::to('setting/biaya');
    }
    
    public function get_edit($biaya_id){
        $jenisbiaya = Jenisbiaya::find($biaya_id);
        $this->layout->nest('content', 'setting.biaya.edit',array('jenisbiaya'=>$jenisbiaya));
    }
    /**
     * Simpan data jenis biaya
     */
    public function post_edit(){
        $this->layout = null;
        
        $tetap = Input::get('tetap');
        $iuran = Input::get('iuran');
        $bulanan = Input::get('bulanan');
        $jenjang = Input::get('jenjang');
        $arus = Input::get('arus');
                
        $jenisbiaya = Jenisbiaya::find(Input::get('jenisbiaya_id'));
        $jenisbiaya->nama = Input::get('nama');
        $jenisbiaya->arus = $arus;
        
        if($arus == 'K'){
            $jenisbiaya->tipe = 'BBBI';
            $jenisbiaya->perjenjang = 'N';
        }else{
            if($tetap == 'tetap'){
                if($iuran == 'iuran'){
                    if($bulanan == 'bulanan'){
                        $jenisbiaya->tipe = 'ITB';
                        if($jenjang == 'beda' ){
                            $jenisbiaya->perjenjang = 'Y';
                        }else{
                            $jenisbiaya->perjenjang = 'N';
                        }
                    }else{
                        $jenisbiaya->tipe = 'ITC';
                        if($jenjang == 'beda' ){
                            $jenisbiaya->perjenjang = 'Y';
                        }else{
                            $jenisbiaya->perjenjang = 'N';
                        }
                    }
                }else{
                    $jenisbiaya->tipe = 'BTBI';
                    $jenisbiaya->perjenjang = 'N';
                }
            }else{
                //biaya bebas
                 if($iuran == 'iuran'){
                    $jenisbiaya->tipe = 'IB';
                }else{
                    $jenisbiaya->tipe = 'BBBI';
                }
            }
            
        }
        
        
        $jenisbiaya->save();
        
        return Laravel\Redirect::to('setting/biaya');
    }    
    /**
     * simpan data ketentuan biaya perjenjang
     */
    public function post_editketentuanjenjang(){
        $this->layout = null;
        
        $input= Input::all();
        echo var_dump($input);
    }
    /**
     * Simpan data ketentuan biaya tetap bukan perjenjang
     */
    public function post_editketentuan(){
        $this->layout = null;
    }
    
    public function get_delete($biaya_id){
        if ($biaya_id > 1){
        
            //delete ketentuan dulu baru delete biayayna
            DB::connection()->pdo->beginTransaction();

            //delete ketentuan biaya
            DB::table('ketentuanbiaya')
                    ->where('jenisbiaya_id','=',$biaya_id)
                    ->delete();
            //delete biaya
            DB::table('jenisbiaya')
                    ->where('id','=',$biaya_id)
                    ->delete();

            //commit
            DB::connection()->pdo->commit();
            
        }
        
        return Laravel\Redirect::to('setting/biaya');
    }
        
}
