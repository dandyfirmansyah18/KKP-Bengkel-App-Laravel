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
        <h3><center><b>BERITA ACARA PEKERJAAN</b></center></h3>
    <br>
    <br>
	<table>
	    <tr>
	        <td width="50">No. Polisi</td>
	        <td width="10">: </td>
	        <td width="80">{{ $bapdata['header']->no_polisi }}</td>
	        <td width="10">&nbsp;</td>
	        <td width="80">Merk Mobil</td>
	        <td width="10">: </td>
	        <td width="80">{{ $bapdata['header']->merk_mobil }}</td>	
	    </tr>
	    <tr>
	        <td width="50">No SPK</td>
	        <td width="50">: </td>
	        <td width="50">{{ $bapdata['header']->id_spk }}</td>
	        <td width="10">&nbsp;</td>
	        <td width="50">Tanggal</td>
	        <td width="50">: </td>
	        <td width="50">{{ $bapdata['header']->tgl_bap }}</td>	
	    </tr>
	    <tr>
	    	<td width="50">No BAP</td>
	        <td width="50">: </td>
	        <td width="50">{{ $bapdata['header']->id_bap }}</td>
	        <td width="10">&nbsp;</td>
	        <td width="50">&nbsp;</td>
	        <td width="50">&nbsp; </td>
	        <td width="50">&nbsp;</td>	
	    </tr>
	</table>
	<br>
	<br>
	<table class="table table-bordered">
        <tbody>
        	<tr>
	          <th style="text-align:center;background-color:#ECF542; width: 45;">No</th>
	          <th style="text-align:center;background-color:#ECF542; width: 225;">Nama Part/Service</th>
	          <th style="text-align:center;background-color:#ECF542; width: 125;">Qty</th>
	        </tr>
        	@foreach($bapdata['detail'] as $part)
	        <tr>
	          <td>{{ $part->no }}</td>
	          <td>{{ $part->nm_brg }}</td>
	          <td>{{ $part->qty }}</td>
	        </tr>
	        @endforeach
      	</tbody>
    </table>
    <br>
	<br>
	<table>
	    <thead>
	    <tr>
	        <td width="335">Mekanik</td>
	        <td width="300">Service Advisor</td>
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
	        <td>{{ $bapdata['header']->nm_karyawan }}</td>
	        <td>{{ $bapdata['ttd']->nm_karyawan }}</td>
	    </tr>
	    </thead>
	</table>

</body>
</html>