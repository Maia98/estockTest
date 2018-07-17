<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListFormValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'name_plura' => 'required',
            'sort_model' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'name.required' => 'Nome não preenchido',
            'name_plura.required' => 'Nome Plural não preenchido',
            'sort_model.required' => 'Ordenação não selecionada',
        ];
    }
}
