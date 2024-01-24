<div class="form-group row">
    {!! Form::label('kecamatan_id', 'Kecamatan', ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('kecamatan_id', $listKecamatan, $var['kecamatanId'], ['class'=>'form-control select2', 'placeholder'=>'Pilih Kecamatan', 'style'=>'width: 100%;', 'onchange'=>'dataKelurahan()']) !!}
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>