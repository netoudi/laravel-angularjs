<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ProjectNote extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'project_id',
        'title',
        'note'
    ];

    public function getCreatedAt()
    {
        $date = new \DateTime($this->created_at);
        return $date->format('c');
    }
    public function getUpdatedAt()
    {
        $date = new \DateTime($this->updated_at);
        return $date->format('c');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
