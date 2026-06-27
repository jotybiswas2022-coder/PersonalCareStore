<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class SiteController extends Controller
{
    public function index(){
        $account = Account::first(); 
        return view('frontend.index', compact('account'));
    }
}
