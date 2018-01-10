<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siswa
 *
 * @author root
 */
class Setting_Siswa_Controller extends Base_Controller {
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_siswa');
    }
    
    public function get_index(){
        $siswas = Siswa::with('rombel')->get();
        $rombels = Rombel::order_by('jenjang','asc')->get();
        $rombelselect = array('all' => 'Semua');
        foreach($rombels as $rombel){
            $rombelselect[$rombel->id] = $rombel->nama;
        }
        
        
        //tahunajaran
        $datatahunajaran = Tahunajaran::order_by('posisi','asc')->get();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $selectTahunAjaran = array();
        foreach($datatahunajaran as $ta){
            $selectTahunAjaran[$ta->id] = $ta->nama;
        }
        
        //untuk kenaikan kelas
        if($tahunaktif){
            $tahunlanjut = Tahunajaran::where('posisi','=',$tahunaktif->posisi + 1)->first();
        }else{
            $tahunlanjut = null;
        }
        
        
        $this->layout->nest('content', 'setting.siswa.index',array(
            'selectTahunAjaran'=>$selectTahunAjaran,
            'tahunaktif'=>$tahunaktif,
            'siswas'=>$siswas,
            'rombelselect'=>$rombelselect,
            'rombels'=>$rombels,
            'tahunlanjut' => $tahunlanjut
                ));
    }
    
    public function get_rep($nama){
        return str_replace("'","`",$nama);
    }
    
    public function get_new(){
        $rombels = Rombel::order_by('jenjang','asc')->get();
        $rombelselect = array();
        foreach($rombels as $rombel){
            $rombelselect[$rombel->id] = $rombel->nama;
        }
        
        //tahunajaran
        $datatahunajaran = Tahunajaran::order_by('posisi','asc')->get();
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        $selectTahunAjaran = array();
        foreach($datatahunajaran as $ta){
            $selectTahunAjaran[$ta->id] = $ta->nama;
        }
        
        //untuk kenaikan kelas
        if($tahunaktif){
            $tahunlanjut = Tahunajaran::where('posisi','=',$tahunaktif->posisi + 1)->first();
        }else{
            $tahunlanjut = null;
        }
        
        $this->layout->nest('content', 'setting.siswa.new',array(
            'selectTahunAjaran'=>$selectTahunAjaran,
            'tahunaktif'=>$tahunaktif,
            'rombelselect'=>$rombelselect,
            'rombels'=>$rombels,
            'tahunlanjut' => $tahunlanjut
                ));
    }
    
    public function post_new(){
        $this->layout = null;
        
        //begin connection
        DB::connection()->pdo->beginTransaction();          
        //insert data siswa
        
        $rombel = Rombel::find(Input::get('rombel'));
        if (Input::get('mutasi') == true){
            //input jenjang_spp dengan 1 untuk mengikuti spp yang terbaru
            $siswa = array(
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                'nama'=> str_replace("'","`",ucwords(strtolower(Input::get('nama')))),
                'nisn'=>Input::get('nisn'),
                'jenjang_spp'=>1,
                'mutasi'=>'Y'
            );
        }else{
            //input jenjang sPP yang sesuai rombel
            $siswa = array(
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                'nama'=> str_replace("'","`",ucwords(strtolower(Input::get('nama')))),
                'nisn'=>Input::get('nisn'),
                'jenjang_spp'=>$rombel->jenjang
            );
        }        
        
        $siswa_id = DB::table('siswa')->insert_get_id($siswa);
        //insert rombel        
        DB::table('rombelsiswa')->insert(array(
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
            'tahunajaran_id' => Input::get('tahunajaraninput'),
            'siswa_id' => $siswa_id,
            'rombel_id' => Input::get('rombel')
        ));
        //commit
        DB::connection()->pdo->commit();
        
        return Redirect::to('setting/siswa');
    }
    
    public function get_edit($siswa_id,$tahunajaran_id){
        $siswa = Siswa::find($siswa_id);
        $tahunajaranaktif = Tahunajaran::where('aktif','=','Y')->first();
        $tahunselected = Tahunajaran::find($tahunajaran_id);
        $rombels = Rombel::all();
        $rombelselect = array();
        foreach($rombels as $rombel){
            $rombelselect[$rombel->id] = $rombel->nama;
        }
        
        $this->layout->nest('content', 'setting.siswa.edit',array(
            'siswa'=>$siswa,
            'rombelselect'=>$rombelselect,
            'tahunajaranaktif'=>$tahunajaranaktif,
            'tahunselected'=>$tahunselected
            ));
    }
    
    public function post_edit(){
        $this->layout = null;        
        
        //begin connection
        DB::connection()->pdo->beginTransaction();          
        //update data siswa
        DB::table('siswa')
                ->where('id','=',Input::get('siswa_id'))
                ->update(array(
                   'nama'=>  Input::get('nama'),
                   'nisn'=>  Input::get('nisn')
                ));
        //update data rombel
        $tahunajaran = Input::get('tahunajaran');
        DB::table('rombelsiswa')
                ->where('tahunajaran_id','=',$tahunajaran)
                ->where('siswa_id','=',Input::get('siswa_id'))
                ->update(array(
                   'rombel_id'=>  Input::get('rombel')
                ));
        //commit
        DB::connection()->pdo->commit();        
        
        return Redirect::to('setting/siswa');
    }
    
    public function get_delete($siswa_id){
        $siswa = Siswa::find($siswa_id);
        $siswa->aktif ='N';
        $siswa->save();
        
        return Redirect::to('setting/siswa');
    }
    
    public function get_ajaxselectsiswa($rombel_id){
        
        if ($rombel_id == 'all'){
            $siswas = Siswa::all();
        }else{
            $siswas = Siswa::where('rombel_id','=',$rombel_id)->get();
        }
        
        $selectSiswa = array('all'=>'Semua');
        foreach($siswas as $sis){
            $selectSiswa[$sis->id] = $sis->nisn . ' - ' .$sis->nama;
        }
        
        return \Laravel\Form::select('siswa', $selectSiswa, null, array('id'=>'selectSiswa'));
    }
    
    public function get_jsonsiswabynisn($nisn){
        $siswa = Vsiswa::where('nisn','=',$nisn)->first();
        if ($siswa){
            return eloquent_to_json($siswa);
        }else{
            return '"null"';
        }
    }
    
    public function get_jsonsiswabyid($siswa_id){
        $siswa = Vsiswa::where('siswa_id','=',$siswa_id)->first();
        if ($siswa){
            return eloquent_to_json($siswa);
        }else{
            return '"null"';
        }
    }
    
    public function post_transfer(){
        $tahunajaranasal = Input::get('tahunajaranasal');
        $tahunajaranlanjut = Input::get('tahunajaranlanjut');
        $rombelasal = Input::get('rombelasal');
        $rombellanjut = Input::get('rombellanjut');
                
        $query = 'insert into rombelsiswa (created_at,updated_at,tahunajaran_id,rombel_id,siswa_id) 
            (select "' . date('Y-m-d H:i:s') . '" , "' . date('Y-m-d H:i:s') . '" ,' . $tahunajaranlanjut . ',' . $rombellanjut . ',s.id from siswa s inner join rombelsiswa rs on rs.id = s.id 
                where rs.rombel_id = ' . $rombelasal . ' and tahunajaran_id = ' . $tahunajaranasal . ' )';
        
        //begin connection
        DB::connection()->pdo->beginTransaction();          
        //delete dulu jika data sudah ada
        DB::table('rombelsiswa')
                ->where('tahunajaran_id','=',$tahunajaranlanjut)
                ->where('rombel_id','=',$rombellanjut)
                ->delete();
        //insert data yang baru
        DB::query($query);
        //commit
        DB::connection()->pdo->commit();   
        
        
        return Redirect::to('setting/siswa');
    }
    
    /**
     * mengembalikan ajax data siswa berdasar tahun ajaran dan rombel
     * @param type $tahunajaran_id
     * @param type $rombel_id
     */
    public function get_ajxsiswa($tahunajaran_id,$rombel_id){
        $tahunajaran = Tahunajaran::find($tahunajaran_id);
        
        if($rombel_id == 'all'){
            $siswas = Vsiswa::where('tahunajaran_id','=',$tahunajaran_id)
                ->where('aktif','=','Y')
                ->order_by('jenjang','asc')
                ->order_by('rombel_id','asc')
                ->order_by('nisn','asc')
                ->get();
        }else{
            $siswas = Vsiswa::where('tahunajaran_id','=',$tahunajaran_id)
                ->where('rombel_id','=',$rombel_id)
                ->where('aktif','=','Y')
                ->order_by('jenjang','asc')
                ->order_by('rombel_id','asc')
                ->order_by('nisn','asc')
                ->get();
        }
        
        return View::make('setting/siswa/ajaxtabelsiswa')
                ->with('siswas',$siswas)
                ->with('tahunajaran',$tahunajaran);
    }
    
    public function get_refresh(){
        $this->layout = null;
        $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
        //isi jenjang_spp
        $siswa = Siswa::all();
        foreach($siswa as $sis){
            echo $sis->nisn . ' ' . $sis->nama . '<br/>';
            $rom = $sis->rombels()->where('tahunajaran_id','=',$tahunaktif->id)->first();
            echo  ($rom ? $rom->nama : 'NULL');
            echo '<br/><br/><br/>';
            
            $sis->jenjang_spp = ($rom ? $rom->jenjang : 'NULL');
            $sis->save();
        }
        
        echo 'selesai';
    }
    
    public function get_nonaktif($id){
        $siswa = Siswa::find($id);
        $siswa->aktif = 'N';
        $siswa->save();
        
        return Redirect::to('setting/siswa');
    }
    
    public function get_rombelselect($jenjang='all'){
        if ($jenjang == 'all'){
            $rombels = Rombel::order_by('jenjang','asc')->get();
            $rombelselect = array();
            foreach($rombels as $rombel){
                $rombelselect[$rombel->id] = $rombel->nama;
            }
        }else{
            $rombels = Rombel::where('jenjang','=',$jenjang)->order_by('jenjang','asc')->get();
            $rombelselect = array();
            foreach($rombels as $rombel){
                $rombelselect[$rombel->id] = $rombel->nama;
            }
        }
        
        return \Laravel\Form::select('rombel', $rombelselect);
    }
    
    public function get_printtopdf($tahunajaranid,$rombelid='all'){
        $this->layout = null;
        
        $tahunajaran = Tahunajaran::find($tahunajaranid);
        
        if($rombelid != 'all'){
            $rombel = Rombel::find($rombelid);
        }
        
        if($rombelid == 'all'){
            $siswas = Vsiswa::where('tahunajaran_id','=',$tahunajaranid)
                ->where('aktif','=','Y')
                ->order_by('jenjang','asc')
                ->order_by('rombel_id','asc')
                ->order_by('nisn','asc')
                ->get();
        }else{
            $siswas = Vsiswa::where('tahunajaran_id','=',$tahunajaranid)
                ->where('rombel_id','=',$rombelid)
                ->where('aktif','=','Y')
                ->order_by('jenjang','asc')
                ->order_by('rombel_id','asc')
                ->order_by('nisn','asc')
                ->get();
        }
        
        //set report header setting
        $namasekolah = Setting::first()->nama_skul;
        $alamat = Setting::first()->alamat_skul;
        $namareport = 'Data Siswa Tahun Ajaran ' . $tahunajaran->nama;
        if($rombelid != 'all'){
            $namakelas = 'Rombongan Belajar ' . $rombel->nama;
        }
        //pre defined
        $isFirstPage = true;
        $tglcetak = date('d-m-Y [H:i:s]');        
        //set column with variables
        $colnum = 10;
        $colnis = 20;
        $colnama = 100;
        $colrombel = 65;
        //$coltgl = 30;
        
        $pdf = new Fpdf('P','mm',array(215,330));
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();
        
        //create page header
        $pdf->SetFont('Courier','B',16);
        $pdf->Cell(0,8,$namareport,0,1,'C');
        if($rombelid != 'all'){
            $pdf->SetFont('Courier','',12);
            $pdf->Cell(0,8,$namakelas,0,1,'C');
        }
        $pdf->SetFont('Courier','',12);
        $pdf->Cell(0,5,$namasekolah,0,1,'C');
        $pdf->SetFont('Courier','',10);
        $pdf->Cell(0,5,$alamat,0,1,'C');
        $pdf->Cell(0,2,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,0.1,'','B',1);
        $pdf->Cell(0,1,'','B',1);
        $pdf->ln(5);
        //create report header
        $pdf->Cell(100,5,'Tahun Ajaran        : ' . $tahunajaran->nama,0,0,'L');
        $pdf->Cell(95,5,'Dicetak pada        : ' . $tglcetak,0,1,'R');
        
        $pdf->ln(5);
        //create table header
        $pdf->SetFont('Courier','',12);
        $pdf->Cell($colnum,8,'NO',1,0,'C');
        $pdf->Cell($colnis,8,'NIS',1,0,'C');
        $pdf->Cell($colnama,8,'Nama',1,0,'C');
        $pdf->Cell($colrombel,8,'Rombel',1,0,'C');
        $pdf->ln();
        
        //create content
        $pdf->SetFont('Courier','',10);
        $rownum = 1;
        $yAxis = 65;
        $totm = 0;
        $totk = 0;
        $totmlalu=0;
        $totklalu=0;
        
        foreach($siswas as $sis){
            $pdf->SetFont('Courier','',10);
            $pdf->Cell($colnum,5,$rownum++,1,0,'R');
            $pdf->Cell($colnis,5,$sis->nisn,1,0,'L');
            $pdf->Cell($colnama,5,ucwords(strtolower($sis->siswa)),1,0,'L');
            $pdf->Cell($colrombel,5,$sis->rombel,1,0,'L');
            $pdf->ln();           
            
            //new page setting
            $yAxis += 10;
            
            if($isFirstPage){
                $batasAkhirAxis = 590;
            }else{
                $batasAkhirAxis = 640;
            }
            
            if ($yAxis> $batasAkhirAxis){
                //add new page
                $pdf->AddPage();
                //sub header
                $pdf->SetFont('Courier','',10);
                $pdf->Cell($colnum+$colnis+$colnama,10,$namareport . '  (' . $tglcetak . ') ',0,0,'L'); //page number
                $pdf->Cell($colrombel,10,'Page ' . $pdf->PageNo(),0,1,'R'); //page number
                //create page header
                $pdf->SetFont('Courier','',12);
                $pdf->Cell($colnum,8,'NO',1,0,'C');
                $pdf->Cell($colnis,8,'NIS',1,0,'C');
                $pdf->Cell($colnama,8,'Nama',1,0,'C');
                $pdf->Cell($colrombel,8,'Rombel',1,0,'C');
                $pdf->ln();
                
                $yAxis = 65;
                $isFirstPage = false;
            }
        }                
        $pdf->Output('RekapDataSiswa_'.date('YmdHis').'.pdf','D');
    }
    
}
