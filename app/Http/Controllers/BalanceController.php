<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function index(){
        $data=Balance::all();
        return view("Master_Admin.Balance.balance",["data"=>$data]);

    }
}
