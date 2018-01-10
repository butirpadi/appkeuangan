<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of potongan
 *
 * @author Klik
 */
class Setting_Potongan_Controller extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_beasiswa');
    }
    
    public function get_index(){
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $selecttahunajaran = array();
        foreach($tahunajarans as $ta){
            $selecttahunajaran[$ta->id] = $ta->nama;
        }
        
        $this->layout->nest('content', 'setting.potongan.index',array(
            'selecttahunajaran' => $selecttahunajaran,
            'tahunaktif' => $tahunaktif
                ));
    }
    
    public function get_new(){
        $tahunajarans = Tahunajaran::all();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $selecttahunajaran = array();
        foreach($tahunajarans as $ta){
            $selecttahunajaran[$ta->id] = $ta->nama;
        }
        
        $jenisbiayas = Jenisbiaya::where_in('tipe',array('ITB','ITC'))->get();
        $selectjenisbiaya = array();
        foreach($jenisbiayas as $jb){
            $selectjenisbiaya[$jb->id] = ucwords($jb->nama);
        }
        
        $this->layout->nest('content', 'setting.potongan.new',array(
            'selecttahunajaran' => $selecttahunajaran,
            'tahunaktif' => $tahunaktif,
            'selectjenisbiaya' => $selectjenisbiaya
        ));
    }
    
    public function post_new(){
        $this->layout = null;
        
        $tahunajaran = Tahunajaran::find(Input::get('tahunajaran'));
        $siswa = Siswa::find(Input::get('siswa_id'));
        $jenisbiaya = Jenisbiaya::find(Input::get('jenisbiaya'));
        
        if($jenisbiaya->tipe == 'ITB'){
            //input banyak per bulan yang dipilih
            $bulans = Input::get('bulan');
            for($i=0;$i<count($bulans);$i++){
                $tahunajaran->potonganiuran()->attach($siswa,array(
                'jenisbiaya_id' => $jenisbiaya->id,
                'disc' => Input::get('disc'),
                'nilai' => str_replace(' ', '', str_replace('Rp', '', str_replace('.', '', Input::get('nilai')))),
                'ket' => Input::get('keterangan'),
                'jenis' => Input::get('jenis'),
                'bulan_id' => $bulans[$i]
                    ));
            }
            
        }else{
            $tahunajaran->potonganiuran()->attach($siswa,array(
                'jenisbiaya_id' => $jenisbiaya->id,
                'disc' => Input::get('disc'),
                'nilai' => str_replace(' ', '', str_replace('Rp', '', str_replace('.', '', Input::get('nilai')))),
                'ket' => Input::get('keterangan'),
                'jenis' => Input::get('jenis')
                    ));
        }
        
        return Redirect::to('setting/potongan');
    }
    
    public function get_tahunajaran($id){
        $tahunajaran = Tahunajaran::find($id);
        
        return eloquent_to_json($tahunajaran);
    }
    
    public function get_listpotongan($tahunajaranid){
        // $tahunajaran = Tahunajaran::find($tahunajaranid);
        // return View::make('setting.potongan.ajaxlistpotongan')->with('tahunajaran',$tahunajaran);

        $data = DB::query("SELECT
                potongan.id,
                potongan.siswa_id,
                siswa.nisn,
                siswa.nama AS nama_siswa,
                rombel.id AS rombel_id,
                rombel.nama AS rombel,
                case when jenis = 'BP' then 'Bantuan Pendidikan' else 'Beasiswa Prestasi' end AS jenis_potongan,
                potongan.jenis,
                potongan.ket,
                potongan.jenisbiaya_id,
                jenisbiaya.nama AS jenis_biaya,
                potongan.bulan_id,
                potongan.tahunajaran_id,
                case when potongan.bulan_id != '' then bulan.nama else '-' end AS bulan,
                case when jenisbiaya_id = 1 then
                (select jumlah from ketentuanbiaya where jenisbiaya_id= potongan.jenisbiaya_id
                    and tahunajaran_id = potongan.tahunajaran_id and jenjang = siswa.jenjang_spp)
                else
                (select jumlah from ketentuanbiaya where jenisbiaya_id= potongan.jenisbiaya_id
                    and tahunajaran_id = potongan.tahunajaran_id and jenjang = rombel.jenjang)
                end as harus_bayar,
                potongan.disc,
                potongan.nilai,
                case when jenisbiaya_id = 1 then
                (select jumlah from ketentuanbiaya where jenisbiaya_id= potongan.jenisbiaya_id
                    and tahunajaran_id = potongan.tahunajaran_id and jenjang = siswa.jenjang_spp) - potongan.nilai
                else
                (select jumlah from ketentuanbiaya where jenisbiaya_id= potongan.jenisbiaya_id
                    and tahunajaran_id = potongan.tahunajaran_id and jenjang = rombel.jenjang) - potongan.nilai
                end as sisa_bayar
                
            FROM
                siswa
                INNER JOIN potongan
                 ON siswa.id = potongan.siswa_id
                INNER JOIN rombelsiswa
                 ON siswa.id = rombelsiswa.siswa_id
                INNER JOIN rombel
                 ON rombelsiswa.rombel_id = rombel.id
                INNER JOIN jenisbiaya
                 ON potongan.jenisbiaya_id = jenisbiaya.id
                LEFT OUTER JOIN bulan
                 ON potongan.bulan_id = bulan.id
            WHERE
                potongan.tahunajaran_id = " . $tahunajaranid . "
                and rombelsiswa.tahunajaran_id = " . $tahunajaranid);

        // echo count($data);

        return View::make('setting.potongan.ajaxlistpotongan_2')->with('data',$data);
    }
    
    public function get_listsiswa(){
        $siswa = Vsiswa::where('siswa','like','%'.Input::get('nama').'%')->where('tahunajaran_id','=',Input::get('tahunajaranid'))->get();
        return View::make('setting.potongan.ajaxlistsiswa')->with('listsiswa',$siswa);
    }
    
    public function get_siswabynis($tahunajaranid,$nis){
        //$siswa = Vsiswa::where('nisn','=',$nis)->first();
        $siswa = Viewsiswa::where('tahunajaran_id','=',$tahunajaranid)->where('nisn','=',$nis)->first();
        return eloquent_to_json($siswa);
    }
    
//    public function get_jenisbiaya($id,$jenjang,$tahunajaranid){
//        $jenisbiaya = DB::query('select kb.tahunajaran_id,kb.jenisbiaya_id, kb.jenjang,kb.jumlah,jb.nama,jb.tipe
//                from ketentuanbiaya kb inner join jenisbiaya jb on kb.jenisbiaya_id = jb.id 
//                inner join tahunajaran ta on kb.tahunajaran_id = ta.id
//                where jb.id = ' . $id . ' and jenjang = ' . $jenjang . ' and kb.tahunajaran_id = ' . $tahunajaranid);
//        
//        return Response::json($jenisbiaya[0]);
//    }
    
    public function get_jenisbiaya($id,$jenjang,$tahunajaranid,$siswaid){
        $this->layout = null;
        
        if($id == 1){
            //jika SPP
            $ket = Viewspp::where('id','=',$siswaid)->where('tahunajaran_id','=',$tahunajaranid)->first();
            //return var_dump($ket[0]);
            return eloquent_to_json($ket);
        }else{
            $jenisbiaya = DB::query('select kb.tahunajaran_id,kb.jenisbiaya_id, kb.jenjang,kb.jumlah,jb.nama,jb.tipe
                from ketentuanbiaya kb inner join jenisbiaya jb on kb.jenisbiaya_id = jb.id 
                inner join tahunajaran ta on kb.tahunajaran_id = ta.id
                where jb.id = ' . $id . ' and jenjang = ' . $jenjang . ' and kb.tahunajaran_id = ' . $tahunajaranid);
        
            return Response::json($jenisbiaya[0]);
        }
    }
    
    public function get_sisabulan($tahunajaran_id,$jenisbiaya_id,$siswa_id){
        $bulan = DB::query('select * from bulan
                where bulan.id not in (select dtm.bulan_id from detiltransmasuk dtm
                inner join transmasuk tm on dtm.transmasuk_id = tm.id
                where tm.siswa_id = ' . $siswa_id . ' and tm.tahunajaran_id = ' . $tahunajaran_id . ' and dtm.jenisbiaya_id = ' . $jenisbiaya_id . ')
                order by posisi asc');
        
        return View::make('setting.potongan.ajaxlistbulan')
                ->with('bulan',$bulan);
    }
    
    public function get_delete($id=null){
        if ($id==null){
            $id = Input::get('id');
        }
        
        $pot  = Potongan::find($id);
        $pot->delete();
        
        return Redirect::to('setting/potongan');
    }
    
}
