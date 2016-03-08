<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\ProjectTask;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ProjectTaskRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectTaskRepositoryEloquent extends BaseRepository implements ProjectTaskRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectTask::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function recentTasks($userId, $limit = 6)
    {
        return $this->scopeQuery(function ($query) use ($userId, $limit) {
            return $query->select('project_tasks.*')
                ->whereIn('project_tasks.project_id', function ($query) use ($userId) {
                    return $query->select('projects.id')
                        ->from('projects')
                        ->leftJoin('project_members', 'projects.id', '=', 'project_members.project_id')
                        ->orWhere('projects.owner_id', '=', $userId)
                        ->orWhere('project_members.member_id', '=', $userId)
                        ->groupBy('projects.id');
                })->orderBy('project_tasks.updated_at', 'desc')->limit($limit);
        })->all();
    }
}
