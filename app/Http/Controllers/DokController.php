<?php

namespace App\Http\Controllers;

use App\Dok;
use Illuminate\Http\Request;

class DokController extends Controller
{
public function index()
    {
        $data['dok'] = Dok::orderBy('idDok', 'desc')->get();
        return view('dokumen',compact('data'))->with(["page" => "dok"]);
    }

    public function create()
    {
        $data['status'] = 'add';
        $data['fakultas'] = Fakultas::get();
        $data['tema'] = 'Tambah Dokumen'; 
        return view('formPenelitian',compact('data'))->with(["page" => "dok"]);
    }

    public function show($id)
    {
        $dokumen = Dok::where('idDok',$id)->first();
        $data['tema'] = 'Detail Dokumen'; 
        return view('viewPenelitian',compact('data','dokumen'))->with(["page" => "dok"]);
    }

    public function edit($id)
    {
        $data['status'] = 'edit';
        $data['fakultas'] = Fakultas::get();
        $data['dokumen'] = Dok::where('idDok',$id)->first();
        $data['tema'] = 'Ubah Dokumen'; 
        return view('formPenelitian',compact('data'))->with(["page" => "dok"]);
    }

    public function update(Request $request, $id)
    {
        $text       = $request->abstrak;        //-------------pre-processing abstrak baru
        $proses1    = str_replace('-', ' ', $text);
        $proses2    = preg_replace("/[^a-zA-Z\ ]/ ", " ", $proses1);
        $proses3    = strtolower($proses2);
        $proses4    = explode(" ", $proses3);
        $proses5    = array_values(array_filter($proses4));
        $proses6    = $this->stopword($proses5);

        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer  = $stemmerFactory->createStemmer();

        $proses7 = array();
        $i = 0;
        foreach ($proses6 as $kata) {
            $proses7[$i] = $stemmer->stem($kata);
            $i++;
        }

        $hasilPre   = array_count_values($proses7);
        $frekuensi  = array_values($hasilPre);
        $daftarKata = array_keys($hasilPre);
        $tot        = count($hasilPre);

        $dokumen             = Dok::where('idDok',$id)->first();
        $preLama = explode(" ",$dokumen->hasilPre);//term dari semua dokumen sebelumnya
        $dokumen->judul      = $request->judul;
        $dokumen->penulis    = $request->penulis;
        $dokumen->date       = $request->date;
        $dokumen->abstrak    = $request->abstrak;
        $dokumen->keywords    = $request->keywords;
        $dokumen->idFakultas = $request->idFakultas;
        $dokumen->hasilPre   = implode(" ", $daftarKata);
        $dokumen->totKata    = $tot;
        $dokumen->save();
        
        // kata pada abstrak lama yg tidak ada pada abstrak baru
        foreach ($preLama as $k) {
            if (in_array($k, $daftarKata)==false) {
                $this->minTerm($k);
            }
        }        
        
        // kata pada abstrak baru yg tidak ada pada abstrak lama
        $listKata = Kata::pluck('kata')->toArray();  //daftar kata unik dari semua dokumen sebelumnya
        foreach ($daftarKata as $k) {
            if (in_array($k, $preLama)==false) {
                if (in_array($k, $listKata)==false) {
                    $this->tambahTerm($k);
                }else{
                    $this->updateTerm($k);
                }   
            }
        }

        //--------- hapus detailKata sebelumya
        $doks = DetailKata::where('idDok','=',$id)->delete();
        for ($i=0; $i < count($daftarKata); $i++) { //simpan tf
            $word           = new DetailKata;
            $word->kata     = $daftarKata[$i];
            $word->idDok    = $id;
            $word->tf       = $frekuensi[$i]/$tot;
            $word->save();
        }

        return redirect()->route('penelitian.index')
                        ->with(["page" => "dok"])->with('success','Document updated successfully.');
    }

    public function destroy($id)
    {
        $dok = Dok::where('idDok',$id)->first(); //-----------ambil data dok dg id
        $listKata = explode(" ", $dok->hasilPre);

        foreach ($listKata as $kata) {           //-----------hapus kata dari list idf
            $this->minTerm($kata);
        }

        $doks = DetailKata::where('idDok',$id)->delete();//--hapus kata dari list detailKata 
        $dok->delete();//-----------hapus data dok
        return redirect()->route('dok.index')->with('success','Document deleted successfully');
    }

    public function store(Request $request)
    {
        $text       = $request->abstrak;
        $proses1    = str_replace('-', ' ', $text);
        $proses2    = preg_replace("/[^a-zA-Z\ ]/ ", " ", $proses1);
        $proses3    = strtolower($proses2);
        $proses4    = explode(" ", $proses3);
        $proses5    = array_values(array_filter($proses4));
        $proses6    = $this->stopword($proses5);

        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer  = $stemmerFactory->createStemmer();

        $proses7 = array();
        $i = 0;
        foreach ($proses6 as $kata) {
            $proses7[$i] = $stemmer->stem($kata);
            $i++;
        }

        $hasilPre   = array_count_values($proses7);
        $frekuensi  = array_values($hasilPre);
        $daftarKata = array_keys($hasilPre);
        $tot        = count($hasilPre);

        $doku            = new Dok;
        $doku->judul     = $request->judul;
        $doku->penulis   = $request->penulis;
        $doku->date      = $request->date;
        $doku->idFakultas  = $request->idFakultas;
        $doku->abstrak   = $request->abstrak;
        $doku->keywords  = $request->keywords;
        $doku->hasilPre  = implode(" ", $daftarKata);
        $doku->totKata   = $tot;
        $doku->save();
        $id = $doku->idDok;

        //daftar kata unik dari semua dokumen sebelumnya
        $listKata = Kata::pluck('kata')->toArray();

        for ($i=0; $i < count($daftarKata); $i++) { //simpan tf
            $word           = new DetailKata;
            $word->kata     = $daftarKata[$i];
            $word->idDok    = $id;
            $word->tf       = $frekuensi[$i]/$tot;
            $word->save();

            if (in_array($daftarKata[$i], $listKata)==false) {
                $this->tambahTerm($daftarKata[$i]);
            }else{
                $this->updateTerm($daftarKata[$i]);
            }
        }
   
        return redirect()->route('penelitian.index')
                        ->with(["page" => "dok"])->with('success','Document created successfully.');
    }


    // ----------------stopword manual--------------
    public function dbstopword(){
        $data = Stopwords::all();
        $a = array();
        foreach ($data as $key => $value) {
                $a[] = $value->kata; //menyimpan kata stopword pada 1 array
        }
        return $a;
    }

    public function stopword($arrayKalimat){
        $arr = $this->dbstopword();
        $data = $arrayKalimat;
        $a = array();
        for ($j=0; $j < count($arr); $j++) { 
            foreach($data as $key => $value) { 
                if($value == $arr[$j]){
                    unset($data[$key]);
                }
            }
            if($j == count($arr)-1){
                foreach ($data as $key => $value) {
                    $a[] = $value;
                }
            }
        }
        $data = $a;
        return $data;
    }

    // ---------------- cu tabel kata --------------
    public function tambahTerm($kata){
        $unik         = new Kata;
        $unik->kata   = $kata;
        $unik->totDok = 1;
        $unik->idf    = 0;
        $unik->save();
    }

    public function updateTerm($term){
        $data = Kata::where('kata',$term)->first();
        $nilaiDf = ($data->totDok + 1);
        $data->totDok = $nilaiDf;
        $data->save();
    }

    public function minTerm($term){
        $data = Kata::where('kata',$term)->first();
        if ($data->totDok == 1) {
            $data->delete();
        } else {
            $nilaiDf = ($data->totDok - 1);
            $data->update(['totDok' => $nilaiDf]);
        }        
    }
 
}
