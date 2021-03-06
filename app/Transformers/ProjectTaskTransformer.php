<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectTask;

class ProjectTaskTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['project'];

    public function transform(ProjectTask $model)
    {
        return [
            'id' => $model->id,
            'project_id' => $model->project_id,
            'name' => $model->name,
            'start_date' => $model->getStartDate(),
            'due_date' => $model->getDueDate(),
            'status' => $model->status,
            'created_at' => $model->getCreatedAt(),
            'updated_at' => $model->getUpdatedAt(),
        ];
    }

    public function includeProject(ProjectTask $model)
    {
        return $this->item($model->project, new ProjectTransformer());
    }
}
