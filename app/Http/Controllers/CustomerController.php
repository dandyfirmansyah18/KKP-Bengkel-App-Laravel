<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Http\Requests;
use Response;

class CustomerController extends Controller
{
    public function listcustomer()
    {
    	$data = DB::table('m_pelanggan')->select('id_plg','nm_plg', 'alamat', 'no_telp', 'no_polisi', 'merk_mobil', 'no_mesin')->get();

    	return view('content.master.datacustomer')->with('data',$data);
    }

    public function addcustomer()
    {
        if(DB::table('m_pelanggan')->count() > 0){
            $data['nik'] = "P" . sprintf("%04d", DB::table('m_pelanggan')->count()+1);      
        }else{
            $data['nik'] = "P0001";
        }
    	
        $data['act'] = "/savecustomer";

    	return view('content.master.form-customer', $data); //->with('data',$data);
    }

    public function savecus(Request $request)
    {
        $proses = DB::table('m_pelanggan')->insert(
                        [
                            'id_plg' => Input::get('nik'), 
                            'nm_plg' => Input::get('nama'), 
                            'alamat' => Input::get('alamat'),
                            'no_telp' => Input::get('notelp'), 
                            'no_polisi' => Input::get('nopol'),
                            'no_mesin' => Input::get('nomesin'),
                            'no_chasis' => Input::get('nocasis'),
                            'create_date' => date('Y-m-d H:i:s'),
                            'merk_mobil' => Input::get('merkmobil')
                        ]
                    );

        $ret = "MSG||YES||Data berhasil di proses||listcus";
        return $ret;
    }

    public function showcus($id)
    {
        $data['datas'] = DB::table('m_pelanggan')->where('id_plg',$id)->select('id_plg', 'nm_plg', 'alamat', 'no_telp', 'no_polisi', 'merk_mobil', 'no_mesin', 'no_chasis')->first();
        $data['act'] = "";
        
        return view('content.master.form-customer', $data);
    }

    public function getcus($id)
    {
        $data['datas'] = DB::table('m_pelanggan')->where('id_plg',$id)->select('id_plg', 'nm_plg', 'alamat', 'no_telp', 'no_polisi', 'merk_mobil', 'no_mesin', 'no_chasis')->first();
        $data['act'] = "/editcus";
        return view('content.master.form-customer', $data);
    }

    public function editcus(Request $request)
    {
        $proses = DB::table('m_pelanggan')->where('id_plg', Input::get('nik'))
                        ->update(
                        [
                            'nm_plg' => Input::get('nama'), 
                            'alamat' => Input::get('alamat'),
                            'no_telp' => Input::get('notelp'), 
                            'no_polisi' => Input::get('nopol'),
                            'no_mesin' => Input::get('nomesin'),
                            'no_chasis' => Input::get('nocasis'),
                            'merk_mobil' => Input::get('merkmobil')
                        ]
                    );

    $ret = "MSG||YES||Data berhasil di proses||listcus";
    return $ret;
    }

    public function delete($id)
    {
        $delete = DB::table('m_pelanggan')->where('id_plg',$id)->delete();
        if ($delete) {
            $ret = "MSG||YES||Data berhasil di proses||listcus";
        }else{
            $ret = "MSG||ERR||Data Gagal di proses||listcus";
        }

        return $ret;
    }

    public function pilihpelanggan()
    {
        DB::statement(DB::raw('SET @boom=0'));
        $data = DB::table('m_pelanggan')
                    ->select(DB::raw('@boom:=@boom+1 AS no'),'id_plg as id','nm_plg as nama','alamat','no_polisi','no_chasis',
                            DB::raw("CONCAT('<a onclick=pilih(','&quot;',id_plg,'&quot;',')><span class=btn btn-block btn-success btn-xs>Pilih</span></a>') as action"))
                    ->get();
        return $data;
    }

    public function lookup_pelanggan()
    {
        $id_plg = Input::get('id_plg');
        // dd($id_plg);
        $data = DB::table('m_pelanggan')
                ->select('id_plg as id','nm_plg as nama','alamat','no_chasis','no_polisi')
                ->where('id_plg',$id_plg)
                ->first();

        return Response::json($data);
    }
}
