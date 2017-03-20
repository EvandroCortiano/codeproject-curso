<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectNote;

class ProjectNoteTransformer extends TransformerAbstract{
	
	public function transform(ProjectNote $projectNote){
		return [
			'note_id' => $projectNote->id,
			'project_id' => $projectNote->project_id,
			'title' => $projectNote->title,
			'note' => $projectNote->note,
		];
	}
	
}