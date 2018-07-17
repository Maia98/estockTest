<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Medicao extends Model
{
    protected $table    = "medicao";
    protected $fillable = ['obra_id', 'usuario_id', 'funcionario_fiscal_id', 'status_medicao_id','data_medicao', 'valor_pago', 'observacao'];

    public function statusMedicao()
    {
      return $this->belongsTo('App\Model\TipoStatusMedicao', 'status_medicao_id', 'id');
    }

    public function obra(){

        return $this->belongsTo('App\Model\Obra', 'obra_id', 'id');
    }

    public function usuario(){

        return $this->belongsTo('App\User', 'usuario_id', 'id');
    }

     public function fiscal(){
        
        return $this->belongsTo('App\Model\Funcionario', 'funcionario_fiscal_id', 'id');
    }

    public function itensMedicao()
    {
        return $this->hasMany('App\Model\ItensMedicao', 'medicao_id', 'id');
    }

    

    public function rules() { 

        return [
        		'obra_id'           => 'required|not_in:0',
        		'status_medicao_id' => 'required|not_in:0',
        		'data_medicao'	    => 'required'           
        ];
    }
    
    public $msgRules = [

    		'obra_id.required' 			  => 'Número Obra não preenchido.',
    		'obra_id.not_in' 			  => 'Número Obra não selecionado.',
    		'status_medicao_id.required'  => 'Status Medição não preenchido.',
    		'status_medicao_id.not_in'	  => 'Status Medição não selecionado.',
    		'data_medicao.required'		  => 'Data Medição não preenchida.'
      
    ];


    public static function filterMedicao($campos)
    {
        $result = Medicao::select('medicao.id','obra_id', 'status_medicao_id', 'medicao.funcionario_fiscal_id', 'valor_pago', 'data_medicao', \DB::raw('SUM(dm.sub_total) as valor_total'), \DB::raw("string_agg(am.nome, ', ') as apontamentos"))
                           ->leftjoin('itens_medicao as dm', 'dm.medicao_id','=', 'medicao.id')
                           ->leftjoin('itens_apontamento_medicao as ipm', 'ipm.medicao_id','=', 'medicao.id')
                           ->leftjoin('apontamento_medicao as am', 'ipm.apontamento_medicao_id','=', 'am.id')
                           ->join('obra', 'obra.id', '=', 'medicao.obra_id')
                           ->groupBy('medicao.id');

        if(isset($campos['filter_obra_id'])){

            $filter = '%'.$campos["filter_obra_id"].'%';
            $result = $result->whereRaw("CAST(obra.numero_obra AS varchar) LIKE '$filter' ");
        }

        if(isset($campos['filter_status_medicao']) && $campos['filter_status_medicao'] != 0){
             $result = $result->where('status_medicao_id', $campos["filter_status_medicao"]);
        }

        if(isset($campos['filter_funcionario_fiscal_id']) && $campos['filter_funcionario_fiscal_id'] != 0){
            $result = $result->where('medicao.funcionario_fiscal_id', $campos['filter_funcionario_fiscal_id']);
        }

        if(isset($campos['filter_data_inicial']) && isset($campos['filter_data_final'] )){
            
            $result = $result->whereBetween('medicao.data_medicao', [$campos['filter_data_inicial'], $campos['filter_data_final']]);
        }

        if(isset($campos['filter_apontamentos']) && $campos['filter_apontamentos'] != 0){

            $ids = \DB::table('itens_apontamento_medicao')->select('medicao_id')
                        ->where('apontamento_medicao_id', $campos['filter_apontamentos'])
                        ->get()->toArray();

            if(count($ids))
            {
                $filter_id_apontamento = array_column($ids, 'medicao_id');
            }else{
                $filter_id_apontamento = [0];
            }

            $result = $result->whereIn('ipm.medicao_id', $filter_id_apontamento);
        }

        return $result;
    }
}