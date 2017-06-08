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

        session()->put('cpf',$request->cpf);

        return redirect()->route('register.home');
    }

}
