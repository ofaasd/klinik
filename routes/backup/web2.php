<?php
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});
Route::get('/clear-config', function() {
    $exitCode = Artisan::call('config:cache');
    // return what you want
});

//LOGIN
Route::get('/', 'Auth\LoginController@showLoginForm');
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
Route::get('statistik','StatistikController@index');


Route::get('beranda', 'HomeController@index');


Route::prefix('master-data')->group(function () {
    Route::post('sub-satuan-kerja/cek-validasi', 'MasterData\SubSatuanKerjaController@cekValidasi');
    Route::resource('sub-satuan-kerja', 'MasterData\SubSatuanKerjaController');
    Route::post('spesies/cek-validasi', 'MasterData\SpesiesController@cekValidasi');
    Route::resource('spesies', 'MasterData\SpesiesController');
    Route::post('ras/cek-validasi', 'MasterData\RasController@cekValidasi');
    Route::resource('ras', 'MasterData\RasController');
    Route::post('jenis-contoh/cek-validasi', 'MasterData\JenisContohController@cekValidasi');
    Route::resource('jenis-contoh', 'MasterData\JenisContohController');
    Route::post('bentuk-contoh/cek-validasi', 'MasterData\BentukContohController@cekValidasi');
    Route::resource('bentuk-contoh', 'MasterData\BentukContohController');
    Route::post('seksi-laboratorium/cek-validasi', 'MasterData\SeksiLaboratoriumController@cekValidasi');
    Route::resource('seksi-laboratorium', 'MasterData\SeksiLaboratoriumController');
    Route::post('jenis-pengujian/cek-validasi', 'MasterData\JenisPengujianController@cekValidasi');
    Route::resource('jenis-pengujian', 'MasterData\JenisPengujianController');
    Route::get('customer/area-kelurahan', 'MasterData\CustomerController@formAreaKelurahan');
    Route::get('customer/area-kecamatan', 'MasterData\CustomerController@formAreaKecamatan');
    Route::get('customer/area-kota', 'MasterData\CustomerController@formAreaKota');
    Route::post('customer/cek-validasi', 'MasterData\CustomerController@cekValidasi');
    Route::resource('customer', 'MasterData\CustomerController');
    Route::post('asal-hewan/cek-validasi', 'MasterData\AsalHewanController@cekValidasi');
    Route::resource('asal-hewan', 'MasterData\AsalHewanController');
    Route::post('pemeriksa/cek-validasi', 'MasterData\PemeriksaController@cekValidasi');
    Route::resource('pemeriksa', 'MasterData\PemeriksaController');
    Route::post('pemilik/cek-validasi', 'MasterData\PemilikController@cekValidasi');
    Route::resource('pemilik', 'MasterData\PemilikController');
    Route::post('penyakit/cek-validasi', 'MasterData\PenyakitController@cekValidasi');
    Route::resource('penyakit', 'MasterData\PenyakitController');
    Route::post('obat/cek-validasi', 'MasterData\ObatController@cekValidasi');
    Route::resource('obat', 'MasterData\ObatController');
    Route::get('logo', 'MasterData\LogoController@index');
});



// LABORATORIUM
Route::get('laboratorium/cetak/{id}', 'Modul\LaboratoriumController@cetakKartu');
Route::post('laboratorium/hapus-file', 'Modul\LaboratoriumController@hapusFile');
Route::get('laboratorium/area-file', 'Modul\LaboratoriumController@getFile');
Route::get('laboratorium/area-jenis-pengujian', 'Modul\LaboratoriumController@formAreaJenisPengujian');
Route::get('laboratorium/area-bentuk-contoh', 'Modul\LaboratoriumController@formAreaBentukContoh');
Route::get('laboratorium/area-jenis-contoh', 'Modul\LaboratoriumController@formAreaJenisContoh');
Route::get('laboratorium/customer', 'Modul\LaboratoriumController@getCustomer');
Route::get('laboratorium/nama-laboratorium', 'Modul\LaboratoriumController@getLaboratorium');
Route::post('laboratorium/cek-validasi', 'Modul\LaboratoriumController@cekValidasi');
Route::resource('laboratorium', 'Modul\LaboratoriumController');



//LABORATORIUM
Route::prefix('lab')->group(function () {
    // Route::get('area-jenis-contoh', 'Laboratorium\KeswanController@formAreaJenisContoh');
    // Route::get('nama-laboratorium', 'Laboratorium\KeswanController@getLaboratorium');
    Route::get('customer', 'Laboratorium\KeswanController@getCustomer');
    Route::get('keswan/customer', 'Laboratorium\KeswanController@getCustomer');
    Route::get('pakan/customer', 'Laboratorium\PakanController@getCustomer');
    Route::get('kesmavet/customer', 'Laboratorium\KesmavetController@getCustomer');
    Route::post('checknoepid', 'Laboratorium\KeswanController@checkNoEpid');

    // KESWAN
    // Route::get('keswan/cetak/{id}', 'Laboratorium\KeswanController@cetakKartu');
    // Route::post('keswan/hapus-file', 'Laboratorium\KeswanController@hapusFile');
    // Route::get('keswan/area-file', 'Laboratorium\KeswanController@getFile');
    // Route::get('keswan/area-jenis-pengujian', 'Laboratorium\KeswanController@formAreaJenisPengujian');
    // Route::get('keswan/area-bentuk-contoh', 'Laboratorium\KeswanController@formAreaBentukContoh');
    // Route::post('keswan/cek-validasi', 'Laboratorium\KeswanController@cekValidasi');
    Route::group(['middleware' => ['ajax']], function (){
        Route::get('keswan', 'Laboratorium\KeswanController@index');
        Route::get('keswan/form01', 'Laboratorium\KeswanController@getForm01');
        Route::get('keswan/{id}/form01', 'Laboratorium\KeswanController@getForm01');
        Route::get('keswan/{id}/form02', 'Laboratorium\KeswanController@getForm02');
        Route::get('keswan/{id}/form03', 'Laboratorium\KeswanController@getForm03');
        Route::get('keswan/{id}/form04', 'Laboratorium\KeswanController@getForm04');
        Route::get('keswan/{id}/formhasil', 'Laboratorium\KeswanController@getFormhasil');
        Route::post('keswan/form01', 'Laboratorium\KeswanController@postForm01');
        Route::post('keswan/form02', 'Laboratorium\KeswanController@postForm02');
        Route::post('keswan/form03', 'Laboratorium\KeswanController@postForm03');
        Route::post('keswan/form04', 'Laboratorium\KeswanController@postForm04');
        Route::post('keswan/formhasil', 'Laboratorium\KeswanController@postFormHasil');


        Route::get('kesmavet', 'Laboratorium\KesmavetController@index');
        Route::get('kesmavet/form01', 'Laboratorium\KesmavetController@getForm01');
        Route::get('kesmavet/{id}/form01', 'Laboratorium\KesmavetController@getForm01');
        Route::get('kesmavet/{id}/form02', 'Laboratorium\KesmavetController@getForm02');
        Route::get('kesmavet/{id}/form03', 'Laboratorium\KesmavetController@getForm03');
        Route::get('kesmavet/{id}/form04', 'Laboratorium\KesmavetController@getForm04');
        Route::get('kesmavet/{id}/formhasil', 'Laboratorium\KesmavetController@getFormhasil');
        Route::post('kesmavet/form01', 'Laboratorium\KesmavetController@postForm01');
        Route::post('kesmavet/form02', 'Laboratorium\KesmavetController@postForm02');
        Route::post('kesmavet/form03', 'Laboratorium\KesmavetController@postForm03');
        Route::post('kesmavet/form04', 'Laboratorium\KesmavetController@postForm04');
        Route::post('kesmavet/formhasil', 'Laboratorium\KesmavetController@postFormHasil');

        
        Route::get('pakan', 'Laboratorium\PakanController@index');
        Route::get('pakan/form01', 'Laboratorium\PakanController@getForm01');
        Route::get('pakan/{id}/form01', 'Laboratorium\PakanController@getForm01');
        Route::get('pakan/{id}/form02', 'Laboratorium\PakanController@getForm02');
        Route::get('pakan/{id}/form03', 'Laboratorium\PakanController@getForm03');
        Route::get('pakan/{id}/form04', 'Laboratorium\PakanController@getForm04');
        Route::get('pakan/{id}/formhasil', 'Laboratorium\PakanController@getFormhasil');
        Route::post('pakan/form01', 'Laboratorium\PakanController@postForm01');
        Route::post('pakan/form02', 'Laboratorium\PakanController@postForm02');
        Route::post('pakan/form03', 'Laboratorium\PakanController@postForm03');
        Route::post('pakan/form04', 'Laboratorium\PakanController@postForm04');
        Route::post('pakan/formhasil', 'Laboratorium\PakanController@postFormHasil');

    });

    
    Route::get('keswan/{id}/cetak01', 'Laboratorium\KeswanController@getCetak01');
    Route::get('keswan/{id}/cetak02', 'Laboratorium\KeswanController@getCetak02');
    Route::get('keswan/{id}/cetak03', 'Laboratorium\KeswanController@getCetak03');
    Route::get('keswan/{id}/cetak04', 'Laboratorium\KeswanController@getCetak04');
    Route::get('keswan/{id}/cetakhasil', 'Laboratorium\KeswanController@getCetakHasil');


    Route::get('kesmavet/{id}/cetak01', 'Laboratorium\KesmavetController@getCetak01');
    Route::get('kesmavet/{id}/cetak02', 'Laboratorium\KesmavetController@getCetak02');
    Route::get('kesmavet/{id}/cetak03', 'Laboratorium\KesmavetController@getCetak03');
    Route::get('kesmavet/{id}/cetak04', 'Laboratorium\KesmavetController@getCetak04');
    Route::get('kesmavet/{id}/cetakhasil', 'Laboratorium\KesmavetController@getCetakHasil');


    Route::get('pakan/{id}/cetak01', 'Laboratorium\PakanController@getCetak01');
    Route::get('pakan/{id}/cetak02', 'Laboratorium\PakanController@getCetak02');
    Route::get('pakan/{id}/cetak03', 'Laboratorium\PakanController@getCetak03');
    Route::get('pakan/{id}/cetak04', 'Laboratorium\PakanController@getCetak04');
    Route::get('pakan/{id}/cetakhasil', 'Laboratorium\PakanController@getCetakHasil');

});



//PLLT
Route::post('pllt/hapus-data-hewan', 'Modul\PlltController@hapusDataHewan');
Route::get('pllt/area-data-hewan', 'Modul\PlltController@getDataHewan');
Route::post('pllt/tambah-data-hewan', 'Modul\PlltController@tambahDataHewan');
Route::post('pllt/hapus-file', 'Modul\PlltController@hapusFile');
Route::get('pllt/area-file', 'Modul\PlltController@getFile');
Route::get('pllt/area-pemeriksa', 'Modul\PlltController@formPemeriksa');
Route::get('pllt/area-kecamatan-tujuan', 'Modul\PlltController@formAreaKecamatanTujuan');
Route::get('pllt/area-kota-tujuan', 'Modul\PlltController@formAreaKotaTujuan');
Route::get('pllt/area-kecamatan-asal', 'Modul\PlltController@formAreaKecamatanAsal');
Route::get('pllt/area-kota-asal', 'Modul\PlltController@formAreaKotaAsal');
Route::get('pllt/area-jenis-hewan', 'Modul\PlltController@formAreaJenisHewan');
Route::get('pllt/nama-pllt', 'Modul\PlltController@getPllt');
Route::resource('pllt', 'Modul\PlltController');



//KLINIK
Route::post('klinik/hapus-data-terapi', 'Modul\KlinikController@hapusDataTerapi');
Route::get('klinik/area-data-terapi', 'Modul\KlinikController@getDataTerapi');
Route::post('klinik/tambah-data-terapi', 'Modul\KlinikController@tambahDataTerapi');
Route::get('klinik/area-ras', 'Modul\KlinikController@formAreaRas');
Route::get('klinik/area-obat', 'Modul\KlinikController@formAreaObat');
Route::get('klinik/area-operasi', 'Modul\KlinikController@formAreaOperasi');
Route::get('klinik/cetak/{id}', 'Modul\KlinikController@cetakKartu');
Route::get('klinik/cetakRM/{id}', 'Modul\KlinikController@cetakRM');
Route::post('klinik/cek-validasi', 'Modul\KlinikController@cekValidasi');
Route::get('klinik/pemilik', 'Modul\KlinikController@getPemilik');
Route::get('klinik/hewan', 'Modul\KlinikController@getHewan');
Route::get('klinik/detailHewan', 'Modul\KlinikController@getDetailHewan');
Route::get('klinik/getJmlPeriksa', 'Modul\KlinikController@getJmlPeriksa');
Route::get('klinik/getNoRm', 'Modul\KlinikController@getNoRm');
Route::get('klinik/nama-klinik', 'Modul\KlinikController@getKlinik');
Route::get('klinik/add/','Modul\KlinikController@addKlinik');
Route::post('klinik/tambahTerapi','Modul\KlinikController@tambahTerapi');
Route::get('klinik/detailPeriksa/{id}','Modul\KlinikController@detailPeriksa');
Route::resource('klinik', 'Modul\KlinikController');


Route::prefix('laporan')->group(function () {
    Route::post('lap-klinik', 'Laporan\LaporanKlinikController@cetakLaporanPasien');
    Route::get('lap-klinik', 'Laporan\LaporanKlinikController@formCetak');
    Route::get('lap-klinik-prev', 'Laporan\LaporanKlinikController@preview');
    Route::post('lap-ternak-masuk', 'Laporan\LaporanPlltController@cetakTernakMasuk');
    Route::get('lap-ternak-masuk', 'Laporan\LaporanPlltController@formCetakTernakMasuk');
    Route::get('lap-ternak-masuk-prev', 'Laporan\LaporanPlltController@TernakMasukPrev');
    Route::post('lap-ternak-lewat', 'Laporan\LaporanPlltController@cetakTernakLewat');
    Route::get('lap-ternak-lewat', 'Laporan\LaporanPlltController@formCetakTernakLewat');
    Route::get('lap-ternak-lewat-prev', 'Laporan\LaporanPlltController@TernakLewatPrev');
    Route::post('lap-ternak-keluar', 'Laporan\LaporanPlltController@cetakTernakKeluar');
    Route::get('lap-ternak-keluar', 'Laporan\LaporanPlltController@formCetakTernakKeluar');
    Route::get('lap-ternak-keluar-prev', 'Laporan\LaporanPlltController@TernakKeluarPrev');

    Route::get('lab-keswan/{bulan}/{tahun}/{id}/{tipe}', 'Laporan\LaporanKeswanController@getLaporanKeswan');
    Route::get('lab-kesmavet/{bulan}/{tahun}/{id}/{tipe}', 'Laporan\LaporanKesmavetController@getLaporanKesmavet');
    Route::get('lab-pakan/{bulan}/{tahun}/{id}/{tipe}', 'Laporan\LaporanPakanController@getLaporanPakan');

    Route::post('lab-keswan', 'Laporan\LaporanKeswanController@postLaporanKeswan');
    Route::post('lab-pakan', 'Laporan\LaporanPakanController@postLaporanPakan');
    Route::post('lab-kesmavet', 'Laporan\LaporanKesmavetController@postLaporanKesmavet');

    Route::group(['middleware' => ['ajax']], function (){
        Route::post('lab-keswan/tampil', 'Laporan\LaporanKeswanController@cetakPengujian');
        Route::post('lab-pakan/tampil', 'Laporan\LaporanPakanController@cetakPengujian');        
        Route::post('lab-kesmavet/tampil', 'Laporan\LaporanKesmavetController@cetakPengujian');        
        Route::get('lab-keswan', 'Laporan\LaporanKeswanController@formCetakPengujian');        
        Route::get('lab-kesmavet', 'Laporan\LaporanKesmavetController@formCetakPengujian');        
        Route::get('lab-pakan', 'Laporan\LaporanPakanController@formCetakPengujian');

        // Route::get('lab-keswan', 'Laporan\LaporanKeswanController@formCetakPengujian');
        // Route::post('lab-keswan', 'Laporan\LaporanKeswanController@CetakPengujian');

        
        // Route::get('lab-kesmavet', 'Laporan\LaporanKesmavetController@formCetakPengujian');
        // Route::post('lab-kesmavet', 'Laporan\LaporanKesmavetController@CetakPengujian');

        
        // Route::get('lab-pakan', 'Laporan\LaporanPakanController@formCetakPengujian');
        // Route::post('lab-pakan', 'Laporan\LaporanPakanController@CetakPengujian');
    });

});


Route::prefix('pengaturan')->group(function () {
    Route::get('pengguna/satuan-kerja', 'Pengaturan\PenggunaController@formSubSatuanKerja');
    Route::post('pengguna/cek-validasi', 'Pengaturan\PenggunaController@cekValidasi');
    Route::resource('pengguna', 'Pengaturan\PenggunaController');
    Route::resource('hak-akses', 'Pengaturan\HakAksesController');

});


Route::get('ganti-password', 'Pengaturan\LainLainController@formGantiPassword');
Route::post('ganti-password', 'Pengaturan\LainLainController@updatePassword');
Route::get('informasi-pengguna', 'Pengaturan\LainLainController@getInformasiPengguna');