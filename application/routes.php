<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

//Route::get('/', function()
//{
//	return View::make('home.index');
//});

Route::controller(array(
    'login',
    'home',
    'locker',
    'bajak',
    'snkey',
    'setting/tahunajaran',
    'setting/rombel',
    'setting/biaya',
    'setting/setbiaya',
    'setting/bukuspp',
    'setting/siswa',
    'setting/sysconf',
    'setting/adconf',
    'setting/user',
    'setting/role',
    'setting/profiler',
    'setting/kenaikan',
    'setting/potongan',
    'setting/target',
    'setting/penyesuaian',
    'transaksi/iuran',
    'transaksi/bayariuran',
    'transaksi/penerimaan',
    'transaksi/pengeluaran',
    'transaksi/histori',
    'transaksi/mutasi',
    'rekap/transaksi',
    'rekap/iurantahunan',
    'rekap/tahunan',
    'rekap/iuranbulanan',
    'rekap/bulanan',
    'rekap/rekapsiswa',
    'datarekap/rekapharian',
    'datarekap/rekapbulanan',
));


/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{       //cek login
        if (Auth::guest()){
            return Redirect::to('login');
        }else{
            //cek applocker
            $user = Auth::retrieve(Session::get('onuser_id'));
            if($user->username != 'eries'){
                $appset = Appsetting::first();
                if($appset->lunas != 'Y'){
                    $applocker = Applocker::where('lunas','=','N')->order_by('tanggal','asc')->first();
                    $today = strtotime(date("Y-m-d")); 
                    $timelock = strtotime($applocker->tanggal);
                    if($today >= $timelock){
                        //Auth::logout();
                        //Session::flush();
                        return Redirect::to('locker');
                    }
                }
            }
        }        
});

Route::filter('permission', function($permission_name)
{
	$user = Auth::retrieve(Session::get('onuser_id'));
        if (!$user->can($permission_name)) return Redirect::to('home');
});

Route::filter('adconf',function($username){
    if($username != 'eries')return Redirect::to('home');
});

Route::filter('snkey',function(){
    $appset = Appsetting::first(); //get application setting
    
    ob_start(); // Turn on output buffering
    system('ipconfig /all'); //Execute external program to display output
    $mycom=ob_get_contents(); // Capture the output into a variable
    ob_clean(); // Clean (erase) the output buffer

    $findme = "Physical";
    $pmac = strpos($mycom, $findme); // Find the position of Physical text
    $mac=substr($mycom,($pmac+36),17); // Get Physical Address
    
    //proses enkripsi mac->base64_encode->split_with_dash    
    $arr = str_split(base64_encode($mac), 2); //split encoded mac addres menjadi array per 2 huruf
    $reqkey = '';
    //split with dash
    for ($i=0;$i<count($arr);$i++){
        $reqkey .= $arr[$i];
        if ($i<(count($arr)-1)) $reqkey .= '-';
    }
    //echo $reqkey;
    Session::put('reqkey',$reqkey);
    if($reqkey != base64_decode($appset->sn_key))return Redirect::to('bajak');
    
});