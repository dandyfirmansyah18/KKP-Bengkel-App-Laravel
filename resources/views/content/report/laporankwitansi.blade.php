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
        <td colspan="6" align="center">LAPORAN REKAP KWITANSI</td>
    </tr>
    <tr>
        <td colspan="6" align="center">DARI TANGGAL {{ $data['tgl1'] }} s/d TANGGAL {{ $data['tgl2'] }}</td>
    </tr>
    </thead>
</table>
<table style="border: 1px solid black;">
    
    <tr>        
        <th width="6"  align="center"  style="text-align:center;background-color:#ECF542; border: 3px solid #000000;">No</th>
        <th width="20" align="center"  style="text-align:center;background-color:#ECF542; border: 3px solid #000000;">Kode Kwitansi</th>
        <th width="15" align="center"  style="text-align:center;text-align:center;background-color:#ECF542; border: 3px solid #000000;">No Polisi</th>
        <th width="15" align="center"  style="text-align:center;background-color:#ECF542; border: 3px solid #000000;">Merk Mobil</th>
        <th width="55" align="center"  style="text-align:center;background-color:#ECF542; border: 3px solid #000000;">KM/Odometer</th>
        <th width="35" align="center"  style="text-align:center;background-color:#ECF542; border: 3px solid #000000;">Total</th>
    </tr>
@foreach($data['isi'] as $datas)
    <tr>
        <td style="border: 3px solid #000000;">{{ $datas->no }}</td>
        <td style="border: 3px solid #000000;">{{ $datas->id_byr}}</td>
        <td style="border: 3px solid #000000;">{{ $datas->no_polisi}}</td>
        <td style="border: 3px solid #000000;">{{ $datas->merk_mobil }}</td>
        <td style="border: 3px solid #000000;text-align: right;">{{ number_format($datas->kilometer) }} KM</td>
        <td style="border: 3px solid #000000;text-align: right;">Rp. {{ number_format($datas->total_byr) }}</td>
    </tr>
@endforeach
    <tr>
        <td colspan="5" style="border: 3px solid #000000;text-align: right;"><b>Grand Total</b></td>
        <td style="border: 3px solid #000000;text-align: right;">Rp. {{ number_format($data['grand_total']) }}</td>
    </tr>
</table> 
</body> 
</html>