<?php
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Support\Facades\Schema;
    use Intervention\Image\Facades\Image;
    use Illuminate\Http\Request;
    use App\Model\Empresa;
    // use Intervention\Image\ImageManagerStatic as Image;
    
    function versao(){
        return '3.4.3';
    }

    class Util {
    /* Tipo Fase */
    public static $tipoFase = [['id' => 1, 'descricao' => 'N'],
                               ['id' => 2, 'descricao' => 'A'],
                               ['id' => 3, 'descricao' => 'AN'],
                               ['id' => 4, 'descricao' => 'B'],
                               ['id' => 5, 'descricao' => 'BN'],
                               ['id' => 6, 'descricao' => 'C'],
                               ['id' => 7, 'descricao' => 'CN'],
                               ['id' => 8, 'descricao' => 'AB'],
                               ['id' => 9, 'descricao' => 'ABN'],
                               ['id' => 10, 'descricao' => 'AC'],
                               ['id' => 11, 'descricao' => 'ACN'],
                               ['id' => 12, 'descricao' => 'BC'],
                               ['id' => 13, 'descricao' => 'BCN'],
                               ['id' => 14, 'descricao' => 'ABC'],
                               ['id' => 15, 'descricao' => 'ABCN']
                              ];
    
    }
    
    function jumpers()
    {
        return $jumpers = [
                        0 => 'Ausente',
                        1 => 'Carga',
                        2 => 'Fonte',
                        3 => 'Ambos'
                    ];
    }
    
    function getJumperById($id) {
        $jumpers = jumpers();
        
        if (key_exists($id, $jumpers)) {
            return $jumpers[$id];
        } 

        return null;
    }
    
    function features()
    {
        return $features = [
                        1 => 'piquete',
                        2 => 'aerogerador',
                        3 => 'rede-mt-sub-aerogerador',
                        4 => 'torre',
                        5 => 'rede-alta-tensao',
                        5 => 'subestacao'
                    ];
    }
    
    function getFeatureIdByName($name) {
        $features = features();
        
        foreach ($features as $key => $value)
        {
            if($value == $name)
                return $key;
        }
        
        return 0;
    }
    
    function getFeatureNameByid($id) {
        $features = features();

        if (key_exists($id, $features)) {
            return $features[$id];
        } 
        
        return null;
    }

    function getController($modulo, $controller)
    {
        $module = Module::find($modulo);
        if($module)
        {
            return '\Modules\\' .$module->getName(). '\\Http\Controllers\\' .$controller;
        }

        return $controller;
    }
    
    function arrayToSelect(array $values, $key, $value) {
        if(count($values) > 0)
        {
            $data = array();
        
            $data[0] = 'Selecione';
            foreach ($values as $row) {
                $data[$row[$key]] = $row[$value];
            }

            return $data;
        }else{
            return [''];
        }
        
    }
    
    function objectToSelect(array $values, $key, $value) {
        $data = array();

        $data[0] = 'Selecione';
        foreach ($values as $row) {
            //dd($row);
            if ($row->$value != '') {
                $data[$row->$key] = $row->$value;
            }
        }

        return $data;
    }
    
    function arrayToValidator($arr) {
        
        $erros = '<ul>';
            
        foreach ($arr->toArray() as $erro)
        {
            foreach ($erro as $msg)
            {
                $erros .= '<li>' .$msg. '</li>';
            }
        }
        
        $erros .= '</ul>';
        
        return $erros;
    }
    
    function queryToArray($arr, $key)
    {
        $array = [];
        foreach ($arr as $row)
        {
            $array[] = $row->$key;
        }
        
        return $array;
    }
    
    /*function moduleAsset($asset)
    {
        list($name, $url) = explode(':', $asset);
        
        $baseUrl = str_replace(public_path() . DIRECTORY_SEPARATOR, '', Module::getAssetsPath());
        $url = asset("assets/{$name}/" . $url);
        return str_replace(['http://', 'https://'], '//', $url);
    }*/
    
    function modalMessage($titulo, $texto, $id_subestacao = null)
    {
        if($id_subestacao){
            return view('ativos::pages.modal-erro-subestacao', compact('titulo', 'texto', 'id_subestacao'));
        }

        return view('modal-erro', compact('titulo', 'texto'));
    }
    
    function paginate($page, $request, $perPage, $dados)
    {
        //Remove da url &page=numero da pagina para não ficar repetindo na url        
        $paramsUrl = str_replace('&page='.$page, "", $request->fullUrl());
        //Total de registro por pagina
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(array_slice($dados, $offset, $perPage, true), count($dados), $perPage, $page, ['path' => $paramsUrl] );   
    } 
    
    function exceptThumb($imagens)
    {
        $arr = [];
        foreach ($imagens as $imagem)
        {
            if(!stripos($imagem, '-thumb'))
            {
                $arr[] = $imagem;
            }
        }
        return $arr;
    }
    
    function saveImage($prefix, $file, $path)
    {
        $validextensions = ["jpeg", "jpg", "png"];
        $extension = $file->getClientOriginalExtension();
        
        if(in_array( strtolower($extension), $validextensions)){
            $nameHash = hash("md5", uniqid(time()));
 
            $picture = $prefix.'_' .$nameHash. '.'.$extension;
            $pictureThumb = $prefix.'_' .$nameHash. '-thumb.'.$extension;
            $destinationPath = $path;
 
            Image::make($file)->resize(300, null, function($constraint){
                $constraint->aspectRatio();
            })->save($destinationPath .'/'. $pictureThumb);  

            $file->move($destinationPath, $picture);

        }else{
            throw new Exception('Erro extenções permitidas: jpg, jpeg e png.');
        }
    }
    
    function deleteImage($request)
    {
        $srcThumb = $request->input('src');
        $srcThumb = str_replace(url('/'), '', $srcThumb);
        $src = str_replace('-thumb', '', $srcThumb);
        
        if(!empty($src)){
            $imagens = File::glob(public_path($src), GLOB_MARK);
            File::delete($imagens);   
            
            $imagensThumb = File::glob(public_path($srcThumb), GLOB_MARK);
            File::delete($imagensThumb);
            return response()->json(['success' => true, 'msg' => 'Imagem deletada da pasta com sucesso.']);
        }else{
            return response()->json(['success' => false, 'msg' => 'Não foi possivel deletar a imagem.']);
        }
    }
    
    function getImagens($path, $id)
    {
        $imagensTorre = File::glob($path .$id. '_*', GLOB_MARK);
        $imagensTorre = exceptThumb($imagensTorre);
        $imagensTorre = str_replace('\\', '/', str_replace(public_path(''), url(''), $imagensTorre)) ;
        return $imagensTorre;
    }
    
    function getImagensThumb($path, $id)
    {
        $imagensTorre = File::glob($path .$id. '_*-thumb*' , GLOB_MARK);
        //$imagensTorre = File::glob(public_path('storage/imagens/torre/' .$this->id. '_*-thumb*'), GLOB_MARK);
        return $imagensTorre = str_replace(public_path(), url('/'), $imagensTorre);
    }

    function qtdEstoqueProduto($array){
        if(!isset($array['almoxarifado_id']) or $array['almoxarifado_id'] == 0) { 
            $qtdeInEstoque = \DB::table('materiais_estoque')
                                   ->where('produto_id', $array['produto_id'])
                                   ->where('local_id',$array['local_id'])
                                   ->whereNull('almoxarifado_id')
                                   ->sum('qtde');
        }else{
            $qtdeInEstoque = \DB::table('materiais_estoque')
                                   ->where('produto_id', $array['produto_id'])
                                   ->where('local_id',$array['local_id'])
                                   ->where('almoxarifado_id', $array['almoxarifado_id'])
                                   ->sum('qtde');
        }
        // retorna a quantidade do produto no estoque do complexo e/ou parque passados por parametro
        return $qtdeInEstoque;

    }
    
    function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function($key) {
                    return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }
    
    function xmlToArray($xml, $options = array()) {
        $defaults = array(
            'namespaceSeparator' => ':', //you may want this to be something other than a colon
            'attributePrefix' => '@', //to distinguish between attributes and nodes with the same name
            'alwaysArray' => array(), //array of xml tag names which should always become arrays
            'autoArray' => true, //only create arrays for tags which appear more than once
            'textContent' => '$', //key used for the text content of elements
            'autoText' => true, //skip textContent key if node has no attributes or child nodes
            'keySearch' => false, //optional search and replace on tag and attribute names
            'keyReplace' => false       //replace values for above search values (as passed to str_replace())
        );
        $options = array_merge($defaults, $options);
        $namespaces = $xml->getDocNamespaces();
        $namespaces[''] = null; //add base (empty) namespace
        //get attributes from all namespaces
        $attributesArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
                //replace characters in attribute name
                if ($options['keySearch'])
                    $attributeName = str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
                $attributeKey = $options['attributePrefix']
                        . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                        . $attributeName;
                $attributesArray[$attributeKey] = (string) $attribute;
            }
        }

        //get child nodes from all namespaces
        $tagsArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->children($namespace) as $childXml) {
                //recurse into child nodes
                $childArray = xmlToArray($childXml, $options);
                list($childTagName, $childProperties) = each($childArray);

                //replace characters in tag name
                if ($options['keySearch'])
                    $childTagName = str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
                //add namespace prefix, if any
                if ($prefix)
                    $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;

                if (!isset($tagsArray[$childTagName])) {
                    //only entry with this key
                    //test if tags of this type should always be arrays, no matter the element count
                    $tagsArray[$childTagName] = in_array($childTagName, $options['alwaysArray']) || !$options['autoArray'] ? array($childProperties) : $childProperties;
                } elseif (
                        is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName]) === range(0, count($tagsArray[$childTagName]) - 1)
                ) {
                    //key already exists and is integer indexed array
                    $tagsArray[$childTagName][] = $childProperties;
                } else {
                    //key exists so convert to integer indexed array with previous value in position 0
                    $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
                }
            }
        }

        //get text content of node
        $textContentArray = array();
        $plainText = trim((string) $xml);
        if ($plainText !== '')
            $textContentArray[$options['textContent']] = $plainText;

        //stick it all together
        $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '') ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;

        //return node as array
        return array(
            $xml->getName() => $propertiesArray
        );
    }

    
    function dateToView($value, $hour = null) {
        
        if(!isset($value)){
            return '';
        }
        
        if($hour){
            
            return date('d/m/Y H:i', strtotime($value));
        }
        
        return date('d/m/Y', strtotime($value));
    }

function exportPdf($titulo, $result, $name, $route, $orientation = "portrait", $balanco = null){

    $folder    =  'storage/app/imagens/empresa';
    if(!\File::exists($folder))
    {
        Storage::makeDirectory('public/imagens/empresa');
    }
    
    $titulo  = $titulo != "" ? $titulo : "";
    $empresa = Empresa::first();

      //===================================================================================//
     //============================== INFO EMPRESA =======================================//
    //===================================================================================//
    $enderecoEmpresa = '';
    if($empresa){
        $logradouro      = $empresa->logradouro != "" ? "$empresa->logradouro, " : "";
        $numero          = $empresa->numero != ""? "$empresa->numero, " : "";
        $bairro          = $empresa->bairro != "" ? "$empresa->bairro, " : "";
        $cidade          = $empresa->cidade != "" && $empresa->uf != "" ? "$empresa->cidade-".$empresa->uf->uf.", " : "";
        $cep             = $empresa->cep != "" ? substr($empresa->cep,0,5)."-".substr($empresa->cep,5,3)."," : "";
        $enderecoEmpresa = "$logradouro$numero$bairro$cidade$cep";
        $enderecoEmpresa = !empty($enderecoEmpresa) ? substr($enderecoEmpresa, 0, strripos($enderecoEmpresa, ',')) : "Informações da Empresa";
    }

    $file            = \File::allFiles(public_path().'/storage/imagens/empresa/');
    $nameLogo        = $file == null ? $file : $file[0]->getFilename();

    $view = \View::make($route, compact("result", "titulo", "empresa", "enderecoEmpresa", "nameLogo", "name", "balanco"))->render();
    $pdf = \PDF::loadHTML($view)->setPaper('A4', $orientation);
    return $pdf->stream($name.".pdf");    

}

function dateToSave($data,$hour = null){
    if(!isset($data)){
            return null;
        }
    $formatDate = str_replace("/", ".", $data);
    if($hour){
        return date('Y-m-d H:i', strtotime($formatDate));
    }
        
    return date('Y-m-d', strtotime($formatDate));
}

