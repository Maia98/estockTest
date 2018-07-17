<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Role;
use DB;
use Exception;

class UsuarioController extends Controller
{
    public function __construct()
    {
        // $this->authorize('sada');
    }

    public function index(Request $request)
    {
        $this->authorize('CONSULTAR_USUARIO');

        $filter = $request->input('filter');

        $usuarios = User::orderBy('id');
        
        if($filter){
            $usuarios = $usuarios->where('name','like', '%'.$filter.'%')
                                 ->orWhere('email','like', '%'.$filter.'%');
        }
        
        $usuarios = $usuarios->paginate(15);
        
        return view('pages.usuarios.index', compact('usuarios', 'filter'));
    }

    public function create()
    {
        $this->authorize('CADASTRAR_USUARIO');
        //tem altorizacao ?
        //$autorizacao = \Auth::user()->can('CONSULTAR_ESTOQUE');

        $funcoes =  arrayToSelect(Role::select('id', 'description')->get()->toArray(), 'id', 'description');
        

        return response()->json([
            'success' => true,
            'result' => view('pages.usuarios.form', compact('funcoes'))->render()
        ]);

    }

    public function store(Request $request)
    {
        $this->authorize('CADASTRAR_USUARIO');
        try{
            $result = DB::transaction(function () use ($request) {

                $id = $request->input('id');
                $password = trim($request->input('password'));
                $repeat_password = $request->input('repeat-password');

                $usuario = User::where('id', $id)->first();

                if (!$usuario){
                    $usuario = new User();
                }
                
                if(empty($id)){
                    if (empty($password)) {
                        return response()->json(['success' => false, 'msg'=> 'Por favor, informe a senha.']);
                        
                    } elseif ($password === $repeat_password){
                        $usuario->password = bcrypt($password);
                    } else {
                        return response()->json(['success' => false, 'msg'=> 'Atenção, as senhas divergem. Tente Novamente']);
                    }
                }elseif($password != null){
                    if ($password === $repeat_password){
                        $usuario->password = bcrypt($password);
                    } else {
                        return response()->json(['success' => false, 'msg'=> 'Atenção, as senhas divergem. Tente Novamente']);
                    }
                }

                $usuario->fill($request->all());

                $validate = validator($request->all(), $usuario->rules(), $usuario->mensages);

                if($validate->fails())
                {
                    return response()->json(['success' => false, 'msg' => arrayToValidator($validate->errors())]);
                }

                $save = $usuario->save();
                
                if($save) {

                    $funcoes = $request->input('funcoes');

                    if($funcoes)
                    {
                        $funcoes = json_decode($funcoes);

                        foreach($funcoes as $funcao)
                        {
                            if($funcao->id == 0){
                                DB::table('role_user')->insert(['role_id' => $funcao->funcao, 'user_id' => $usuario->id]);
                            }else if($funcao->deletar && $funcao->id > 0)
                            {
                                DB::table('role_user')->where('id', $funcao->id)->delete();
                            }
                        }
                    }

                return response()->json(['success' => true, 'msg' => 'Usuário salvo com sucesso.']);
                }else{
                    return response()->json(['success' => false, 'msg' => 'Erro ao salvar Usuário.']);
                }

            });

            return $result;
        }catch(\Exception $exc){
            return response()->json(['success' => false, 'msg' => 'Erro ao salvar Usuário.']);
        }
    }

    public function edit(User $usuario)
    {
        $this->authorize('CADASTRAR_USUARIO');
        $funcoes =  arrayToSelect(Role::select('id', 'description')->get()->toArray(), 'id', 'description');

        return view('pages.usuarios.form', compact('usuario', 'funcoes'));
    }

    public function getFuncoes($user)
    {
        return DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->select('role_user.id', 'role_user.role_id', 'roles.description')
                ->where('role_user.user_id', $user)
                ->get();
    }

    public function createChangePass(){
        return view('pages.usuarios.change-password');
    }

    public  function changePassword(Request $request){
        $usuario = \Auth::user();
        $password = trim($request->input('password'));
        if(\Hash::check($password, $usuario->password)){
            $newPassword = trim($request->input('new-password'));

            $repeat_password = trim($request->input('repeat-password'));
            if (empty($newPassword)) {
                return response()->json(['success' => false, 'msg'=> 'Por favor, informe a senha.']);

            } elseif ($newPassword === $repeat_password){
                $usuario->password = bcrypt($newPassword);
                $save = $usuario->save();

                if($save){
                    return response()->json(['success' => true, 'msg'=> 'Senha redefinida com sucesso']);
                }else{
                    return response()->json(['success' => false, 'msg'=> 'falha ao redefinir senha']);
                }

            } else {
                return response()->json(['success' => false, 'msg'=> 'Atenção, as senhas divergem. Tente Novamente']);
            }
        }else{
            return response()->json(['success' => false, 'msg'=> 'Atenção, senha atual incorreta']);
        }



    }

}