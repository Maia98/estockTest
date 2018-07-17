<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    protected $table    = "obra";
    protected $fillable = ['tipo_setor_obra_id','tipo_obra_id' ,'cidade_id', 'funcionario_supervisor_id', 'funcionario_fiscal_id', 'tipo_status_obra_id', 'tipo_prioridade_obra_id', 'numero_obra', 'data_abertura', 'data_recebimento', 'data_previsao_retirada_material', 'prazo_execucao_inicio', 'prazo_execucao_fim', 'valor_orcado', 'medidor', 'instalacao', 'observacao'];

    public function cidade()
    {
        return $this->belongsTo('App\Model\Cidade', 'cidade_id', 'id');
    }

    public function setorObra()
    {
        return $this->belongsTo('App\Model\TipoSetorObra', 'tipo_setor_obra_id', 'id');
    }

    public function tipoObra(){

        return $this->belongsTo('App\Model\TipoObra', 'tipo_obra_id', 'id');
    }

     public function funcionarioSupervisor(){

        return $this->belongsTo('App\Model\Funcionario', 'funcionario_supervisor_id', 'id');
    }

     public function funcionarioFiscal(){

        return $this->belongsTo('App\Model\Funcionario', 'funcionario_fiscal_id', 'id');
    }

     public function statusObra(){

        return $this->belongsTo('App\Model\StatusObra', 'tipo_status_obra_id', 'id');
    }

    public function prioridadeObra(){
        
        return $this->belongsTo('App\Model\TipoPrioridade', 'tipo_prioridade_obra_id', 'id');
    }

    public function encarregado()
    {
        return $this->hasMany('App\Model\FuncionarioEncarregadoHasObra', 'obra_id', 'id');
    }

    public function apoio()
    {
        return $this->hasMany('App\Model\ApoioExecucaoHasObra', 'obra_id', 'id');
    }

    public function getValorPago(){
        return \DB::table('medicao')->where('obra_id', $this->id)->sum('valor_pago');
    }

    public function getValorMedido(){
        return \DB::table('itens_medicao as im')->join('medicao', 'im.medicao_id', '=', 'medicao.id')->where('medicao.obra_id', $this->id)->sum('im.sub_total');
    }

    
    public function rules() { 

        return [ 
            'numero_obra'               => 'required|numeric|unique:obra,numero_obra'. (($this->id) ? ', ' . $this->id : ''),
            'tipo_setor_obra_id'        => 'required|not_in:0',
            'data_recebimento'          => 'required',
            'cidade_id'            => 'required|not_in:0',
            'tipo_prioridade_obra_id'   => 'required|not_in:0',
            'tipo_obra_id'              => 'required|not_in:0', 
            'tipo_status_obra_id'       => 'required|not_in:0',

        ];
    }
    
    public $msgRules = [
        'numero_obra.required'               => 'Número Obra não preenchido.',
        'numero_obra.unique'                 => 'Número Obra já cadastrado.',
        'numero_obra.numeric'                => 'Número Obra só aceita valores numéricos.',
        'tipo_setor_obra_id.required'        => 'Setor não preenchido.',
        'tipo_setor_obra_id.not_in'          => 'Setor não selecionado.',
        'cidade_id.required'                 => 'Cidade não preenchida.',
        'cidade_id.not_in'                   => 'Cidade não selecionada.',
        'tipo_obra_id.required'              => 'Tipo não preenchido.',
        'tipo_obra_id.not_in'                => 'Tipo não selecionada.',
        'tipo_status_obra_id.required'       => 'Status Obra não preenchido.',
        'tipo_status_obra_id.not_in'         => 'Status Obra não selecionado.',
        'tipo_prioridade_obra_id.required'   => 'Prioridade não preenchida.',
        'tipo_prioridade_obra_id.not_in'     => 'Prioridade não selecionada.',
        'data_recebimento.required'          => 'Data Recebimento não preenchida.',
    ];



    public function validaSupervisorAndFiscal(){
        if($this->funcionario_supervisor_id == 0){
            $this->funcionario_supervisor_id = null;
        }

        if($this->funcionario_fiscal_id == 0){
            $this->funcionario_fiscal_id = null;
        }
    }

    /*public function validaDatas(){
        
        if(date_create(str_replace('/', '-', $this->data_recebimento)) == false){
            return true;
        }

        if($this->data_abertura != null && date_create(str_replace('/', '-', $this->data_abertura)) == false){
            return true;
        }

        if($this->data_previsao_retirada_material != null && date_create(str_replace('/', '-', $this->data_previsao_retirada_material)) == false){

            return true;
        }

        if($this->prazo_execucao_inicio != null && date_create(str_replace('/', '-', $this->prazo_execucao_inicio)) == false){

            return true;
        }

        if($this->prazo_execucao_fim != null && date_create(str_replace('/', '-', $this->prazo_execucao_fim))){

            return true;
        }
    }*/

// função que formata todas os campos para exibição de edição da obra
    
    public function formatInputs(){
        
        $this->data_recebimento = dateToView($this->data_recebimento);
        
        if($this->data_abertura != null){ 
            $this->data_abertura = dateToView($this->data_abertura);
        }

        if($this->data_previsao_retirada_material != null){ 
            $this->data_previsao_retirada_material = dateToView($this->data_previsao_retirada_material);
        }

        if($this->prazo_execucao_inicio != null){ 
            $this->prazo_execucao_inicio = dateToView($this->prazo_execucao_inicio, true);
        }

        if($this->prazo_execucao_fim != null){ 
            $this->prazo_execucao_fim = dateToView($this->prazo_execucao_fim, true);
        }

        if($this->valor_orcado){
            $this->valor_orcado = number_format($this->valor_orcado,2,",",".");
        }
    }

    
    public static function filterObra($campos, $excel = null){

        // execução da consulta base
        $result = Obra::join('cidade as cid', 'cid.id','=','obra.cidade_id')
                  ->leftJoin('funcionario_encarregado_has_obra as enc', 'enc.obra_id','=','obra.id')
                  ->leftJoin('funcionarios as func', 'func.id','=','enc.funcionario_id');
        
        if(isset($campos['filter_numero_obra'])){
            $filter = $campos["filter_numero_obra"].'%';
            $result = $result->whereRaw("CAST(numero_obra AS varchar) LIKE '$filter' ");
        }

        if(isset($campos['filter_status_obra']) && $campos['filter_status_obra'] > 0){
            $result = $result->where('tipo_status_obra_id',$campos['filter_status_obra']); 
        }

        if(isset($campos['filter_cidade']) && $campos['filter_cidade'] > 0){
            $result = $result->where('cidade_id',$campos['filter_cidade']); 
        }

        if(isset($campos['filter_medidor'])){
            $filter = '%'.$campos["filter_medidor"].'%';
            $result = $result->whereRaw("medidor ILIKE '$filter' ");
        }

        if(isset($campos['filter_instalacao'])){
            $filter = '%'.$campos["filter_instalacao"].'%';
            $result = $result->whereRaw("instalacao ILIKE '$filter' ");
        }

        if(isset($campos['filter_setor']) && $campos['filter_setor'] > 0){
            $result = $result->where('tipo_setor_obra_id',$campos['filter_setor']);
        }

        $campoData = (isset($campos['filter_tipo_data']) && $campos['filter_tipo_data'] > 0) ? Obra::tipoData($campos['filter_tipo_data']) : false;

        if($campoData){
            
            $campos['filter_data_inicial']  = $campos['filter_data_inicial']. ' 00:00';
            $campos['filter_data_final']    = $campos['filter_data_final']. ' 23:59';

            $result = $result->whereBetween($campoData, [$campos['filter_data_inicial'], $campos['filter_data_final']]);
        }
        if(isset($campos['filter_regional']) && $campos['filter_regional'] != 0){
            $result = $result->join('regional as reg', 'reg.id','=','cid.regional_id')
                             ->where('reg.id',$campos['filter_regional']);
        }

        if(isset($campos['filter_encarregado']) && $campos['filter_encarregado'] != 0){
                // vai na tabela funcionario_encarregado_has_obra e tras todos os Ids de obra concatenados que o encarregado está
            $ids = \DB::table('funcionario_encarregado_has_obra as temp')->select(\DB::raw("string_agg(CAST(temp.obra_id AS varchar), ';') as obras_id"))->where('funcionario_id',$campos['filter_encarregado'] )->get()->toArray();

                // explode os Ids gerando um array simples
            if(isset($ids[0]->obras_id)){
                // caso a consulta retorne algo dado explode no campo para gerar um array com Ids da obra
                $filter_id_funcionario = explode(';', $ids[0]->obras_id);

            }else{
                // se consulta vier vazia é coloca um array com valor 0 para simbolizar que nao existe nenhuma obra com o encarregado selecionado
                $filter_id_funcionario = [0];
            }
            $result = $result->whereIn('obra.id',$filter_id_funcionario);
        }

        // consulta excel
        if($excel)
        {
            // informações necessarias apenas para a consulta de exportação em excel

            $result = $result->select('obra.id as id','obra.numero_obra as numero_obra','obra.data_recebimento as data_recebimento' ,'obra.prazo_execucao_inicio as inicio','obra.prazo_execucao_fim as termino','obra.data_previsao_retirada_material as ret_material','prioridade.nome as prioridade','cid.nome as cidade','status.nome as status_obra', 'obra.observacao as observacao', \DB::raw("string_agg(func.nome || ' ' ||func.sobrenome, '; ') as encarregados"),
                \DB::raw("string_agg(ta.descricao, '; ') as apoios"))
                     ->join('status_obra as status', 'status.id','=','obra.tipo_status_obra_id')
                     ->join('tipo_prioridade as prioridade', 'prioridade.id','=','obra.tipo_prioridade_obra_id')
                     ->leftJoin('apoio_execucao_obra_has_obra as aeho', 'aeho.obra_id', '=','obra.id')
                     ->leftJoin('tipo_apoio as ta', 'ta.id','=','aeho.apoio_execucao_obra_id')
                     ->groupBy('obra.id', 'prioridade.nome', 'cid.nome', 'status.nome')
                     ->orderBy('obra.id');

        }else{
                    
            $result = $result->select('obra.id as id','numero_obra','cidade_id','data_recebimento','tipo_status_obra_id','funcionario_supervisor_id', \DB::raw("string_agg(func.nome || ' ' ||func.sobrenome, ', ') as encarregados"))->groupBy('obra.id');
        }
        // resultado retornado de acordo com o tipo, index/PDF ou excel
        return $result;
    }

    private static function tipoData($idTipoData){
        switch ($idTipoData) {
            case 1:
                return 'data_recebimento';
            break;

            case 2:
                return 'data_abertura';
            break;

            case 3:
                return 'prazo_execucao_inicio';
            break;

            case 4:
                return 'prazo_execucao_fim';
            break;

            case 5:
                return 'data_previsao_retirada_material';
            break;
            
            default:
                return null;
            break;
        }
    }

    public static function getBalanco($idObra, $saldo = null)
    {
        $query = "SELECT id, codigo, descricao, unidade, sum(orcado) as orcado, sum(entrada) as entrada, sum(saida) as saida, sum(transferenciaEntrada) as transferenciaent, sum(transferenciaSaida) as transferenciasai, numero_obra FROM (
                    SELECT mat_orc.id as idAcao, mat.id as id, mat_orc.cod_mat as codigo, mat_orc.descricao_mat as descricao, tipo_unidade_medida.codigo as unidade, mat_orc.qtd_orc as orcado, 0 as entrada, 0 as saida, 0 as transferenciaentrada, 0 as transferenciasaida, obra.numero_obra  
                    FROM material_orcado as mat_orc
                    LEFT JOIN tipo_material AS mat ON (mat_orc.cod_mat = mat.codigo)
                    LEFT JOIN tipo_unidade_medida ON (tipo_unidade_medida.id = mat.tipo_unidade_medida_material_id)
                    JOIN obra ON obra.id = mat_orc.obra_id  
                    WHERE obra_id = ?
                    UNION 
                    SELECT ent.id as idAcao,mat.id, mat.codigo AS codigo, mat.descricao AS descricao, tum.codigo AS unidade, 0 as orcado, ent_mat.qtde AS entrada, 0 as saida, 0 as transferenciaEntrada, 0 as transferenciaSaida, obra.numero_obra as numero_obra
                    FROM tipo_material AS mat
                    JOIN tipo_unidade_medida as tum on mat.tipo_unidade_medida_material_id = tum.id  
                    JOIN estoque ON estoque.tipo_material_id = mat.id
                    JOIN almoxarifado on almoxarifado.id = estoque.almoxarifado_id
                    JOIN entrada_estoque AS ent ON ent.obra_id = estoque.obra_id AND ent.almoxarifado_id = estoque.almoxarifado_id
                    JOIN entrada_material_estoque AS ent_mat ON ent_mat.tipo_material_id = mat.id AND ent_mat.entrada_estoque_id = ent.id
                    JOIN obra ON obra.id = ent.obra_id  
                    WHERE ent.obra_id = ?
                    UNION
                    SELECT sai.id as idAcao, mat.id, mat.codigo AS codigo, mat.descricao AS descricao, tum.codigo AS unidade, 0 as orcado, 0 AS entrada, sai_mat.qtde as saida, 0 as transferenciaEntrada, 0 as transferenciaSaida, obra.numero_obra as numero_obra
                    FROM tipo_material AS mat
                    JOIN tipo_unidade_medida as tum on mat.tipo_unidade_medida_material_id = tum.id  
                    JOIN estoque ON estoque.tipo_material_id = mat.id
                    JOIN almoxarifado on almoxarifado.id = estoque.almoxarifado_id
                    JOIN saida_estoque AS sai ON sai.obra_id = estoque.obra_id AND sai.almoxarifado_id = estoque.almoxarifado_id
                    JOIN saida_material_estoque AS sai_mat ON sai_mat.tipo_material_id = mat.id AND sai_mat.saida_estoque_id = sai.id
                    JOIN obra ON obra.id = sai.obra_id
                    WHERE sai.obra_id = ?
                    UNION
                    SELECT trans.id as idAcao,mat.id, mat.codigo AS codigo, mat.descricao AS descricao, tum.codigo AS unidade, 0 as orcado, 0 AS entrada, 0 as saida, trans_mat.qtde as transferenciaEntrada, 0 as transferenciaSaida, obra.numero_obra as numero_obra
                    FROM tipo_material AS mat
                    JOIN tipo_unidade_medida as tum on mat.tipo_unidade_medida_material_id = tum.id  
                    JOIN estoque ON estoque.tipo_material_id = mat.id
                    JOIN almoxarifado on almoxarifado.id = estoque.almoxarifado_id
                    JOIN transferencia_estoque AS trans ON trans.obra_destino_id = estoque.obra_id AND trans.almoxarifado_destino_id = estoque.almoxarifado_id
                    JOIN transferencia_material_estoque AS trans_mat ON trans_mat.tipo_material_id = mat.id AND trans_mat.transferencia_estoque_id = trans.id
                    JOIN obra ON obra.id = trans.obra_destino_id
                    WHERE trans.obra_destino_id = ?
                    UNION
                    SELECT trans.id as idAcao,mat.id, mat.codigo AS codigo, mat.descricao AS descricao, tum.codigo AS unidade, 0 as orcado, 0 AS entrada, 0 as saida,  0 as transferenciaEntrada, trans_mat.qtde as transferenciaSaida, obra.numero_obra as numero_obra
                    FROM tipo_material AS mat
                    JOIN tipo_unidade_medida as tum on mat.tipo_unidade_medida_material_id = tum.id  
                    JOIN estoque ON estoque.tipo_material_id = mat.id
                    JOIN almoxarifado on almoxarifado.id = estoque.almoxarifado_id
                    JOIN transferencia_estoque AS trans ON trans.almoxarifado_origem_id = estoque.almoxarifado_id
                    JOIN transferencia_material_estoque AS trans_mat ON trans_mat.obra_origem_id = estoque.obra_id AND  trans_mat.tipo_material_id = mat.id AND trans_mat.transferencia_estoque_id = trans.id
                    JOIN obra ON obra.id = trans_mat.obra_origem_id
                    WHERE trans_mat.obra_origem_id  = ?
                ) AS tab GROUP BY id, codigo, descricao, unidade, numero_obra
            ";
        // if para pegar saldo do balanço conforme o filtro
        if($saldo == 1){
            $query = $query. "  HAVING sum(entrada) - sum(saida) > 0";
        } else {
            if($saldo == 2){
                $query = $query. "  HAVING sum(entrada) - sum(saida) < 0";
            }

        }

        $query = $query. ' ORDER BY descricao, codigo';

        $balanco = \DB::select($query, [$idObra, $idObra, $idObra, $idObra, $idObra]);
        return $balanco;
    }

    public static function getSaldoPositivoAndNegativo($campos, $tipo){

        $query = "

                SELECT ent.obra_id as obra_id ,ent.id as idAcao,mat.id, mat.codigo AS codigo, mat.descricao AS descricao, tum.codigo AS unidade, almoxarifado.nome AS almoxarifado, ent_mat.qtde AS entrada, 0 as saida
                FROM tipo_material AS mat
                JOIN tipo_unidade_medida as tum on mat.tipo_unidade_medida_material_id = tum.id  
                JOIN estoque ON estoque.tipo_material_id = mat.id
                JOIN almoxarifado on almoxarifado.id = estoque.almoxarifado_id
                JOIN entrada_estoque AS ent ON ent.obra_id = estoque.obra_id AND ent.almoxarifado_id = estoque.almoxarifado_id
                JOIN entrada_material_estoque AS ent_mat ON ent_mat.tipo_material_id = mat.id AND ent_mat.entrada_estoque_id = ent.id 
                UNION
                SELECT sai.obra_id as obra_id ,sai.id as idAcao, mat.id, mat.codigo AS codigo, mat.descricao AS descricao, tum.codigo AS unidade, almoxarifado.nome AS almoxarifado, 0 AS entrada, sai_mat.qtde as saida
                FROM tipo_material AS mat
                JOIN tipo_unidade_medida as tum on mat.tipo_unidade_medida_material_id = tum.id  
                JOIN estoque ON estoque.tipo_material_id = mat.id
                JOIN almoxarifado on almoxarifado.id = estoque.almoxarifado_id
                JOIN saida_estoque AS sai ON sai.obra_id = estoque.obra_id AND sai.almoxarifado_id = estoque.almoxarifado_id
                JOIN saida_material_estoque AS sai_mat ON sai_mat.tipo_material_id = mat.id AND sai_mat.saida_estoque_id = sai.id
            ";

        $saldos = \DB::table(\DB::raw("({$query}) as tab"))->select('tab.obra_id as id','obra.numero_obra as numero_obra','status.nome as status_obra', 'obra.data_recebimento as data_recebimento'
                                                                    ,\DB::raw("string_agg(distinct func.nome || ' ' ||func.sobrenome, ', ') as encarregados"), 'cid.nome as cidade','reg.descricao as regional')
                                                            ->join('obra','tab.obra_id','=','obra.id')
                                                            ->join('status_obra as status', 'status.id','=','obra.tipo_status_obra_id')
                                                            ->join('cidade as cid', 'cid.id','=','obra.cidade_id')
                                                            ->join('regional as reg', 'reg.id','=','cid.regional_id')
                                                            ->leftJoin('funcionario_encarregado_has_obra as enc', 'enc.obra_id','=','obra.id')
                                                            ->leftJoin('funcionarios as func', 'func.id','=','enc.funcionario_id')
                                                            ->groupBy('tab.id','tab.codigo','tab.descricao','tab.unidade','tab.almoxarifado','tab.obra_id','obra.numero_obra','obra.tipo_status_obra_id','obra.data_recebimento'
                                                                        ,'status.nome','cid.nome', 'reg.descricao')
                                                            ->orderBy('obra.data_recebimento','desc')
                                                            ->distinct('tab.obra_id');
        if($tipo == 1){
           $saldos = $saldos->havingRaw('sum(entrada) - sum(saida) > 0');
        }else{
            $saldos = $saldos->havingRaw('sum(entrada) - sum(saida) < 0');
        }

        if(isset($campos['filter_status_obra']) && $campos['filter_status_obra'] > 0){
            $saldos = $saldos->where('tipo_status_obra_id',$campos['filter_status_obra']);
        }

        if(isset($campos['filter_numero_obra'])){
            $filter = $campos["filter_numero_obra"].'%';
            $saldos = $saldos->whereRaw("CAST(obra.numero_obra AS varchar) LIKE '$filter' ");
        }

        if(isset($campos['filter_medidor'])){
            $filter = '%'.$campos["filter_medidor"].'%';
            $saldos = $saldos->whereRaw("medidor ILIKE '$filter' ");
        }

        if(isset($campos['filter_instalacao'])){
            $filter = '%'.$campos["filter_instalacao"].'%';
            $saldos = $saldos->whereRaw("instalacao ILIKE '$filter' ");
        }

        if(isset($campos['filter_setor']) && $campos['filter_setor'] > 0){
            $saldos = $saldos->where('tipo_setor_obra_id', $campos['filter_setor']);
        }

        $campoData = (isset($campos['filter_tipo_data']) && $campos['filter_tipo_data'] > 0) ? Obra::tipoData($campos['filter_tipo_data']) : false;

        if($campoData){

            $campos['filter_data_inicial']  = $campos['filter_data_inicial']. ' 00:00';
            $campos['filter_data_final']    = $campos['filter_data_final']. ' 23:59';

            $saldos = $saldos->whereBetween($campoData, [$campos['filter_data_inicial'], $campos['filter_data_final']]);
        }

        if(isset($campos['filter_cidade']) && $campos['filter_cidade'] > 0){
            $saldos = $saldos->where('cidade_id',$campos['filter_cidade']);
        }

        if(isset($campos['filter_regional']) && $campos['filter_regional'] != 0){
            $saldos = $saldos->where('reg.id',$campos['filter_regional']);
        }

        if(isset($campos['filter_encarregado']) && $campos['filter_encarregado'] != 0){
            // vai na tabela funcionario_encarregado_has_obra e tras todos os Ids de obra concatenados que o encarregado está
            $ids = \DB::table('funcionario_encarregado_has_obra as temp')->select(\DB::raw("string_agg(CAST(temp.obra_id AS varchar), ';') as obras_id"))->where('funcionario_id',$campos['filter_encarregado'] )->get()->toArray();

            // explode os Ids gerando um array simples
            if(isset($ids[0]->obras_id)){
                // caso a consulta retorne algo dado explode no campo para gerar um array com Ids da obra
                $filter_id_funcionario = explode(';', $ids[0]->obras_id);

            }else{
                // se consulta vier vazia é coloca um array com valor 0 para simbolizar que nao existe nenhuma obra com o encarregado selecionado
                $filter_id_funcionario = [0];
            }
            $saldos = $saldos->whereIn('obra.id',$filter_id_funcionario);
        }

        return $saldos;
    }

    public function getImagensObra()
    {
        //$allFiles = \File::allFiles(public_path() . '/storage/documetos-anexados/obra/' . $this->numero_obra);
        $vart = public_path() . '/storage/documetos-anexados/obra/'. $this->numero_obra. '/';
        $arquivos = \File::glob($vart .$this->id. '_*', GLOB_MARK);
        $imagens = [];
        foreach ($arquivos as $imagem)
        {
            if(stripos($imagem, '.png') || stripos($imagem, '.jpeg') || stripos($imagem, '.jpg'))
            {
                $imagens[] = $imagem;
            }
        }
        $imagensObra = str_replace('\\', '/', str_replace(public_path(''), url(''), $imagens));
        return $imagensObra;
    }
}