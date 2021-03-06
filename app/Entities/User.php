<?php

namespace CodeProject\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    

    //relacionamento * - * com a tabela project
    public function project(){
    	return $this->belongsToMany(Project::class, 'project_members', 'user_id', 'project_id');
    }
}
