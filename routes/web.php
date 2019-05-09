<?php
use Illuminate\Support\Facades\Input;
use SiAtmo\User;
use SiAtmo\Sparepart;
use SiAtmo\Service;
use SiAtmo\Supplier;
use SiAtmo\Kendaraan;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/cs', function () {
    return view('cs');
});

Route::get('/kasir', function () {
    return view('kasir');
});

//Konsumen
Route::get('konsumen/katalog',
[
    'as'    =>'konsumen.katalog',
    'uses'  =>'KonsumenController@katalog'
]);

Route::get('konsumen/riwayat',
[
    'as'    =>'konsumen.riwayat',
    'uses'  =>'KonsumenController@riwayat'
]);
//


Route::get('transaksiService/downloadPDF/{noPemesanan}',
[
    'as'=>'transaksiService.downloadPDF',
    'uses'=>'TransaksiServiceController@downloadPDF']);

Route::get('transaksiService/downloadPDFLunas/{noPemesanan}',
[
    'as'=>'transaksiService.downloadPDFLunas',
    'uses'=>'TransaksiServiceController@downloadPDFLunas']);

Route::get('transaksiSparepart/downloadPDF/{noPemesanan}',
[
    'as'=>'transaksiSparepart.downloadPDF',
    'uses'=>'TransaksiSparepartController@downloadPDF']);

Route::get('transaksiService/printPreview/{noPemesanan}',
[
    'as'=>'transaksiService.printPreview',
    'uses'=>'TransaksiServiceController@printPreview']);
    
Route::get('transaksiSparepart/printPreview/{noPemesanan}',
[
    'as'=>'transaksiSparepart.printPreview',
    'uses'=>'TransaksiSparepartController@printPreview']);

Auth::routes();

Route::group(['middleware'=>'cekRole'], function(){
    //PDF
    Route::get('pemesanan/downloadPDF/{noPemesanan}',
    [
        'as'=>'pemesanan.downloadPDF',
        'uses'=>'PemesananController@downloadPDF']);

     //Print Preview
     Route::get('pemesanan/printPreview/{noPemesanan}',
     [
         'as'=>'pemesanan. printPreview',
         'uses'=>'PemesananController@printPreview']);

    //Report
    Route::get('laporan/pendapatanBulanan',
    [
        'as'=>'laporan.pendapatanBulanan',
        'uses'=>'ReportController@LaporanPendapatanBulanan']);
        
    //Sorting
    Route::get('sparepart/byHarga', 
    [   
        'as'    =>'sparepart.byHarga',
        'uses'  =>'SparepartController@ByHarga']);
        
    Route::get('sparepart/byStok', 
    [   
        'as'    =>'sparepart.byStok',
        'uses'  =>'SparepartController@ByStok']);

    //CRUD
    Route::patch('pemesanan/endOrder/{noPemesanan}',
    [   
        'as'    =>'pemesanan.selesaiOrder',
        'uses'  =>'PemesananController@endPesanan']);

    Route::get('owner', 'HomeController@index')->name('home');
    Route::resource('pegawai', 'PegawaiController');
    Route::resource('sparepart', 'SparepartController');
    Route::get('service/search', 'Service@search')->name('live_search.action');
    Route::resource('service', 'ServiceController');
    Route::resource('supplier', 'SupplierController');
    Route::resource('kendaraan', 'KendaraanController');
    Route::resource('pemesanan', 'PemesananController');
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

    Route::any('supplier/search',function()
    {
        $q = Input::get ( 'tipe' );
        $user = Supplier::where('namaPerusahaan','LIKE','%'.$q.'%')->orWhere('namaSales','LIKE','%'.$q.'%')->get();
        if(count($user) > 0)
            return view('supplier.search')->withDetails($user)->withQuery ( $q );
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

    Route::any('kendaraan/search',function()
    {
        $q = Input::get ( 'tipe' );
        $user = Sparepart::where('tipe','LIKE','%'.$q.'%')->orWhere('merk','LIKE','%'.$q.'%')->get();
        if(count($user) > 0)
            return view('kendaraan.search')->withDetails($user)->withQuery ( $q );
        else return view ('welcome')->withMessage('No Details found. Try to search again !');
    });
});

Route::group(['middleware'=>'cekRoleCS'], function(){
    //Transaksi
    Route::get('daftarKendaraanKonsumen', 'KendaraanController@createKonsumen')->name('daftarKendaraanKonsumen');
    Route::post('daftarKendaraanKonsumen/create', 'KendaraanController@saveKendaraanKonsumen')->name('daftarKendaraanKonsumen/create');
    Route::resource('transaksiService', 'TransaksiServiceController');
    Route::resource('transaksiSparepart', 'TransaksiSparepartController');
});

Route::group(['middleware'=>'cekRoleKasir'], function(){
    Route::resource('dataTransaksi', 'KasirController');
});
