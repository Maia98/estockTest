<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\NotificationReset;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'data_inicio_filtro', 'data_fim_filtro',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
    
    public function authorizeRoles($roles)
    {
        if($this->hasAnyRole($roles))
        {
            return true;
        }
        
        abort(401, 'Ação não autorizada.');
    }

    public function hasPermission(Permission $permission)
    {
        return $this->hasAnyRole($permission->roles);
    }
    
    public function hasAnyRole($roles)
    {
        if(is_array($roles))
        {
            foreach ($roles as $role)
            {
                if($this->hasRole($role))
                {
                    return true;
                }
            }
        }else if(is_object($roles)){
            foreach ($roles as $role)
            {
                if($this->hasRole($role->name))
                {
                    return true;
                }
            }
        } else {
            if($this->hasRole($roles))
            {
                return true;
            }
        }
        
        return false;
    }
    
    public function hasRole($role)
    {
        if($this->roles()->where('name', $role)->first())
        {
            return true;
        }
        
        return false;
    }

    public static function getUsersByRole($role)
    {
        return DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('roles.name', $role);
    }

    public function rules(){
        return $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email'. (($this->id) ? ', ' . $this->id : ''),
        ];
    }

    public $mensages = [
        'name.required' => 'O nome do Usuário é obrigatório.',
        'name.max' => 'O tamanho máximo do nome é de 255 caracteres',
        'email.required' => 'O e-mail do Usuário é obrigatório.',
        'email.max' => 'O tamanho máximo do e-mail é de 255 caracteres',
        'email.email' => 'E-mail em um formato inválido',
        'email.unique' => 'E-mail já cadastrado para outro Usuário.'
    ];
    //Função para enviar notificao de recuperar senha
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new NotificationReset($token));
    }
}
