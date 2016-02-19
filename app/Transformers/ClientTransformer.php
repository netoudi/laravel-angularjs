<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\Client;

class ClientTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['projects'];

    public function transform(Client $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'responsible' => $model->responsible,
            'email' => $model->email,
            'phone' => $model->phone,
            'address' => $model->address,
            'skype' => $model->skype,
            'twitter' => $model->twitter,
            'facebook' => $model->facebook,
            'google_plus' => $model->google_plus,
            'website' => $model->website,
            'obs' => $model->obs,
        ];
    }

    public function includeProjects(Client $model)
    {
        return $this->collection($model->projects, new ClientProjectTransformer());
    }
}
