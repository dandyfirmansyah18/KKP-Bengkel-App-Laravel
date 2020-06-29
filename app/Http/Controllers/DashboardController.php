<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;

class DashboardController extends Controller
{
    public function index()
    {

    	$viewData = array(
		                '_content_' => $this->view_dashboard()
	                );
        return view('templates.app', $viewData);
    }

    public function view_dashboard()
    {
        return view('content.dashboard');
    }

    public function dashboard_chart()
    {
        $tahun_now = date('Y');
        $array_service = array();

        $serviceJanuari     = DB::table('t_spk')->whereRaw('MONTH(tgl_awal) = 01 AND YEAR(tgl_awal) = "'.$tahun_now.'"')->count();
        $serviceFebruari    = DB::table('t_spk')->whereRaw('MONTH(tgl_awal) = 02 AND YEAR(tgl_awal) = "'.$tahun_now.'"')->count();
        $serviceMaret       = DB::table('t_spk')->whereRaw('MONTH(tgl_awal) = 03 AND YEAR(tgl_awal) = "'.$tahun_now.'"')->count();
        $serviceApril       = DB::table('t_spk')->whereRaw('MONTH(tgl_awal) = 04 AND YEAR(tgl_awal) = "'.$tahun_now.'"')->count();
        $serviceMei         = DB::table('t_spk')->whereRaw('MONTH(tgl_awal) = 05 AND YEAR(tgl_awal) = "'.$tahun_now.'"')->count();
        $serviceJuni        = DB::table('t_spk')->whereRaw('MONTH(tgl_awal) = 06 AND YEAR(tgl_awal) = "'.$tahun_now.'"')->count();
        $serviceJuli        = DB::table('t_spk')->whereRaw('MONTH(tgl_awal) = 07 AND YEAR(tgl_awal) = "'.$tahun_now.'"')->count();
        $serviceAgustus     = DB::table('t_spk')->whereRaw('MONTH(tgl_awal) = 08 AND YEAR(tgl_awal) = "'.$tahun_now.'"')->count();
        $serviceSeptember   = DB::table('t_spk')->whereRaw('MONTH(tgl_awal) = 09 AND YEAR(tgl_awal) = "'.$tahun_now.'"')->count();
        $serviceOktober     = DB::table('t_spk')->whereRaw('MONTH(tgl_awal) = 10 AND YEAR(tgl_awal) = "'.$tahun_now.'"')->count();
        $serviceNopember    = DB::table('t_spk')->whereRaw('MONTH(tgl_awal) = 11 AND YEAR(tgl_awal) = "'.$tahun_now.'"')->count();
        $serviceDesember    = DB::table('t_spk')->whereRaw('MONTH(tgl_awal) = 12 AND YEAR(tgl_awal) = "'.$tahun_now.'"')->count();

        array_push($array_service, $serviceJanuari, $serviceFebruari, $serviceMaret, $serviceApril, $serviceMei, $serviceJuni, $serviceJuli, $serviceAgustus, $serviceSeptember, $serviceOktober, $serviceNopember, $serviceDesember);

        $array_garansi = array();
        $garansiJanuari     = DB::table('t_klaim_garansi')->whereRaw('MONTH(tgl_klaim) = 01 AND YEAR(tgl_klaim) = "'.$tahun_now.'"')->count();
        $garansiFebruari    = DB::table('t_klaim_garansi')->whereRaw('MONTH(tgl_klaim) = 02 AND YEAR(tgl_klaim) = "'.$tahun_now.'"')->count();
        $garansiMaret       = DB::table('t_klaim_garansi')->whereRaw('MONTH(tgl_klaim) = 03 AND YEAR(tgl_klaim) = "'.$tahun_now.'"')->count();
        $garansiApril       = DB::table('t_klaim_garansi')->whereRaw('MONTH(tgl_klaim) = 04 AND YEAR(tgl_klaim) = "'.$tahun_now.'"')->count();
        $garansiMei         = DB::table('t_klaim_garansi')->whereRaw('MONTH(tgl_klaim) = 05 AND YEAR(tgl_klaim) = "'.$tahun_now.'"')->count();
        $garansiJuni        = DB::table('t_klaim_garansi')->whereRaw('MONTH(tgl_klaim) = 06 AND YEAR(tgl_klaim) = "'.$tahun_now.'"')->count();
        $garansiJuli        = DB::table('t_klaim_garansi')->whereRaw('MONTH(tgl_klaim) = 07 AND YEAR(tgl_klaim) = "'.$tahun_now.'"')->count();
        $garansiAgustus     = DB::table('t_klaim_garansi')->whereRaw('MONTH(tgl_klaim) = 08 AND YEAR(tgl_klaim) = "'.$tahun_now.'"')->count();
        $garansiSeptember   = DB::table('t_klaim_garansi')->whereRaw('MONTH(tgl_klaim) = 09 AND YEAR(tgl_klaim) = "'.$tahun_now.'"')->count();
        $garansiOktober     = DB::table('t_klaim_garansi')->whereRaw('MONTH(tgl_klaim) = 10 AND YEAR(tgl_klaim) = "'.$tahun_now.'"')->count();
        $garansiNopember    = DB::table('t_klaim_garansi')->whereRaw('MONTH(tgl_klaim) = 11 AND YEAR(tgl_klaim) = "'.$tahun_now.'"')->count();
        $garansiDesember    = DB::table('t_klaim_garansi')->whereRaw('MONTH(tgl_klaim) = 12 AND YEAR(tgl_klaim) = "'.$tahun_now.'"')->count();

        array_push($array_garansi, $garansiJanuari,$garansiFebruari,$garansiMaret,$garansiApril,$garansiMei,$garansiJuni,$garansiJuli,$garansiAgustus,$garansiSeptember,$garansiOktober,$garansiNopember,$garansiDesember);

        $data['array_service'] = $array_service;
        $data['array_garansi'] = $array_garansi;

        return $data;


    }


    
}