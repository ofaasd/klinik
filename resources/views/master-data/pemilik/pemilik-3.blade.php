@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pasien
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active">Pasien</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a href="{{ url('master-data/pemilik') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('master-data/pemilik/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        {!! Form::model($listPemilik, ['method'=>'PATCH', 'url'=> '/master-data/pemilik/'.$listPemilik->id.$var['url']['all'], 'id'=>'form-pemilik']) !!}
                                    @elseif($var['method']=='create')
                                        {!! Form::open(['id'=>'form-pemilik', 'method'=>'POST', 'url'=>'/master-data/pemilik']) !!}
                                    @else
                                        {!! Form::model($listPemilik, ['class'=>'form-pemilik']) !!}
                                    @endif
                                        <div class="form-group row">
                                            {!! Form::label('kode', 'Kode', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                            @if($var['method']=='edit')
                                                {!! Form::text('kode', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Kode']) !!}
											@else
                                                {!! Form::text('kode', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Kode']) !!}
                                            @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('nama', 'Nama', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('nama', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nama']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('alamat', 'Alamat', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('alamat', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Alamat']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('telepon', 'Telepon', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('telepon', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Telepon']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('ktp', 'Nomor KTP', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('ktp', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nomor KTP']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                @if($var['method']=='edit')
                                                    {!! Form::submit('Update', ['class'=>'btn btn-primary']) !!}
                                                    {!! Form::reset('Reset', ['class'=>'btn btn-danger']) !!}
                                                @elseif($var['method']=='create')
                                                    {!! Form::submit('Simpan', ['class'=>'btn btn-primary']) !!}
                                                    {!! Form::reset('Reset', ['class'=>'btn btn-danger']) !!}
                                                @else
                                                    <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
                                                @endif
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </div>

    </section>
    <!-- /.content -->


@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            @if($var['method']=='edit' || $var['method']=='show')
                var pk = "{{ $listPemilik->id }}";
            @else
                var pk = null;
            @endif

            $("#form-pemilik").validate({
                rules: {
                    kode: {
                        required: true,
                        remote: {
                            url: "{{ url('master-data/pemilik/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "kode",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                    nama: "required",
                },
                messages: {
                    kode: {
                        required: "Kolom kode harus diisi",
                        remote: "Kode sudah digunakan"
                    },
                    nama: "Kolom nama harus diisi",
                }
            });
        });
    </script>
@endsection
