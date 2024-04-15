<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\Layanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LayananController extends Controller
{
    private $url;
    private $cari;
    private $jumPerPage = 10;

    function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->cari = Input::get('cari', '');
        $this->url = makeUrl($request->query());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $var['url'] = $this->url;

        $queryLayanan = Layanan::orderBy('id', 'desc');
        (!empty($this->cari))?$queryLayanan->Cari($this->cari):'';
        $listLayanan = $queryLayanan->paginate($this->jumPerPage);
        (!empty($this->cari))?$listLayanan->setPath('Layanan'.$var['url']['cari']):'';

        return view('master-data.layanan.layanan-1', compact('var', 'listLayanan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $var['method'] =  'create';

        return view('master-data.layanan.layanan-2', compact('var'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $Layanan = Layanan::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Layanan Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Layanan Gagal Disimpan');
            return redirect('master-data/layanan/create')->withInput();
        }

        return redirect('master-data/layanan/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $var['url'] = $this->url;
        $var['method'] = 'show';
        $listLayanan = Layanan::find($id);

        return view('master-data.layanan.layanan-2', compact('listLayanan', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //if(!Auth::user()->hasPermissionTo('Update Layanan')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $listLayanan = Layanan::find($id);

        return view('master-data.layanan.layanan-2', compact('listLayanan', 'var'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $var['url'] = $this->url;

        try {
            DB::beginTransaction();
            $input = $request->all();
            $Layanan = Layanan::find($id);
            $Layanan->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Layanan Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Layanan Gagal Diupdate');
        }

        return redirect('master-data/layanan'.$var['url']['all']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $var['url'] = $this->url;

        try {
            DB::beginTransaction();
            $Layanan = Layanan::find($id);
            $Layanan->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Layanan Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Layanan Gagal Dihapus');
        }

        return redirect('master-data/layanan'.$var['url']['all']);
    }


}
