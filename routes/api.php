<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use SiAtmo\User;
use SiAtmo\Sparepart;
use SiAtmo\Service;
use SiAtmo\Supplier;
use SiAtmo\Kendaraan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'ApiControllers\LoginController@login');

Route::get('service', 'ApiControllers\ServiceController@index');
Route::post('service', 'ApiControllers\ServiceController@store');
Route::patch('service/{kodeService}', 'ApiControllers\ServiceController@update');
Route::delete('service/{kodeService}', 'ApiControllers\ServiceController@destroy');

Route::get('sparepart', 'ApiControllers\SparepartController@index');
Route::get('sparepart/pushnotif', 'ApiControllers\SparepartController@pushNotif');
Route::get('sparepart/kodesparepart', 'ApiControllers\SparepartController@kodeSparepart');
Route::get('sparepart/bystok', 'ApiControllers\SparepartController@bystok');
Route::get('sparepart/byharga', 'ApiControllers\SparepartController@byharga');
Route::get('sparepart/tipesparepart', 'ApiControllers\SparepartController@tipeSparepart');
Route::post('sparepart', 'ApiControllers\SparepartController@store');
Route::patch('sparepart/{kodeSparepart}', 'ApiControllers\SparepartController@update');
Route::delete('sparepart/{kodeSparepart}', 'ApiControllers\SparepartController@destroy');

Route::get('supplier', 'ApiControllers\SupplierController@index');
Route::get('supplier/namaperusahaan', 'ApiControllers\SupplierController@namaPerusahaan');
Route::post('supplier', 'ApiControllers\SupplierController@store');
Route::patch('supplier/{namaPerusahaan}', 'ApiControllers\SupplierController@update');
Route::delete('supplier/{namaPerusahaan}', 'ApiControllers\SupplierController@destroy');

Route::get('pemesanan', 'ApiControllers\PemesananController@index');
Route::post('pemesanan', 'ApiControllers\PemesananController@store');
Route::post('pemesanan/add', 'ApiControllers\PemesananController@addStore');
Route::post('pemesanan/{noPemesanan}', 'ApiControllers\PemesananController@showDetil');
Route::post('pemesanan/status/{noPemesanan}', 'ApiControllers\PemesananController@updateStatus');
Route::delete('pemesanan/{noPemesanan}', 'ApiControllers\PemesananController@destroy');

Route::get('kodenota', 'ApiControllers\TransaksiFullController@kodeNota');
Route::get('cekhistorytransaksi', 'ApiControllers\TransaksiFullController@index');
Route::post('historytransaksi', 'ApiControllers\TransaksiFullController@showIndex');


//Search
Route::any('pegawai/search',function()
{
    $q = Input::get ( 'name' );
    $user = User::leftJoin('posisi','posisi.idPosisi','=','users.idPosisi')->where('name','LIKE','%'.$q.'%')->orWhere('name','LIKE','%'.$q.'%')->get();
    if(count($user) > 0)
        return response()->json($user);
    else return response()->json('Data Tidak Ditemukan');
});

Route::any('service/search',function()
{
    $q = Input::get ( 'keterangan' );
    $user = Service::where('keterangan','LIKE','%'.$q.'%')->orWhere('keterangan','LIKE','%'.$q.'%')->get();
    if(count($user) > 0)
        return response()->json($user);
    else return response()->json('Data Tidak Ditemukan');
});

Route::any('sparepart/search',function()
{
    $q = Input::get ( 'namaSparepart' );
    $user = Sparepart::where('namaSparepart','LIKE','%'.$q.'%')->get();
    if(count($user) > 0)
        return response()->json($user);
    else return response()->json('Data Tidak Ditemukan');
});

//Proto Laporan
Route::get('pemesanan/printPreview/{noPemesanan}',[
    'as'=>'pemesananMobile. printPreview',
    'uses'=>'ApiControllers\PemesananController@printPreview']);

//Laporan
Route::get('laporan/pendapatanBulanan/{tahun}',[
    'as'=>'laporan.pendapatanBulanan',
    'uses'=>'ApiControllers\ReportController@LaporanPendapatanBulanan']);

Route::get('laporan/pengeluaranBulanan/{tahun}',[
    'as'=>'laporan.pengeluaranBulanan',
    'uses'=>'ApiControllers\ReportController@LaporanPengeluaranBulanan']);
        
Route::get('laporan/sparepartterlaris/{tahun}',[
    'as'=>'laporan.stokTerlaris',
    'uses'=>'ApiControllers\ReportController@LaporanSparepartTerlaris']);

Route::get('laporan/serviceterlaris',[
    'as'=>'laporan.serviceTerlaris',
    'uses'=>'ApiControllers\ReportController@LaporanServiceTerlaris']);

Route::get('laporan/sisastok/{tahun}/{tipe}',[
    'as'=>'laporan.sisaStok',
    'uses'=>'ApiControllers\ReportController@LaporanSisaStok']);

Route::get('laporan/cabang/{tahun}',[
    'as'=>'laporan.cabang',
    'uses'=>'ApiControllers\ReportController@LaporanCabang']);

//Surat
Route::get('spk/printPreview/{noPemesanan}',[
    'as'=>'SPK.printPreview',
    'uses'=>'ApiControllers\TransaksiServiceController@printPreviewSPK']);
Route::get('transaksiFull/spk/printPreview/{noPemesanan}',
[
    'as'=>'SPKFull.printPreview',
    'uses'=>'TransaksiFullController@printPreviewSPK']);