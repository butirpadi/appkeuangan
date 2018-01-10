<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of penyesuaian
 *
 * @author Klik
 */
class Setting_Penyesuaian_Controller extends Base_Controller {
        
        public function __construct() {
            parent::__construct();

            //filter login
            $this->filter('before', 'auth');
            //filter permission
            $this->filter('before', 'permission:manage_penyesuaian_spp');
        }

        public function get_index(){
            $tahunajarans = Tahunajaran::all();
            $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
            $selecttahunajaran = array();
            foreach($tahunajarans as $ta){
                $selecttahunajaran[$ta->id] = $ta->nama;
            }
            
            $datapenyesuaian = DB::query("select lp.id, lp.siswa_id, s.nisn, s.nama,s.jenjang_spp, 
                    (select jumlah from ketentuanbiaya where tahunajaran_id = (select id from tahunajaran where aktif = 'Y') 
                    and jenjang = s.jenjang_spp and jenisbiaya_id = 1) as spp_disesuaikan
                    from log_penyesuaian lp inner join siswa s on lp.siswa_id = s.id");
            
            $this->layout->nest('content', 'setting.penyesuaian.index',array(
                'tahunajarans'=>$tahunajarans,
                'tahunaktif'=>$tahunaktif,
                'selectTahunajaran'=>$selecttahunajaran,
                'datapenyesuaian' => $datapenyesuaian
            ));
        }
        
        public function get_siswabynis($tahunId,$nis){
            $siswa = Vsiswa::where('tahunajaran_id','=',$tahunId)->where('nisn','=',$nis)->first();
            return eloquent_to_json($siswa);
        }
        
        public function get_sppsiswa($tahunId,$nis){
            $spp = Viewspp::where('tahunajaran_id','=',$tahunId)->where('nisn','=',$nis)->first();
            return eloquent_to_json($spp);
        }
        
        public function get_nilaispp($tahunId,$jenjang){
            $nilaispp = DB::table('ketentuanbiaya')->where('jenisbiaya_id','=',1)->where('tahunajaran_id','=',$tahunId)->where('jenjang','=',$jenjang)->first();
            return json_encode($nilaispp);
        }
        
        public function post_penyesuaian(){
            $siswaId = Input::get('siswa_id');
            $jenjangSesuai = Input::get('jenjang_sesuai');
            $jenjangAwal = Input::get('jenjang_awal');
            $mutasi = Input::get('mutasi');
            
            $siswa = Siswa::where('id','=',$siswaId)->first();
            if($mutasi == 'Y'){
                $siswa->mutasi = 'Y';
            }            
            $siswa->jenjang_spp = $jenjangSesuai;
            $siswa->save();
            //add log
            $id = DB::table('log_penyesuaian')->insert_get_id(array('created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),'siswa_id'=>$siswaId,'jenjang_awal'=>$jenjangAwal,
                    'jenjang_penyesuaian'=>$jenjangSesuai));
            
            return $id;
        }
        
        public function get_delete($id){
            //kembalikan ke posisi semula
            DB::query("update siswa set jenjang_spp = (select jenjang from rombel where id = 
                (select rombel_id from rombelsiswa rs where siswa_id = 
                (select siswa_id from log_penyesuaian where id = " . $id .") 
                and tahunajaran_id = (select id from tahunajaran where aktif = 'Y') )) , mutasi = 'N' 
                where id = (select siswa_id from log_penyesuaian where id = " . $id . ")");
            
            //delete from log
            DB::table('log_penyesuaian')->where('id','=',$id)->delete();
            
            return Redirect::to('setting/penyesuaian');
        }
}
