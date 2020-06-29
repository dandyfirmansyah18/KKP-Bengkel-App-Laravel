<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Http\Requests;

class BarangController extends Controller
{
    public function listbarang()
    {
    	$data = DB::table('m_barang')->select('id_brg', 'nm_brg', 'harga')->get();

    	return view('content.master.databarang')->with('data',$data);
    }

     public function addbarang()
    {
        if(DB::table('m_barang')->count() > 0){
            $data['id_brg'] = "B" . sprintf("%04d", DB::table('m_barang')->count()+1);      
        }else{
            $data['id_brg'] = "B0001";
        }
        $data['act'] = "/savebarang";
        $data['option'] = ['JASA', 'SPARE PART'];
        return view('content.master.form-barang',$data); //->with('data',$data);
    }

    public function savebarang(Request $request)
    {
        if(DB::table('m_barang')->where('id_brg',Input::get('id_brg'))->count() < 1){
            
             $proses = DB::table('m_barang')->insert(
                        [
                            'id_brg' => Input::get('id_brg'), 
                            'nm_brg' => Input::get('nama'),
                            'harga' => Input::get('harga'),
                            'kategori' => Input::get('kategori'), 
                            'create_date' => date('Y-m-d')
                        ]
                    );
                $ret = "MSG||YES||Data berhasil di proses||listbarang";   
            }else{
                $ret = "MSG||NO||Data tidak berhasil di proses||listbarang";            
            }

        
        return $ret;
    }

    public function showbarang($id)
    {
        $data['datas'] = DB::table('m_barang')->where('id_brg',$id)->select('nama_karyawan', 'alamat_karyawan', 'nomer_telp', 'nik')->first();
        $data['act'] = "";
        $data['option'] = ['JASA', 'SPARE PART'];

        return view('content.master.form-karyawan', $data);
    }

    public function getbarang($id)
    {
        $data['datas'] = DB::table('m_barang')->where('id_brg',$id)->select('nm_brg', 'harga', 'kategori', 'id_brg')->first();
        $data['act'] = "/editbrg";
        $data['option'] = ['JASA', 'SPARE PART'];
        return view('content.master.form-barang', $data);
    }

    public function editbarang(Request $request)
    {
        $proses = DB::table('m_barang')->where('id_brg', Input::get('id_brg'))
                        ->update(
                        [
                            'nm_brg' => Input::get('nama'),
                            'harga' => Input::get('harga'),
                            'kategori' => Input::get('kategori')
                        ]
                    );

    $ret = "MSG||YES||Data berhasil di proses||listbarang";
    return $ret;
    }

    public function delete($id)
    {
        $delete =  DB::table('m_barang')->where('id_brg',$id)->delete();
        if ($delete) {
            $ret = "MSG||YES||Data berhasil di proses||listbarang";
        }else{
            $ret = "MSG||ERR||Data Gagal di proses||listbarang";
        }

        return $ret;
    }
}
