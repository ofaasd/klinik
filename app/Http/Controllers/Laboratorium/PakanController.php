<?php

namespace App\Http\Controllers\Laboratorium;

use PDF, Session, Request, Auth, DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use App\Http\Controllers\Helpers\UserHelper;

use App\Models\Modul\LaboratoriumPakan;
use App\Models\MasterData\Customer;
use App\Models\MasterData\LabManyContoh;
// use App\Models\Modul\LaboratoriumFile;
// use App\Models\Pengaturan\User;
// use App\Models\MasterData\SubSatuanKerja;
// use App\Models\MasterData\Spesies;
use App\Models\MasterData\JenisContoh;
// use App\Models\MasterData\BentukContoh;
// use App\Models\MasterData\SeksiLaboratorium;
// use App\Models\MasterData\JenisPengujian;
// use App\Models\Indonesia\Kota;
// use Illuminate\Support\Facades\DB;


class PakanController extends Controller
{
    private $url;
    private $cari;
    private $jumPerPage = 10;

    function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->cari = Input::get('cari', '');
        $this->url = makeUrl($request::query());
    }

    public function index()
    {
        if(!Auth::user()->hasPermissionTo('Read Lab Pakan')) return view('errors.403');
        $var['url'] = $this->url;

        if(Auth::user()->view_data > 2){
            $queryLaboratorium = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->orderBy('id', 'desc');
        }else{
            $queryLaboratorium = LaboratoriumPakan::where('lab_id',2)->orderBy('id', 'desc');
        }

        (!empty($this->cari))?$queryLaboratorium->Cari($this->cari):'';
        $listLaboratorium = $queryLaboratorium->paginate($this->jumPerPage);
        (!empty($this->cari))?$listLaboratorium->setPath('laboratorium'.$var['url']['cari']):'';

        return view('laboratorium.pakan.pakan_index', compact('var', 'listLaboratorium'));
    }

// get1
    public function getForm01(Request $request,$id = false)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');
        if(!\Illuminate\Support\Facades\Request::ajax()) return view("layouts.admin_redirect");
        $pakan = null;
        if($id != false){
            if(Auth::user()->view_data > 2){
            $pakan = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->with(['subSatuanKerja:sub_satuan_kerja','customer','pakanTr'])->find($id);
            }else{
                $pakan = LaboratoriumPakan::where('lab_id',2)->with(['subSatuanKerja:sub_satuan_kerja','customer','pakanTr'])->find($id);
            }
            $id = true;

            if(empty($pakan)){
                return view('errors.403');
            }
        }

        return view("laboratorium.pakan.pakan_form01", compact('id','pakan'));
    }
// get2
    public function getForm02($id)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');
    
        if(is_numeric($id)){
            if(Auth::user()->view_data > 2){
            $pakan = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->with(['subSatuanKerja:sub_satuan_kerja','customer','pakanTr'])->find($id);
        }else{
            $pakan = LaboratoriumPakan::where('lab_id',2)->with(['subSatuanKerja:sub_satuan_kerja','customer','pakanTr'])->find($id);
        }
            if (!empty($pakan)){
                return view('laboratorium.pakan.pakan_form02', compact('pakan'));
            }else{
                return view('errors.403');
            }
        }
        return 0;
    }

    public function getForm03($id)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');
    
        if(is_numeric($id)){
            if(Auth::user()->view_data > 2){
            $pakan = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->with(['subSatuanKerja:sub_satuan_kerja','customer','pakanTr'])->find($id);
        }else{
            $pakan = LaboratoriumPakan::where('lab_id',2)->with(['subSatuanKerja:sub_satuan_kerja','customer','pakanTr'])->find($id);
        }
            if (!empty($pakan)){
                if (is_null($pakan->time_02)) {
                    return view('errors.403');
                }else{
                    return view('laboratorium.pakan.pakan_form03', compact('pakan'));
                }
            }else{
                    return view('errors.403');
            }
        }
        return 0;
    }

    // get4
    public function getForm04($id)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');
    
        if(is_numeric($id)){
            if(Auth::user()->view_data > 2){
            $pakan = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->with(['pakanTr','subSatuanKerja:sub_satuan_kerja','seksiLaboratorium'])->find($id);
        }else{
            $pakan = LaboratoriumPakan::where('lab_id',2)->with(['pakanTr','subSatuanKerja:sub_satuan_kerja','seksiLaboratorium'])->find($id);
        }
            if (!empty($pakan)){
                if (is_null($pakan->time_03)) {
                    return view('errors.403');
                }else{
                    return view('laboratorium.pakan.pakan_form04', compact('pakan'));
                }
            }else{
                return view('errors.403');
            }
        }
        return 0;
    }

    // gethasil
    public function getFormHasil($id)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');
    
        if(is_numeric($id)){
            if(Auth::user()->view_data > 2){
            $pakan = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->with(['pakanTr','subSatuanKerja:sub_satuan_kerja','seksiLaboratorium'])->find($id);
        }else{
            $pakan = LaboratoriumPakan::where('lab_id',2)->with(['pakanTr','subSatuanKerja:sub_satuan_kerja','seksiLaboratorium'])->find($id);
        }
            if (!empty($pakan)){
                if (is_null($pakan->time_04)) {
                    return view('errors.403');
                }else{
                    $jumlah_contoh = $pakan->labContoh->sum('jumlah');
                    return view('laboratorium.pakan.pakan_formhasil', compact('pakan','jumlah_contoh'));
                }
            }else{
                return view('errors.403');
            }
        }
        return 0;
    }
   // post1
    public function postForm01(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');

        // dd(Input::get('permintaan_uji'));
        try {
            DB::beginTransaction();

            $no_uji = null;
            if(Input::has('id')){
                if(Input::get('id')== '0'){
                    $lab = new LaboratoriumPakan();
                    $lab->status_epid = Input::get('status_epid');
                    $lab->no_epid = Input::get('no_epid');    
                    $no_uji = LabManyContoh::max('no_uji');
                }else{
                    if(Auth::user()->view_data > 2){
                        $lab = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->find(Input::get('id'));
                    }else{
                        $lab = LaboratoriumPakan::where('lab_id',2)->find(Input::get('id'));
                    }
                    
                    if(empty($lab)){
                        return view('errors.403');
                    }
                }
            }else{
                $lab = new LaboratoriumPakan();
                $lab->status_epid = Input::get('status_epid');
                $lab->no_epid = Input::get('no_epid');
                $no_uji = LabManyContoh::max('no_uji');
            }

            $lab->lab_id = 2;
            $lab->sub_satuan_kerja_id = Input::get('sub_satuan_kerja_id');
            $lab->nama_pengirim_id = Input::get('nama_pengirim_id');
            $lab->jenis_hewan_id = Input::get('jenis_hewan_id');
            $lab->kriteria_contoh = Input::get('kriteria_contoh');
            $lab->catatan = Input::get('catatan');
            $lab->peralatan = Input::get('peralatan');
            $lab->bahan = Input::get('bahan');
            $lab->personil = Input::get('personil');
            $lab->tanggal_penerimaan = Input::get('tanggal_penerimaan');
            $lab->pengirim = Input::get('pengirim');
            $lab->penerima = Input::get('penerima');
            $lab->input_by = Auth::user()->id;

            $lab->save();

            $pengujian = Input::get('permintaan_uji');
            $contoh = Input::get('jenis_contoh');
            $sni_id = Input::get('sni_id');
            $berat_pakan = Input::get('berat_pakan');
            $bahan_pakan = Input::get('bahan_pakan');

			$status = array();
            foreach ($contoh as $key => $value) {
                $manyContoh = $lab->pakanTr()->where('urut',$key)->get();
                foreach ($pengujian[$key] as $p_key => $p_value) {
                    if(empty($manyContoh) || $manyContoh->count() == 0){
						$status[] = "kosong";
                        $lab->pakanTr()->create(
                            [
                                'urut' => $key,
                                'lab_id' => $lab->id,
                                'pengujian_id' => $p_value,
                                'status_uji' => $lab->status_epid=="es"?"P":"A",
                                'no_uji' => $no_uji,
                                'sni_id' => $sni_id[$key],
                                'berat' => $berat_pakan[$key],
                                'bahan' => $bahan_pakan[$key],
                                'contoh_id' => $value,
                            ]
                        );
                    }else{
						$status[] = $manyContoh;
                        $mContoh = $manyContoh->where('pengujian_id',$p_value)->first();
                        $no_uji_b = $manyContoh->first()->no_uji; 
                        if(empty($mContoh)){
                            $lab->pakanTr()->create(
                                [
                                    'urut' => $key,
                                    'lab_id' => $lab->id,
                                    'pengujian_id' => $p_value,
                                    'status_uji' => $lab->status_epid=="ES"?"P":"A",
                                    'no_uji' => $no_uji_b,
                                    'sni_id' => $sni_id[$key],
                                    'berat' => $berat_pakan[$key],
                                    'bahan' => $bahan_pakan[$key],
                                    'contoh_id' => $value,
                                ]
                            );
                        }else{
                            $mContoh->status_uji = $lab->status_epid=="ES"?"P":"A";
                            $mContoh->sni_id = $sni_id[$key];
                            $mContoh->berat = $berat_pakan[$key];
                            $mContoh->bahan = $bahan_pakan[$key];
                            $mContoh->no_uji = $no_uji_b;
                            $mContoh->contoh_id = $value;
                            $mContoh->save();
                        }
                    }
                }
                // $jenis_contoh[$value] = array('jumlah' => Input::get('jumlah_contoh')[$key]);
            }
            // $lab->labContoh()->sync($jenis_contoh);
            // $lab->labPengujian()->sync(Input::get('permintaan_uji'));   

            DB::commit();

            return response()->json(array('kode' => '1','id'=> $lab->id, 'pesan' => 'FORM01 Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(array('kode' => '0', 'pesan' => 'FORM01 Gagal Disimpan','e' => $e->getMessage(),'status'=>var_dump($status)));
        }
    }
   // post2
    public function postForm02(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');

        try {
            DB::beginTransaction();

            if(Auth::user()->view_data > 2){
            $lab = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->find(Input::get('id'));
        }else{
            $lab = LaboratoriumPakan::where('lab_id',2)->find(Input::get('id'));
        }
            if(empty($lab)){
                return view('errors.403');
            }

            $lab->asal_contoh_id = Input::get('asal_contoh_id');
            $lab->penerima_02 = Input::get('penerima_02');
            $lab->catatan_02 = Input::get('catatan_02');
            $nomor_baru = Input::get('nomor_baru');
            $nomor_asal = Input::get('nomor_asal');

            if(empty($lab->time_02)){
                $lab->time_02 = date('Y-m-d H:i:s');
            }

            foreach ($nomor_baru as $key => $value) {
                    LabManyContoh::where('lab_id',$lab->id)->where('urut',$key)
                        ->update([
                            'nomor_asal' => $nomor_asal[$key],
                            'nomor_baru' => $nomor_baru[$key]
                        ]
                    );
            }

            $lab->save();

            DB::commit();

            return response()->json(array('kode' => '1','id'=> $lab->id, 'pesan' => 'FORM02 Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(array('kode' => '0', 'pesan' => 'FORM02 Gagal Disimpan','e' => $e->getMessage()));
        }
    }

    // post3
    public function postForm03(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');

        try {
            DB::beginTransaction();

            if(Auth::user()->view_data > 2){
            $lab = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->find(Input::get('id'));
        }else{
            $lab = LaboratoriumPakan::where('lab_id',2)->find(Input::get('id'));
        }
            if(empty($lab)){
                return view('errors.403');
            }

            $lab->seksi_laboratorium_id = Input::get('seksi_laboratorium_id');
            $lab->manajer_teknis = Input::get('manajer_teknis');
            $lab->catatan_03 = Input::get('catatan_03');
            
            if(empty($lab->time_03)){
                $lab->time_03 = date('Y-m-d H:i:s');
            }

            $lab->save();

            DB::commit();

            return response()->json(array('kode' => '1','id'=> $lab->id, 'pesan' => 'FORM03 Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(array('kode' => '0', 'pesan' => 'FORM03 Gagal Disimpan','e' => $e->getMessage()));
        }
    }

    // post4
    public function postForm04(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');

        try {
            DB::beginTransaction();

            if(Auth::user()->view_data > 2){
            $lab = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->find(Input::get('id'));
        }else{
            $lab = LaboratoriumPakan::where('lab_id',2)->find(Input::get('id'));
        }
            if(empty($lab)){
                return view('errors.403');
            }

            $lab->penguji_ditunjuk = Input::get('penguji_ditunjuk');
            $lab->catatan_04 = Input::get('catatan_04');
            
            if(empty($lab->time_04)){
                $lab->time_04 = date('Y-m-d H:i:s');
            }

            $lab->save();

            DB::commit();

            return response()->json(array('kode' => '1','id'=> $lab->id, 'pesan' => 'FORM04 Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(array('kode' => '0', 'pesan' => 'FORM04 Gagal Disimpan','e' => $e->getMessage()));
        }
    }

    // posthasil
    public function postFormHasil(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');
        try {
            DB::beginTransaction();

            if(Auth::user()->view_data > 2){
            $lab = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->find(Input::get('id'));
        }else{
            $lab = LaboratoriumPakan::where('lab_id',2)->find(Input::get('id'));
        }
            if(empty($lab)){
                return view('errors.403');
            }

            $lab->catatan_hasil = Input::get('catatan_04');
            $hasil = Input::get('hasil');
            
            if(empty($lab->time_hasil)){
                $lab->time_hasil = date('Y-m-d H:i:s');
            }

            foreach ($lab->pakanTr as $key=>$ptr) {
                $ptr->sni = $hasil[$ptr->id][0];
                $ptr->nilai = $hasil[$ptr->id][1];
                $ptr->save();
            }


                // $arr = [];
                // $i = 0;
                // foreach($hasil[$lc->contoh_id] as $key2=>$h) {
                //     dd($hasil);
                //     $arr[$i++] = array($lc->id => array(
                //         'sni' => $h[0],
                //         'nilai' => $h[1],
                //         'lab_id' => $lab->id
                //     ));
                // }
                // dd($arr);
                // $lc->pengujianContoh()->sync($hasil[$lc->id]);
            // }
            $lab->save();

            DB::commit();

            return response()->json(array('kode' => '1','id'=> $lab->id, 'pesan' => 'FORM04 Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(array('kode' => '0', 'pesan' => 'FORM04 Gagal Disimpan','e' => $e->getMessage()));
        }
    }

    public function getCustomer(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');
    
        $customer = Customer::find(Input::get('customerId'));
        return response()->json($customer);
    }

    public function checkNoEpid(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');
    
        if (Input::get('id') !=0) {
            return true;
        }else{
            if(Auth::user()->view_data > 2){
            $jumlah = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->where('no_epid', Input::get('no_epid'))->count();
        }else{
            $jumlah = LaboratoriumPakan::where('lab_id',2)->where('no_epid', Input::get('no_epid'))->count();
        }
            return response()->json($jumlah>0?false:true);
        }
    }

    public function getCetak01($id) {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');
    
        if(Auth::user()->view_data > 2){
            $pakan = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->with(['pakanTr','labContoh','subSatuanKerja','customer'])->find($id);
        }else{
        $pakan = LaboratoriumPakan::where('lab_id',2)->with(['pakanTr','labContoh','subSatuanKerja','customer'])->find($id);
    }
        if (empty($pakan)) {
            return view('errors.403');
        }

        return view('laboratorium.pakan.pakan_cetak01',compact('pakan'));
    }

    public function getCetak02($id) {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');
    
        if(Auth::user()->view_data > 2){
            $pakan = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->with(['pakanTr','subSatuanKerja'])->find($id);
        }else{
        $pakan = LaboratoriumPakan::where('lab_id',2)->with(['pakanTr','subSatuanKerja'])->find($id);
    }
        if (empty($pakan)) {
            return view('errors.403');
        }

        return view('laboratorium.pakan.pakan_cetak02',compact('pakan'));
    }
    
    public function getCetak03($id) {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');
    
        if(Auth::user()->view_data > 2){
            $pakan = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->with(['pakanTr','subSatuanKerja','customer'])->find($id);
        }else{
        $pakan = LaboratoriumPakan::where('lab_id',2)->with(['pakanTr','subSatuanKerja','customer'])->find($id);
    }
        if (empty($pakan)) {
            return view('errors.403');
        }

        return view('laboratorium.pakan.pakan_cetak03',compact('pakan'));
    }
    
    public function getCetak04($id) {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');
    
        if(Auth::user()->view_data > 2){
            $pakan = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->with(['pakanTr','subSatuanKerja','customer'])->find($id);
        }else{
        $pakan = LaboratoriumPakan::where('lab_id',2)->with(['pakanTr','subSatuanKerja','customer'])->find($id);
    }
        if (empty($pakan)) {
            return view('errors.403');
        }

        return view('laboratorium.pakan.pakan_cetak04',compact('pakan'));
    }
    
    public function getCetakHasil($id) {
        if(!Auth::user()->hasPermissionTo('Create Lab Pakan')) return view('errors.403');
    
        if(Auth::user()->view_data > 2){
            $pakan = LaboratoriumPakan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',2)->with(['pakanTr','labContoh:jumlah','subSatuanKerja','seksiLaboratorium'])->find($id);
        }else{
        $pakan = LaboratoriumPakan::where('lab_id',2)->with(['pakanTr','subSatuanKerja','seksiLaboratorium'])->find($id);
    }
        if (empty($pakan)) {
            return view('errors.403');
        }

        return view('laboratorium.pakan.pakan_cetakhasil',compact('pakan'));
    }
}