<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Obra;

class Regional extends Model
{
    protected $table    = "regional";
    protected $fillable = ['descricao'];

    public function rules() { 

        return [ 
            'descricao' => 'required|unique:regional,descricao'. (($this->id) ? ', ' . $this->id : '')
            ];
    }
    
    public $msgRules = [
        'descricao.unique'   => 'Descrição cadastrada.',
        'descricao.required' => 'Descrição não preenchida.',
    ];


    public static function regionalPorStatus($dataInicio, $dataFim)
    {
        $arr = [];
        
        $regionais = Obra::join('cidade', 'cidade.id', '=', 'obra.cidade_id')
                         ->join('regional', 'regional.id', '=', 'cidade.regional_id')
                         ->distinct()
                         ->select('regional.id', 'regional.descricao as descricao')
                         ->get();

        foreach ($regionais as $value) {
            $stausObra = Obra::select(\DB::raw('status_obra.id as status_obra_id, status_obra.nome as status_obra, count(status_obra.nome) as qtd'))
                        ->join('status_obra','status_obra.id', '=', 'tipo_status_obra_id')
                        ->join('cidade','cidade.id', '=', 'obra.cidade_id')
                        ->join('regional', 'regional.id', '=', 'cidade.regional_id')
                        ->whereBetween('data_recebimento', [[$dataInicio], [$dataFim]])
                        ->where('regional.id', $value->id)
                        ->groupBy('status_obra.id', 'regional.descricao')
                        ->get();

            $arrStatus = [];
            if(count($stausObra) > 0){
                foreach ($stausObra as $status) {
                    $arrStatus['regional'] = $value->descricao;
                    $arrStatus[$status->status_obra] = $status->qtd;
                }

                $arr[] = $arrStatus;
            }
        }

        return $arr;
    
    }
}
