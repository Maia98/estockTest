<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ValorUS;

class ValorUSController extends Controller
{

    public function create()
    {
        $this->authorize('ALTERAR_US_MEDICAO');
        $valorUS = ValorUS::join('users', 'users.id', '=', 'valor_us.usuario_id')->first();

        if($valorUS){
            $valorUS->valor =  number_format($valorUS->valor,2,",",".");
        }else{
            $valorUS = null;
        }
        
        return view('pages.medicao.us-medicao', compact('valorUS'));
    }

    public function store(Request $request)
    {
        $this->authorize('ALTERAR_US_MEDICAO');
        $id = $request->input('id');

        $valorUS = ValorUS::find(1);

        if(!$valorUS){
            $valorUS = new ValorUS();
            $valorUS->id = 1;
        }

        $oldValue = $valorUS->valor;
        $valorUS->fill($request->all());
        $valorUS->usuario_id = \Auth::user()->id;
        $valorUS->valor_anterior = $oldValue;
        $save = $valorUS->save();
        
        if($save)
        {
            return response()->json(['success' => true, 'msg' => 'Valor US inserido com sucesso.', 'result' => $valorUS ]);
        }else{
            return response()->json(['success' => false, 'msg' => 'Erro ao inserir valor US']);
        }

    }

    

}
