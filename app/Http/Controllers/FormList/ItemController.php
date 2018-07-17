<?php

namespace App\Http\Controllers\FormList;

use App\Model\Form\ListItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lista_id = $_GET['id'];

        return view("pages.list.formitem", compact('lista_id'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        $id = $request->input('id');

        $item = ListItem::find($id);

        if (!$item) {
            $item = new ListItem();
        }

        $item->fill($request->all());

        $validator = validator($request->all(), [
            'value' => 'required',
            'extra' => 'nullable',
        ], [
                'value.required' => 'Valor não preenchido',
            ]
        );

        if ($validator->fails()) {

            return redirect('/sistema/list/')
                ->withErrors($validator)
                ->withInput();
        } else {

            if (isset($item))
                $save = $item->save();
            else
                $create = $item->create($request->all());

            if ($save || $create) {
                return redirect('/sistema/list');
            } else {
                return redirect('/sistema/list')
                    ->withErrors('ERROR')
                    ->withInput();
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $dados = array(
            'itens' => ''
        );
        $dados['itens'] = ListItem::where('lista_id', $id)->orderBy('id', 'desc')->get();
        echo json_encode($dados);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        if (ListItem::find($id)) {
            $item = ListItem::find($id);
        }
        return view('pages.list.formitem', compact('item'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {


        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        $id = $request->input('id');

        $item = ListItem::find($id);

        $alert = "Erro ao excluir item";
        if (isset($item)) {
            $delete = ListItem::destroy($id);

            if ($delete) {
                return redirect()->action('FormList\ItemController@show', compact('id'));
            } else {
                return view('pages.list.formitem', compact('alert'));
            }
        }

        /*if (!empty($item)){
            try {
                $delete = DB::table('list_items')
                    ->where('id', $id)
                    ->delete();
                if ($delete){
                    echo "chegou aqui = TRUE";
                    exit();
                    notify()->flash('Item excluido com sucesso.', 'success');
                }else{
                    echo "chegou aqui = FALSE";
                    exit();
                    notify()->flash('Erro ao excluir Item.');
                }
            }catch (\Exception $exc){
                if( $exc->getCode() == 23503) {

                    notify()->flash('Não é permitido excluir Item em uso.', 'danger');

                }else{

                    notify()->flash('Erro ao excluir Item.', 'danger');
                }
            }finally {
                return redirect()->action('FormList\ItemController@show',compact('id'));
            }*/
    }



    public function delete($id, ListItem $item){
        $this->authorize('EXCLUIR_TABELAS_SISTEMA');

        if (ListItem::find($id)){
            $item = ListItem::find($id);
        }

        $this->authorize('EXCLUIR_TABELAS_SISTEMA');
        return view('pages.list.deleteItem', compact(['item']));
    }
}
