<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Sparepart;
use App\Service;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('login', 'ApiControllers\LoginController');
//Auth::routes();

//Route::get('laporan/pendapatanBulanan', 'ReportController@LaporanPendapatanBulanan');

Route::get('pegawai', 'ApiControllers\PegawaiController@index');
Route::post('pegawai', 'ApiControllers\PegawaiController@store');
Route::patch('pegawai/{$email}', 'ApiControllers\PegawaiController@update');
Route::delete('pegawai/{$email}', 'ApiControllers\PegawaiController@destroy');

Route::get('service', 'ApiControllers\ServiceController@index');
Route::post('service', 'ApiControllers\ServiceController@store');
Route::patch('service/{$kodeService}', 'ApiControllers\ServiceController@update');
Route::delete('service/{$kodeService}', 'ApiControllers\ServiceController@destroy');

Route::get('sparepart', 'ApiControllers\SparepartController@index');
Route::post('sparepart', 'ApiControllers\SparepartController@store');
Route::patch('sparepart/{$kodeSparepart}', 'ApiControllers\SparepartController@update');
Route::delete('sparepart/{$kodeSparepart}', 'ApiControllers\SparepartController@destroy');

Route::get('supplier', 'ApiControllers\SupplierController@index');
Route::post('supplier', 'ApiControllers\SupplierController@store');
Route::patch('supplier/{$kodeSparepart}', 'ApiControllers\SupplierController@update');
Route::delete('supplier/{$kodeSparepart}', 'ApiControllers\SupplierController@destroy');

Route::get('kendaraan', 'ApiControllers\KendaraanController@index');
Route::post('kendaraan', 'ApiControllers\KendaraanController@store');
Route::patch('kendaraan/{$kodeSparepart}', 'ApiControllers\KendaraanController@update');
Route::delete('kendaraan/{$kodeSparepart}', 'ApiControllers\KendaraanController@destroy');

Route::get('pemesanan', 'ApiControllers\PemesananController@index');
Route::post('pemesanan', 'ApiControllers\PemesananController@store');
Route::patch('pemesanan/{$kodeSparepart}', 'ApiControllers\PemesananController@update');
Route::delete('pemesanan/{$kodeSparepart}', 'ApiControllers\PemesananController@destroy');

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


