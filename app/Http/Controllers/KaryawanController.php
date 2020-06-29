<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DataTables, DB, Mail;
use App\Http\Requests;

class KaryawanController extends Controller
{
    public function listkaryawan()
    {
    	$data = DB::table('m_karyawan')->select('nm_karyawan', 'alamat', 'id_karyawan', 'jabatan')->get();

    	return view('content.master.datakaryawan')->with('data',$data);
    }

    public function addkaryawan()
    {
        if(DB::table('m_karyawan')->count() > 0){
            $data['nik'] = "K" . sprintf("%04d", DB::table('m_karyawan')->count()+1);      
        }else{
            $data['nik'] = "K0001";
        }
		$data['option'] = ['Admin', 'SA', 'Mekanik', 'Kasir'];
        $data['act'] = "/listsavekar";
    	return view('content.master.form-karyawan',$data); //->with('data',$data);
    }

    public function savekaryawan(Request $request)
    {
        if(DB::table('m_karyawan')->where('id_karyawan',Input::get('nik'))->count() < 1){
            
            $proses = DB::table('m_karyawan')->insert(
                        [
                            'id_karyawan' => Input::get('nik'), 
                            'nm_karyawan' => Input::get('nama'),
                            'alamat' => Input::get('alamat'), 
                            // 'email' => Input::get('email'), 
                            'jabatan' => Input::get('jabatan'),
                            'password' => md5(Input::get('nik')),
                            'no_telp' => Input::get('notelp')
                        ]
                    );

            $email = Input::get('email');
            Mail::send('email.yourpassword', ['nm_karyawan' => Input::get('nama'), 'email' => Input::get('email'), 'password' => Input::get('nik')], function($mail) use ($email) {
                $mail->from('no-reply@bengkel99.com', 'Bengkel 99');
                $mail->to($email)
                    ->subject('Your Password Application Bengkel 99');
            });

            $ret = "MSG||YES||Data berhasil di proses||listkaryawan";   
        }else{
            $ret = "MSG||NO||Data tidak berhasil di proses||listkaryawan";            
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
    	$delete =  DB::table('m_karyawan')->where('id_karyawan',$id)->delete();
        if ($delete) {
            $ret = "MSG||YES||Data berhasil di proses||listkaryawan";
        }else{
            $ret = "MSG||ERR||Data Gagal di proses||listkaryawan";
        }

        return $ret;
    }
}
