<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('kriteria')->get();
        return view('kriteria')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $x = 1;
        $kode = 'K'.$x;
        $data = DB::table('kriteria')->get();
        foreach ($data as $d) {
            if ($kode == $d->kode) {
                 $x++;
                 $kode = 'K'.$x;
             } 
             else{
                $kodex = $kode;
             }
        }
                //return dd($kode);
        return view('tambah_k')->with('kode',$kode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data =[
        //     'kode' => $request->kode,
        //     'nama' => $request->nama,
        //     'bobot' => $request->bobot

        // ] ;
        // DB::table('kriteria')->insert($data);
        $cek = DB::table('kriteria')->where('nama',$request->nama)->get();
        //return count($cek);
        if (count($cek) > 0) {
             return redirect('/kriteria')->with('sukses','Kriteria Sudah Ada!');
         }
         else
         { 
        $da =DB::table('alternatif')->get();
        if(count($da) <>0){
             $data =[
             'kode' => $request->kode,
             'nama' => $request->nama,
             'bobot' => $request->bobot

         ] ;
        $ik = DB::table('kriteria')->insert($data);
        if ($ik) {
            foreach ($da as $d) {
                $data2 =[
                    'alternatif' => $d->id,
                    'kriteria' => $request->kode,
                    'nilai' => 0
                ];
                DB::table('nilai')->insert($data2);
            }
            return redirect('/kriteria')->with('sukses','Kriteria ditambah');
        }
        else{
            return redirect('/kriteria')->with('sukses','Kriteria Gagal ditambah');   
        }
            
        }
        else{
             $data =[
             'kode' => $request->kode,
             'nama' => $request->nama,
             'bobot' => $request->bobot

         ] ;
        $ik = DB::table('kriteria')->insert($data);
        if ($ik) {
        return redirect('/kriteria')->with('sukses','Kriteria ditambah');
        }
        else{
           
          return redirect('/kriteria')->with('sukses','Kriteria Gagal ditambah');   
        }
    }
}
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('kriteria')->where('kode',$id)->first();
        return view('/edit_k')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'bobot' => $request->bobot
        ];
        $uk = DB::table('kriteria')->where('kode',$request->kode)->update($data);
        if ($uk) {
            
        return redirect('/kriteria')->with('sukses','Kriteria Berhasil Diubah!');
        }
        else{
        return redirect('/kriteria')->with('sukses','Kriteria Gagal Diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        //$da = DB::table('alternatif')->get();
        $dk = DB::table('kriteria')->where('kode',$id)->delete();
        //foreach ($da as $d) {
             DB::table('nilai')->where('kriteria',$id)->delete();
        //}
        if ($dk) {
            
        return redirect('/kriteria')->with('sukses','Kriteria Berhasil Dihapus!');
        }
        else{
        return redirect('/kriteria')->with('sukses','Kriteria Gagal Dihapus!');
        }
        //
    }
}
