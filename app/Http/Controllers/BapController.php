<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Http\Requests;
use Barryvdh\DomPDF\Facade as PDF;
use Excel;
use Response;

class BapController extends Controller
{
    public function listbap()
    {
    	$data = DB::table('t_bap')
                ->join('t_spk', 't_bap.id_spk', '=', 't_spk.id_spk')
                ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                ->join('m_karyawan', 't_bap.mekanik', '=', 'm_karyawan.id_karyawan')
                ->select('t_bap.id_bap', 'm_karyawan.nm_karyawan', 'm_pelanggan.nm_plg', 'm_pelanggan.merk_mobil', 'm_pelanggan.no_polisi','t_spk.id_spk', 't_bap.status')
                ->get();

    	return view('content.transaksi.databap')->with('data',$data);
    }

    public function addbap()
    {
        if(DB::table('t_bap')->count() > 0){
            $show_last_id = DB::table('t_bap')->select('id_bap')->orderby('create_date','desc')->first();
            $last_id = $show_last_id->id_bap;
            $last_id = substr($last_id,2);
            $last_id = ((int)$last_id) + 1;
            // $data['nobap'] = "BA" . sprintf("%04d",  DB::table('t_bap')->count()+1);      
            $data['nobap'] = "BA" . sprintf("%04d",  $last_id);      
        }else{
            $data['nobap'] = "BA0001";
        }
		$data['act'] = "/savebap";
        $data['jika'] = 'add';
        $data['mekanik'] = DB::table('m_karyawan')->select('id_karyawan', 'nm_karyawan')->where('jabatan','mekanik')->get();

        $data['barang'] = DB::table('m_barang')->get();
    	return view('content.transaksi.form-bap',$data); //->with('data',$data);
    }

    public function savebap(Request $request)
    {
        if(DB::table('t_bap')->where('id_bap',Input::get('nobap'))->count() < 1){
            
            $proses = DB::table('t_bap')->insert(
                    [
                        'id_bap' => Input::get('nobap'), 
                        'id_spk' => Input::get('nospk'),
                        'tgl_bap' => date("Y-m-d", strtotime(Input::get('tgl_slesai'))),
                        'mekanik' => Input::get('mekanik'),
                        'catatan' => Input::get('catatan'),
                        'create_date' => date('Y-m-d H:i:s')
                    ]
                );


            $proses = DB::table('t_spk')->where('id_spk', Input::get('nospk'))
                            ->update(
                            [
                                'status' => '1'
                            ]
                        );

            $angka = 0;
            foreach (Input::get('barang') as $a => $b) {
                DB::table('t_bap_dtl')->insert(
                    [
                        'id_bap' => Input::get('nobap'), 
                        'barang' => $b,                                                        
                        'qty'=> Input::get('qty')[$angka],
                        'create_date' => date('Y-m-d H:i:s'),
                    ]
                );

                $angka++;
            }  
            $ret = "MSG||YES||Data berhasil di proses||listbap";   
        }else{
            $ret = "MSG||NO||Data tidak berhasil di proses||listbap";            
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

    public function listbarang_dd(){
        $data = DB::table('m_barang')->get();
        return Response::json($data);
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

    public function pilihbap()
    {
        DB::statement(DB::raw('SET @boom=0'));
        $data = DB::table('t_bap')
                    ->join('t_spk', 't_bap.id_spk', '=', 't_spk.id_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->select(DB::raw('@boom:=@boom+1 AS no'),'t_bap.id_bap as id','m_pelanggan.nm_plg as nama','t_bap.mekanik','m_pelanggan.no_polisi', DB::raw("CONCAT('<a onclick=pilih(','&quot;',t_bap.id_bap,'&quot;',')><span class=btn btn-block btn-success btn-xs>Pilih</span></a>') as action"))
                    ->where('t_bap.status','0')
                    ->orWhere('t_bap.status',null)
                    ->get();
        return $data;
    }

    public function lookup_bap()
    {
        $id_bap = Input::get('id_bap');
        // dd($id_plg);
        $data['header'] = DB::table('t_bap')
                            ->join('t_spk', 't_bap.id_spk', '=', 't_spk.id_spk')
                            ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                            ->join('m_karyawan', 't_bap.mekanik', '=', 'm_karyawan.id_karyawan')
                            ->select('t_bap.id_bap as id','m_pelanggan.nm_plg as nama','m_karyawan.nm_karyawan','m_pelanggan.no_polisi',DB::raw('(SELECT SUM(t_bap_dtl.qty * m_barang.harga)
                                FROM t_bap_dtl
                                LEFT JOIN m_barang ON t_bap_dtl.barang = m_barang.id_brg
                                WHERE t_bap_dtl.id_bap = t_bap.id_bap) AS grand_total'))
                            ->where('t_bap.id_bap',$id_bap)
                            ->first();

        DB::statement(DB::raw('SET @boom=0'));                    
        $data['detail'] = DB::table('t_bap_dtl')
                            ->join('m_barang', 't_bap_dtl.barang', '=', 'm_barang.id_brg')
                            ->select(DB::raw('@boom:=@boom+1 AS no'),'m_barang.nm_brg','t_bap_dtl.qty','m_barang.harga',
                            DB::raw('t_bap_dtl.qty*m_barang.harga as total'))
                            ->where('id_bap',$id_bap)
                            ->get();                              

        return Response::json($data);
    }

    public function laporanbap()
    {
        $data['act'] = "/downbap";
        return view('content.report.form-lapBap',$data); //->with('data',$data);
    }

    public function downloadLapbap(Request $request)
    {
         $tanggal = date('Y-m-d H:i:s');
         $now = date("Y-m-d", strtotime(Input::get('tgl_awal'))).' 00:00:00';
         $end = date("Y-m-d", strtotime(Input::get('tgl_akhir'))).' 23:59:59';

         $data['tgl1'] = Input::get('tgl_awal');
         $data['tgl2'] = Input::get('tgl_akhir');

         DB::statement(DB::raw('SET @boom=0'));
         $data['isi'] = DB::table('t_bap')
                    ->join('t_spk', 't_spk.id_spk', '=', 't_bap.id_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->join('m_karyawan', 't_bap.mekanik', '=', 'm_karyawan.id_karyawan')
                    ->select(DB::raw('@boom:=@boom+1 AS no'),'t_bap.id_bap', 'm_pelanggan.merk_mobil', 'm_pelanggan.no_polisi', 't_spk.kilometer', 'm_karyawan.nm_karyawn')
                    ->whereBetween('t_bap.tgl_bap',[$now, $end])
                    ->get();

         $type = '';

         Excel::create('Export Data Laporan BAP - '.$tanggal, function($excel) use($data, $tanggal, $type) {
            $excel->sheet('Sheet 1', function($sheet) use($data, $tanggal, $type) {
              $sheet->loadView('content.report.laporanbap')
                ->with("data",$data)
                ->with("tanggal",$tanggal)
                ->with("type",$type);
            });
        })->export('xlsx');

    }

    public function editbap($idbap)
    {
        $show = DB::table('t_bap AS a')
                    ->select('a.id_bap','a.id_spk','c.nm_plg','c.id_plg','c.no_polisi',DB::raw('DATE_FORMAT(a.tgl_bap,"%d-%m-%Y") as tgl_bap'),'a.catatan','a.mekanik','c.merk_mobil','b.kilometer')
                    ->leftjoin('t_spk AS b','a.id_spk','=','b.id_spk')
                    ->leftjoin('m_pelanggan AS c','b.id_plg','=','c.id_plg')
                    ->where('a.id_bap',$idbap)
                    ->first();        

        $data['act'] = '/updatebap';
        $data['jika'] = 'edit';
        $data['datas'] = $show;

        $show_detail = DB::table('t_bap_dtl')
                            ->select('*')                            
                            ->where('id_bap',$idbap)
                            ->get();
        $data['detailbap'] = $show_detail;
        $data['mekanik'] = DB::table('m_karyawan')->select('id_karyawan', 'nm_karyawan')->get();
        $data['barang'] = DB::table('m_barang')->get();

        return view('content.transaksi.form-bap',$data);
    }

    public function updatebap()
    {
        $cekspk = DB::table('t_bap')->where('id_bap',Input::get('nobap'))->value('id_spk');

        if ($cekspk == Input::get('nospk')) {            
        }else{
            $proses = DB::table('t_spk')->where('id_spk', $cekspk)
                                ->update(
                                [
                                    'status' => '0'
                                ]
                            );

            $proses = DB::table('t_spk')->where('id_spk', Input::get('nospk'))
                                ->update(
                                [
                                    'status' => '1'
                                ]
                            );
        }

        $proses = DB::table('t_bap')->where('id_bap',Input::get('nobap'))->update(
                [                    
                    'id_spk' => Input::get('nospk'),
                    'tgl_bap' => date("Y-m-d", strtotime(Input::get('tgl_slesai'))),
                    'mekanik' => Input::get('mekanik'),
                    'catatan' => Input::get('catatan'),
                    // 'create_date' => date('Y-m-d H:i:s')
                ]
            );


        $hpausDetail = DB::table('t_bap_dtl')->where('id_bap',Input::get('nobap'))->delete();

        $angka = 0;
        foreach (Input::get('barang_update') as $a => $b) {
            DB::table('t_bap_dtl')->insert(
                [
                    'id_bap' => Input::get('nobap'), 
                    'barang' => $b,                                                        
                    'qty'=> Input::get('qty_update')[$angka],
                    'create_date' => date('Y-m-d H:i:s'),
                ]
            );

            $angka++;
        }

        $ret = "MSG||YES||Data berhasil di proses||listbap";    

        return $ret;       
    }

    public function bap_form_cetak($nobap)
    {
        $bapdata['header'] = DB::table('t_bap')
                    ->join('t_spk', 't_spk.id_spk', '=', 't_bap.id_spk')
                    ->join('m_pelanggan', 't_spk.id_plg', '=', 'm_pelanggan.id_plg')
                    ->join('m_karyawan', 't_bap.mekanik', '=', 'm_karyawan.id_karyawan')
                    ->select('t_bap.id_bap', 'm_pelanggan.merk_mobil', 'm_pelanggan.no_polisi', 't_spk.kilometer', 'm_karyawan.nm_karyawan','t_spk.id_spk', 't_bap.tgl_bap')
                    ->where('t_bap.id_bap',$nobap)->first();
        
        $bapdata['ttd'] = DB::table('t_bap')
                        ->join('t_spk', 't_spk.id_spk', '=', 't_bap.id_spk')
                        ->join('m_karyawan', 't_spk.create_by', '=', 'm_karyawan.id_karyawan')
                        ->select('m_karyawan.nm_karyawan')
                        ->where('t_bap.id_bap',$nobap)->first();

        DB::statement(DB::raw('SET @boom=0'));            
        $bapdata['detail'] = DB::table('t_bap_dtl')
                    ->join('m_barang', 't_bap_dtl.barang', '=', 'm_barang.id_brg')        
                    ->select(DB::raw('@boom:=@boom+1 AS no'),'m_barang.nm_brg', 't_bap_dtl.qty')
                    ->where('id_bap',$nobap)->get();

        $pdf = PDF::loadView('content.cetakan.bap_cetak', compact('bapdata'));

        return $pdf->stream();
    }

    public function showbap($idbap)
    {
        $show = DB::table('t_bap AS a')
                    ->select('a.id_bap','a.id_spk','c.nm_plg','c.id_plg','c.no_polisi',DB::raw('DATE_FORMAT(a.tgl_bap,"%d-%m-%Y") as tgl_bap'),'a.catatan','a.mekanik','c.merk_mobil','b.kilometer')
                    ->leftjoin('t_spk AS b','a.id_spk','=','b.id_spk')
                    ->leftjoin('m_pelanggan AS c','b.id_plg','=','c.id_plg')
                    ->where('a.id_bap',$idbap)
                    ->first();        

        $data['act'] = '/showbap';
        $data['jika'] = 'detail';
        $data['datas'] = $show;

        $show_detail = DB::table('t_bap_dtl')
                            ->select('*')                            
                            ->where('id_bap',$idbap)
                            ->get();
        $data['detailbap'] = $show_detail;
        $data['mekanik'] = DB::table('m_karyawan')->select('id_karyawan', 'nm_karyawan')->get();
        $data['barang'] = DB::table('m_barang')->get();

        return view('content.transaksi.form-bap',$data);
    }

    public function delbap($id_bap)
    {
        $id = $id_bap;        

        $getidspk = DB::table('t_bap')->where('id_bap',$id)->value('id_spk');
        $update = DB::table('t_spk')->where('id_spk',$getidspk)->update(
                        [                    
                            'status' => '0',
                        ]
                    );
        
        $delet = DB::table('t_bap')->where('id_bap',$id)->delete();

        $delete_detail = DB::table('t_bap_dtl')->where('id_bap',$id)->delete();

        if($delet){
            $ret = "MSG||YES||Data berhasil dihapus||listbap";
        }else{
            $ret = "MSG||NO||Data tidak berhasil dihapus||listbap";            
        }   
        
        return $ret;

    }    
    
}
