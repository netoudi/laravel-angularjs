<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectNote;

class ProjectNoteTransformer extends TransformerAbstract
{
    public function transform(ProjectNote $model)
    {
        return [
            'id' => $model->id,
            'title' => $model->title,
            'note' => $model->note,
            'created_at' => $model->getCreatedAt(),
            'updated_at' => $model->getUpdatedAt(),
        ];
    }
}
