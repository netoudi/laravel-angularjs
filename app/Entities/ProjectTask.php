<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ProjectTask extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'project_id',
        'name',
        'start_date',
        'due_date',
        'status'
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

    public function getStartDate()
    {
        $date = new \DateTime($this->start_date);
        return $date->format('c');
    }

    public function getDueDate()
    {
        $date = new \DateTime($this->due_date);
        return $date->format('c');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
