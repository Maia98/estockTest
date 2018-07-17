<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
//use App\Permission;
use DB;

class FuncaoController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('CONSULTAR_FUNCAO');
        $roles = Role::all();
        $filter = $request->input('filter');
        $roles = Role::orderBy('id');

        if($filter){
            $roles->where("name", "ilike", "%$filter%")->orWhere("description", "ilike", "%$filter%");
        }

        $roles = $roles->paginate(10);

        return view('pages.funcoes.index', compact('roles'));
    }

    public function create()
    {
        $this->authorize('CADASTRAR_FUNCAO');
        $permissoes = arrayToSelect(Permission::select('id', 'name')->get()->toArray(), 'id', 'name');
        
        return view('pages.funcoes.form', compact('permissoes'));
    }

    public function store(Request $request)
    {
        $this->authorize('CADASTRAR_FUNCAO');
        $result = DB::transaction(function () use ($request) {

            try{

                $id = $request->input('id');

                $funcao = Role::find($id);
                if(!$funcao)
                {
                    $funcao = new Role();
                }

                $funcao->name = $request->input('name');
                $funcao->description = $request->input('description');

                $validade = validator($funcao->toArray(), $funcao->rules(), $funcao->msgRules);

                if($validade->fails())
                {
                    return response()->json(['success' => false, 'msg' => arrayToValidator($validade->getMessageBag())]);
                }

                $permissoes = $request->input('permissoes');

                if($permissoes == null)
                {
                    return ['success' => false, 'msg' => 'Permissão não preenchida!'];
                }

                $saveRole = $funcao->save();

                if($saveRole)
                {

                    if($permissoes)
                    {
                        $permissoes = json_decode($permissoes);

                        for($i=0;$i<sizeof($permissoes);$i++)
                        {
                            if($permissoes[$i]->id == 0){

                                DB::table('permission_role')->insert(['permission_id' => $permissoes[$i]->permissao, 'role_id' => $funcao->id]);
                            }else if($permissoes[$i]->deletar && $permissoes[$i]->id > 0)
                            {
                                DB::table('permission_role')->where('id', $permissoes[$i]->id)->delete();
                            }
                        }
                    }

                    return ['success' => true, 'msg' => 'Função salva com sucesso!'];

                }else{

                    throw new \Exception('Erro ao salvar Função!');
                }

            }catch(\Exception $exc)
            {
                return ['success' => false, 'msg' => $exc->getMessage()];
            }
        });

        return $result;
    }

    public function edit(Role $funcao)
    {
        $this->authorize('CADASTRAR_FUNCAO');
        $permissoes = arrayToSelect(Permission::select('id', 'description')->get()->toArray(), 'id', 'description');
        
        return view('pages.funcoes.form', compact('permissoes', 'funcao'));
    }

    public function getPermissoes($role)
    {
        return DB::table('permission_role')
                ->join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
                ->select('permission_role.id', 'permission_role.permission_id', 'permissions.description')
                ->where('permission_role.role_id', $role)
                ->get();
    }
//
//    public function delete(Role $funcao)
//    {
//        return view('pages.funcoes.delete', compact('funcao'));
//    }
//
//    public function destroy(Request $request)
//    {
//        try{
//            $result = DB::transaction(function () use ($request) {
//
//                $id = $request->input('id');
//
//                if($id)
//                {
//                    DB::table('permission_role')->where('role_id', $id)->delete();
//                    DB::table('roles')->where('id', $id)->delete();
//
//                    notify()->flash('Função excluida com sucesso.', 'success');
//                }else{
//                    notify()->flash('Código da função invalido.', 'danger');
//                }
//            });
//
//        } catch(\Exception $exc) {
//            notify()->flash('Erro ao excluir função.', 'danger');
//        } finally {
//            return redirect()->action('FuncaoController@index');
//        }
//    }
}
