<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DataTables;
use DB, Response;
use App\Http\Requests;
use Barryvdh\DomPDF\Facade as PDF;
use Excel;

class GaransiController extends Controller
{
    public function listgaransi()
    {        
    	$data = DB::table('t_klaim_garansi')
                ->join('t_pembayaran', 't_pembayaran.id_byr', '=', 't_klaim_garansi.id_byr')
                ->join('t_bap', 't_bap.id_bap', '=', 't_pembayaran.id_bap')
                ->join('t_spk', 't_spk.id_spk', '=', 't_bap.id_spk')
                ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                ->select('t_klaim_garansi.id_klaim','t_klaim_garansi.tgl_klaim',DB::raw('DATE_FORMAT(t_klaim_garansi.tgl_klaim,"%d-%m-%Y") as tanggal_klaim'),'t_klaim_garansi.catatan','t_pembayaran.id_byr', 't_spk.id_spk', DB::raw('DATE_FORMAT(t_spk.tgl_awal,"%d-%m-%Y") as tanggal_service'), 'm_pelanggan.nm_plg','m_pelanggan.alamat','m_pelanggan.merk_mobil','m_pelanggan.no_polisi', DB::raw('DATE_FORMAT(t_pembayaran.create_date,"%d-%m-%Y") as tanggal_bayar'))
                ->get();

    	return view('content.transaksi.datagaransi')->with('data',$data);
    }

    public function addgaransi()
    {
        if(DB::table('t_klaim_garansi')->count() > 0){
            $show_last_id = DB::table('t_klaim_garansi')->select('id_klaim')->orderby('tgl_klaim','desc')->first();
            $last_id = $show_last_id->id_klaim;
            $last_id = substr($last_id,2);
            $last_id = ((int)$last_id) + 1;
            $data['noklaim'] = "KG" . sprintf("%04d", $last_id);      
        }else{
            $data['noklaim'] = "KG0001";
        }
		$data['act'] = "/savegaransi";
        $data['jika'] = 'add';
    	return view('content.transaksi.form-garansi',$data); //->with('data',$data);
    }

    public function savegaransi(Request $request)
    {
        if(DB::table('t_klaim_garansi')->where('id_klaim',Input::get('id_klaim'))->count() < 1){        
            $proses = DB::table('t_klaim_garansi')->insert(
                        [
                            'id_klaim' => Input::get('noklaim'), 
                            'id_byr' => Input::get('nokwi'),
                            'tgl_klaim' => date("Y-m-d", strtotime(Input::get('tgl_klaim'))),
                            'catatan' => Input::get('catatan'),
                        ]
                    );

            $ret = "MSG||YES||Data berhasil di proses||listgaransi";
        }else{
            $ret = "MSG||NO||Data tidak berhasil di proses||listgaransi";
        }            
        
        return $ret;
    }	

    public function showgaransi($idklaim)
    {
        $show = DB::table('t_klaim_garansi')
                    ->join('t_pembayaran', 't_klaim_garansi.id_byr', '=', 't_pembayaran.id_byr')
                    ->join('t_bap', 't_bap.id_bap', '=', 't_pembayaran.id_bap')
                    ->join('t_spk', 't_bap.id_spk', '=', 't_spk.id_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->join('m_karyawan', 't_bap.mekanik', '=', 'm_karyawan.id_karyawan')
                    ->select('t_klaim_garansi.id_klaim','t_klaim_garansi.catatan',DB::raw('DATE_FORMAT(t_klaim_garansi.tgl_klaim,"%d-%m-%Y") as tanggal_klaim'),'t_pembayaran.id_byr', 't_pembayaran.total_byr', 't_spk.id_spk',
                        DB::raw('DATE_FORMAT(t_pembayaran.create_date,"%d-%m-%Y") as tanggal_bayar'), 't_bap.id_bap',
                        'm_pelanggan.nm_plg','m_karyawan.nm_karyawan','m_pelanggan.no_polisi','m_pelanggan.merk_mobil',
                        DB::raw('DATE_FORMAT(t_spk.tgl_awal,"%d-%m-%Y") as tanggal_service'),
                        DB::raw('(SELECT SUM(t_bap_dtl.qty * m_barang.harga)
                        FROM t_bap_dtl
                        LEFT JOIN m_barang ON t_bap_dtl.barang = m_barang.id_brg
                        WHERE t_bap_dtl.id_bap = t_bap.id_bap) AS grand_total'))
                    ->where('t_klaim_garansi.id_klaim',$idklaim)
                    ->first();

        $data['act'] = '/showgaransi';
        $data['jika'] = 'detail';
        $data['datas'] = $show;

        return view('content.transaksi.form-garansi',$data);
    }

    public function editgaransi($idklaim)
    {
        $show = DB::table('t_klaim_garansi')
                    ->join('t_pembayaran', 't_klaim_garansi.id_byr', '=', 't_pembayaran.id_byr')
                    ->join('t_bap', 't_bap.id_bap', '=', 't_pembayaran.id_bap')
                    ->join('t_spk', 't_bap.id_spk', '=', 't_spk.id_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->join('m_karyawan', 't_bap.mekanik', '=', 'm_karyawan.id_karyawan')
                    ->select('t_klaim_garansi.id_klaim','t_klaim_garansi.catatan',DB::raw('DATE_FORMAT(t_klaim_garansi.tgl_klaim,"%d-%m-%Y") as tanggal_klaim'),'t_pembayaran.id_byr', 't_pembayaran.total_byr', 't_spk.id_spk',
                        DB::raw('DATE_FORMAT(t_pembayaran.create_date,"%d-%m-%Y") as tanggal_bayar'), 't_bap.id_bap',
                        'm_pelanggan.nm_plg','m_karyawan.nm_karyawan','m_pelanggan.no_polisi','m_pelanggan.merk_mobil',
                        DB::raw('DATE_FORMAT(t_spk.tgl_awal,"%d-%m-%Y") as tanggal_service'),
                        DB::raw('(SELECT SUM(t_bap_dtl.qty * m_barang.harga)
                        FROM t_bap_dtl
                        LEFT JOIN m_barang ON t_bap_dtl.barang = m_barang.id_brg
                        WHERE t_bap_dtl.id_bap = t_bap.id_bap) AS grand_total'))
                    ->where('t_klaim_garansi.id_klaim',$idklaim)
                    ->first();

        $data['act'] = '/updategaransi';
        $data['jika'] = 'edit';
        $data['datas'] = $show;

        return view('content.transaksi.form-garansi',$data);
    }

    public function updategaransi()
    {
        $proses = DB::table('t_klaim_garansi')->where('id_klaim',Input::get('noklaim'))->update(
                [                    
                    'id_byr' => Input::get('nokwi'),
                    'tgl_klaim' => date("Y-m-d", strtotime(Input::get('tgl_klaim'))),
                    'catatan' => Input::get('catatan'),
                ]
            );

        $ret = "MSG||YES||Data berhasil di proses||listgaransi";
        return $ret;

    }

    public function pilihkwitansi()
    {
        $date = strtotime("-15 day");
        $date15 = date('Y-m-d', $date);
        DB::statement(DB::raw('SET @boom=0'));
        $data = DB::table('t_pembayaran')
                    ->join('t_bap', 't_bap.id_bap', '=', 't_pembayaran.id_bap')
                    ->join('t_spk', 't_bap.id_spk', '=', 't_spk.id_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->select(DB::raw('@boom:=@boom+1 AS no'),'t_pembayaran.id_byr','t_pembayaran.total_byr',DB::raw('DATE_FORMAT(t_pembayaran.create_date,"%d %M %Y") as tgl_kwitansi'),'t_bap.id_bap','m_pelanggan.nm_plg as nama','t_bap.mekanik','m_pelanggan.no_polisi', DB::raw("CONCAT('<a onclick=pilih(','&quot;',t_pembayaran.id_byr,'&quot;',')><span class=btn btn-block btn-success btn-xs>Pilih</span></a>') as action"))
                    ->whereRaw('t_pembayaran.create_date > "'.$date15.'"')               
                    ->get();
        return $data;
    }

    public function lookup_kwitansi()
    {
        $id_byr = Input::get('id_byr');        
        $data['header'] = DB::table('t_pembayaran')
                            ->join('t_bap', 't_bap.id_bap', '=', 't_pembayaran.id_bap')
                            ->join('t_spk', 't_bap.id_spk', '=', 't_spk.id_spk')
                            ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                            ->join('m_karyawan', 't_bap.mekanik', '=', 'm_karyawan.id_karyawan')
                            ->select('t_pembayaran.id_byr', DB::raw('DATE_FORMAT(t_pembayaran.create_date,"%d-%M-%Y") as tgl_kwitansi'), 't_bap.id_bap','m_pelanggan.nm_plg as nama','m_karyawan.nm_karyawan','m_pelanggan.no_polisi','m_pelanggan.merk_mobil','t_spk.id_spk',
                                DB::raw('DATE_FORMAT(t_spk.tgl_awal,"%d-%M-%Y") as tgl_service'))
                            ->where('t_pembayaran.id_byr',$id_byr)
                            ->first();

        return Response::json($data);
    }

    public function delete($id)
    {
    	return DB::table('m_karyawan')->where('id_karyawan',$id)->delete();
    }

    public function laporangaransi()
    {
        $data['act'] = "/downgaransi";
        return view('content.report.form-lapGaransi',$data); //->with('data',$data);
    }

    public function downloadLapGaransi(Request $request)
    {
         $tanggal = date('Y-m-d H:i:s');
         $now = date("Y-m-d", strtotime(Input::get('tgl_awal')));
         $end = date("Y-m-d", strtotime(Input::get('tgl_akhir')));

         $data['tgl1'] = Input::get('tgl_awal');
         $data['tgl2'] = Input::get('tgl_akhir');

         DB::statement(DB::raw('SET @boom=0'));
         $data['isi'] = DB::table('t_klaim_garansi')
                    ->join('t_pembayaran', 't_pembayaran.id_byr', '=', 't_klaim_garansi.id_byr')
                    ->join('t_bap', 't_bap.id_bap', '=', 't_pembayaran.id_bap')
                    ->join('t_spk', 't_spk.id_spk', '=', 't_bap.id_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->join('m_karyawan', 't_bap.mekanik', '=', 'm_karyawan.id_karyawan')
                    ->select(DB::raw('@boom:=@boom+1 AS no'),'t_klaim_garansi.id_klaim',DB::raw('DATE_FORMAT(t_klaim_garansi.tgl_klaim,"%d-%m-%Y") as tanggal_klaim'),'t_klaim_garansi.catatan','t_pembayaran.id_byr', 'm_pelanggan.merk_mobil', 'm_pelanggan.no_polisi', 't_spk.kilometer', 't_pembayaran.total_byr','t_spk.id_spk','m_pelanggan.nm_plg',DB::raw('DATE_FORMAT(t_pembayaran.create_date,"%d-%m-%Y") as tanggal_bayar'))
                    ->whereBetween('t_klaim_garansi.tgl_klaim',[$now, $end])
                    ->get();

         $type = '';

         Excel::create('Export Data Laporan Garansi- '.$now, function($excel) use($data, $tanggal, $type) {
            $excel->sheet('Sheet 1', function($sheet) use($data, $tanggal, $type) {
              $sheet->loadView('content.report.laporangaransi')
                ->with("data",$data)
                ->with("tanggal",$tanggal)
                ->with("type",$type);
            });
        })->export('xlsx');

    }

    public function garansi_form_cetak($noklaim)
    {
        $garansidata['header'] = DB::table('t_klaim_garansi')
                    ->join('t_pembayaran', 't_pembayaran.id_byr', '=', 't_klaim_garansi.id_byr')
                    ->join('t_bap', 't_bap.id_bap', '=', 't_pembayaran.id_bap')
                    ->join('t_spk', 't_spk.id_spk', '=', 't_bap.id_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->join('m_karyawan', 't_bap.mekanik', '=', 'm_karyawan.id_karyawan')
                    ->select(DB::raw('@boom:=@boom+1 AS no'),'t_klaim_garansi.id_klaim',DB::raw('DATE_FORMAT(t_klaim_garansi.tgl_klaim,"%d-%m-%Y") as tanggal_klaim'),'t_klaim_garansi.catatan','t_pembayaran.id_byr', 'm_pelanggan.merk_mobil', 'm_pelanggan.no_polisi', 't_spk.kilometer', 't_pembayaran.total_byr','t_spk.id_spk','m_pelanggan.nm_plg',DB::raw('DATE_FORMAT(t_pembayaran.create_date,"%d-%m-%Y") as tanggal_bayar'),'m_karyawan.nm_karyawan as nama_mekanik',DB::raw('DATE_FORMAT(t_spk.tgl_awal,"%d-%m-%Y") as tanggal_service'))
                    ->where('t_klaim_garansi.id_klaim',$noklaim)
                    ->first();

        $getsa = DB::table('m_karyawan')->select('nm_karyawan')->where('jabatan','SA')->first();
        $garansidata['service_advisor'] = $getsa->nm_karyawan;

        $pdf = PDF::loadView('content.cetakan.klaim_garansi_cetak', compact('garansidata'));

        return $pdf->stream();

    }

    public function delgaransi($id_klaim)
    {
        $delete =  DB::table('t_klaim_garansi')->where('id_klaim',$id_klaim)->delete();
        if ($delete) {
            $ret = "MSG||YES||Data berhasil di proses||listgaransi";
        }else{
            $ret = "MSG||ERR||Data Gagal di proses||listgaransi";
        }

        return $ret;
    }
}
