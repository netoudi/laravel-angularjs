<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Services\ProjectService;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectTaskController extends Controller
{
    /**
     * @var ProjectTaskService
     */
    private $service;
    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * @param ProjectTaskService $service
     * @param ProjectService $projectService
     */
    public function __construct(ProjectTaskService $service, ProjectService $projectService)
    {
        $this->service = $service;
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return Response
     */
    public function index($id)
    {
        if ($this->checkProjectPermissions($id) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->all($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @param int $projectId
     * @return Response
     */
    public function store(Request $request, $projectId)
    {
        if ($this->checkProjectPermissions($projectId) == false) {
            return ['error' => 'Access Forbidden'];
        }

        $data = $request->all();
        $data['project_id'] = $projectId;

        return $this->service->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param int $taskId
     * @return Response
     */
    public function show($id, $taskId)
    {
        if ($this->checkProjectPermissions($id) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->find($id, $taskId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param int $id
     * @param  int $taskId
     * @return Response
     */
    public function update(Request $request, $id, $taskId)
    {
        if ($this->checkProjectOwner($id) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->update($request->all(), $taskId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param  int $taskId
     * @return Response
     */
    public function destroy($id, $taskId)
    {
        if ($this->checkProjectOwner($id) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->delete($taskId);
    }

    private function checkProjectOwner($projectId)
    {
        return $this->projectService->isOwner($projectId, Authorizer::getResourceOwnerId());
    }

    private function checkProjectMember($projectId)
    {
        return $this->projectService->hasMember($projectId, Authorizer::getResourceOwnerId());
    }

    private function checkProjectPermissions($projectId)
    {
        if ($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)) {
            return true;
        }

        return false;
    }
}
