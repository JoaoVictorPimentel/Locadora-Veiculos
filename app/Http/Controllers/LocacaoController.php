<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use App\Http\Requests\StoreLocacaoRequest;
use App\Http\Requests\UpdateLocacaoRequest;
use App\Repositories\LocacaoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LocacaoController extends Controller
{
    protected $locacao;

    public function __construct(Locacao $locacao) {
        $this->locacao = $locacao;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $locacaoRepository = new LocacaoRepository($this->locacao);

        if($request->has('filtro')) {
            $locacaoRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $locacaoRepository->selectAtributos($request->atributos);
        } 

        return response()->json($locacaoRepository->getResultado(), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocacaoRequest $request)
    {
        try {
            $locacao = $this->locacao->create([
                'cliente_id' => $request->cliente_id,
                'carro_id' => $request->carro_id,
                'data_inicio_periodo' => $request->data_inicio_periodo,
                'data_final_previsto_periodo' => $request->data_final_previsto_periodo,
                'data_final_realizado_periodo' => $request->data_final_realizado_periodo,
                'valor_diaria' => $request->valor_diaria,
                'km_inicial' => $request->km_inicial,
                'km_final' => $request->km_final
            ]);
    
            return response()->json($locacao, 201);
        } catch (Exception $e) {
            return response()->json(['msg' => 'Erro ao cadastar nova locação!']);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $locacao = $this->locacao->find($id);
        if($locacao === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404) ;
        } 

        return response()->json($locacao, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $locacao = $this->locacao->find($id);

        if($locacao === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($locacao->rules() as $input => $regra) {
                
                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            
            $request->validate($regrasDinamicas);

        } else {
            $request->validate($locacao->rules());
        }
        
        $locacao->fill($request->all());
        $locacao->save();
        
        return response()->json($locacao, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $locacao = $this->locacao->find($id);

        if($locacao === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        $locacao->delete();
        return response()->json(['msg' => 'A locação foi removida com sucesso!'], 200);
    }
}
