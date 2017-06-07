<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Método inicial da Classe
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (session()->get('cpf')){
            return redirect()->route('register.home');
        }else{
            return view('index');
        }
    }


    public function postUser(Request $request)
    {

        $request->session()->put('cpf',$request->cpf);
        $request->session()->put('ip',$this->getIpFull());

        return redirect()->route('register.home');
    }

    public function getIpFull()
    {
        $externalContent = file_get_contents('http://checkip.dyndns.com/');
        preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
        $externalIp = $m[1];
        return $externalIp;
    }

}
