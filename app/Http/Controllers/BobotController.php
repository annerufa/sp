<?php

namespace App\Http\Controllers;

use App\Kata;
use App\Dok;
use App\DetailKata;
use Illuminate\Http\Request;

class BobotController extends Controller
{

    public function index()
    { 
        $data['kata'] = Kata::get();
        $ka = Kata::where('idf','=',0)->count();
        if ($ka>0) {
            $data['message']="<div class='alert alert-danger alert-dismissable'>
                <a href='#'' class='close' data-dismiss='alert' aria-label='close' style='right: 4px;'>×</a>
                <strong>Peringatan!</strong> Terdapat <strong> 20 </strong>dokumen belum dihitung. Segera lakukan perhitungan ulang.
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
            $doks = DetailKata::where('kata',$term->kata)->get();
            foreach ($doks as $d) {
                $tfIdf 	= $d->tf*$nilaiIdf;
                $d->tfidf 	= $tfIdf;
                $d->save();
            }
        }
        $katas = Kata::get();
        return view('kata',compact('katas'));
    }
    
    public function inner(){
        $doks = Dok::select('idDok')->get();
        foreach ($doks as $d) {
            $kata = DetailKata::where('idDok',$d->idDok)->get();
            $se = 0;
            foreach ($kata as $k) {
                $a = pow($k->w,2) ;
                $se += $a;
            }
            $innerPoint = sqrt($se);
            $d->w = $innerPoint;
            $d->save();
        }
    }

    public function clustering(){
    // ------clustering-----------
        $doks = Dok::select('idDok','frekuensi')->get();
        $daftarDok = array();
        foreach ($doks as $key => $value) {
            $daftarDok[] = $value->idDokumen; 
        }
        $katas = Kata::get();
        $dimensi = count($katas);
        $k=4;
        $kondisiAwal = true;
        $clusterAkhir = 0;
        $clusterFix = array();
        $iter = 2;
        $clusterInduk = $daftarDok;

        for ($i=1; $i < $k; $i++) { 
            for ($j=0; $j < $iter; $j++) { 
                $hasil = $this->k_means($clusterInduk,$dimensi,$tfidf);
                $os[$j] = $hasil['overallSimilarity']['nilai'];

                if ($j==0) {
                    $ovMax = $os[$j];
                    $cluster = $hasil['kluster'];
                    // $cluster = $hasil['kluster'][$hasil['overallSimilarity']['kluster']];
                    // $clusterInduk = $hasil['kluster'][$hasil['induk']];
                }elseif ($os[$j]>$ovMax) {
                    $ovMax = $os[$j];
                    $cluster = $hasil['kluster'];
                    // $cluster = $hasil['kluster'][$hasil['overallSimilarity']['kluster']];
                    // $clusterInduk = $hasil['kluster'][$hasil['induk']];
                }

                // print_r($hasil['kluster']);
                // echo "<br><br>";
                // print_r($hasil['overallSimilarity']);
                // echo "<br><br><br>";
            }
            echo "===========hasil===========<br>";
            print_r($ovMax);
                // echo "<br><br><br> kluster yang memiliki anggota terbanyak  : ";
            if (count($cluster[0])>count($cluster[1])) {
                $clusterFix[$i] = $cluster[1];
                $clusterInduk = $cluster[0];
                    // print_r($cluster[0]);
            } else {
                $clusterFix[$i] = $cluster[0];
                $clusterInduk = $cluster[1];
                    // print_r($cluster[1]);
            }
            echo "<br><br> kluster terpilih : ";
            print_r($clusterFix[$i]);
            echo "<br><br><br> ";
            if ($i==($k-1)) {
                print_r( $clusterInduk);
            }
                // print_r($clusterInduk);
        }

    }

        // ================cosine similarity=======================
    public function distance( $doks,$centroid,$dimensi, $tfidf){

        //panjang vector 
        $innerPoint = array();
        foreach ($doks as $dok) {
            for ($i=0; $i < $dimensi; $i++) { 
                $innerPoint[$dok][] = $tfidf[$i][$dok]*$tfidf[$i][$dok];
            }
        }

        $innerCen = array();

        for ($i=0; $i <count($centroid); $i++) { 
            for ($j=0; $j < $dimensi; $j++) { 
                $innerCen[$i][] = $centroid[$i][$j]*$centroid[$i][$j];
            }
        }

        //dot product
        $x=0;
        $dotP = array();
        foreach ($centroid as $c) {
            for ($i=0; $i < $dimensi; $i++) { 
                foreach ($doks as $dok) {
                    $dotP[$x][$dok][] = $c[$i]*$tfidf[$i][$dok];
                }
            }$x++;
        }

        //cosine similarity
        $cosine = array();
        for ($i=0; $i < 2; $i++) { 
            foreach ($doks as $dok) {
                $cosine[$dok][$i] = array_sum($dotP[$i][$dok])/(sqrt(array_sum($innerCen[$i]))*sqrt(array_sum($innerPoint[$dok])));
            }
        }

        return $cosine;
    }

    //=========================Clustering=================
    public function k_means1($daftarDok,$dimensi,$bobot){

        //menentukan 2 centroid secara acak     
        $numbers = range(0, (count($daftarDok)-1));
        shuffle($numbers);

        for ($x=0; $x<2; $x++){ 
            $centroid[$x] = $daftarDok[$numbers[$x]];
        }

        $d = $this->distance($daftarDok,$centroid,$dimensi,$bobot);
            
            foreach ($daftarDok as $point) { 
                $nokluster = array_search(max($d[$point]), $d[$point]);
                $kluster[$nokluster][] =  $point;
            }

        //centroid selanjutnya
            $statusAkhir = false;
            $klusterLama   = $kluster;

            while ($statusAkhir==false) {
                for ($i=0; $i < 2; $i++) { 
                    $totalanggota = count($klusterLama[$i]);
                    for ($j=0; $j < $dimensi; $j++) { 
                        $total = 0;
                        foreach ($klusterLama[$i] as $value) {;
                            $total += $bobot[$j][$value];
                        }
                        $centroid[$i][$j]=$total/$totalanggota; 
                    }
                }

                $d = $this->distance($daftarDok,$centroid,$dimensi,$bobot);

                foreach ($daftarDok as $point) { 
                    $nokluster = array_search(max($d[$point]), $d[$point]);
                    $klusterBaru[$nokluster][] =  $point;
                }

                if ($klusterLama==$klusterBaru) {
                    $statusAkhir=true;
                } else {
                    $klusterLama=$klusterBaru;
                }
            } 

            $os=array();
            for ($i=0; $i < 2; $i++) { 
                for ($j=0; $j < $dimensi; $j++) { 
                    $innerCen[$i][] = $centroid[$i][$j]*$centroid[$i][$j];
                }
                $os[$i] = sqrt(array_sum($innerCen[$i])) * sqrt(array_sum($innerCen[$i]));
            }
            if ($os[0]>$os[1]) {
                $overallSimilarity['kluster'] = 0;
                $overallSimilarity['nilai'] = $os[0];
                $hasil['induk'] = 1;
            } else {
                $overallSimilarity['kluster'] = 1;
                $overallSimilarity['nilai'] = $os[1];
                $hasil['induk'] = 0;
            }
            

            $hasil['overallSimilarity'] = $overallSimilarity;
            $hasil['kluster'] = $klusterBaru;
            $hasil['centroid'] = $centroid;
            
            return $hasil;
        }



    public function k_means(){
        $dok = Dok::select('idDok','w')->get()->toArray();
        $doks = array();
        foreach ($dok as $d) {
            $kata = DetailKata::where('idDok','=',$d['idDok'])->pluck('kata')->toArray();
            $tfidf = DetailKata::where('idDok','=',$d['idDok'])->pluck('w')->toArray();
            $doks[$d['idDok']]['inner'] = $d['w'];
            $doks[$d['idDok']]['kata']  = array_combine($kata, $tfidf);
            $doks[$d['idDok']]['list']  = $kata;
        }

        $k=4;
        $daftarDok = array_column($dok, 'idDok');
        $kondisiAwal = true;
        $clusterAkhir = 0;
        $clusterFix = array();
        $iter = 2;
        $clusterInduk = $daftarDok;

        // for ($i=1; $i < $k; $i++) { 
        //     for ($j=0; $j < $iter; $j++) { 
            /*---proses bisecting k-means---*/
            //menentukan 2 centroid secara acak     
                $numbers = range(0, (count($clusterInduk)-1));
                shuffle($numbers);

                for ($x=0; $x<2; $x++){ 
                    $centroid[$x] = $clusterInduk[$numbers[$x]];
                }
                $d = $this->cosineSimilarity($clusterInduk,$centroid,$doks);

                foreach ($clusterInduk as $point) { 
                    $nokluster = array_search(max($d[$point]), $d[$point]);
                    $kluster[$nokluster]['member'][] =  $point;
                    $kluster[$nokluster]['cs'][] =  $d[$point][$nokluster];
                }

                $statusAkhir = false;
                $klusterLama   = $kluster;

                while ($statusAkhir==false) {
                    foreach ($kluster as $key => $value) {
                        $totalanggota = count($kluster[$key]['member']);
                        $total = 0;
                        foreach ($doks[$value]['list'] as $term) {
                            $total += $bobot[$j][$value];
                        }
            $doks[$d['idDok']]['inner'] = $d['w'];
            $doks[$d['idDok']]['kata']  = array_combine($kata, $tfidf);
            $doks[$d['idDok']]['list']  = $kata;
                        $centroid[$i][$j]=$total/$totalanggota;
                    }

                    $d = $this->distance($daftarDok,$centroid,$dimensi,$bobot);
                    $d = $this->cosineSimilarity($clusterInduk,$centroid,$doks);

                    foreach ($daftarDok as $point) { 
                        $nokluster = array_search(max($d[$point]), $d[$point]);
                        $klusterBaru[$nokluster][] =  $point;
                    }

                    if ($klusterLama==$klusterBaru) {
                        $statusAkhir=true;
                    } else {
                        $klusterLama=$klusterBaru;
                    }
                } 

                // pengujian

                /*variabilitas dari 2 cluster*/
                $v=0;$varian=array();
                foreach ($kluster as $nokluster=>$k) {
                    $mean = array_sum($k['cs'])/count($k);
                    foreach ($k['cs'] as $z) {
                        $v += pow(($z-$mean),2);
                    }
                    $varian[$nokluster] = sqrt($v/count($k['member']));
                }
                
                /*pemilihan berdasarkan variablitas*/
                if ($varian[$centroid[0]]>$varian[$centroid[1]]) {
                    $clusterFix     = $kluster[$centroid[0]]['member']; //cluster dengan varian lbh besar disimpan
                    $clusterInduk   = $kluster[$centroid[1]]['member'];
                } else {
                    $clusterFix     = $kluster[$centroid[1]]['member']; 
                    $clusterInduk   = $kluster[$centroid[0]]['member'];
                }
                
                // print_r($clusterFix);echo "</br></br>";
                // print_r($clusterInduk);echo "</br></br>";
                // /*pemilihan berdasarkan overall similaritiy*/ 
                // if ($doks[$centroid[0]]['inner']>$doks[$centroid[1]]['inner']) {
                //     $cd     = $kluster[$centroid[0]]['member']; //cluster dg overallsim lbh besar disimpan
                //     $mk   = $kluster[$centroid[1]]['member'];
                // } else {
                //     $cd     = $kluster[$centroid[1]]['member']; 
                //     $mk   = $kluster[$centroid[0]]['member'];
                // }
                
                // print_r($cd);echo "</br></br>";
                // print_r($mk);echo "</br></br>";

        //     }
        // }
        

    }

    public function cosineSimilarity($daftarDok,$centroid,$doks){
        /*dot product*/
        $x=0;
        $dotP = array();
        foreach ($centroid as $c) {
            foreach ($daftarDok as $d) {
                $sameWord = array_intersect($doks[$c]['list'],$doks[$d]['list'] );
                foreach ($sameWord as $term) {
                    $dotP[$c][$d][] = $doks[$c]['kata'][$term] * $doks[$d]['kata'][$term] ;
                }
            }
            $x++;
        }

        /*cosine similarity*/
        $cosine = array();
        foreach ($centroid as $c) { 
            foreach ($daftarDok as $d) {
                $cosine[$d][$c] = array_sum($dotP[$c][$d])/(sqrt($doks[$d]['inner']))*sqrt($doks[$c]['inner']);
            }
        }

        return $cosine;
        
    }
    public function cek(){
        $kata = DetailKata::where('idDok','=',53)->orWhere('idDok','=',63)->orWhere('idDok','=',80)->pluck('kata')->toArray();
        $katas = array_count_values($kata);
        foreach ($katas as $key => $value) {
            if ($value>1) {
                echo "<br>> ".$key;
                echo " = ".$value;
            }
        }
        
    }



}
