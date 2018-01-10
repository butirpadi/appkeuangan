<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rekapsiswa
 *
 * @author Klik
 */
class Rekap_Rekapsiswa_Controller extends Base_Controller{
    
        public function __construct() {
            parent::__construct();

            //filter login
            $this->filter('before', 'auth');
            //filter permission
            $this->filter('before', 'permission:manage_rekap_siswa');
        }

        public function get_index(){
             //set assets
            Asset::container('footer')->add('rupiah', 'js/rupiah.js');

            $tahunajarans = Tahunajaran::all();
            $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
            $selecttahunajaran = array();
            foreach($tahunajarans as $ta){
                $selecttahunajaran[$ta->id] = $ta->nama;
            }
            
            $bulans = Bulan::order_by('posisi','asc')->get();

            $this->layout->nest('content', 'rekap.rekapsiswa.index',array(
                'tahunajarans'=>$tahunajarans,
                'tahunaktif'=>$tahunaktif,
                'selectTahunajaran'=>$selecttahunajaran,
                'bulans' => $bulans
            ));
        }
        
        public function get_siswabynis($tapelId,$nis){
            $siswa = Vsiswa::where('nisn','=',$nis)->where('tahunajaran_id','=',$tapelId)->first();
            
            return eloquent_to_json($siswa);
        }
        
        public function get_viewsiswabynama($tahunajaranid,$nama){
            $listsiswa = Viewsiswa::where('nama','like','%' . $nama . '%')->where('tahunajaran_id','=',$tahunajaranid)->get();
            return View::make('rekap.rekapsiswa.ajaxlistsiswa')->with('listsiswa',$listsiswa);
        }
        
        public function get_transaksispp($tahunId,$siswaId){
            $datatrans = DB::query('select * from view_transmasuk where jenisbiaya_id = 1 and tahunajaran_id = ' . $tahunId . ' and siswa_id = ' . $siswaId);
            $bulans = Bulan::order_by('posisi','asc')->get();
            return View::make('rekap.rekapsiswa.ajaxlistspp')
                    ->with('datatrans',$datatrans)
                    ->with('bulans',$bulans);
        }
        
        public function get_transaksipartisipasi($tahunId,$siswaId){
            $datatrans = DB::query('select * from view_transmasuk where jenisbiaya_id = 3 and tahunajaran_id = ' . $tahunId . ' and siswa_id = ' . $siswaId);
            return View::make('rekap.rekapsiswa.ajaxlistpartisipasi')
                    ->with('datatrans',$datatrans);
        }
        
        public function get_transaksi($tahunId,$siswaId){
            $datatrans = DB::query('select * from view_transmasuk where tahunajaran_id = ' . $tahunId . ' and siswa_id = ' . $siswaId);
            return View::make('rekap.rekapsiswa.ajaxlisttrans')
                    ->with('datatrans',$datatrans);
        }
}
