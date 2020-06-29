<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    
</head>
<body> 
<table >
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
        <td colspan="8" align="center">LAPORAN REKAP KLAIM GARANSI</td>
    </tr>
    <tr>
        <td colspan="8" align="center">DARI TANGGAL {{ $data['tgl1'] }} s/d TANGGAL {{ $data['tgl2'] }}</td>
    </tr>
    </thead>
</table>
<table style="border: 1px solid black;">    
    <tr>        
        <th width="6"  align="center"  style="text-align:center;background-color:#ECF542; border: 3px solid #000000;">No</th>
        <th width="20" align="center"  style="text-align:center;background-color:#ECF542; border: 3px solid #000000;">No Klaim</th>
        <th width="15" align="center"  style="text-align:center;text-align:center;background-color:#ECF542; border: 3px solid #000000;">No Kwitansi</th>
        <th width="15" align="center"  style="text-align:center;text-align:center;background-color:#ECF542; border: 3px solid #000000;">No SPK</th>
        <th width="40" align="center"  style="text-align:center;background-color:#ECF542; border: 3px solid #000000;">Nama Pelanggan</th>        
        <th width="35" align="center"  style="text-align:center;background-color:#ECF542; border: 3px solid #000000;">Merk Mobil</th>
        <th width="30" align="center"  style="text-align:center;background-color:#ECF542; border: 3px solid #000000;">No Polisi</th>
        <th width="30" align="center"  style="text-align:center;background-color:#ECF542; border: 3px solid #000000;">Tanggal Klaim</th>
    </tr>
    @foreach($data['isi'] as $datas)
    <tr>
        <td style="border: 3px solid #000000;">{{ $datas->no }}</td>
        <td style="border: 3px solid #000000;">{{ $datas->id_klaim}}</td>
        <td style="border: 3px solid #000000;">{{ $datas->id_byr}}</td>
        <td style="border: 3px solid #000000;">{{ $datas->id_spk }}</td>
        <td style="border: 3px solid #000000;">{{ $datas->nm_plg }}</td>
        <td style="border: 3px solid #000000;">{{ $datas->merk_mobil }}</td>
        <td style="border: 3px solid #000000;">{{ $datas->no_polisi }}</td>
        <td style="border: 3px solid #000000;">{{ $datas->tanggal_klaim }}</td>        
    </tr>
    @endforeach
</table> 
</body> 
</html>