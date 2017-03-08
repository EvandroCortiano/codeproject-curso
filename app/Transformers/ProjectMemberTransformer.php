<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\User;

class ProjectMemberTransformer extends TransformerAbstract{
	
	public function transform(User $member){
		return [
			'member_id' => $member->id,
			'name' => $member->name,
		];
	}
}