<?php
use Illuminate\Support\Facades\Input;
use App\User;
use App\Sparepart;
use App\Service;



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

Route::group(['middleware'=>'cekRole'], function(){
    //PDF
    Route::get('pemesanan/downloadPDF/{noPemesanan}',
    [
        'as'=>'pemesanan.downloadPDF',
        'uses'=>'PemesananController@downloadPDF']);
    
    Route::get('transaksiService/downloadPDF/{noPemesanan}',
    [
        'as'=>'transaksiService.downloadPDF',
        'uses'=>'PemesananController@downloadPDF']);
    
    Route::get('transaksiSparepart/downloadPDF/{noPemesanan}',
    [
        'as'=>'transaksiSparepartph.downloadPDF',
        'uses'=>'PemesananController@downloadPDF']);

    //Sorting
    Route::get('sparepart/byHarga', 
    [   
        'as'=>'sparepart.byHarga',
        'uses'=>'SparepartController@ByHarga']);
    Route::get('sparepart/byStok', 
    [   
        'as'=>'sparepart.byStok',
        'uses'=>'SparepartController@ByStok']);

    //CRUD
    Route::get('owner', 'HomeController@index')->name('home');
    Route::resource('pegawai', 'PegawaiController');
    Route::resource('sparepart', 'SparepartController');
    Route::get('service/search', 'Service@search')->name('live_search.action');
    Route::resource('service', 'ServiceController');
    Route::resource('supplier', 'SupplierController');
    Route::resource('kendaraan', 'KendaraanController');
    Route::resource('pemesanan', 'PemesananController');
    Route::resource('transaksiService', 'TransaksiServiceController');
    Route::resource('transaksiSparepart', 'TransaksiSparepartController');
    Route::resource('pemesanan', 'PemesananController');

    //Search Data
    Route::any('service/search',function()
    {
        $q = Input::get ( 'keterangan' );
        $user = Service::where('keterangan','LIKE','%'.$q.'%')->orWhere('keterangan','LIKE','%'.$q.'%')->get();
        if(count($user) > 0)
            return view('service.search')->withDetails($user)->withQuery ( $q );
        else return view ('welcome')->withMessage('No Details found. Try to search again !');
    });

    Route::any('pegawai/search',function()
    {
        $q = Input::get ( 'name' );
        $user = User::leftJoin('posisi','posisi.idPosisi','=','users.idPosisi')->where('name','LIKE','%'.$q.'%')->orWhere('name','LIKE','%'.$q.'%')->get();
        if(count($user) > 0)
            return view('pegawai.search')->withDetails($user)->withQuery ( $q );
        else return view ('welcome')->withMessage('No Details found. Try to search again !');
    });

    Route::any('sparepart/search',function()
    {
        $q = Input::get ( 'namaSparepart' );
        $user = Sparepart::where('namaSparepart','LIKE','%'.$q.'%')->get();
        if(count($user) > 0)
            return view('sparepart.search')->withDetails($user)->withQuery ( $q );
        else return view ('welcome')->withMessage('No Details found. Try to search again !');
    });
});

Route::group(['middleware'=>'cekRoleCS'], function(){
    Route::resource('transaksiService', 'TransaksiServiceController');
    Route::resource('transaksiSparepart', 'TransaksiSparepartController');
});

Route::group(['middleware'=>'cekRoleKasir'], function(){
    //
});
