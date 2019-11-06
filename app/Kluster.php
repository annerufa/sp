<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kluster extends Model
{
	protected $table = 'kluster';
    protected $fillable = [
    	'topik','listDok','variabilitas','similaritas'
    ];
    protected $primaryKey = 'idCluster';

}
