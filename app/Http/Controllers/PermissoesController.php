<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use DB;
use DebugBar;

class PermissoesController extends Controller
{
    public function index(Request $request)
    {
        $permissoes = Permission::all();

        $filter = $request->input('filtro_input');

        $result = Permission::orderBy('name');

        if($filter){
            $filter_like = "%".$filter."%";

            $result = $result->where('name','ilike', $filter_like)
                ->orWhere('description','ilike',$filter_like);
        }

        $result = $result->paginate(10);

        return view('pages.permissoes.index', compact('result', 'filter'));
    }

    public function create()
    {
        return view('pages.permissoes.form');
    }

    public function store(Request $request)
    {
        $id = $request->input('id');


        $permissao = Permission::find($id);
        if(!$permissao)
        {
            $permissao = new Permission();
        }

        $validade = validator($request->all(), $permissao->rules(), $permissao->mensages);
        if($validade->fails())
        {
            return response()->json(['success' => false, 'msg' => arrayToValidator($validade->errors())]);
        }

        $permissao->description = $request->input('description');

        $save = $permissao->save();

        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Permissão salva com sucesso!']);
        }else{
            return response()->json(['success' => true, 'msg' => 'Erro ao salvar permissão!']);
        }
    }

    public function edit(Permission $permissao)
    {
        return view('pages.permissoes.form', compact('permissao'));
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->input('id');

            $permissao = Permission::find($id);
            if($permissao)
            {
                DB::table('permission_role')->where('permission_id', $id)->delete();
                $permissao->delete();

                return response()->json(['success' => true, 'msg' => 'Permissão excluída com sucesso!']);

            }else{
                return response()->json(['success' => false, 'msg' => 'Não foi possivel excluir a permissão!']);
            }
        }catch(Exception $exp) {
            DebugBar::info($exp);
            return response()->json(['success' => false, 'msg' => 'Erro ao excluir permissão!']);
        }
    }
}
