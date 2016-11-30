<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function test(Request $request)
    {
        //$_SESSION['test'] = 'Testing passing angular session to nodejs';
        //dd($_SESSION);
        $testString = 'Node should recieve this';
        if(!$request->session()->has('test'))
            $request->session()->put('test', $testString); 

        dd($request->session());
        dd($request->session()->get('test'));
    } 

}
