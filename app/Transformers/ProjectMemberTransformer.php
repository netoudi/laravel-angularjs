<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectMember;

class ProjectMemberTransformer extends TransformerAbstract
{
    public function transform(ProjectMember $model)
    {
        return [
            'id' => $model->member->id,
            'name' => $model->member->name,
            'email' => $model->member->email,
        ];
    }
}
