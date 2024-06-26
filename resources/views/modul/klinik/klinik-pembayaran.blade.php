@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Klinik
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item active">Klinik</li>
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
                        @include('modul.klinik.menu')
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    <div class="row">
										<div class="col-md-12">

										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<h4>Data Pasien</h4>
											<table class="table table-hover">
												<tbody>
													<tr><td>Nama pasien</td><td align="left">: {{$var['curr_klinik']->nama_pemilik}}</td></tr>
													<tr><td>Tinggi Badan</td><td align="left">: {{$var['curr_klinik']->tb}}</td></tr>
													<tr><td>Berat Badan</td><td align="left">: {{$var['curr_klinik']->bb}}</td></tr>
													<tr><td>Keluhan</td><td align="left">: {{$var['curr_klinik']->keluhan}}</td></tr>
													<tr><td>Hasil Pemeriksaan</td><td align="left">: {{$var['curr_klinik']->signalement}}</td></tr>
													<tr><td>Diagnosis</td><td align="left">: {{$var['curr_klinik']->diagnosa}}</td></tr>
												</tbody>
											</table>
										</div>
										<div class="col-md-6">
											<h4>Penanganan</h4>

											<table class="table table-hover">
												<thead>
													<tr class="bg-info">
														<th style="text-align: center;"><b>Penanganan</b></th>
														<th style="text-align: center;"><b>Terapi</b></th>
														<th style="text-align: center;"><b>Dosis</b></th>
													</tr>
												</thead>
												<tbody id="my_table">
													@if(!empty($var['klinik_dosis']))
														@php
															$i = 1;
														@endphp
														@foreach($var['klinik_dosis'] as $dosis)
															<tr class="tbl{{$i}}">
															<td><input type="hidden" name="tindakan_id[]" value="{{$dosis->tindakan}}">{{$var['penanganan'][$dosis->tindakan]}}</td>
															<td><input type="hidden" name="terapi_id[]" value="{{$dosis->terapi_id}}">{{$var['helper']->terapi($dosis->tindakan,$dosis->terapi_id)}}</td>
															<td><input type="hidden" name="dosis[]" value="{{$dosis->dosis}}">{{$dosis->dosis}}</td></tr>
														@php $i++; @endphp
														@endforeach
													@endif
												</tbody>
											</table>
										</div>

										<div class="col-md-12">
											{!! Form::open(['id'=>'form-klinik', 'method'=>'POST', 'url'=>'/klinik/simpan_pembayaran']) !!}
											<input type="hidden" name="from_url" value="{{$var['from_url']}}">
											<input type="hidden" name="hewan" value="{{$var['curr_klinik']->klinik_id}}">
											<div class="row">
												<div class="col-md-8">
													<h4>Rincian Pembayaran</h4>
												</div>
												{{-- <div class="col-md-4" style="text-align:right">
													<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Tambah Pelayanan</a>
												</div> --}}
												<!-- Modal -->
												<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
												  <div class="modal-dialog">
													<div class="modal-content">
													  <div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														  <span aria-hidden="true">&times;</span>
														</button>
													  </div>
													  <div class="modal-body">
														<select name="layanan" id="layanan" class="form-control select2" style="width:100%">
															<option value="0">Pilih Pelayanan</option>
															@foreach($var['pelayanan'] as $row)
																<option value="{{$row->id}}">{{$row->nama}} - Rp {{number_format($row->tarif,0,"",".")}}</option>
															@endforeach
														</select>
													  </div>
													  <div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
														<button type="button" class="btn btn-primary" id="simpan_layanan" data-dismiss="modal">Save changes</button>
													  </div>
													</div>
												  </div>
												</div>
											</div>
											<br />
											<table class="table table-hover table-bordered table-stripped">
												<thead>
													<tr class="bg-info">
														<td>No. </td>
														<td>Pelayanan</td>
														<td>Qty</td>
														<td>Tarif</td>
                                                        <td>Total</td>
														<td></td>
													</tr>
												</thead>
												<input type="hidden" name="klinik_terapi_id" value={{$var['curr_klinik']->id}}>
												<tbody id="tbl-pembayaran">
													@if(!empty($var['klinik_dosis']))
														@php
															$i = 1;
															$pengobatan = 0;
															$total = 0;
														@endphp
														@foreach($var['klinik_dosis'] as $dosis)

															@if($dosis->tindakan == 1)
																@php $pad = $var['helper']->getHarga($dosis->tindakan,$dosis->terapi_id) @endphp
																<tr class="tbl{{$i}}">
																	<td>{{$i}} <input type="hidden" class="counter" value="{{$i}}"></td>
																	<td>
																		<input type="hidden" name="tindakan_id[]" value="{{$dosis->tindakan}}">
																		{{$pad->obat}}
																	</td>
                                                                    <td>
                                                                        <input type="hidden" name="dosis[]" value="{{$dosis->dosis}}">
																		{{$dosis->dosis}}
                                                                    </td>
																	<td align="right" style="text-align:right">
																		<input type="hidden" name="terapi_id[]" value="{{$pad->id}}">
																		<input type="hidden" name="tarif[]" id="tarif{{$i}}" value="{{$pad->harga_jual}}">
																		Rp. {{number_format($pad->harga_jual,0,",",".")}}
																	</td>
																	<td align="right" style="text-align:right">
																		Rp. {{number_format(($pad->harga_jual * $dosis->dosis),0,",",".")}}
																	</td>
																	<td>
																		<a href="#" onclick="hapus({{$i}})" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
																	</td>
																</tr>
																@php
																	$total += ($pad->harga_jual * (int)$dosis->dosis);
																	$pengobatan = 1;
																	$i++;
																@endphp
															@else
																@php $pad = $var['helper']->getHarga($dosis->tindakan,$dosis->terapi_id) @endphp
																@if(!empty($pad))
																	<tr class="tbl{{$i}}">
																		<td>{{$i}} <input type="hidden" class="counter" value="{{$i}}"></td>
																		<td>
																			<input type="hidden" name="tindakan_id[]" value="{{$dosis->tindakan}}">
																			{{$pad->nama}}
																		</td>
                                                                        <td>
                                                                            <input type="hidden" name="dosis[]" value="{{$dosis->dosis}}">
                                                                        </td>
																		<td align="right" style="text-align:right">
																			<input type="hidden" name="terapi_id[]" value="{{$dosis->terapi_id}}">
																			<input type="hidden" name="tarif[]" id="tarif{{$i}}" value="{{$pad->tarif}}">
																			Rp. {{number_format($pad->tarif,0,",",".")}}
																		</td>
																		<td align="right" style="text-align:right">
																			Rp. {{number_format($pad->tarif,0,",",".")}}
																		</td>
																		<td>
																			<a href="#" onclick="hapus({{$i}})" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
																		</td>
																	</tr>
																	@php
																		$total += $pad->tarif;
																		$i++;
																	@endphp
																@else
																	@php continue; @endphp
																@endif
															@endif



														@endforeach
													@endif
												</tbody>
												<tfoot>
													<tr class="bg-secondary">
														<th colspan=4><b>Total <input type="hidden" name="total" id="total" value="{{$total}}"></b></th>
														<th align="right" style="text-align:right" ><b id="total_view">Rp. {{number_format($total,0,",",".")}}</b></th>

														<th></th>
													</tr>


												</tfoot>
											</table>
											{{-- <div class="form-group row">
												{!! Form::label('no_kwitansi', 'No. Kwitansi', ['class' => 'col-sm-2 col-form-label required']) !!}
												<div class="col-sm-10">

													{!! Form::text('no_kwitansi', (!empty($var['pembayaran']->first())?$var['pembayaran']->first()->no_kwitansi:""), ['class'=>'form-control', 'placeholder'=>'Inputkan No. kwitansi', 'required']) !!}
												</div>
											</div>
											<div class="form-group row">
												{!! Form::label('no_kwitansi', 'No. Kwitansi', ['class' => 'col-sm-2 col-form-label required']) !!}
												<div class="col-sm-10">

													{!! Form::text('no_kwitansi', (!empty($var['pembayaran']->first())?$var['pembayaran']->first()->no_kwitansi:""), ['class'=>'form-control', 'placeholder'=>'Inputkan No. kwitansi', 'required']) !!}
												</div>
											</div> --}}

											<hr />
											{!! Form::submit('Bayar', ['class'=>'btn btn-primary col-md-12']) !!}
											{!! Form::close() !!}
										</div>
										<div class="col-md-12">

										</div>

									</div>
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
		$(document).ready(function(){

			$("#simpan_layanan").click(function(){
				var counter = parseInt($(".counter:last").val())+1;
				var id = $("#layanan").val();
				$.ajax({
                    method : 'post',
                    url : '{{ url('/klinik/cari_layanan') }}',
					dataType: 'JSON',
                    data : 'id='+id,
                }).done(function (data) {
					console.log(data);
                    $("#tbl-pembayaran").append(
						'<tr class="tbl'+counter+'">'+
						'<td>'+counter+'</td>'+
						'<td><input type="hidden" name="nama_layanan[]" value="'+data.nama+'">'+data.nama+'</td>'+
						'<td align="right" style="text-align:right"><input type="hidden" name="tarif_layanan[]" value="'+ data.tarif + '" id="tarif'+counter+'">'+ formatRupiah(String(data.tarif),"Rp. ") +'</td>'+
						'<td><a href="#" class="delete_row btn btn-danger btn-xs" onclick="hapus('+counter+')"><input type="hidden" name="id_detail[]" value="" class="id_detail"><i class="fa fa-trash"></i></a></td>'+
						"</tr>"
					);
					$("#total").val(parseInt($("#total").val())+parseInt(data.tarif));
					$("#total_view").html(formatRupiah($("#total").val(),"Rp. "));
					var id = $("#layanan").val(0);
                });

			});
		});
		function update_harga (){

		}
		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}
		function hapus(i){
			$("#total").val(parseInt($("#total").val())-parseInt($("#tarif"+i).val()));
			$("#total_view").html(formatRupiah($("#total").val(),"Rp. "));
			$(".tbl"+i).remove();
		}
    </script>
@endsection
