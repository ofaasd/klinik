<html>
	<head>
	    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sibavet">
        <meta name="author" content="Visualmedia Semarang">
        <link rel="icon" href="{{ asset('fabadmin/images/favicon.ico') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ env('APP_NAME', 'Laravel') }}</title>

        <style>
            @page{
			size:auto;
			margin:5mm;
		}
		body{
			background-color:#ffffff;

			margin:0px;
		}

        </style>
	</head>
	<body>
		<div style="margin-top:20px;">
		<center>
		   <b>
		   <h4 style="">
			KLINIK dr. RABIAH ADAWIYAH (DAWI), Sp. OG<br>
			DOKTER SPESIALIS KEBIDANAN DAN KANDUNGAN<BR>
			</h4>
			<h5 style="margin-top:-10px">
				{{$dataklinik->alamat}} Telepon {{$dataklinik->telp}}
			</h5>
		   </b>
		</center>
		<hr style="border:1.5px solid black"><hr style="border:1.5px solid black; margin-top:-7px;">
		</div>

		<div>
			<center>
			<h3>
			<b><u>Kwitansi Pembayaran</u></b>
			</h3>
			</center>
		</div>
		<div align="left">
			<table width="100%">
				<tr>
					<td><p>Diterima Dari</p></td><td>: {{$var['curr_klinik']->nama_pemilik}}</td>
					<td align="right">No Kwitansi : {{$var['curr_klinik']->no_pasien}}/{{$var['curr_klinik']->id}}/{{date('m',strtotime($var['curr_klinik']->tanggal_periksa))}}/{{date('y',strtotime($var['curr_klinik']->tanggal_periksa))}}</td>
				</tr>

				<tr>
					<td><p>Uang Sejumlah</p></td><td>: Rp. {{number_format($var['jumlah_uang'],"0","",".")}}</td>
				</tr>
				<tr>
					<td><p>Guna Pembayaran</p></td><td>: </td>
				</tr>
			</table>
		</div>
		<br />
		<table style="border-collapse:collapse;border:1px solid gray;" width="100%" align="center">
			<thead>
				<tr class="bg-info" style="border-collapse:collapse;border:1px solid gray;">
					<td style="border-collapse:collapse;border:1px solid gray;">No. </td>
					<td style="border-collapse:collapse;border:1px solid gray;">Pelayanan</td>
					<td style="border-collapse:collapse;border:1px solid gray;">Qty</td>
					<td style="border-collapse:collapse;border:1px solid gray;">Tarif</td>
					<td style="border-collapse:collapse;border:1px solid gray;">Total</td>
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
                            <tr class="tbl{{$i}}" style="border-collapse:collapse;border-right:1px solid gray;border-left:1px solid gray;">
                                <td style="border-collapse:collapse;border-right:1px solid gray;border-left:1px solid gray;">{{$i}} <input type="hidden" class="counter" value="{{$i}}"></td>
                                <td style="border-collapse:collapse;border-right:1px solid gray;border-left:1px solid gray;">
                                    <input type="hidden" name="tindakan_id[]" value="{{$dosis->tindakan}}">
                                    {{$pad->obat}}
                                </td>
                                <td style="border-collapse:collapse;border-right:1px solid gray;border-left:1px solid gray;">
                                    <input type="hidden" name="dosis[]" value="{{$dosis->dosis}}">
                                    {{$dosis->dosis}}
                                </td>
                                <td align="right" style="text-align:right;border-collapse:collapse;border-right:1px solid gray;border-left:1px solid gray;">
                                    <input type="hidden" name="terapi_id[]" value="{{$pad->id}}">
                                    <input type="hidden" name="tarif[]" id="tarif{{$i}}" value="{{$pad->harga_jual}}">
                                    Rp. {{number_format($pad->harga_jual,0,",",".")}}
                                </td>
                                <td align="right" style="text-align:right;border-collapse:collapse;border-right:1px solid gray;border-left:1px solid gray;">
                                    Rp. {{number_format(($pad->harga_jual * $dosis->dosis),0,",",".")}}
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
                                <tr class="tbl{{$i}}" style="border-collapse:collapse;border-right:1px solid gray;border-left:1px solid gray;">
                                    <td style="border-collapse:collapse;border-right:1px solid gray;border-left:1px solid gray;">{{$i}} <input type="hidden" class="counter" value="{{$i}}"></td>
                                    <td style="border-collapse:collapse;border-right:1px solid gray;border-left:1px solid gray;">
                                        <input type="hidden" name="tindakan_id[]" value="{{$dosis->tindakan}}">
                                        {{$pad->nama}}
                                    </td>
                                    <td style="border-collapse:collapse;border-right:1px solid gray;border-left:1px solid gray;">
                                        <input type="hidden" name="dosis[]" value="{{$dosis->dosis}}">
                                    </td>
                                    <td align="right" style="text-align:right;border-collapse:collapse;border-right:1px solid gray;border-left:1px solid gray;">
                                        <input type="hidden" name="terapi_id[]" value="{{$dosis->terapi_id}}">
                                        <input type="hidden" name="tarif[]" id="tarif{{$i}}" value="{{$pad->tarif}}">
                                        Rp. {{number_format($pad->tarif,0,",",".")}}
                                    </td>
                                    <td align="right" style="text-align:right;border-collapse:collapse;border-right:1px solid gray;border-left:1px solid gray;">
                                        Rp. {{number_format($pad->tarif,0,",",".")}}
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
				<tr style="background:#ecf0f1;border-collapse:collapse;border:1px solid gray;">
					<th colspan=4 style="border-collapse:collapse;border:1px solid gray;"><b>Total <input type="hidden" name="total" id="total" value="{{$total}}"></b></th>
					<th align="right" style="text-align:right;border-collapse:collapse;border:1px solid gray;" ><b id="total_view">Rp. {{number_format($total,0,",",".")}}</b></th>
				</tr>
			</tfoot>
		</table>
        <p style="text-center">Terimakasih atas kunjungan dan semoga sehat selalu</p>
	</body>
</html>
