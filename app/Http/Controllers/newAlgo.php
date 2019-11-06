<?php

namespace App\Http\Controllers;

use App\Kata;
use App\KLuster;
use App\Dok;
use App\DetailKata;
use Illuminate\Http\Request;

class newAlgo extends Controller
{
    public function index()
    {
        $data['kluster'] = Kluster::get();
        $data['dok'] = Dok::select('idDok','judul')->get();
        if (count($data['kluster'])==0) {
            $data['status']  = 'false';
        } else {
            $data['status']  = 'true';
        }
        
        return view('cluster',compact('data'))->with(["page" => "cluster"]);
    }

    public function kel(Request $request)
    {
        $k = $request->k;
        $iter = $request->iter;
		$start      = microtime(TRUE); 
        $doks       = Dok::select('idDok','abstrak','hasilPre','totKata')->get();
		$title    	= Dok::pluck('judul')->toArray();
		$totDok     = count($doks);

     	// nilai tf dan tf-idf

        // idf
		$termList   = Kata::all();
		foreach ($termList as $key => $t) {
			$idf[$t->kata] =  $t->idf;
			$term[] = $t->kata;
		}
		//tf
		$daftarDok=array();
		foreach ($doks as $key => $dok) {
			$daftarDok[]=$dok->idDok;
			$dat = explode(' ',$dok->hasilPre);
            $daftarKata	= array_count_values($dat);
            $kata       = array_keys($daftarKata);

			foreach ($kata as $t) {
				$tf[$t][$dok->idDok] = $daftarKata[$t]/$dok->totKata;
			}
		}
        $dokumen = array_combine($daftarDok, $title);

        //hitung tf-idf
		$nt =0;
		$s=0;
		foreach ($daftarDok as $key => $value) {
            // echo "========================================================== <br><br>idDok = ".$value."<br> tf-idf <br>";
			foreach ($term as $t) {
				if (isset($tf[$t][$value])) {
					$bobot[$value][$t] = $tf[$t][$value] * $idf[$t];
					$nt++;
				}else{
					$bobot[$value][$t] =0;
				}
                    // echo "<br>".$bobot[$value][$t];
			}
			$s++;
		}
		
        // ------clustering-----------
		// $k= count($doks)*count($term)/$nt; echo "nt = ".$nt." k = ".$k;
		// $dimensi = count($term);
		$cluster = array();
		$clusterList = array();
		// $iter = 5;
        // $k=round(sqrt(count($doks)/2));
        // $k=8;
        $kluster = array();
        $varCluster = array();
        $overCluster = array();
		$highOver = array();
		$clusterInduk = $daftarDok;
        $q=0;

		for ($i=1; $i < $k; $i++) {  
            // echo "<br><br>k = ".$i." -=-=----================----------------<br>";
          /*K-means sebanyak ITER perulangan*/
            for ($j=0; $j < $iter ; $j++) {
                $cluster[$j] = $this->k_means($clusterInduk,$term,$bobot);
                // $cluster[$j]= $kluster;
                $lowVar[$j] = $cluster[$j]['minVar']; 
                $highOver[$j] = $cluster[$j]['maxOs']; 
            }
            
          /*Pemilihan cluster terbaik dari ITER perulangan*/
            /*find cluster by lowest variabilitas */
            // $m = array_search(min($lowVar), $lowVar);
            /*find cluster by highest overall similarity */
            $m = array_search(max($highOver), $highOver);
           
          /*tambahkan cluster pilihan ke daftar cluster*/
            for ($a=0; $a < 2 ; $a++) { 
                $clusterList[$q] = $cluster[$m][$a]['member'];
                $varCluster[$q]  = $cluster[$m][$a]['varian'];
                $overCluster[$q] = $cluster[$m][$a]['overall'];
                $nCluster[$q] = count($cluster[$m][$a]['member']);
                $q++;
            }
            $cluster = array();

          /*Pemilihan cluster terburuk yang akan dibagi pada perulangan selanjutnya*/
            /*find cluster by highest variabilitas */
            // $n = array_search(max($varCluster), $varCluster);
            /*find cluster by lowest overall similarity */
            // $n = array_search(min($overCluster), $overCluster);
            /*find cluster by bigest member */
            $n = array_search(max($nCluster), $nCluster);

		  /*jadikan cluster sebagai cluster induk yang akan dibagi dan hapus dari daftar cluster*/    
            $clusterInduk = $clusterList[$n];
            if($i!=($k-1)){
                unset($clusterList[$n]);
                unset($varCluster[$n]);
                unset($overCluster[$n]);
                unset($nCluster[$n]);
            }
		}
        foreach ($clusterList as $key => $c) {
            $data = new KLuster();
            $data->listDok         = implode(" ", $c);
            $data->variabilitas    = $varCluster[$key];
            $data->similaritas     = $overCluster[$key];
            $data->save();
        }
        return redirect()->route('cluster'); 
        // $data['status']  = 'true';
        // $data['dok']  = $dokumen;
        // $data['cluster']  = $clusterList;
        // $data['overSim']    = $overCluster;
        // $data['variabilitas']    = $varCluster;
        // $option['tema'] = 'perhitungan bobot'; 
        // return view('cluster',compact('data','option'))->with(["page" => "cluster"]);
		
        // foreach ($varCluster as $key => $value) { 
        //     echo "<br>cluster - member = ";
        //     print_r($clusterList[$key]);
        //     echo "<br>variablitas = ";
        //     print_r($value);
        //     echo "<br>overall similarity = ";
        //     print_r($overCluster[$key]);
        //     echo "<br>jumlah member = ";
        //     print_r($nCluster[$key]);
        // }
	}



    //=========================K-Means=================
    public function k_means($daftarDok,$term,$bobot){

        /*penentuan centroid pertama*/        
        $numbers = $daftarDok;
        shuffle($numbers);
        // $cent=(array(7, 27));

        for ($x=0; $x<2; $x++){   
            foreach ($term as $key => $value) {
                $centroid[$x][$value] = $bobot[$numbers[$x]][$value];
            } 
        }
        $d = $this->distance($daftarDok,$centroid,$term,$bobot);
        
        foreach ($daftarDok as $point) {
            $nokluster = array_search(max($d[$point]), $d[$point]);
            $klusterLama[$nokluster]['member'][] =  $point;
        }

        //centroid selanjutnya
        $statusAkhir = false;
        while ($statusAkhir==false) {
            /*Penentuan centroid baru*/
            for ($i=0; $i < 2; $i++) { 
                foreach ($term as $t) {
                    $total = 0;
                    foreach ($klusterLama[$i]['member'] as $value) {
                        $total += $bobot[$value][$t];
                    }
                    $centroid[$i][$t]=$total/count($klusterLama[$i]['member']); 
                }
            }

            $d = $this->distance($daftarDok,$centroid,$term,$bobot);
            foreach ($daftarDok as $point) { 
                $nokluster = array_search(max($d[$point]), $d[$point]);
                $klusterBaru[$nokluster]['member'][]     =  $point;
                $klusterBaru[$nokluster]['similarity'][] =  $d[$point][$nokluster];
            }
            /*Membandingkan member cluster yang terbentuk sebelumnya dengan member clusrter baru*/
            $a = array_diff(array_values($klusterLama[0]['member']), array_values($klusterBaru[0]['member']));
            $b = array_diff(array_values($klusterLama[0]['member']), array_values($klusterBaru[1]['member']));
            $ax = count($klusterBaru[0]['member']);
            $bx = count($klusterBaru[1]['member']);
        
            // if (empty($a)||empty($b)&&$klusterBaru[$nokluster]['similarity']) {
            if (($bx>1&&$ax>1)&&(empty($a)||empty($b))) {
                $statusAkhir=true;
            }else {
                // echo "again - ";
                $klusterLama=$klusterBaru;
            }
        } 
        
        /*variabilitas dari 2 cluster*/
        $varian=array();
        foreach ($klusterBaru as $nokluster => $k) {$v=array();
            foreach ($term as $t) {
                $a=0;$n=count($k['member']);
                foreach ($k['member'] as $key => $value) {
                    $a += $bobot[$value][$t];
                }
                $mean[$key][$t] = $a/$n;
            }
            foreach ($term as $t) {$b=0;
                foreach ($k['member'] as $m) {
                    $b += pow($bobot[$m][$t]-$mean[$key][$t],2);
                }
                $v[$t]=$b;
            }
            $klusterBaru[$nokluster]['varian'] = array_sum($v);
        }  

        /*overall similarity dari 2 cluster cara 1*/       
        foreach ($centroid as $no=>$c) {
            foreach ($c as $cen) {
                $innerCen[$no][] = pow($cen, 2); 
            }
            $klusterBaru[$no]['os'] = array_sum($innerCen[$no]);
        }
        /*overall similarity dari 2 cluster cara 2*/ 
        foreach ($klusterBaru as $nok =>$k) {
            $klusterBaru[$nok]['overall'] = array_sum($k['similarity'])/pow(count($k['member']),2);
        }     

        if ($klusterBaru[0]['varian']<$klusterBaru[1]['varian']) {
            $klusterBaru['minVar'] = $klusterBaru[0]['varian'];
        } else {
            $klusterBaru['minVar'] = $klusterBaru[1]['varian'];
        }
        
        if ($klusterBaru[0]['overall']>$klusterBaru[1]['overall']) {
            $klusterBaru['maxOs'] = $klusterBaru[0]['overall'];
        } else {
            $klusterBaru['maxOs'] = $klusterBaru[1]['overall'];
        }

        return $klusterBaru;
    }

        // ================cosine similarity=======================
    public function distance( $doks,$centroid,$term, $tfidf){
        //cosine similarity
        $cosine = array();
        $innerd = array();
        $innerc = array();
        $dotP = array();
        foreach ($centroid as $no=> $c) {
            foreach ($c as $cen) {
                $innerc[$no][] = pow($cen, 2); 
            }
        }
        foreach ($doks as $noD=> $d) {
            foreach ($tfidf[$d] as $dok) {
                $innerd[$d][] = pow($dok, 2); 
            }
        }
        foreach ($centroid as $noC => $ce) {
            foreach ($term as $t ) {
                foreach ($doks as $d) {
                    $dotP[$noC][$d][] = $tfidf[$d][$t]*$ce[$t];
                }
            }
        }
        foreach ($centroid as $key => $value) {
            foreach ($doks as $d) { 
                $cosine[$d][$key] = array_sum($dotP[$key][$d])/(sqrt(array_sum($innerc[$key]))*sqrt(array_sum($innerd[$d])));
            }
        }
        return $cosine;
    }


}