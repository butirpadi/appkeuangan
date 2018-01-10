<?php

use Rah\Danpu\Dump;
use Rah\Danpu\Export;
use \MySQLDump;

class Home_Controller extends Base_Controller {
    
        public function __construct() {
            parent::__construct();
            
            //filter login
            $this->filter('before', 'auth');
        }
        
        public function get_index($view = 'index.html')
	{
                $user = Auth::retrieve(Session::get('onuser_id'));
                $tahunaktif = Tahunajaran::where('aktif','=','Y')->first();
                
                $trans = Transmasuk::where('tanggal','=',date('Y-m-d'))->get();
                
		$this->layout->nest('content', 'home.index',array('user'=>$user,'tahunaktif' => $tahunaktif,'trans' => $trans));
	}
        
        public function get_test(){
            $this->layout = null;
            
            $dump = new MySQLDump(new mysqli('localhost', 'simas', 'simas', 'simasad'));
            $dump->tables['search_cache'] = MySQLDump::DROP | MySQLDump::CREATE;
            $dump->tables['log'] = MySQLDump::NONE;
            $dump->save('d:/export.sql.gz');
            
            echo 'test';
        }
        
        public function get_viewsiswabynama($tahunajaranid,$nama){
            $listsiswa = Viewsiswa::where('nama','like','%' . $nama . '%')->where('tahunajaran_id','=',$tahunajaranid)->get();
            return View::make('transaksi.bayariuran.ajaxlistsiswa')->with('listsiswa',$listsiswa);
        }

}