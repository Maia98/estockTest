<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Empresa;
use App\Model\Estados;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('CONSULTAR_EMPRESA');
        $empresa   = Empresa::first();
        $estado    = Estados::all()->toArray();
        $estado    = arrayToSelect($estado, 'id', 'uf');
        $estado[0] = "UF";
        $folder    =  'storage/app/imagens/empresa';
        if(!\File::exists($folder))
        {
            Storage::makeDirectory('public/imagens/empresa');
        }

        $file      = \File::allFiles(public_path().'/storage/imagens/empresa/');
        $image     = $file == null ? $file : $file[0]->getFilename();

        return view('pages.empresa.index', compact('empresa','estado','image'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('ALTERAR_EMPRESA');
        $id = $request->input('id');
        $cnpj = $request->input('cnpj');
        $cep = $request->input('cep');
        $telefone = $request->input('telefone');
        $celular = $request->input('celular');
        $erros = null;
        $msg = null;

        $empresa = Empresa::find($id);

        if(!$empresa){
            $empresa = new Empresa();
        }

        $empresa->fill($request->all());

        $empresa->cnpj = str_replace(array('.', '/', '-', '_'), '', $cnpj);
        $empresa->cep = str_replace(array('-', '_'), '', $cep);
        $empresa->telefone = str_replace(array('(',')', ' ', '-', '_'), '', $telefone);
        $empresa->celular = str_replace(array('(',')', ' ', '-', '_'), '', $celular);

                
        if($empresa->uf_id <= 0 ){
            $empresa->uf_id= null;
        }

        $validade = validator($request->all(), $empresa->rules(), $empresa->msgRules);

        if(strlen($empresa->cnpj) != 0){
            if(strlen($empresa->cnpj) != 14){
                $erros .= '<li>CNPJ inválido.</li>';
            }
        }

        if(strlen($empresa->cep) != 0){
            if(strlen($empresa->cep) != 8){
                $erros .= '<li>CEP inválido.</li>';
            }
        }

        if(strlen($empresa->telefone) != 0){
            if(strlen($empresa->telefone) != 10){
                $erros .= '<li>Telefone inválido.</li>';
            }
        }

        if(strlen($empresa->celular) != 0){
            if(strlen($empresa->celular) < 10){
                $erros .= '<li>Celular inválido.</li>';
            }
        }

        if($validade->fails() || strlen($erros) > 0){
            $msg = "$erros".arrayToValidator($validade->getMessageBag());
            notify()->flash($msg, 'warning');
            return back()->withInput();
        }

        if($validade->fails())
        {
            notify()->flash(arrayToValidator($validade->getMessageBag()), 'warning');
            return back()->withInput();
        }

        $save = $empresa->save();

        if($save)
        {
            // Upload de fotos
            if ($request->hasFile('image')) {

                $file      = \File::allFiles(public_path().'/storage/imagens/empresa/');
                if($file != null){
                    $nameExist = $file[0]->getFilename();
                    \File::delete(public_path().'/storage/imagens/empresa/'.$nameExist);
                }

                $id        = $request->input('id') == null ? 1 : $request->input('id');
                $file      = $request->file('image');
                $folder    =  public_path() . '/storage/imagens/empresa';
                $extencion = array('jpg', 'png', 'jpeg');
                
                if(!\File::exists($folder))
                {
                    Storage::makeDirectory('public/storage/imagens/empresa');
                }

                if(in_array($file->getClientOriginalExtension(), $extencion)){
                    if($file->getSize() < 69468){
                        $newName = '1.'.$file->getClientOriginalExtension();
                        if(!$file->move($folder, $newName)){
                            notify()->flash('Erro ao carregar a imagem.', 'danger');
                            return back();
                        }
                    }else{
                        notify()->flash('Tamanho da imagem é maior que 67KB.', 'warning');
                        return back();
                    }
                }else{
                    notify()->flash('Erro extensão permitidas: jpg, jpeg e png.', 'warning');
                    return back();
                }
            }
            notify()->flash('Empresa cadastrado com sucesso.', 'success');
            return back();
        }else{
            notify()->flash('Erro ao cadastrar Empresa.', 'danger');
            return back();
        }
        
    }
}