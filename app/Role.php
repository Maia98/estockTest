<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'description'];
    
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function rules() {

        return [
            'name'          => 'required|unique:roles,name'. (($this->id) ? ', ' . $this->id : ''),
            'description'   =>'required',
        ];
    }

    public $msgRules = [
        'name.unique'           => 'Função já cadastrada.',
        'name.required'         => 'Função não preenchida.',
        'description.required'  => 'Descrição não preenchida.'
    ];
    
}
