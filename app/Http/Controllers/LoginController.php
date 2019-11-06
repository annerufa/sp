<?php

namespace App\Http\Controllers;

use App\Kata;
use App\Dok;
use App\DetailKata;
use Illuminate\Http\Request;

class LoginController extends Controller
{

	public function index()
	{
		return view('home')->with(["page" => "home"]);
	}
}