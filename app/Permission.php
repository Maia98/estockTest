<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = ['name', 'description'];

    public function roles()
    {
        return $this->belongsToMany('\App\Role');
    }

    public function rules()
    {
        return [ 
            'name' => 'required|unique:permissions,name'. (($this->id) ? ', ' . $this->id : ''),
            'description' => 'required'
        ];
    }

    public $mensages = [
        'name.unique' => 'Ação já cadastrada',
        'name.required' => 'Ação não preenchida',
        'description.required' => 'Descrição não preenchida.',
    ];

}
