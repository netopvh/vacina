<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $cpf = trim($request->session()->get('cpf'));
        $funcionario = DB::table('svcolaborador')
            ->join('coempresa', 'svcolaborador.CDCASA', '=', 'coempresa.CODIGO')
            ->where('svcolaborador.CPF', $cpf)
            ->select(
                'svcolaborador.CODIGO',
                'svcolaborador.NOME',
                'svcolaborador.CPF',
                'coempresa.RAZAO',
                'svcolaborador.FOLHA'
            )
            ->get()->first();


        $dependentes = DB::table('svdependente')
            ->where('COLABORADOR', $funcionario->CODIGO)
            ->select('CODIGO','NOME','IDADE')
            ->get();

        return view('home', compact('funcionario','dependentes'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAtualiza($id, Request $request)
    {
        DB::table('svcolaborador')->where('CODIGO', $id)->update(['FOLHA' => $request->get('folha')]);

        return redirect()->route('register.home');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDependente(Request $request)
    {

        if ($request->idade < 12){
            $request->session()->flash('error', 'Atenção! Permitido apenas para maiores de 12 anos!');
        }else{
            DB::table('svdependente')->insert([
                'NOME' => $request->nome,
                'IDADE' => $request->idade,
                'COLABORADOR' => $request->codigo
            ]);
        }

        return redirect()->route('register.home');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDependente($id)
    {
        DB::table('svdependente')->where('CODIGO',$id)->delete();

        return redirect()->route('register.home');
    }

    public function generatePdf($id)
    {
        $funcionario = DB::table('svcolaborador')
            ->join('coempresa','svcolaborador.CDCASA','=','coempresa.CODIGO')
            ->where('svcolaborador.CODIGO', $id)
            ->select(
                'svcolaborador.CODIGO',
                'svcolaborador.NOME as COLABORADOR',
                'svcolaborador.CPF',
                'svcolaborador.FOLHA',
                'coempresa.RAZAO'
            )
            ->first();

        $dependente = DB::table('svdependente')
            ->where('COLABORADOR', $funcionario->CODIGO)
            ->select('NOME as nome', 'IDADE as idade')
            ->get()->toArray();

        $data = [
            'colaborador' => $funcionario->COLABORADOR,
            'cpf' => $funcionario->CPF,
            'casa' => $funcionario->RAZAO,
            'folha' => $funcionario->FOLHA,
            'dependentes' => $dependente
        ];

        //dd($data);
        $pdf = Pdf::loadView('termo',$data);
        return $pdf->stream('termo.pdf');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $request->session()->forget('cpf');
        $request->session()->flush();

        return redirect()->route('index');
    }
}
