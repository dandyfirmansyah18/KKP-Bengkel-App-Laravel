<?php

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

// Route::get('/listkaryawan', function () {
//     return view('welcome');
// });

Route::get('/login', function () {
    return view('templates.login');
});
Route::post('/doLogin','LoginController@cekLogin');
Route::get('/doLogout','LoginController@logout');


// Route::middleware(['auth'])->group(function(){
	Route::get('/','DashboardController@index');
	Route::post('home', 'DashboardController@view_dashboard');
	Route::get('dashboard_chart','DashboardController@dashboard_chart');

	//Karyawan
	Route::post('/listkaryawan','KaryawanController@listkaryawan');
	Route::post('/listAddkar','KaryawanController@addkaryawan');
	Route::post('/listsavekar','KaryawanController@savekaryawan');
	Route::post('/listgetkar/{id}','KaryawanController@getkaryawan');
	Route::post('/showkaryawan/{id}','KaryawanController@showkaryawan');
	Route::post('/delkaryawan/{id}','KaryawanController@delete');
	Route::post('/editkaryawan','KaryawanController@editkaryawan');


	//Pelanggan
	Route::post('/listcus','CustomerController@listcustomer');
	Route::post('/listAddcus','CustomerController@addcustomer');
	Route::post('/savecustomer','CustomerController@savecus');
	Route::post('/listEditcus','CustomerController@listkaryawan');
	Route::post('/listgetcus/{id}','CustomerController@getcus');
	Route::post('/showcus/{id}','CustomerController@showcus');
	Route::post('/delcus/{id}','CustomerController@delete');
	Route::post('/editcus','CustomerController@editcus');
	Route::post('/pilihpelanggan','CustomerController@pilihpelanggan');
	Route::post('/lookup_pelanggan','CustomerController@lookup_pelanggan');

	//Barang
	Route::post('/listbarang','BarangController@listbarang');
	Route::post('/listAddbarang','BarangController@addbarang');
	Route::post('/savebarang','BarangController@savebarang');
	Route::post('/listEditbrg','BarangController@listkaryawan');
	Route::post('/listgetbrg/{id}','BarangController@getbarang');
	Route::post('/showbrg/{id}','BarangController@showcus');
	Route::post('/delbrg/{id}','BarangController@delete');
	Route::post('/editbrg','BarangController@editbarang');




	//SPK
	Route::post('/listspk','SpkController@listspk');
	Route::post('/listAddspk','SpkController@addspk');
	Route::post('/savespk','SpkController@savespk');
	Route::post('/editspk/{id_spk}','SpkController@editspk');
	Route::post('/showspk/{id_spk}','SpkController@showspk');
	Route::post('/updatespk','SpkController@updatespk');
	Route::post('/pilihspk','SpkController@pilihspk');
	Route::post('/lookup_spk','SpkController@lookup_spk');
	Route::post('/downloadnota','SpkController@downloadnota');
	Route::post('/delspk/{id_spk}','SpkController@delspk');

	Route::get('/spk_form_cetak/{nospk}','SpkController@spk_form_cetak');



	//BAP
	Route::post('/listbap','BapController@listbap');
	Route::post('/listAddbap','BapController@addbap');
	Route::post('/savebap','BapController@savebap');
	Route::post('/pilihbap','BapController@pilihbap');
	Route::post('/lookup_bap','BapController@lookup_bap');
	Route::post('/listbarang_dd','BapController@listbarang_dd');
	Route::post('/editbap/{id_bap}','BapController@editbap');
	Route::post('/updatebap','BapController@updatebap');
	Route::post('/showbap/{id_bap}','BapController@showbap');
	Route::get('/bap_form_cetak/{id_bap}','BapController@bap_form_cetak');
	Route::post('/delbap/{id_bap}','BapController@delbap');

	//KWITANSI
	Route::post('/listkwitansi','KwitansiController@listkwitansi');
	Route::post('/listAddkwitansi','KwitansiController@addkwitansi');
	Route::post('/savekwitansi','KwitansiController@savekwitansi');
	Route::post('/editkwi/{id_byr}','KwitansiController@editkwi');
	Route::post('/updatekwi','KwitansiController@updatekwi');
	Route::post('/showkwi/{id_byr}','KwitansiController@showkwi');	
	Route::get('/kwi_form_cetak/{id_byr}','KwitansiController@kwi_form_cetak');	
	Route::post('/delkwi/{id_byr}','KwitansiController@delkwi');

	//GARANSI
	Route::post('/listgaransi','GaransiController@listgaransi');
	Route::post('/listAddGaransi','GaransiController@addgaransi');
	Route::post('/savegaransi','GaransiController@savegaransi');
	Route::post('/editgaransi/{id_klaim}','GaransiController@editgaransi');
	Route::post('/updategaransi','GaransiController@updategaransi');
	Route::get('/garansi_form_cetak/{id_klaim}','GaransiController@garansi_form_cetak');
	Route::post('/delgaransi/{id_klaim}','GaransiController@delgaransi');
	Route::post('/showgaransi/{id_klaim}','GaransiController@showgaransi');
	Route::post('/pilihkwitansi','GaransiController@pilihkwitansi');
	Route::post('/lookup_kwitansi','GaransiController@lookup_kwitansi');

	//LAPORAN SPK
	Route::post('/lapspk','SpkController@laporanspk');
	Route::post('/downspk','SpkController@downloadLapspk');

	//LAPORAN BAP
	Route::post('/lapbap','BapController@laporanbap');
	Route::post('/downbap','BapController@downloadLapbap');

	//LAPORAN KWITANSI
	Route::post('/lapkwitansi','KwitansiController@laporankwitansi');
	Route::post('/downkwitansi','KwitansiController@downloadLapkwitansi');

	//LAPORAN GARANSI
	Route::post('/lapgaransi','GaransiController@laporangaransi');
	Route::post('/downgaransi','GaransiController@downloadLapgaransi');

	//LAPORAN GARANSI
	Route::post('/laprekapservice','SpkController@laporanrekapservice');
	Route::post('/downrekapservice','SpkController@downloadLaprekapservice');
// });


