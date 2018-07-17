<div class="footer">
    <div class="assinaturas" style="right: 0" >
        <div class="assinatura assinatura-next">
            <h6 class="text-assinatura">APROVADO POR</h6>
        </div>
        <div class="assinatura assinatura-next">
            <h6 class="text-assinatura">SEPARADO POR</h6>
        </div>
        <div class="assinatura assinatura-next">
            <h6 class="text-assinatura">ENTREGUE POR</h6>
        </div>
        <div class="assinatura">
            <h6 class="text-assinatura">RECEBIDO POR</h6>
        </div>
    </div>
    <div class="info-empresa">
        @if($empresa)
            @if ($empresa->telefone != '')
                <h6>{{"("  .substr($empresa->telefone,0,2).  ") "  .substr($empresa->telefone,2,4).  "-"  .substr($empresa->telefone,6,8). "      ".$empresa->email."   -   ".  (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" }}</h6>
            @else
                <h6>{{ $empresa->email."   -   ".  (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" }}</h6>
            @endif
        @endif
    </div>
</div>