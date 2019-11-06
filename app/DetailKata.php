<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailKata extends Model
{
	protected $primaryKey = null;

	protected $table = 'detailKata';

    protected $fillable = [
    	'kata','idDok','tf','tfidf'
    ];

    public $timestamps = false;
    public $incrementing = false;

    public function dok()
	{
		return $this->belongsTo(Dok::class, 'idDok');
	}

	public function kata()
	{
		return $this->belongsTo(Kata::class, 'kata');
	}
}    
