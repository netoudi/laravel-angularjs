<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['owner', 'client', 'notes', 'tasks', 'members', 'files'];

    public function transform(Project $project)
    {
        return [
            'id' => $project->id,
            'name' => $project->name,
            'description' => $project->description,
            'progress' => (int)$project->progress,
            'status' => $project->status,
            'due_date' => $project->getDueDate(),
            'is_member' => $project->owner_id != Authorizer::getResourceOwnerId(),
            'task_count' => $project->tasks->count(),
            'task_opened' => $this->countTasksOpened($project)
        ];
    }

    public function includeOwner(Project $project)
    {
        return $this->item($project->owner, new UserTransformer());
    }

    public function includeClient(Project $project)
    {
        return $this->item($project->client, new ClientTransformer());
    }

    public function includeNotes(Project $project)
    {
        return $this->collection($project->notes, new ProjectNoteTransformer());
    }

    public function includeTasks(Project $project)
    {
        return $this->collection($project->tasks, new ProjectTaskTransformer());
    }

    public function includeMembers(Project $project)
    {
        return $this->collection($project->members, new UserTransformer());
    }

    public function includeFiles(Project $project)
    {
        return $this->collection($project->files, new ProjectFileTransformer());
    }

    private function countTasksOpened(Project $project)
    {
        $count = 0;
        foreach ($project->tasks as $o) {
            if ($o->status == 1) {
                $count++;
            }
        }

        return $count;
    }
}
