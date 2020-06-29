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
        <h3><center><b>KLAIM GARANSI</b></center></h3>
    <br>
    <br>
	<table>
	    <tr>
	        <td width="90">No. Klaim</td>
	        <td width="10">: </td>
	        <td width="140">{{ $garansidata['header']->id_klaim }}</td>
	        <td width="10">&nbsp;</td>
	        <td width="90">No. SPK</td>
	        <td width="10">: </td>
	        <td width="140">{{ $garansidata['header']->id_spk }}</td>	
	    </tr>
	    <tr>
	        <td>No. Kwitansi</td>
	        <td>: </td>
	        <td>{{ $garansidata['header']->id_byr }}</td>
	        <td width="10">&nbsp;</td>
	        <td>Merk Mobil;</td>
	        <td>:</td>
	        <td>{{ $garansidata['header']->merk_mobil }}</td>	
	    </tr>
	    <tr>
	    	<td>Nama Pelanggan</td>
	        <td>: </td>
	        <td>{{ $garansidata['header']->nm_plg }}</td>
	        <td>&nbsp;</td>
	        <td>No Polisi</td>
	        <td>: </td>
	        <td>{{ $garansidata['header']->no_polisi }}</td>	
	    </tr>
	    <tr>
	    	<td>Tanggal Klaim</td>
	        <td>: </td>
	        <td>{{ $garansidata['header']->tanggal_klaim }}</td>
	        <td>&nbsp;</td>
	        <td>Tanggal Service</td>
	        <td>: </td>
	        <td>{{ $garansidata['header']->tanggal_service }}</td>	
	    </tr>
	</table>
	<br>
	<br>
	<table class="table table-bordered">
        <tbody>
        	<tr>
	          <th style="text-align:center;background-color:#ECF542; width: 25;">No</th>
	          <th style="text-align:center;background-color:#ECF542; width: 200;">Catatan</th>
        	</tr>        	
	        <tr>
	          <td style="text-align: center">1</td>
	          <td>{{ $garansidata['header']->catatan }}</td>
	        </tr>
      	</tbody>
    </table>   
	<hr>    	   
    <br>
	<br>
	<table>
	    <thead>
	    <tr>
	        <td>Kepala Bengkel</td>
	        <td></td>
	        <td>Customer</td>
	    </tr>
	    <tr>
	        <td>&nbsp;</td>
	        <td width="300">&nbsp;</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td>&nbsp;</td>
	        <td width="300">&nbsp;</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td>&nbsp;</td>
	        <td width="300">&nbsp;</td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td>&nbsp;</td>
	        <td width="300">&nbsp;</td>
	        <td>&nbsp;</td>
	    </tr>	    
	    <tr>
	    	<td>{{ $garansidata['service_advisor'] }}</td>	        
	        <td>&nbsp;</td>
	        <td>{{ $garansidata['header']->nm_plg }}</td>
	    </tr>
	    </thead>
	</table>

</body>
</html>