@extends('layouts.default')

@section('main-content')
<style>
    #file-upload{
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    #file-upload span{
       font-size: 1.1em;
    }

    #file-upload span i{
       margin-left: 2%;
    }

    #file-upload #arquivo{
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }

    #salvar-documents-obra{
        width: 100%;
        font-size: 1.1em;
    }
    .preview-thumb{
        width: 100%;
        height: 24vh;
        max-height: 300px;
        border: 1px dashed #c9c9c9;
        overflow: scroll;
        overflow-x: hidden;
        overflow-y: auto;
        padding: 10px;
        margin-bottom: 20px;
        position: relative;
    }
    .preview-thumb::-webkit-scrollbar
    {
        width: 7px;
        background-color: transparent;
    }

    .preview-thumb::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #3c8dbc;
    }
    .image-preview{
        border-radius: 10px;
        width: 150px;
        height: 150px;
        padding: 4px;
        margin: 0 10px 10px 0;
        float: left;
        border: 1px solid #efefef;
        box-shadow: 0px 0px 20px rgba(136, 136, 136, 0.2);
        background-color: #f7f7f7;
        position: relative;
        overflow: hidden;
    }

    .image-preview img{
        width: 100%;
        height: 72%;
        border-radius: 10px 10px 0 0;
    }

    .image-preview .name-thumb{
        width: 100%;
        padding: 5px;
        background-color: rgb(247, 247, 247);
        color: #000000;
        position: absolute;
        bottom: 5px;
        left: 0;
        right:  0;
        margin: auto;
        text-align: center;
        font-weight: bold;
    }

    .image-preview .delete-thumb{
        position: absolute;
        font-size: 1.5em;
        top: 3px;
        color: #3c8dbc;
        padding: 5px;
        border-radius: 50%;
        right:  3px;
        margin: auto;
        cursor: pointer;
    }

    .delete-thumb:hover {
         animation-name: rotate;
         animation-duration: 600ms;
         animation-iteration-count: 1;
         animation-timing-function: linear;
     }

    @keyframes rotate {
        0%  {-webkit-transform: rotate(0deg);}
        25% {-webkit-transform: rotate(180deg);}
        75% {-webkit-transform: rotate(180deg);}
        100% {-webkit-transform: rotate(0deg);}

    }

    .img-save .acoes{
        text-align: center;
        position: absolute;
        bottom: 0;
        left: 0;
        background-color: #fff;
        width: 100%;
        padding: 5px;
    }

    .import-buttons{
        border: 1px dashed #c9c9c9;
        height: 16vh;
    }
    .upload-text{
        font-size: 1.4em;
    }

</style>
<div class="box">
    <div class="box-header page-header">
        <h1><i class="glyphicon glyphicon-menu-right"></i> Documentos Anexados</h1>
        <div id='alert' class="alert "></div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(['action' => ('ObraController@storeDocuments'), 'id' => 'form-store-documents', 'files' => 'true']) !!}
                    {!! Form::hidden('id', $id, ['id' => 'obra_id']) !!}
                    <div id='alert-modal' class="alert"></div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="import-buttons">
                                    <div class="col-md-12 upload-text text-center ">
                                        <p><b>Fazer upload de arquivos</b></p>
                                    </div>
                                    <div class="col-md-2 col-md-offset-4 upload">
                                        <div class="btn btn-primary" id="file-upload">
                                            <span>Importar <i class="fa fa-cloud-upload" aria-hidden="true"></i></span>
                                            {{ Form::file('arquivo', ['accept' => '.xls, .xlsx, .docx, .doc, .pdf, .png, .jpge, .jpg', 'id' => 'arquivo', 'name' =>'files[]', 'multiple']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class='btn btn-primary' id='salvar-documents-obra'>Salvar <i class="fa fa-floppy-o" style="padding-left: 2%" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="preview-thumb" id="upload_files"></div>
                            </div>
                        </div>
                {!! Form::close() !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <h3><b>Arquivos</b></h3>
            </div>
            <div class="col-md-12">
                <div class="preview-thumb" id="download-files">
                    @php
                        $indexImg = 0;
                    @endphp
                    @foreach($allFiles as $key => $row)
                        @if($row->getExtension() == 'jpg' || $row->getExtension() == 'JPG' || $row->getExtension() == 'PNG' ||$row->getExtension() == 'png' || $row->getExtension() == 'jpeg' || $row->getExtension() == 'JPEG')
                            <div class='image-preview' name="{{$row->getFilename()}}">
                                <img src="{{ asset('storage/documetos-anexados/obra/'.$obra->numero_obra.'/'.$row->getFilename()) }}" name="{{$row->getFilename()}}" />
                                <div  class="img-save">
                                    <div class="acoes">
                                        <button type="button" class="btn btn-primary btn-xs"  onClick="documentDownload('{{$row->getFilename()}}','{{ $obra->numero_obra }}', '{{ $row->getExtension() }}');"><i class="fa fa-download download-document" ></i></button>
                                        <button class="btn btn-danger btn-xs"  onClick="documentDelete('{{$row->getFilename()}}','{{ $obra->numero_obra }}');"><i class="fa fa-trash delete-document" ></i></button>
                                        <button class="btn btn-default btn-xs"  onclick="abrirImagemFullScreen({{ $indexImg }}, 'obra', '{{ $obra->id}}')"><i class="fa fa-eye" ></i></button>
                                    </div>
                                </div>
                            </div>
                            @php
                                $indexImg += 1;
                            @endphp

                        @else
                            <div class='image-preview' name="{{$row->getFilename()}}">
                                <center>
                                    <img src="{{ asset('img/'.$row->getExtension().'.png') }}" name="{{$row->getFilename()}}" style="max-width: 74%;"/>
                                </center>
                                <div  class="img-save">
                                    <div class="acoes">
                                        <button type="button" class="btn btn-primary btn-xs" onClick="documentDownload('{{$row->getFilename()}}','{{$obra->numero_obra}}','{{$row->getExtension() }}' );"><i class="fa fa-download download-document" ></i></button>
                                        <button type="button" class="btn btn-danger btn-xs"  onClick="documentDelete('{{$row->getFilename()}}','{{ $obra->numero_obra }}');"><i class="fa fa-trash delete-document" ></i></button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">

    </div>
</div>
@stop

@section('scripts-footer')

    <script type="text/javascript" src="{{ asset('js/obra-documents.js') }}"></script>

@stop