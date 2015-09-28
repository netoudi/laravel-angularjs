<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectTask;

class ProjectTaskTransformer extends TransformerAbstract
{
    public function transform(ProjectTask $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'start_date' => $model->getStartDate(),
            'due_date' => $model->getDueDate(),
            'status' => $model->status,
        ];
    }
}