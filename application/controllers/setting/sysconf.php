<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sysconf
 *
 * @author root
 */
class Setting_Sysconf_Controller extends Base_Controller{
    
    public function __construct() {
        parent::__construct();
        
        //filter login
        $this->filter('before', 'auth');
        //filter permission
        $this->filter('before', 'permission:manage_system_setting');
    }
    
    public function get_index(){
        $appset = Appsetting::first();
        $datatahunajaran = Tahunajaran::all();
        $datapencapaian = Vtargetpencapaian::order_by('posisi','asc')->get();
        $iurans = Jenisbiaya::where_in('tipe',array('ITB','ITC','IB'))->get();
        $selectjenisbiaya = array();
        foreach($iurans as $data){
            $selectjenisbiaya[$data->id] = $data->nama;
        }
        $this->layout->nest('content', 'setting.sysconf.index',array(
            'appset'=>$appset,
            'datatahunajaran'=>$datatahunajaran,
            'datapencapaian'=>$datapencapaian,
            'iuran'=>$iurans,
            'selectjenisbiaya'=>$selectjenisbiaya,
                ));
    }
    
    public function post_targetbulanan(){
        $tahunajaran = Tahunajaran::find(Input::get('tahunajaranid'));
        $jenisbiaya = Jenisbiaya::find(Input::get('jenisbiayaid'));
        $jumlah = Input::get('jumlah');
        
        //delete data sebelumnya
        $target = $tahunajaran->targetbiayabulanan()->where('jenisbiaya_id','=',$jenisbiaya->id)->first();
        if($target){
            $target->pivot->jumlah = $jumlah;
            $target->pivot->save();
        }else{
            //$tahunajaran->targetbiayabulanan()->where('jenisbiaya_id','=',$jenisbiaya->id)->delete();
            $tahunajaran->targetbiayabulanan()->attach($jenisbiaya,array('jumlah' => $jumlah));
        }
        

        
        return true;
    }
    
    public function get_ajaxtargetbulanan($jenisbiaya_id){
        $jenisbiaya = Jenisbiaya::find($jenisbiaya_id);
        $tahunajaran = Tahunajaran::with('targetbiayabulanan')->get();
        return View::make('setting.sysconf.ajaxtargetbulan')
                ->with('jenisbiaya',$jenisbiaya)
                ->with('tahunajaran',$tahunajaran);
    }
    
    public function post_targetpencapaian(){
        $tahunajaran_id = Input::get('tahun_id');
        $jumlah = Input::get('jumlah');
        
        $target = Targetpencapaian::where('tahunajaran_id','=',$tahunajaran_id)->first();
        
        if($target){
            //do nothing
        }else{
            $target = new Targetpencapaian();
        }
        
        $target->jumlah = $jumlah;
        $target->tahunajaran_id = $tahunajaran_id;
        $target->save();
        
        return Redirect::to('setting/sysconf');
    }
    
    public function post_cetaknota(){
        $appset = Appsetting::first();
        $appset->cetaknota = Input::get('cetaknota');
        $appset->save();
        
        return Redirect::to('setting/sysconf');
    }
    
    public function post_printeraddr(){
        $appset = Appsetting::first();
        $appset->printeraddr = Input::get('printeraddr');
        $appset->save();
        
        return Redirect::to('setting/sysconf');
    }
    
    public function post_restore(){
        $this->layout = null;
            
        $datacon = \Laravel\Config::$items;

        $mysqlconf = $datacon['application']['database']['connections']['mysql'];
        $db = array(
                'user' => $mysqlconf['username'],
                'password' => $mysqlconf['password'],
                'name' => $mysqlconf['database'],
                'host' => $mysqlconf['host']
            );                       

        $mysqldumppath = Appsetting::first()->mysqldumppath;
        //get file 
        $fileupload = Input::file('fileupload');
        //create temp for file
        $tempfile = sys_get_temp_dir() .'/' . $fileupload['name'] ; 
        //move uploaded file to temp file
        move_uploaded_file($fileupload['tmp_name'],$tempfile);
        //create restore script
        if(PHP_OS == 'Linux'){
            $restore = $mysqldumppath . "mysql -h " . $db['host'] . " -u ".$db['user']." --password=".$db['password']." ".$db['name']." < ".$tempfile;
        }else{
            $restore = $mysqldumppath . "mysql.exe -h " . $db['host'] . " -u ".$db['user']." --password=".$db['password']." ".$db['name']." < ".$tempfile;
        }
        //restore process
        system($restore);
        //remoce tempfile
        unlink($tempfile);
        //return n redirect
        return Redirect::to('setting/sysconf');
    }
    
    public function post_queryrunner(){
        DB::query(Input::get('query'));
        
        return Redirect::to('setting/sysconf');
    }
    
//    public function get_backup()
//    {
//
//            $this->layout = null;
//            
//            $datacon = \Laravel\Config::$items;
//           
//            $mysqlconf = $datacon['application']['database']['connections']['mysql'];
//            $db = array(
//                    'user' => $mysqlconf['username'],
//                    'password' => $mysqlconf['password'],
//                    'name' => $mysqlconf['database'],
//                    'host' => $mysqlconf['host']
//                );
//                        
//
//            header('Content-disposition: attachment; filename=' . $db['name'].'_'.date('Y_m_d') . '.sql');
//            header('Content-type: text/plain');
//           
//            $mysqldumppath = Appsetting::first()->mysqldumppath;
//            
//            if(PHP_OS == 'Linux'){
//                $sqlFile = sys_get_temp_dir() .'/' .$db['name'].'_'.date('Y_m_d') . '.sql';
//                $createBackup = $mysqldumppath . "mysqldump --add-drop-database -h " . $db['host'] . " -u ".$db['user']." --password=".$db['password']." --databases ".$db['name']." > ".$sqlFile;
//            }else{
//                $sqlFile = sys_get_temp_dir() .'\\' .$db['name'].'_'.date('Y_m_d') . '.sql';
//                $createBackup = $mysqldumppath . "mysqldump.exe --add-drop-database -h " . $db['host'] . " -u ".$db['user']." --password=".$db['password']." --databases ".$db['name']." > ".$sqlFile;
//            }
//                        
//            //backup process
//            system($createBackup);
//
//            //read file for echo and download
//            $file = fopen($sqlFile, 'r');
//            $datafile = fread($file,  filesize($sqlFile));
//            echo $datafile;
//            
//            fclose($file);
//            
//            //remove temp file
//            unlink($sqlFile);
//    }
    
   
    public function get_backupme(){
        $this->layout = null;
            
        $datacon = \Laravel\Config::$items;

        $mysqlconf = $datacon['application']['database']['connections']['mysql'];

        $dump = new MySQLDump(new mysqli($mysqlconf['host'],$mysqlconf['username'],$mysqlconf['password'],$mysqlconf['database']));
        $dump->tables['search_cache'] = MySQLDump::DROP | MySQLDump::CREATE;
        $dump->tables['log'] = MySQLDump::NONE;
        //$dump->save('d:/export.sql.gz');
        
        header('Content-disposition: attachment; filename=simasad_db_backup_'.date('YmdHis') . '.sql');
        header('Content-type: text/plain');
        
        $dump->write();
    }


    public function get_updatedirectprint(){
        // cek apakah sudah ada data direct ptint
        // echo 'inside update direct print <br/>';
        $appset = Appsetting::first();
        // if($appset->created_at){
        //     echo 'tertsedia';

        // }else{
        //     echo 'tidak tersedia';
        // }

        try {
            \DB::table('appsetting')
            ->update([
                'using_winrawprint' => 'N'
            ]);   

        } catch (Exception $e) {
            // alter table create column using_winrarprint\
            $pdo = DB::connection('mysql')->pdo;
            $stmt = $pdo->prepare("ALTER TABLE appsetting ADD COLUMN using_winrawprint char(1) NULL DEFAULT 'Y' AFTER sn_key, ADD COLUMN winrawprint_loc varchar(250) NULL DEFAULT 'Y' AFTER using_winrawprint");
            $stmt->execute();
        }
       

         // \DB::statement("ALTER TABLE appsetting ADD COLUMN using_winrawprint DOUBLE NULL DEFAULT '0' AFTER sn_key");
        echo '.:: UPDATING SYSTEM ::.<br/>';
        echo 'updating win raw printing......<br/>';
        echo 'updating on progress......<br/>';
        echo 'done.<br/>';

        return false;
    }

    public function post_setWinPrintLoc(){
        $appset = Appsetting::first();
        $appset->winrawprint_loc = Input::get('winrawprintloc');
        $appset->save();
        
        return Redirect::to('setting/sysconf');
    }

    public function post_setUseWinPrint(){
        $appset = Appsetting::first();
        $appset->using_winrawprint = Input::get('usingwinrawprint');
        $appset->save();
        
        return Redirect::to('setting/sysconf');
    }
    
    
    
}
