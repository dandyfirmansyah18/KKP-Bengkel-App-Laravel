<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Http\Requests;
use Response, Session;
use Barryvdh\DomPDF\Facade as PDF;
use Excel;

class SpkController extends Controller
{
    public function listspk()
    {
    	$data = DB::table('t_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->select('t_spk.id_spk', 'm_pelanggan.nm_plg', 'm_pelanggan.alamat', 'm_pelanggan.merk_mobil', 'm_pelanggan.no_polisi', 't_spk.status')->get();

    	return view('content.transaksi.dataspk')->with('data',$data);
    }

    public function addspk()
    {
        if(DB::table('t_spk')->count() > 0){
            $show_last_id = DB::table('t_spk')->select('id_spk')->orderby('create_date','desc')->first();
            $last_id = $show_last_id->id_spk;
            $last_id = substr($last_id,3);
            $last_id = ((int)$last_id) + 1;            
            // $data['nospk'] = "SPK" . date("d") . sprintf("%04d", DB::table('t_spk')->count()+1);      
            $data['nospk'] = "SPK" . sprintf("%04d", $last_id);      
        }else{
            $data['nospk'] = "SPK0001";
        }
		$data['act'] = "/savespk";
        $data['jika'] = 'add';
    	return view('content.transaksi.form-spk',$data); //->with('data',$data);
    }

    public function editspk($id_spk){
        $show = DB::table('t_spk AS a')
                    ->select('a.id_spk','a.id_plg',DB::raw('DATE_FORMAT(a.tgl_awal,"%d-%m-%Y") as tgl_awal'),
                        DB::raw('DATE_FORMAT(a.tgl_akhir,"%d-%m-%Y") as tgl_akhir'),'a.kilometer','a.cuci','a.status','b.nm_plg','b.alamat','b.no_telp','b.no_polisi',
                        'b.merk_mobil','b.no_chasis'
                    )
                    ->leftjoin('m_pelanggan AS b','a.id_plg','=','b.id_plg')
                    ->where('a.id_spk',$id_spk)
                    ->first();

        $data['act'] = '/updatespk';
        $data['jika'] = 'edit';
        $data['datas'] = $show;

        $show_keluhan = DB::table('t_spk_detail')
                            ->select('*')                            
                            ->where('id_spk',$id_spk)
                            ->get();
        $data['keluhan'] = $show_keluhan;

        return view('content.transaksi.form-spk',$data);

    }

    public function savespk(Request $request)
    {
        if(DB::table('t_spk')->where('id_spk',Input::get('nospk'))->count() < 1){
            
             $proses = DB::table('t_spk')->insert(
                        [
                            'id_spk' => Input::get('nospk'), 
                            'id_plg' => Input::get('id_pel'),
                            'tgl_awal' => date("Y-m-d", strtotime(Input::get('tgl_awal'))), 
                            'tgl_akhir' => date("Y-m-d", strtotime(Input::get('tgl_akhir'))),
                            'kilometer' => Input::get('km'),
                            'cuci' => '1',
                            'create_date' => date('Y-m-d H:i:s'),
                            'create_by' => Session::get('nik_karyawan'),
                            'status' => '0'
                        ]
                    );
                foreach (Input::get('keluhan') as $a => $b) {
                    DB::table('t_spk_detail')->insert(
                        [
                            'id_spk' => Input::get('nospk'), 
                            'create_date' => date('Y-m-d H:i:s'),
                            'keluhan' => $b
                        ]
                    );
                }  
                $ret = "MSG||YES||Data berhasil di proses||listspk";   
            }else{
                $ret = "MSG||NO||Data tidak berhasil di proses||listspk";            
            }

        
        return $ret;
    }

	public function showkaryawan($id)
    {
    	$data['datas'] = DB::table('m_karyawan')->where('nik',$id)->select('nama_karyawan', 'alamat_karyawan', 'nomer_telp', 'nik')->first();
		$data['act'] = "";
    	$data['option'] = ['Admin', 'SA', 'Mekanik', 'Kasir'];

    	return view('content.master.form-karyawan', $data);
    }

    public function getspk($id)
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

    

    public function pilihspk()
    {
        DB::statement(DB::raw('SET @boom=0'));
        $data = DB::table('t_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->select(DB::raw('@boom:=@boom+1 AS no'),'t_spk.id_spk as id','m_pelanggan.nm_plg as nama','m_pelanggan.no_polisi','m_pelanggan.merk_mobil','t_spk.kilometer',
                            DB::raw("CONCAT('<a onclick=pilih(','&quot;',t_spk.id_spk,'&quot;',')><span class=btn btn-block btn-success btn-xs>Pilih</span></a>') as action"))
                    ->where('t_spk.status','0')
                    ->get();
        return $data;
    }

    public function lookup_spk()
    {
        $id_spk = Input::get('id_spk');
        // dd($id_plg);
        $data = DB::table('t_spk')
                ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                ->select('t_spk.id_spk as id','m_pelanggan.nm_plg as nama','m_pelanggan.no_polisi','m_pelanggan.merk_mobil','t_spk.kilometer')
                ->where('t_spk.id_spk',$id_spk)
                ->first();

        return Response::json($data);
    }

    public function laporanspk()
    {
        $data['act'] = "/downspk";
        return view('content.report.form-lapSpk',$data); //->with('data',$data);
    }

    public function downloadLapspk(Request $request)
    {
         $tanggal = date('Y-m-d H:i:s');
         $now = date("Y-m-d", strtotime(Input::get('tgl_awal'))).' 00:00:00';
         $end = date("Y-m-d", strtotime(Input::get('tgl_akhir'))).' 23:59:59';

         $data['tgl1'] = Input::get('tgl_awal');
         $data['tgl2'] = Input::get('tgl_akhir');

         DB::statement(DB::raw('SET @boom=0'));
         $data['isi'] = DB::table('t_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->join('m_karyawan', 't_spk.create_by', '=', 'm_karyawan.id_karyawan')
                    ->join('t_spk_detail', 't_spk_detail.id_spk', '=', 't_spk.id_spk')
                    ->select(DB::raw('@boom:=@boom+1 AS no'),'t_spk.id_spk', 'm_karyawan.nm_karyawan', 'm_pelanggan.nm_plg', 'm_pelanggan.alamat', 'm_pelanggan.merk_mobil', 'm_pelanggan.no_polisi', 't_spk_detail.keluhan')
                    ->whereBetween('t_spk.create_date',[$now, $end])
                    ->get();
         $type = '';

         Excel::create('Export Data Laporan SPK - '.$tanggal, function($excel) use($data, $tanggal, $type) {
            $excel->sheet('Sheet 1', function($sheet) use($data, $tanggal, $type) {
              $sheet->loadView('content.report.laporanspk')
                ->with("data",$data)
                ->with("tanggal",$tanggal)
                ->with("type",$type);
            });
        })->export('xlsx');

    }

    public function updatespk(Request $request)
    {        
        $proses = DB::table('t_spk')->where('id_spk',Input::get('nospk'))->update(
                        [
                            // 'id_spk' => Input::get('nospk'), 
                            'id_plg' => Input::get('id_pel'),
                            'tgl_awal' => date("Y-m-d", strtotime(Input::get('tgl_awal'))), 
                            'tgl_akhir' => date("Y-m-d", strtotime(Input::get('tgl_akhir'))),
                            'kilometer' => Input::get('km'),
                            'cuci' => Input::get('cuci'),
                            // 'create_date' => date('Y-m-d H:i:s'),
                            'status' => '1'
                        ]
                    );
        $hapus_keluhan =  DB::table('t_spk_detail')->where('id_spk',Input::get('nospk'))->delete();

                foreach (Input::get('keluhan_update') as $a => $b) {
                    DB::table('t_spk_detail')->insert(
                        [
                            'id_spk' => Input::get('nospk'), 
                            'status' => '1',
                            'create_date' => date('Y-m-d H:i:s'),
                            'keluhan' => $b
                        ]
                    );
                }
            // if($proses){  
            $ret = "MSG||YES||Data berhasil di update.||listspk";   
            // }else{
                // $ret = "MSG||NO||Maaf anda tidak melakukan perubahan data.||listspk";            
            // }
    
        return $ret;
    }

    public function spk_form_cetak($nospk)
    {
        $spkdata['header'] = DB::table('t_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->join('m_karyawan', 't_spk.create_by', '=', 'm_karyawan.id_karyawan')
                    ->select('t_spk.id_spk', 'm_karyawan.nm_karyawan', 'm_pelanggan.nm_plg', 'm_pelanggan.alamat', 'm_pelanggan.merk_mobil', 'm_pelanggan.no_polisi', 'm_pelanggan.no_telp', 't_spk.tgl_awal', 't_spk.tgl_akhir', 'm_karyawan.nm_karyawan')
                    ->where('t_spk.id_spk',$nospk)->first();
        
        DB::statement(DB::raw('SET @boom=0'));            
        $spkdata['detail'] = DB::table('t_spk_detail')
                    ->select(DB::raw('@boom:=@boom+1 AS no'),'keluhan')
                    ->where('id_spk',$nospk)->get();
        
        $pdf = PDF::loadView('content.cetakan.spk_cetak', compact('spkdata'));

        return $pdf->stream();

    }

    public function showspk($id_spk)
    {
        $show = DB::table('t_spk AS a')
                    ->select('a.id_spk','a.id_plg',DB::raw('DATE_FORMAT(a.tgl_awal,"%d-%m-%Y") as tgl_awal'),
                        DB::raw('DATE_FORMAT(a.tgl_akhir,"%d-%m-%Y") as tgl_akhir'),'a.kilometer','a.cuci','a.status','b.nm_plg','b.alamat','b.no_telp','b.no_polisi',
                        'b.merk_mobil','b.no_chasis'
                    )
                    ->leftjoin('m_pelanggan AS b','a.id_plg','=','b.id_plg')
                    ->where('a.id_spk',$id_spk)
                    ->first();

        $data['act'] = '/showspk';
        $data['jika'] = 'detail';
        $data['datas'] = $show;

        $show_keluhan = DB::table('t_spk_detail')
                            ->select('*')                            
                            ->where('id_spk',$id_spk)
                            ->get();
        $data['keluhan'] = $show_keluhan;

        return view('content.transaksi.form-spk',$data);
    }

    public function delspk($id_spk)
    {
        $id = $id_spk;        
        $delet = DB::table('t_spk')->where('id_spk',$id)->delete();

        $delete_detail = DB::table('t_spk_detail')->where('id_spk',$id)->delete();

        if($delet){
            $ret = "MSG||YES||Data berhasil dihapus||listspk";
        }else{
            $ret = "MSG||NO||Data tidak berhasil dihapus||listspk";            
        }   
        
        return $ret;

    }

    public function laporanrekapservice()
    {
        $data['act'] = "/downrekapservice";
        return view('content.report.form-lapRekapService',$data); //->with('data',$data);
    }

    public function downloadLaprekapservice(Request $request)
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

        $grand_total = 0;
        foreach ($data['isi'] as $datas) {
            $grand_total = $grand_total + ($datas->total_byr);
        }

        $data['grand_total'] = $grand_total;

         $type = '';

         Excel::create('Export Data Laporan Rekapitulasi Service - '.$now, function($excel) use($data, $tanggal, $type) {
            $excel->sheet('Sheet 1', function($sheet) use($data, $tanggal, $type) {
              $sheet->loadView('content.report.laporanrekapservice')
                ->with("data",$data)
                ->with("tanggal",$tanggal)
                ->with("type",$type);
            });
        })->export('xlsx');

    }
}
