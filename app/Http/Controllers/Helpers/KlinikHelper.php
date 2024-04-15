<?php

namespace App\Http\Controllers\Helpers;


use App\Models\MasterData\Obat;
use App\Models\MasterData\Operasi;
use App\Models\MasterData\Layanan;
use App\Models\MasterData\DaftarHarga;
use App\Models\Modul\Pembayaran;

class KlinikHelper
{
	function testing(){
		return "asdasda berhasil";
	}
	function terapi($penang,$terapi_id){
		if($penang == 2){
			return Layanan::where("id",$terapi_id)->first()->nama;
		}else{
			return Obat::where("id",$terapi_id)->first()->obat;
		}
	}
	function getHarga($tindakan, $terapi){
        if($tindakan == 1){
            $hasil = Obat::where('id', $terapi)->first();
        }else{
            $hasil = Layanan::where('id', $terapi)->first();
        }


		return $hasil;
	}
	function getTotal($id){
		return pembayaran::where("klinik_terapi_id",$id)->first()->total;
	}
}
