<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = DB::table('kriteria')->get();
        $data2 = DB::table('alternatif')->get();
        foreach ($data2 as $d) {
            foreach ($data as $dd) {
                $xx = DB::table('nilai')->select('nilai')->where('alternatif',$d->id)->where('kriteria',$dd->kode)->first();
                //$y = $d->nama;
                 //$$y[$] => $xx;
                $datax [$d->id.$dd->kode] = $xx; 
                // = $d->nama;
            }
        }
     // return dd($datax);
        if(count($data2) <> 0){
     return view('alternatif',['data'=>$data,'data2' =>$data2,'datax' => $datax]);
        }
        else{
            return view('alternatif',['data'=>$data,'data2' =>$data2]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    $x = 1;$l=1;
        $kode = 'A'.$x;
        $qr = "length(id) DESC";
        $datab = DB::table('alternatif')->select('id')->orderByRaw($qr)->get();
       //return max($datab);
        foreach ($datab as $d) {
            $datab2 = DB::table('alternatif')->count();
            //return dd($datab2);
                 $oo []=$l;
                 $l = $l+1;
               //  echo($l);
            if ($kode ==  $d->id) {
                $x++;
                 $kode = 'A'.$x;

             //$data = DB::table('kriteria')->get();
             //return view('tambah_a',['data' => $data,'id' => $kode,'x' => $x]);  
        //          $data = DB::table('kriteria')->get();
        // return view('tambah_a',['data' => $data,'id' =>$kode,'x' => $x]);
             } 
             else{
               //  $kode = $kode2;
                 //return $kode2;                
             //return view('tambah_a',['data' => $data,'id' => $kode,'x' => $x]);
                  }
                    //$x=$x+1;
        }//return min($oo);
        //arsort($oo);
       // return $oo;
        $data = DB::table('kriteria')->get();
        return view('tambah_a',['data' => $data,'id' => $kode,'x' => $x]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // $cek = DB::table('alternatif')->where('nama',$request->nama);
        //if (count($cek) > 0)  {
        //return redirect('/alternatif')->with('sukses','Alternatif Sudah Ada!');    
        //}
        $data =[
            'id' =>$request->id,
            'nama' =>$request->nama
        ];
        DB::table('alternatif')->insert($data);
        $dv = DB::table('kriteria')->get();
        foreach ($dv as $k) {
            $kode =$k->kode;
            $bb ['alternatif']  = $request->id;
            $bb ['kriteria']  = $k->kode;
            $bb ['nilai']  = $request->$kode;
            DB::table('nilai')->insert($bb);

        }
        return redirect('/alternatif')->with('sukses','Alternatif Berhasil Ditambah!');
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
        $data = DB::table('nilai')->where('alternatif',$id)->get();
        $data2 = DB::table('alternatif')->where('id',$id)->first();
        $data3 = DB::table('kriteria')->get();
     //   $dr = DB::table('nilai')->where('kriteria','K1')->max('nilai');
       // return dd($dr);
        return view('edit_a',['data'=>$data,'data2'=>$data2,'data3'=>$data3]);
        //return dd($data);
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
        //
        // $data =[
        //     'id' =>$request->id,
        //     'nama' =>$request->nama
        // ];
        //  $ua = DB::table('alternatif')->where('id',$request->id)->update($data);
        $dv = DB::table('kriteria')->get();
        foreach ($dv as $k) {
            $kode =$k->kode;
            // $bb ['alternatif']  = $request->id;
            //$bb ['kriteria']  = $k->kode;
            $bb ['nilai']  = $request->$kode;
           $n = DB::table('nilai')->where('alternatif',$request->id)->where('kriteria',$k->kode)->update($bb);

        }
        $data =[
            'id' =>$request->id,
            'nama' =>$request->nama
        ];
         $ua = DB::table('alternatif')->where('id',$request->id)->update($data);
        if ($ua or $n) {
        return redirect('/alternatif')->with('sukses','Alternatif Berhasil Diubah!');
        }
        else{
         return redirect('/alternatif')->with('sukses','Alternatif Gagal Diubah!');   
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
        //
        DB::table('nilai')->where('alternatif',$id)->delete();
        $ha = DB::table('alternatif')->where('id',$id)->delete();
        if ($ha) {
        return redirect('/alternatif')->with('sukses','Alternatif Berhasil Dihapus!');
        }
        else{
         return redirect('/alternatif')->with('sukses','Alternatif Gagal Dihapus!');   
        }
    }
}
