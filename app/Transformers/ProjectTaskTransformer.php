<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectTask;

class ProjectTaskTransformer extends TransformerAbstract{
	
	public function transform(ProjectTask $projectTask){
		return[
			'project_task' => $projectTask->id,
			'project_id' => $projectTask->project_id,
    		'name' => $projectTask->name,
    		'start_date' => $projectTask->start_date,
    		'due_date' => $projectTask->due_date,
    		'status' => $projectTask->status,
		];
	}
	
}