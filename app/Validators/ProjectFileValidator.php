<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator{
	
	protected $rules = [
		'name' => 'required|max:50', 
		'description' => 'required|max:255',
		'extension' => 'required|max:10',
	];
}