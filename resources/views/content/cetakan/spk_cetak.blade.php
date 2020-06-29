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
        <h3><center><b>SURAT PERINTAH KERJA</b></center></h3>
    <br>
    <br>
	<table>
	    <tr>
	        <td width="100">No. SPK</td>
	        <td width="10">:</td>
	        <td width="140">{{ $spkdata['header']->id_spk }}</td>
	        <td width="10">&nbsp;</td>
	        <td width="100">Merk Mobil</td>
	        <td width="10">: </td>
	        <td width="140">{{ $spkdata['header']->merk_mobil }}</td>	
	    </tr>
	    <tr>
	        <td>Nama</td>
	        <td>:</td>
	        <td>{{ $spkdata['header']->nm_plg }}</td>
	        <td>&nbsp;</td>
	        <td>Alamat</td>
	        <td>: </td>
	        <td>{{ $spkdata['header']->alamat }}</td>	
	    </tr>
	    <tr>
	    	<td>Telepon</td>
	        <td>: </td>
	        <td>{{ $spkdata['header']->no_telp }}</td>
	        <td>&nbsp;</td>
	        <td>No. Polisi</td>
	        <td>: </td>
	        <td>{{ $spkdata['header']->no_polisi }}</td>	
	    </tr>
	    <tr>
	    	<td>Tanggal Terima</td>
	        <td>: </td>
	        <td>{{ date("d-m-Y", strtotime($spkdata['header']->tgl_awal)) }}</td>
	        <td>&nbsp;</td>
	        <td>Tanggal Selesai</td>
	        <td>: </td>
	        <td>{{ date("d-m-Y", strtotime($spkdata['header']->tgl_akhir)) }}</td>	
	    </tr>
	</table>
	<br>
	<br>
	<table class="table table-bordered">
        <tbody>
        	<tr>
	          <th style="text-align:center;background-color:#ECF542; width: 45;">No</th>
	          <th style="text-align:center;background-color:#ECF542; width: 425;">Keluhan</th>
        	</tr>
        	@foreach($spkdata['detail'] as $keluhan)
	        <tr>
	          <td style="text-align: center;">{{ $keluhan->no }}</td>
	          <td>{{ $keluhan->keluhan }}</td>
	        </tr>
	        @endforeach
      	</tbody>
    </table>
    <br>
	<br>
	<table>
	    <thead>
	    <tr>
	        <td width="335">Pemberi Perintah</td>
	        <td width="300">Diterima Oleh</td>
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
	        <td>{{ $spkdata['header']->nm_plg }}</td>
	        <td>{{ $spkdata['header']->nm_karyawan }}</td>
	    </tr>
	    </thead>
	</table>

</body>
</html>