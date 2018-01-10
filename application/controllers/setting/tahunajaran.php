<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tahunajaran
 *
 * @author root
 */
class Setting_Tahunajaran_Controller extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_tahun_ajaran');
    }
    
    public function get_index(){
        $tahunajarans = Tahunajaran::order_by('posisi','asc')->get();
        $this->layout->nest('content', 'setting.tahunajaran.index',array('tahunajarans'=>$tahunajarans));
    }
    
    public function post_index(){
        //simpan data menggunakan transaction
        DB::connection()->pdo->beginTransaction();          

        //jika data baru di set aktif maka non aktifkan yang lain dulu
        if (Input::get('aktif') == 'Y' ){
            //set data yang lain tidak aktif
            DB::table('tahunajaran')->update(array('aktif'=>'N'));
        }

        //ambil no urut terakhir
        $posisiterakhir = DB::table('tahunajaran')->max('posisi');

        //insert tahun ajaran baru
        $tahun = array(
            'nama'=>Input::get('nama'),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
            'aktif' => Input::get('aktif'),
            'posisi' => ($posisiterakhir+1)
        );
        DB::table('tahunajaran')->insert_get_id($tahun);

        //commit
        DB::connection()->pdo->commit();
        
        return Redirect::to('setting/tahunajaran');
    }
    
    public function get_new(){
        $this->layout->nest('content', 'setting.tahunajaran.new');
    }
    
    public function post_new(){
         //simpan data menggunakan transaction
        DB::connection()->pdo->beginTransaction();          

        //jika data baru di set aktif maka non aktifkan yang lain dulu
        if (Input::get('aktif') == 'Y' ){
            //set data yang lain tidak aktif
            DB::table('tahunajaran')->update(array('aktif'=>'N'));
        }

        //ambil no urut terakhir
        $posisiterakhir = DB::table('tahunajaran')->max('posisi');

        //insert tahun ajaran baru
        $tahun = array(
            'nama'=>Input::get('nama'),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
            'aktif' => Input::get('aktif'),
            'posisi' => ($posisiterakhir+1)
        );
        DB::table('tahunajaran')->insert_get_id($tahun);

        //commit
        DB::connection()->pdo->commit();
        
        return Redirect::to('setting/tahunajaran');
    }
    
    public function get_edit($tahunajaran_id){
        $tahunajaran = Tahunajaran::find($tahunajaran_id);
        $this->layout->nest('content', 'setting.tahunajaran.edit',array('tahunajaran'=>$tahunajaran));
    }
    
    public function post_edit(){
        $tahunajaran = Tahunajaran::Find(Input::get('tahunajaran_id'));
        $tahunajaran->nama = Input::get('nama');
        $tahunajaran->aktif = Input::get('aktif');
        
        if ($tahunajaran->aktif == 'Y' ){
            //non aktifkan dulu yang lain
            //simpan data menggunakan transaction
            DB::connection()->pdo->beginTransaction();          
            //set data yang lain tidak aktif
            DB::table('tahunajaran')->update(array('aktif'=>'N'));
            //update aktif
            DB::table('tahunajaran')
                    ->where('id','=',$tahunajaran->id)
                    ->update(array('nama'=>Input::get('nama'),'aktif'=>'Y'));
            //commit
            DB::connection()->pdo->commit();
        }else{
            $tahunajaran->save();
        }
        
        return Redirect::to('setting/tahunajaran');
    }
    
    public function get_delete($tahunajaran_id){
        $tahunajaran = Tahunajaran::find($tahunajaran_id);
        $posisi = $tahunajaran->posisi;
        $tahunajaran->delete();
        
        //rubah posisi yang diatas tahun ini agar posisi tahun ajaran tidak kacau
        DB::update('update tahunajaran set posisi = (posisi-1) where posisi > ' . $posisi);
        
        return Redirect::to('setting/tahunajaran');
    }
    
    public function get_shiftup($tahun_id){
        $tahun = Tahunajaran::find($tahun_id);
        if ($tahun->posisi > 1){
            $prevtahun = Tahunajaran::where('posisi','=',$tahun->posisi-1)->first();
            $tahun->posisi = $tahun->posisi-1;
            $tahun->save();
            $prevtahun->posisi = $prevtahun->posisi+1;            
            $prevtahun->save();
        }
        
        return Redirect::to('setting/tahunajaran');
    }
    
    public function get_shiftdown($tahun_id){
        $tahun = Tahunajaran::find($tahun_id);
        if ($tahun->posisi < 12){
            $nexttahun = Tahunajaran::where('posisi','=',$tahun->posisi+1)->first();
            $tahun->posisi = $tahun->posisi+1;
            $tahun->save();
            $nexttahun->posisi = $nexttahun->posisi-1;            
            $nexttahun->save();
        }
        
        return Redirect::to('setting/tahunajaran');
    }
}

?>
