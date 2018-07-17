<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Obra;
use App\User;
use App\Model\Regional;

class GerencialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('CONSULTAR_GERENCIAL');
        $user = \Auth::user();
        $data_inicio_filtro = $request->input('data_inicio');
        $data_fim_filtro = $request->input('data_fim');

        if(empty($data_inicio_filtro) && empty($data_fim_filtro) && empty($user->data_inicio_filtro) && empty($user->data_fim_filtro)){
            $data_inicio_filtro = date('Y-m-d');
            $data_fim_filtro = date("Y-m-d",strtotime("+30 day",strtotime("now")));
        }else if(empty($data_inicio_filtro) && empty($data_fim_filtro) && !empty($user->data_inicio_filtro) && !empty($user->data_fim_filtro)){
            $data_inicio_filtro = $user->data_inicio_filtro;
            $data_fim_filtro = $user->data_fim_filtro;
        }

        return view('pages.gerencial.index', compact('user', 'data_inicio_filtro', 'data_fim_filtro'));
    }


    public function obraPorStatus(Request $request)
    {
        try {
            $dataInicio = $request->input('data_inicio');
            $dataFim = $request->input('data_fim');
            $result = '';
            $dataObraStatus = Obra::select(\DB::raw('status_obra.nome, COUNT(obra.tipo_status_obra_id) as count_status_obra'))
                                ->join('status_obra', 'obra.tipo_status_obra_id', '=', 'status_obra.id')
                                ->whereBetween('data_recebimento', [[$dataInicio], [$dataFim]])
                                ->groupBy('obra.tipo_status_obra_id', 'status_obra.nome')
                                ->get();
            
            if(count($dataObraStatus) > 0){
                $result = json_encode($dataObraStatus);
                return response()->json(['success' => true, 'msg' => 'Carregado com suceso.', 'result' => $result]);
            }else{
                throw new \Exception('Não foi encontrado nenhum dado para este filtro.');
            }

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }

    }    


    public function obraPorRegional(Request $request)
    {
         try {
            $dataInicio = $request->input('data_inicio');
            $dataFim = $request->input('data_fim');

            
            $result = Regional::regionalPorStatus($dataInicio, $dataFim);

            if(count($result) > 0){
                return response()->json(['success' => true, 'msg' => 'Carregado com suceso.', 'result' => $result]);
            }else{
                throw new \Exception('Não foi encontrado nenhum dado para este filtro.');
            }


        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function obraPorValorOracado(Request $request)
    {
        try {
            $dataInicio = $request->input('data_inicio');
            $dataFim = $request->input('data_fim');

            $result = Obra::select('obra.numero_obra', 'obra.valor_orcado')
                        ->whereBetween('data_recebimento', [[$dataInicio], [$dataFim]])
                        ->where('obra.valor_orcado', '>', 0)
                        ->orderBy('obra.valor_orcado','desc')
                        ->get();

            if(count($result) > 0){
                return response()->json(['success' => true, 'msg' => 'Carregado com suceso.', 'result' => $result]);
            }else{
                throw new \Exception('Não foi encontrado nenhum dado para este filtro.');
            }
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }    


    public function storeFilterUsuario(Request $request)
    {
        try {
            $dataInicio = $request->input('data_inicio');
            $dataFim = $request->input('data_fim');

            if(!empty($dataInicio) && !empty($dataFim)){
                
                $usuario = User::find(\Auth::user()->id);
                $usuario->data_inicio_filtro = $dataInicio;
                $usuario->data_fim_filtro = $dataFim;
                $usuario->save();

                return response()->json(['success' => true, 'msg' => 'Datas do filtro salvo com sucesso.']);
            }else{
                throw new \Exception('Não foi possivel salvar as datas do filtro.');
            }
            

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

}
