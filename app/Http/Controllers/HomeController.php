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

        $colaborador = DB::table('svcolaborador')
            ->where('CPF',$request->cpf)
            ->get();

        if (count($colaborador) < 1){
            $request->session()->flash('error', 'Colaborador não localizado');
            return redirect()->route('index');
        }else{
            session()->put('cpf',$request->cpf);
            return redirect()->route('register.home');
        }
    }

}
