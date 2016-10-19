<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('sidebar-update', function() {
    $value = \DB::table('appsetting')->whereName('sidebar_collapse')->first()->value;
    \DB::table('appsetting')->whereName('sidebar_collapse')->update(['value' => $value == 1 ? '0' : '1']);
});

// Tampilkan View Login
Route::get('/', function() {
    return redirect('login');
});

Route::get('login', function () {
    return view('login');
});

Route::post('login', function() {
    //auth user
    Auth::attempt(['username' => Request::input('username'), 'password' => Request::input('password')]);

    if (Request::ajax()) {
        if (Auth::check()) {
            return "true";
        } else {
            return "false";
        }
    } else {
        if (Auth::check()) {
            return redirect('home');
        } else {
            return redirect('login');
        }
    }
});

// Logout
Route::get('logout', function() {
    Auth::logout();
    return redirect('login');
});

Route::group(['middleware' => ['web','auth']], function () {
	Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);

    Route::get('api/get-auto-complete-obat','ApiController@getAutoCompleteObat');
    Route::get('api/get-auto-complete-supplier','ApiController@getAutoCompleteSupplier');

    Route::group(['prefix' => 'master'], function () {
        // USER
        Route::get('user','UserController@index');
        Route::get('user/create','UserController@create');
        Route::get('user/edit/{user_id}','UserController@edit');

        // POLI
        Route::get('poli','PoliController@index');
        Route::get('poli/create','PoliController@create');
        Route::post('poli/insert','PoliController@insert');
        Route::get('poli/edit/{user_id}','PoliController@edit');
        Route::post('poli/update','PoliController@update');

        // DOKTER
        Route::get('dokter','DokterController@index');
        Route::get('dokter/create','DokterController@create');
        Route::post('dokter/insert','DokterController@insert');
        Route::get('dokter/edit/{user_id}','DokterController@edit');
        Route::post('dokter/update','DokterController@update');

        // SHIFT
        Route::get('shift','ShiftController@index');
        Route::get('shift/create','ShiftController@create');
        Route::post('shift/insert','ShiftController@insert');
        Route::get('shift/edit/{user_id}','ShiftController@edit');
        Route::post('shift/update','ShiftController@update');

        // KARYAWAN
        Route::get('karyawan','KaryawanController@index');
        Route::get('karyawan/create','KaryawanController@create');
        Route::post('karyawan/insert','KaryawanController@insert');
        Route::get('karyawan/edit/{user_id}','KaryawanController@edit');
        Route::post('karyawan/update','KaryawanController@update');

        // PASIEN
        Route::get('pasien','PasienController@index');
        Route::get('pasien/create','PasienController@create');
        Route::post('pasien/insert','PasienController@insert');
        Route::get('pasien/edit/{user_id}','PasienController@edit');
        Route::post('pasien/update','PasienController@update');

        // SUPPLIER
        Route::get('supplier','SupplierController@index');
        Route::get('supplier/create','SupplierController@create');
        Route::post('supplier/insert','SupplierController@insert');
        Route::get('supplier/edit/{user_id}','SupplierController@edit');
        Route::post('supplier/update','SupplierController@update');

    });

    Route::group(['prefix' => 'inventory'], function () {
        // OBAT
        Route::get('obat','ObatController@index');
        Route::get('obat/create','ObatController@create');
        Route::post('obat/insert','ObatController@insert');
        Route::get('obat/edit/{obat_id}','ObatController@edit');
        Route::post('obat/update','ObatController@update');

        // SATUAN
        Route::get('satuan','SatuanController@index');
        Route::get('satuan/create','SatuanController@create');
        Route::post('satuan/insert','SatuanController@insert');
        Route::get('satuan/edit/{user_id}','SatuanController@edit');
        Route::post('satuan/update','SatuanController@update');

        // MUTASI
        Route::get('mutasi','MutasiController@index');
        Route::get('mutasi/create','MutasiController@create');
        Route::get('mutasi/edit/{mutasi_id}','MutasiController@edit');
        Route::post('mutasi/insert','MutasiController@insert');

    });

    Route::group(['prefix' => 'invoice'], function () {
        // SUPPLIER BILL
        Route::get('supplier-bill','SupplierBillController@index');
        Route::get('supplier-bill/create','SupplierBillController@create');
        Route::post('supplier-bill/insert','SupplierBillController@insert');
        Route::post('supplier-bill/update','SupplierBillController@update');
        Route::post('supplier-bill/set-as-paid','SupplierBillController@setAsPaid');
        Route::get('supplier-bill/edit/{bill_id}','SupplierBillController@edit');
        // Route::get('obat/create','ObatController@create');
        // Route::post('obat/insert','ObatController@insert');
        // Route::get('obat/edit/{obat_id}','ObatController@edit');
        // Route::post('obat/update','ObatController@update');


    });

});
