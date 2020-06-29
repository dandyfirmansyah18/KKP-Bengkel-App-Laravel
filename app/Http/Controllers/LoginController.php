<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;
use Response;
use Session;
use DB;

class LoginController extends Controller
{
    public function cekLogin(Request $req){

        // dd(md5('P@ssw0rd'));

        $validator = Validator::make($req->all(), [
            
            'nik' => [
                            'required',
                            'min:3',

                        ],
            'password' => [
                            'required',
                            'min:3',
                        ],
        
        ]);

        if ($validator->fails()) {
            return redirect('login')
                        ->withErrors($validator)
                        ->withInput();
        }
        $nik= $req->nik;
        $pass = md5($req->password);
         // $pass = $req->password;

        $check = DB::table('m_karyawan')->where('id_karyawan',$nik)->where('password',$pass)->count();
        if( !($check > 0) )  {
             return redirect('login')->with('error', 'Username Atau Password anda tidak sesuai');
        }

        $take = DB::table('m_karyawan')->where('id_karyawan',$nik)->first();

        session(['nik_karyawan' => $take->id_karyawan]);
        session(['nm_karyawan' => $take->nm_karyawan]);
        session(['jabatan' => $take->jabatan]);
        session(['password' => true ]);
        session(['login' => true ]);

        return redirect('/');

    }

    public function logout(Request $req){

        $req->session()->regenerate();
        $req->session()->flush();
        
        return redirect('login');

    }

}
