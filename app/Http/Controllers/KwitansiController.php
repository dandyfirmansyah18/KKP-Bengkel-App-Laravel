<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DataTables;
use DB;
use App\Http\Requests;
use Barryvdh\DomPDF\Facade as PDF;
use Excel;

class KwitansiController extends Controller
{
    public function listkwitansi()
    {
    	$data = DB::table('t_pembayaran')
                ->join('t_bap', 't_pembayaran.id_bap', '=', 't_bap.id_bap')
                ->join('t_spk', 't_spk.id_spk', '=', 't_bap.id_spk')
                ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                ->select('t_pembayaran.id_byr', 'm_pelanggan.nm_plg','m_pelanggan.alamat','m_pelanggan.merk_mobil','m_pelanggan.no_polisi',
                    't_pembayaran.id_bap','t_pembayaran.total_byr',DB::raw('DATE_FORMAT(t_pembayaran.create_date,"%d-%m-%Y") as tanggal_bayar'))
                ->get();

    	return view('content.transaksi.datakwitansi')->with('data',$data);
    }

    public function addkwitansi()
    {
        if(DB::table('t_pembayaran')->count() > 0){
            $show_last_id = DB::table('t_pembayaran')->select('id_byr')->orderby('id_byr','desc')->first();
            $last_id = $show_last_id->id_byr;            
            $last_id = substr($last_id,2);
            $last_id = ((int)$last_id) + 1;
            $data['nokwi'] = "KW" . sprintf("%04d", $last_id);      
        }else{
            $data['nokwi'] = "KW0001";
        }

		$data['act'] = "/savekwitansi";
        $data['jika'] = 'add';
    	return view('content.transaksi.form-kwitansi',$data); //->with('data',$data);
    }

    public function savekwitansi(Request $request)
    {
        if(DB::table('t_pembayaran')->where('id_byr',Input::get('nik'))->count() < 1){
            
             $proses = DB::table('t_pembayaran')->insert(
                        [
                            'id_byr' => Input::get('nokwi'), 
                            'id_bap' => Input::get('nobap'),
                            'total_byr' => Input::get('total'),
                            'create_date' => date("Y-m-d", strtotime(Input::get('tgl_byr'))),
                        ]
                    );
                $ret = "MSG||YES||Data berhasil di proses||listkwitansi";   
            }else{
                $ret = "MSG||NO||Data tidak berhasil di proses||listkwitansi";            
            }

            $proses = DB::table('t_bap')->where('id_bap', Input::get('nobap'))
                            ->update(
                            [
                                'status' => '1'
                            ]
                        );
        
        return $ret;
    }

    // public function kwi_form_cetak($nokwi)
    // {
    //     $kwidata['header'] = DB::table('t_pembayaran')
    //                 ->join('t_bap', 't_bap.id_bap', '=', 't_pembayaran.id_bap')
    //                 ->join('t_spk', 't_spk.id_spk', '=', 't_bap.id_spk')
    //                 ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
    //                 ->join('m_karyawan', 't_bap.mekanik', '=', 'm_karyawan.id_karyawan')
    //                 ->select('t_pembayaran.id_byr',DB::raw('DATE_FORMAT(t_pembayaran.create_date,"%d-%m-%Y") as tgl_bayar'), 't_bap.id_bap', 'm_pelanggan.merk_mobil', 'm_pelanggan.no_polisi', 't_spk.kilometer', 'm_karyawan.nm_karyawan','t_spk.id_spk', 't_bap.tgl_bap')
    //                 ->where('t_pembayaran.id_byr',$nokwi)->first();

    //     $nobap = $kwidata['header']->id_bap;
        
    //     $kwidata['ttd'] = DB::table('t_pembayaran')
    //                     ->join('t_bap', 't_bap.id_bap', '=', 't_pembayaran.id_bap')
    //                     ->join('t_spk', 't_spk.id_spk', '=', 't_bap.id_spk')
    //                     ->join('m_karyawan', 't_spk.create_by', '=', 'm_karyawan.id_karyawan')
    //                     ->select('m_karyawan.nm_karyawan')
    //                     ->where('t_pembayaran.id_byr',$nokwi)->first();

    //     DB::statement(DB::raw('SET @boom=0'));            
    //     $kwidata['detail'] = DB::table('t_bap_dtl')
    //                 ->join('m_barang', 't_bap_dtl.barang', '=', 'm_barang.id_brg')        
    //                 ->select(DB::raw('@boom:=@boom+1 AS no'),'m_barang.nm_brg', 't_bap_dtl.qty')
    //                 ->where('id_bap',$nobap)->get();

    //     $pdf = PDF::loadView('content.cetakan.kwitansi_cetak', compact('kwidata'));
    //     return $pdf->stream();
    // }

	public function showkaryawan($id)
    {
    	$data['datas'] = DB::table('m_karyawan')->where('nik',$id)->select('nama_karyawan', 'alamat_karyawan', 'nomer_telp', 'nik')->first();
		$data['act'] = "";
    	$data['option'] = ['Admin', 'SA', 'Mekanik', 'Kasir'];

    	return view('content.master.form-karyawan', $data);
    }

    public function showkwi($idbyr)
    {
        $show = DB::table('t_pembayaran')
                    ->join('t_bap', 't_bap.id_bap', '=', 't_pembayaran.id_bap')
                    ->join('t_spk', 't_bap.id_spk', '=', 't_spk.id_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->join('m_karyawan', 't_bap.mekanik', '=', 'm_karyawan.id_karyawan')
                    ->select('t_pembayaran.id_byr', 't_pembayaran.total_byr', DB::raw('DATE_FORMAT(t_pembayaran.create_date,"%d-%m-%Y") as tanggal_bayar'), 't_bap.id_bap',
                        'm_pelanggan.nm_plg','m_karyawan.nm_karyawan','m_pelanggan.no_polisi',
                        DB::raw('(SELECT SUM(t_bap_dtl.qty * m_barang.harga)
                        FROM t_bap_dtl
                        LEFT JOIN m_barang ON t_bap_dtl.barang = m_barang.id_brg
                        WHERE t_bap_dtl.id_bap = t_bap.id_bap) AS grand_total'))
                    ->where('t_pembayaran.id_byr',$idbyr)
                    ->first();

        $data['act'] = '/showkwi';
        $data['jika'] = 'detail';
        $data['datas'] = $show;

        return view('content.transaksi.form-kwitansi',$data);
    }

    public function getkaryawan($id)
    {
    	$data['datas'] = DB::table('m_karyawan')->where('id_karyawan',$id)->select('nm_karyawan', 'alamat', 'no_telp', 'id_karyawan', 'jabatan')->first();
    	$data['act'] = "/editkaryawan";
    	$data['option'] = ['Admin', 'SA', 'Mekanik', 'Kasir'];
    	return view('content.master.form-karyawan', $data);
    }

    public function editkaryawan(Request $request)
    {
    	$proses = DB::table('m_karyawan')->where('id_karyawan', Input::get('nik'))
    					->update(
                        [
                            'nm_karyawan' => Input::get('nama'),
                            'alamat' => Input::get('alamat'), 
                            'jabatan' => Input::get('jabatan'),
                            'no_telp' => Input::get('notelp')
                        ]
                    );

    $ret = "MSG||YES||Data berhasil di proses||listkaryawan";
	return $ret;
    }

    public function delete($id)
    {
    	return DB::table('m_karyawan')->where('id_karyawan',$id)->delete();
    }

    public function laporankwitansi()
    {
        $data['act'] = "/downkwitansi";
        return view('content.report.form-lapKwitansi',$data); //->with('data',$data);
    }

    public function downloadLapkwitansi(Request $request)
    {
         $tanggal = date('Y-m-d H:i:s');
         $now = date("Y-m-d", strtotime(Input::get('tgl_awal')));
         $end = date("Y-m-d", strtotime(Input::get('tgl_akhir')));

         $data['tgl1'] = Input::get('tgl_awal');
         $data['tgl2'] = Input::get('tgl_akhir');

         DB::statement(DB::raw('SET @boom=0'));
         $data['isi'] = DB::table('t_pembayaran')
                    ->join('t_bap', 't_bap.id_bap', '=', 't_pembayaran.id_bap')
                    ->join('t_spk', 't_spk.id_spk', '=', 't_bap.id_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->join('m_karyawan', 't_bap.mekanik', '=', 'm_karyawan.id_karyawan')
                    ->select(DB::raw('@boom:=@boom+1 AS no'),'t_pembayaran.id_byr', 'm_pelanggan.merk_mobil', 'm_pelanggan.no_polisi', 't_spk.kilometer', 't_pembayaran.total_byr')
                    ->whereBetween('t_pembayaran.create_date',[$now, $end])
                    ->get();

        $grand_total = 0;
        foreach ($data['isi'] as $datas) {
            $grand_total = $grand_total + ($datas->total_byr);
        }

        $data['grand_total'] = $grand_total;

         $type = '';

         Excel::create('Export Data Laporan Kwitansi- '.$now, function($excel) use($data, $tanggal, $type) {
            $excel->sheet('Sheet 1', function($sheet) use($data, $tanggal, $type) {
              $sheet->loadView('content.report.laporankwitansi')
                ->with("data",$data)
                ->with("tanggal",$tanggal)
                ->with("type",$type);
            });
        })->export('xlsx');

    }

    public function kwi_form_cetak($nokwi)
    {
        $kwidata['header'] = DB::table('t_pembayaran')
                        ->join('t_bap', 't_bap.id_bap', '=', 't_pembayaran.id_bap')
                        ->join('t_spk', 't_spk.id_spk', '=', 't_bap.id_spk')
                        ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                        ->join('m_karyawan', 't_bap.mekanik', '=', 'm_karyawan.id_karyawan')
                        ->select('t_pembayaran.id_byr', 'm_pelanggan.merk_mobil', 'm_pelanggan.no_polisi', 't_spk.kilometer', 't_pembayaran.total_byr','m_pelanggan.alamat', 't_spk.id_spk', 'm_pelanggan.nm_plg','t_pembayaran.total_byr')
                        ->where('t_pembayaran.id_byr',$nokwi)->first();

        DB::statement(DB::raw('SET @boom=0'));                    
        $kwidata['detail'] = DB::table('t_bap_dtl')
                            ->join('t_pembayaran', 't_bap_dtl.id_bap', '=', 't_pembayaran.id_bap')
                            ->join('m_barang', 't_bap_dtl.barang', '=', 'm_barang.id_brg')
                            ->select(DB::raw('@boom:=@boom+1 AS no'),'m_barang.nm_brg','t_bap_dtl.qty','m_barang.harga', 'm_barang.kategori',
                                DB::raw('t_bap_dtl.qty*m_barang.harga as total'))
                            ->where('t_pembayaran.id_byr',$nokwi)
                            ->get();  

        $pdf = PDF::loadView('content.cetakan.kwitansi_cetak', compact('kwidata'));
        return $pdf->stream();

    }

    public function editkwi($idbyr)
    {
        $show = DB::table('t_pembayaran')
                    ->join('t_bap', 't_bap.id_bap', '=', 't_pembayaran.id_bap')
                    ->join('t_spk', 't_bap.id_spk', '=', 't_spk.id_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->join('m_karyawan', 't_bap.mekanik', '=', 'm_karyawan.id_karyawan')
                    ->select('t_pembayaran.id_byr', 't_pembayaran.total_byr', DB::raw('DATE_FORMAT(t_pembayaran.create_date,"%d-%m-%Y") as tanggal_bayar'), 't_bap.id_bap',
                        'm_pelanggan.nm_plg','m_karyawan.nm_karyawan','m_pelanggan.no_polisi',
                        DB::raw('(SELECT SUM(t_bap_dtl.qty * m_barang.harga)
                        FROM t_bap_dtl
                        LEFT JOIN m_barang ON t_bap_dtl.barang = m_barang.id_brg
                        WHERE t_bap_dtl.id_bap = t_bap.id_bap) AS grand_total'))
                    ->where('t_pembayaran.id_byr',$idbyr)
                    ->first();      

        $data['act'] = '/updatekwi';
        $data['jika'] = 'edit';
        $data['datas'] = $show;

        return view('content.transaksi.form-kwitansi',$data);
    }

    public function updatekwi()
    {
        $cekbap = DB::table('t_pembayaran')->where('id_byr',Input::get('nokwi'))->value('id_bap');
        if ($cekbap == Input::get('nobap')) {
        }else{
            $proses = DB::table('t_bap')->where('id_bap', $cekbap)
                            ->update(
                            [
                                'status' => '0'
                            ]
                        );

            $proses = DB::table('t_bap')->where('id_bap', Input::get('nobap'))
                            ->update(
                            [
                                'status' => '1'
                            ]
                        );
        }

        $proses = DB::table('t_pembayaran')->where('id_byr',Input::get('nokwi'))->update(
                [                    
                    'id_bap' => Input::get('nobap'),
                    'create_date' => date("Y-m-d", strtotime(Input::get('tgl_byr')))                    
                ]
            );

        $ret = "MSG||YES||Data berhasil di proses||listkwitansi";
        return $ret;

    }

    public function delkwi($id_byr)
    {
        $getidbap = DB::table('t_pembayaran')->where('id_byr',$id_byr)->value('id_bap');
        $updatebap = DB::table('t_bap')->where('id_bap',$getidbap)->update(
                        [                    
                            'status' => '0',
                        ]
                    );


        $delete =  DB::table('t_pembayaran')->where('id_byr',$id_byr)->delete();
        if ($delete) {
            $ret = "MSG||YES||Data berhasil di proses||listkwitansi";
        }else{
            $ret = "MSG||ERR||Data Gagal di proses||listkwitansi";
        }

        return $ret;
    }
}
