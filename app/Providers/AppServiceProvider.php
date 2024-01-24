<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $varGlobal = array();
        //MENU
        if(Request::segment(1) == 'beranda') $varGlobal['beranda'] = 'active';
        if(Request::segment(1) == 'master-data') $varGlobal['master-data'] = 'active';
        if(Request::segment(1) == 'lab') $varGlobal['lab'] = 'active';
        if(Request::segment(1) == 'pllt') $varGlobal['pllt'] = 'active';
        if(Request::segment(1) == 'klinik') $varGlobal['klinik'] = 'active';
        if(Request::segment(1) == 'laporan') $varGlobal['laporan'] = 'active';
        if(Request::segment(1) == 'pengaturan') $varGlobal['pengaturan'] = 'active';

        //SUB MENU
        if(Request::segment(2) == 'sub-satuan-kerja') $varGlobal['sub-satuan-kerja'] = 'active';
        if(Request::segment(2) == 'spesies') $varGlobal['spesies'] = 'active';
        if(Request::segment(2) == 'ras') $varGlobal['ras'] = 'active';
        if(Request::segment(2) == 'jenis-contoh') $varGlobal['jenis-contoh'] = 'active';
        if(Request::segment(2) == 'bentuk-contoh') $varGlobal['bentuk-contoh'] = 'active';
        if(Request::segment(2) == 'seksi-laboratorium') $varGlobal['seksi-laboratorium'] = 'active';
        if(Request::segment(2) == 'jenis-pengujian') $varGlobal['jenis-pengujian'] = 'active';
        if(Request::segment(2) == 'customer') $varGlobal['customer'] = 'active';
        if(Request::segment(2) == 'asal-hewan') $varGlobal['asal-hewan'] = 'active';
        if(Request::segment(2) == 'pemeriksa') $varGlobal['pemeriksa'] = 'active';
        if(Request::segment(2) == 'pemilik') $varGlobal['pemilik'] = 'active';
        if(Request::segment(2) == 'penyakit') $varGlobal['penyakit'] = 'active';
        if(Request::segment(2) == 'obat') $varGlobal['obat'] = 'active';
        if(Request::segment(2) == 'lap-klinik') $varGlobal['lap-klinik'] = 'active';
        if(Request::segment(2) == 'lap-ternak-masuk') $varGlobal['lap-ternak-masuk'] = 'active';
        if(Request::segment(2) == 'lap-ternak-lewat') $varGlobal['lap-ternak-lewat'] = 'active';
        if(Request::segment(2) == 'lap-ternak-keluar') $varGlobal['lap-ternak-keluar'] = 'active';
        if(Request::segment(2) == 'lap-pengujian') $varGlobal['lap-pengujian'] = 'active';
        if(Request::segment(2) == 'pengguna') $varGlobal['pengguna'] = 'active';
        if(Request::segment(2) == 'hak-akses') $varGlobal['hak-akses'] = 'active';
        if(Request::segment(2) == 'keswan') $varGlobal['keswan'] = 'active';

        View::share('varGlobal', $varGlobal);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
