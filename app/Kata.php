<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kata extends Model
{
	protected $table = 'kata';
    protected $fillable = [
    	'kata','totDok','idf'
    ];
    protected $primaryKey = 'kata';

    public $incrementing = false;
    public $timestamps = false;
}
