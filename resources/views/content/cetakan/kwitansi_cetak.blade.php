<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table>
	    <thead>
	    <tr>
	        <td style="color:blue;"><h1><b><u>BENGKEL 99</u></b><h1></td>
	    </tr>
	    <tr>
	        <td><b>JL. OTISTA RAYA NO.139, JAKARTA TIMUR</b></td>
	    </tr>
	    <tr>
	        <td><b>Tlp.(021)08199582, 8194084 Fax.(021) 8506009</b></td>
	    </tr>
	    <tr>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td>&nbsp;</td>
	    </tr>
	    </thead>
	</table>
	<br>
        <h3><center><b>KWITANSI PENJUALAN</b></center></h3>
    <br>
    <br>
	<table>
	    <tr>
	        <td width="90">No. Kwitansi</td>
	        <td width="10">: </td>
	        <td width="140">{{ $kwidata['header']->id_byr }}</td>
	        <td width="10">&nbsp;</td>
	        <td width="90">Alamat</td>
	        <td width="10">: </td>
	        <td width="140">{{ $kwidata['header']->alamat }}</td>	
	    </tr>
	    <tr>
	        <td>No. WO</td>
	        <td>: </td>
	        <td>{{ $kwidata['header']->id_spk }} / {{ $kwidata['header']->kilometer }} KM</td>
	        <td width="10">&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>	
	    </tr>
	    <tr>
	    	<td>Nama</td>
	        <td>: </td>
	        <td>{{ $kwidata['header']->nm_plg }}</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>	
	    </tr>
	    <tr>
	    	<td>Kendaraan</td>
	        <td>: </td>
	        <td>{{ $kwidata['header']->no_polisi }} / {{ $kwidata['header']->merk_mobil }}</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>	
	    </tr>
	</table>
	<br>
	<br>
	<table class="table table-bordered">
        <tbody>
        	<tr>
	          <th style="text-align:center;background-color:#ECF542; width: 25;">No</th>
	          <th style="text-align:center;background-color:#ECF542; width: 100;">Kode</th>
	          <th style="text-align:center;background-color:#ECF542; width: 135;">Nama Part/Service</th>
	          <th style="text-align:center;background-color:#ECF542; width: 35;">Qty</th>
	          <th style="text-align:center;background-color:#ECF542; width: 115;">Harga Disc</th>
	          <th style="text-align:center;background-color:#ECF542; width: 115;">SubTotal</th>
        	</tr>
        	@foreach($kwidata['detail'] as $keluhan)
	        <tr>
	          <td>{{ $keluhan->no }}</td>
	          <td>{{ $keluhan->kategori }}</td>
	          <td>{{ $keluhan->nm_brg }}</td>
	          <td style="text-align: right;">{{ $keluhan->qty }}</td>
	          <td style="text-align: right;">{{ number_format($keluhan->harga) }}</td>
	          <td style="text-align: right;">{{ number_format($keluhan->total) }}</td>
	        </tr>
	        @endforeach

      	</tbody>
    </table>
    <hr>
    <table>
	    <thead>
	    <tr>
	    	<td width="350">&nbsp;</td>
	        <td width="50">Jumlah</td>
	        <td width="20">Rp</td>
	        <td width="110" style="text-align: right;">{{ number_format($kwidata['header']->total_byr) }}</td>
	    </tr>
	    <tr>
	    	<td width="350">&nbsp;</td>
	        <td>PPn 10%</td>
	        <td width="10">Rp</td>
	        <td style="text-align: right;">{{ number_format(0.1 * $kwidata['header']->total_byr) }}</td>
	    </tr>
	    <tr>
	    	<td width="350">&nbsp;</td>
	        <td>Total</td>
	        <td width="10">Rp</td>
	        <td style="text-align: right;">{{ number_format($kwidata['header']->total_byr + (0.1 * $kwidata['header']->total_byr)) }}</td>
	    </tr>
	    </thead>
	</table>
	<hr>    	   
    <br>
	<br>
	<table>
	    <thead>
	    <tr>
	        <td>Mekanik</td>
	        <td>:</td>
	        <td width="250">APIN</td>
	        <td width="100">Kepala Bengkel</td>
	        <td width="100">Customer</td>
	    </tr>
	    <tr>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	    	<td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>Irwan. H</td>
	        <td>{{ $kwidata['header']->nm_plg }}</td>
	    </tr>
	    </thead>
	</table>

</body>
</html>