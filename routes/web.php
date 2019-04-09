<?php
use Illuminate\Support\Facades\Input;
use App\User;
use App\Sparepart;
use App\Service;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cs', function () {
    return view('cs');
});

Route::get('/kasir', function () {
    return view('kasir');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>'cekRole'], function(){
    Route::get('owner', 'HomeController@index')->name('home');
    Route::resource('pegawai', 'PegawaiController');
    Route::any('pegawai/search',function()
    {
        $q = Input::get ( 'name' );
        $user = User::leftJoin('posisi','posisi.idPosisi','=','users.idPosisi')->where('name','LIKE','%'.$q.'%')->orWhere('name','LIKE','%'.$q.'%')->get();
        if(count($user) > 0)
            return view('pegawai.search')->withDetails($user)->withQuery ( $q );
        else return view ('welcome')->withMessage('No Details found. Try to search again !');
    });
    Route::resource('sparepart', 'SparepartController');
    Route::any('sparepart/search',function()
    {
        $q = Input::get ( 'namaSparepart' );
        $user = Sparepart::where('namaSparepart','LIKE','%'.$q.'%')->get();
        if(count($user) > 0)
            return view('sparepart.search')->withDetails($user)->withQuery ( $q );
        else return view ('welcome')->withMessage('No Details found. Try to search again !');
    });
    Route::resource('service', 'ServiceController');
    Route::any('service/search',function()
    {
        $q = Input::get ( 'keterangan' );
        $user = Service::where('keterangan','LIKE','%'.$q.'%')->orWhere('keterangan','LIKE','%'.$q.'%')->get();
        if(count($user) > 0)
            return view('service.search')->withDetails($user)->withQuery ( $q );
        else return view ('welcome')->withMessage('No Details found. Try to search again !');
    });
    Route::resource('supplier', 'SupplierController');
    Route::resource('kendaraan', 'KendaraanController');
    Route::resource('transaksiService', 'TransaksiServiceController');
    Route::resource('transaksiSparepart', 'TransaksiSparepartController');
    Route::resource('pemesanan', 'PemesananController');
    //Route::get('/info/{kodeService}', 'TransaksiServiceController@getInfo');
});
