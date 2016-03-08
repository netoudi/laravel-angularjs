<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['owner', 'client', 'notes', 'tasks', 'members', 'files'];

    public function transform(Project $project)
    {
        return [
            'id' => $project->id,
            'name' => $project->name,
            'description' => $project->description,
            'progress' => $this->countProgress($project),
            'status' => $project->status,
            'start_date' => $project->getStartDate(),
            'due_date' => $project->getDueDate(),
            'is_member' => $project->owner_id != Authorizer::getResourceOwnerId(),
            'task_count' => $project->tasks->count(),
            'task_opened' => $this->countTasksOpened($project),
            'expected_progress' => $this->countExpectedProgress($project),
            'day_count' => $this->countDay($project)
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
        $transformer = new ProjectTaskTransformer();
        $transformer->setDefaultIncludes([]);

        return $this->collection($project->tasks, $transformer);
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
            if ($o->status < 3) {
                $count++;
            }
        }

        return $count;
    }

    private function countProgress(Project $project)
    {
        if ($project->tasks->count() > 0) {
            if ($this->countTasksOpened($project) > 0) {
                $progress = $this->countTasksOpened($project) * 100 / $project->tasks->count();
                $project->progress = (int)$progress;
            } else {
                $project->progress = 100;
                $project->status = 3;
            }
            $project->save();
            return $project->progress;
        }
        return 0;
    }

    private function countExpectedProgress(Project $project)
    {
        $nowDate = new \DateTime('now');
        $tasksOpen = $this->countTasksOpened($project);

        $countLate = 0;
        foreach ($project->tasks as $o) {
            $startDate = new \DateTime($o->start_date);
            $dueDate = new \DateTime($o->due_date);
            if (($o->status == 0 || $o->status == 1) && $startDate <= $nowDate) {
                $countLate++;
            } elseif ($o->status < 3 && $dueDate <= $nowDate) {
                $o->status = 2;
                $o->save();
                $countLate++;
            }
        }

        if ($countLate > 0) {
            return (int)($countLate * 100 / $tasksOpen);
        }
        return 0;
    }

    private function countDay(Project $project)
    {
        $nowDate = new \DateTime('now');
        $startDate = new \DateTime($project->start_date);
        $dueDate = new \DateTime($project->due_date);

        if ($project->status == 0) { // Não iniciou
            return '+0';
        } elseif ($project->status == 1) { // Iniciado
            $interval = $startDate->diff($nowDate);
            return '+' . $interval->d;
        } elseif ($project->status == 2) { // Atrasado
            $interval = $dueDate->diff($nowDate);
            return '-' . $interval->d;
        } elseif ($project->status == 3) { // Concluído
            $interval = $startDate->diff($dueDate);
            return '+' . $interval->d;
        }
    }
}
