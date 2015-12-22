<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectFile;

class ProjectFileTransformer extends TransformerAbstract
{
    public function transform(ProjectFile $model)
    {
        return [
            'id' => $model->id,
            'project_id' => $model->project->id,
            'name' => $model->name,
            'description' => $model->description,
            'file' => $model->file,
            'extension' => $model->extension,
            'created_at' => $model->getCreatedAt(),
            'updated_at' => $model->getUpdatedAt(),
        ];
    }
}
