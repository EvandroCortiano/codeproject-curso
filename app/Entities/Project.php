<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Project extends Model implements Transformable 
{
	use TransformableTrait;
	
	protected $fillable = [ 
		'owner_id',
		'client_id',
		'name',
		'description',
		'progress',
		'status',
		'due_date' 
	];

	//relacionamento 1 - * com a tabela project_notes
	public function notes(){
		return $this->hasMany(ProjectNote::class);
	}
	
	//relacionamento * - 1 com a tabela client
	public function client(){
		return $this->belongsTo(Client::class);
	}
	
	//relacionamento 1 - * com a tabela project_tasks
	public function tasks(){
		return $this->hasMany(ProjectTask::class);
	}
	
<<<<<<< HEAD
	public function users(){
		return $this->belongsToMany(User::class);
	}
=======
	//relacionamento * - * com a tabela Users
	public function users(){
		return $this->belongsToMany(User::class, 'project_members', 'project_id', 'user_id');
	}
	
>>>>>>> 912700d3fd518e603df5d9e459f1fa5f0933bd01
}
