<?php

namespace App\Http\Controllers;

use App\Kata;
use App\Dok; 
use App\DetailKata;
use Illuminate\Http\Request;

class KataController extends Controller
{

	public function index()
	{ 
		$data['kata'] = Kata::get();
		$ka = Kata::where('idf','=',0)->count();
		if ($ka>0) {
			$data['message']="<div class='alert alert-danger alert-dismissable'>
			<a href='#'' class='close' data-dismiss='alert' aria-label='close' style='right: 4px;'>×</a>
			<strong>Peringatan!</strong> Terdapat <strong>".$ka." </strong>kata yang belum masuk perhitungan. Segera lakukan perhitungan ulang.
			</div>";
		}

		return view('kata',compact('data'))->with(["page" => "kata"]);
	}

	public function hitung_bobot(){

		ini_set('memory_limit', '400M');
		ini_set('max_execution_time', 300);
		$dokumen = Dok::count();
		$tbKata = Kata::all();
		foreach ($tbKata as $term) {
    	// --------------IDF-----------------
			$nilaiIdf = round(log($dokumen/$term->totDok,10), 3);
			$term->idf = $nilaiIdf;
			$term->save();
        // --------------TF-IDF------------
			// $doks = DetailKata::where('kata',$term->kata)->get();
			// foreach ($doks as $d) {
			// 	$tfIdf 	= $d->tf*$nilaiIdf;
			// 	$d->tfidf 	= $tfIdf;
			// 	$d->save();
			// }
		}
		$katas = Kata::get();
		return redirect('/kata'); 
	}

	public function cekUpdate(){
		$data 			= new DetailKata();
		$data->kata 	= 'ahung';
		$data->idDok 	= 31;
		$data->exists 	= true;
		$data->w 	 	= 3.434;
		$data->save();
	}

	public function cek(){
		$data = new Dok();
		$data->text 	 	= '3.434';
		$data->save();
        // $lastDok = Dok::orderBy('idDok', 'DESC')->first();
        // $ids = $data->id;
		echo "id dok ".$data->id;	
		echo " text ".$data->text;	
	}
	public function update3(){
		$term = 'hubung';
		$doks = DetailKata::where('kata',$term)->get();
		foreach ($doks as $d) {
			$tfIdf = 0.0100203;
			$d->w 	 	= $tfIdf;
			$d->save();
		}
	}


}
