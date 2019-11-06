<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $fillable = [
    	'namaFakultas'
    ];
    protected $primaryKey = 'idFakultas';
    
}
