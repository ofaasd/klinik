@extends('boyolali.layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Kelompok Kerja
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active">Kelompok Kerja</li>
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
                            <li class="nav-item"><a href="{{ url('boyolali/master-data/kelompok-kerja') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('master-data/obat/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        {!! Form::model($listKelompok, ['method'=>'PATCH', 'url'=> 'boyolali/master-data/kelompok-kerja/'.$listKelompok->id.$var['url']['all'], 'id'=>'form-operasi']) !!}
                                    @elseif($var['method']=='create')
                                        {!! Form::open(['id'=>'form-operasi', 'method'=>'POST', 'url'=>'/boyolali/master-data/kelompok-kerja']) !!}
                                    @else
                                        {!! Form::model($listKelompok, ['class'=>'form-operasi']) !!}
                                    @endif
                                        <div class="form-group row">
                                            {!! Form::label('kelompok', 'Pilih Kelompok', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('kelompok', $var['kelompok'],null, ['class'=>'form-control', 'placeholder'=>'Pilih Kelompok']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('jenis', 'Jenis Kelompok', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('jenis', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Jenis Kelompok']) !!}
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
                var pk = "{{ $listKelompok->id }}";
            @else
                var pk = null;
            @endif

            $("#form-obat").validate({
                rules: {
                    kode: {
                        required: true,
                        remote: {
                            url: "{{ url('master-data/operasi/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "kode",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                    obat: "required",
                },
                messages: {
                    kode: {
                        required: "Kolom kode harus diisi",
                        remote: "Kode sudah digunakan"
                    },
                    tindakan: "Kolom tindakan harus diisi",
                }
            });
        });
    </script>
@endsection