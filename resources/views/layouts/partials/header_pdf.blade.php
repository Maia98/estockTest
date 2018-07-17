<style>

.table{
    border-collapse: collapse;
    width: 100%;
    margin-top: 90px;
}

.table th, td {
    text-align: left;
    padding: 8px;
}
.table th{
    font-size: 13px;
    white-space: nowrap;
}

.table td{
    font-size: 12px;
}

.table tr:nth-child(even){background-color: #f2f2f2}

@page { 
    margin: 120px 50px 120px 50px;
    page-break-after:always;
    position: relative;
}

.assinaturas {
    padding-top: 120px;
}

.assinatura {
    border-top: solid 1px #000000; 
    width: 20%;
    padding-top: -20px;
    float: left;
}

.assinatura-next {
    margin-right: 6.6%;
}

.text-assinatura {
    text-align: center;
    font-size: 55%;
}


.info-empresa h6 {
    border-top: 1px dashed #000000; 
    border-bottom: 1px dashed #000000; 
    height: 5%; 
    margin-top: 150px; 
    padding-top: 10px;
}

.header {
    position: fixed; top: -100px; width: 100%; height: 20%;
}

.header-logo {
    position: absolute; float: left; top: 10px;
}

.header-logo img {
    width: 200px; height: 50px;
}

.header-info {
    position: absolute; float: left; text-align: center; width: 75%; height: 10%;
}

.header-info h6 {
    padding-top: -20px;
}

.panel-info {
    position: fixed;  width: 100%; height: 5%; padding-bottom: 20px;  border-top: solid 1px #000000; border-bottom: solid 1px #000000;
}

.panel-info h4 {
    text-align: left; color: #337ab7;
}

.panel-info-right {
    float: left; position: absolute; text-align: right; width: 100%; height: 7%;
}

.panel-info-right h5 {
    text-align: right;
}

.footer {
    position: absolute;
    bottom: -90px; 
    left: 10px;
}

.nomeEmpresa{
    margin-bottom: 15px;
    font-size: 14px;
}

.enderecoEmpresa{
    max-width: 300px;
    margin: 0 auto;
    font-size: 12px;
    font-weight: lighter;
}

</style>
<div class="header">
    <div class="header-logo">
        @if($nameLogo)
            <img src="{{ public_path('/storage/imagens/empresa/').$nameLogo }}">
        @else
            Logo Empresa
        @endif
    </div>
    <div class="header-info">
        <h5 class="nomeEmpresa">
            @if($empresa != null)
                @if( $empresa->nome_fantasia != '')
                    {{$empresa->nome_fantasia}}
                @else
                    {{$empresa->razao_social}}
                @endif
            @else
                {!! "Nome da Empresa" !!}
            @endif

        </h5>
        <h5 class="enderecoEmpresa">
            @php
                if($enderecoEmpresa!= null && strlen($enderecoEmpresa) > 45){
                    $endereco    = substr($enderecoEmpresa,0,45);
                    $endereco    = substr($endereco,0,strripos($endereco, ',')+1);
                    $newEndereco = $endereco."<br/>".substr($enderecoEmpresa,strripos($endereco, ',')+1);
                    echo $newEndereco;
                }else{
                    echo $enderecoEmpresa;
                }
            @endphp
        </h5>
    </div>
</div>

<div class="panel-info">
    <div>
        <h4>{{ $titulo }}</h4>
    </div>
    <div class="panel-info-right">
        <h5>{{date('d/m/Y H:i')}}</h5>
    </div>
</div>