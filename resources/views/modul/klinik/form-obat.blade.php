<div class="form-group row">
        {!! Form::label('terapi_id', 'Terapi / Tindakan', ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">

        <select name="terapi_id" id="terapi_id" class='form-control select2' style='width: 100%;'>
            @foreach($var['obat'] as $obat)
            <option value="{{$obat->id}}">{{$obat->obat}} ({{$obat->satuan}})</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
