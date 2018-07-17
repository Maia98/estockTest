<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TipoSetorObra;

class TipoSetorObraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('CONSULTAR_TABELAS_SISTEMA');

        $filter = $request->input('filtro_input');

        $result = TipoSetorObra::orderBy('id');

        if($filter){
            $filter_like = "%".$filter."%";
            
            $result = $result->where('descricao','ilike',$filter_like);
        }

        $result = $result->paginate(10);

        return view('pages.tipo-setor-obra.index', compact('result', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

       return view('pages.tipo-setor-obra.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        $id = $request->input('id');

        $tipoSetorObra = TipoSetorObra::find($id);

        if(!$tipoSetorObra){
            $tipoSetorObra = new TipoSetorObra();
        }

        $tipoSetorObra->fill($request->all());

        $validade = validator($request->all(), $tipoSetorObra->rules(), $tipoSetorObra->msgRules);

        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
        }

        $save = $tipoSetorObra->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Tipo Setor Obra com sucesso.', 'result' => $tipoSetorObra]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar Tipo Setor Obra.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoSetorObra $tipoSetorObra)
    {
        $this->authorize('CADASTRAR_TABELAS_SISTEMA');

        return view('pages.tipo-setor-obra.form', compact('tipoSetorObra'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function delete(TipoSetorObra $tipoSetorObra)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        return view('pages.tipo-setor-obra.delete', compact('tipoSetorObra'));
    }



    public function destroy(Request $request)
    {
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        $id = $request->input('id');

        try {
            $detete = \DB::table('tipo_setor_obra')
                           ->where('id', $id)
                           ->delete();

            if($detete)
            { 
                 notify()->flash('Tipo Setor Obra com sucesso.', 'success');
            }else{
                 notify()->flash('Erro ao excluir Tipo Setor Obra.', 'danger');
            }
        } catch (\Exception $exc) {
            if( $exc->getCode() == 23503) {
                    
                 notify()->flash('Não é permitido excluir Tipo Setor Obra em uso.', 'danger');
        
            }else{
        
                 notify()->flash('Erro ao excluir Tipo Setor Obra.', 'danger');
            }
        } finally {
            return redirect()->action('TipoSetorObraController@index');  
        }  
    }

    public function exportarExcel(Request $request)
    {
        
        $data = TipoSetorObra::select('id as Id', 'descricao as Descrição')
                               ->orderBy('id')
                               ->get()
                               ->toArray();

        return \Excel::create('export_tipo_setor_obra', function($excel) use ($data) {
            $excel->sheet('Plan 1', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download('xlsx');
    }
}
