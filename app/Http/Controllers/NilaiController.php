<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class NilaiController extends Controller
{
    //
    public function tampil(){
    	$da = DB::table('alternatif')->get();
    	$dk = DB::table('kriteria')->get();
    	$dn = DB::table('nilai')->get();
    	foreach ($da as $a) {
    		# code...
    		foreach ($dk as $k) {
    			# code...
    			$nm = DB::table('nilai')->where('kriteria',$k->kode)->max('nilai');
    			$max[$k->kode] = $nm;
    			$xx = DB::table('nilai')->select('nilai')->where('alternatif',$a->id)->where('kriteria',$k->kode)->first();
    			$yy = DB::table('nilai')->select('nilai')->where('kriteria',$k->kode)->get();
                $dy [$k->kode] = $yy;
                //$y = $d->nama;
                 //$$y[$] => $xx;
                $dx [$a->id.$k->kode] = $xx; 
                // = $d->nama;

    		}
    	}
    	//return dd($dy);
    		return view('tampil',['da' => $da,'dk' => $dk,'dn' => $dn,'max' => $max,'dx'=>$dx,'dy' => $dy]);
    }

      public function normal(){
    	$da = DB::table('alternatif')->get();
    	$dk = DB::table('kriteria')->get();
    	$dn = DB::table('nilai')->get();
    	foreach ($da as $a) {
    		# code...
    		foreach ($dk as $k) {
    			# code...
    			$nm = DB::table('nilai')->where('kriteria',$k->kode)->max('nilai');
    			$max[$k->kode] = $nm;
    			$xx = DB::table('nilai')->select('nilai')->where('alternatif',$a->id)->where('kriteria',$k->kode)->first();
                //$y = $d->nama;
                 //$$y[$] => $xx;
                $dx [$a->id.$k->kode] = $xx; 
                // = $d->nama;

    		}
    	}
    	//return dd($max);
    		return view('normal',['da' => $da,'dk' => $dk,'dn' => $dn,'max' => $max,'dx'=>$dx]);
    }

    public function vektor(){
    	$da = DB::table('alternatif')->get();
    	$dk = DB::table('kriteria')->get();
    	$dn = DB::table('nilai')->get();
    	DB::table('hasil')->truncate();
    	foreach ($da as $a) {
    		# code...
    		$dv[$a->id] = 0;
    		foreach ($dk as $k) {
    			# code...
    			$nm = DB::table('nilai')->where('kriteria',$k->kode)->max('nilai');
    			$max[$k->kode] = $nm;
    			$xx = DB::table('nilai')->select('nilai')->where('alternatif',$a->id)->where('kriteria',$k->kode)->first();
                //$y = $d->nama;
                 //$$y[$] => $xx;
                $dx [$a->id.$k->kode] = $xx;
                $yy = $dx [$a->id.$k->kode]->nilai/$nm;
                $dm [$a->id.$k->kode] = $yy;
                //$dv[$a->id] = $dm [$a->id.$k->kode];
                //echo $dv[$a->id]." ";

                //$dv[$a->id] = $dv[$a->id]+$dm [$a->id.$k->kode];	
                // = $d->nama;
                //echo $dv[$a->id]." ";
                $z = ($dm[$a->id.$k->kode])*($k->bobot/100);
    			$dv[$a->id] = $dv[$a->id]+$z;
    			//echo $k->kode." ".$dv[$a->id]." ";

    		}
    	$hs =[
    		'alternatif' => $a->nama,
    		'nilai' => $dv[$a->id]
    		];
    		DB::table('hasil')->insert($hs);
    		// echo "<br>";
    	}
    	//return dd($dv);
    		return view('vektor',['da' => $da,'dk' => $dk,'dn' => $dn,'max' => $max,'dx'=> $dx,'dm' => $dm,'dv' => $dv]);
    }
    public function hasil(){
    	$dh = DB::table('hasil')->orderBy('nilai','DESC')->get();
    	return view('hasil',['dh' => $dh]);
    }
}
