<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

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



        if (!$this->existsUser($request->cpf)){
            $request->session()->flash('error', 'Colaborador não localizado');
            return redirect()->route('index');
        }else{
            session()->put('cpf',$request->cpf);
            return redirect()->route('register.home');
        }
    }

    public function existsUser($cpf)
    {
        $colaborador = DB::table('svcolaborador')
            ->where('CPF',$cpf)
            ->get();

        if (count($colaborador) >= 1){
            return true;
        }else{
            return false;
        }
    }

}
