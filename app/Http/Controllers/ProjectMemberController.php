<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Services\ProjectMemberService;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectMemberController extends Controller
{
    /**
     * @var ProjectMemberService
     */
    private $service;
    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * @param ProjectMemberService $service
     * @param ProjectService $projectService
     */
    public function __construct(ProjectMemberService $service, ProjectService $projectService)
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
     * @param  int $projectId
     * @return Response
     */
    public function store(Request $request, $projectId)
    {
        if ($this->checkProjectOwner($projectId) == false) {
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
     * @param int $memberId
     * @return Response
     */
    public function show($id, $memberId)
    {
        if ($this->checkProjectPermissions($id) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->find($id, $memberId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param  int $memberId
     * @return Response
     */
    public function destroy($id, $memberId)
    {
        if ($this->checkProjectOwner($id) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->delete($id, $memberId);
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
