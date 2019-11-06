<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dok extends Model
{
	protected $table = 'dok';
    protected $fillable = [
    	'judul','penulis','date','idFakultas','keywords','abstrak','hasilPre','totKata'
    ];
    protected $primaryKey = 'idDok';

    public function fakultas(){
		return $this->belongsTo(Fakultas::class, 'idFakultas');
	}
}
