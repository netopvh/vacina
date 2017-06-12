<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use PulkitJalan\GeoIP\GeoIP;

class RegisterController extends Controller
{
    public $geoIp;

    public function __construct(GeoIP $geoIP)
    {
        $this->middleware('user');
        $this->geoIp = $geoIP;
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
                'svcolaborador.FOLHA',
                'svcolaborador.CDFILIAL',
                'svcolaborador.DEPENDENTE',
                'svcolaborador.ADERIR'
            )
            ->get()->first();


        $dependentes = DB::table('svdependente')
            ->where('COLABORADOR', $funcionario->CODIGO)
            ->select('CODIGO','NOME','IDADE')
            ->get();

        $unidades = DB::table('filial')
            ->where('STATUS','A')
            ->select('CODIGO as cod','NMFILIAL as filial')
            ->get();

        $this->sessionUnidade('unidade',$funcionario->CDFILIAL);

        return view('home', compact('funcionario','dependentes','unidades'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAtualiza($id, Request $request)
    {
        //insere a unidade na sessão
        $this->sessionUnidade('unidade',$request->unidade);

        DB::table('svcolaborador')
            ->where('CODIGO', $id)
            ->update([
                'FOLHA' => $request->folha,
                'CDFILIAL' => $request->unidade,
                'DEPENDENTE' => $request->dependente
                ]);

        return redirect()->route('register.home');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDependente(Request $request)
    {

        if (!$this->getColabAtualizado(session('cpf'))){
            $request->session()->flash('error', 'Atenção! É obrigatório atualizar informações do colaborador!');
            return redirect()->route('register.home');
        }

        if ($request->idade < 12){
            $request->session()->flash('error', 'Atenção! Permitido apenas para maiores de 12 anos!');
        }else{
            $colab = DB::table('svcolaborador')
                ->select(DB::raw("(case when count(svcolaborador.CODIGO) >= svmeta.QTTRI then 'S' else 'N' end) as meta"))
                ->join('svmeta','svmeta.CDUNIDADE','=','svcolaborador.CDFILIAL')
                ->where('svcolaborador.CDFILIAL',session('unidade'))
                ->groupBy('svmeta.QTTRI')
                ->get()->first();

            if ($colab->meta == 'S'){
                $request->session()->flash('error', 'Atenção! Meta de Vacina atingida');
                return redirect()->route('register.home');
            }else{
                DB::table('svdependente')->insert([
                    'NOME' => strtoupper($request->nome),
                    'IDADE' => $request->idade,
                    'COLABORADOR' => $request->codigo
                ]);
            }
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

    /**
     * @param $id
     * @return mixed
     */
    public function generatePdf($id)
    {
        $this->geoIp->setIp(file_get_contents('http://bot.whatismyipaddress.com/'));

        if (!$this->getColabAtualizado(session('cpf'))){
            session()->flash('error', 'Atenção! É obrigatório atualizar informações do colaborador!');
            return redirect()->route('register.home');
        }


        $funcionario = DB::table('svcolaborador')
            ->join('coempresa','svcolaborador.CDCASA','=','coempresa.CODIGO')
            ->where('svcolaborador.CODIGO', $id)
            ->select(
                'svcolaborador.CODIGO',
                'svcolaborador.NOME as COLABORADOR',
                'svcolaborador.CPF',
                'svcolaborador.FOLHA',
                'coempresa.RAZAO',
                'svcolaborador.DEPENDENTE'
            )
            ->first();

        $dependente = DB::table('svdependente')
            ->where('COLABORADOR', $funcionario->CODIGO)
            ->select('NOME as nome', 'IDADE as idade')
            ->get()->toArray();

        if (count($dependente) < 1){
            session()->flash('error', 'Atenção! É obrigatório cadastrar ao menos um dependente');
            return redirect()->route('register.home');
        }

        $data = [
            'cidade' => $this->geoIp->getCity(),
            'colaborador' => $funcionario->COLABORADOR,
            'cpf' => $funcionario->CPF,
            'casa' => $funcionario->RAZAO,
            'folha' => $funcionario->FOLHA,
            'filhos' => $funcionario->DEPENDENTE,
            'dependentes' => $dependente
        ];

        $this->colabAderir(session('cpf'));

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
        $request->session()->forget('unidade');
        $request->session()->flush();

        return redirect()->route('index');
    }

    /**
     * @param $id
     * @return bool
     */
    public function getColabAtualizado($id)
    {
        $colab = DB::table('svcolaborador')
            ->where('CPF',$id)
            ->get()->first();
        if (is_null($colab->FOLHA) && is_null($colab->CDFILIAL)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * @param $sessao
     * @param $value
     */
    public function sessionUnidade($sessao, $value)
    {
        if (!session($sessao)){
            session()->put($sessao,$value);
        }else{
            session()->forget($sessao);
            session()->put($sessao, $value);
        }
    }

    /**
     * @param $cpf
     */
    public function colabAderir($cpf)
    {
        DB::table('svcolaborador')->where('cpf', $cpf)->update(['ADERIR' => 'S']);
    }

    public function colabCancela($id)
    {
        DB::table('svcolaborador')->where('CODIGO',$id)->update(['ADERIR' => 'N']);
        DB::table('svdependente')->where('COLABORADOR',$id)->delete();

        session()->forget('cpf');
        session()->flush();
        session()->forget('unidade');
        session()->flush();

        return redirect()->route('index');
    }
}
