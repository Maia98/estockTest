<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RegistroHistoricoObra extends Model
{
    protected $table    = "registro_historico_obra";
    protected $fillable = ['obra_id', 'usuario_id', 'status_obra', 'descricao'];

    public function obra()
    {
      return $this->belongsTo('App\Model\Obra', 'obra_id', 'id');
    }

    public function usuario()
    {
      return $this->belongsTo('App\User', 'usuario_id', 'id');
    }

    public function rules() { 

        return [ 
            'descricao'        => 'required'
        ];
    }
    
    public $msgRules = [
        'descricao.required' => 'Descrição não preenchida'
    ];


    public static function registerHistorico($obra,$mensagem,$idAcao = null){
        
        $historicoObra = new RegistroHistoricoObra();
        $historicoObra->obra_id = $obra->id;
        $historicoObra->usuario_id = \Auth::user()->id;;
        if($idAcao){
            $mensagem = $mensagem. ' '.$idAcao;
        }
        
        $historicoObra->descricao = $mensagem;
        $historicoObra->status_obra = $obra->statusObra->nome;
        
        $save = $historicoObra->save();


    }
}