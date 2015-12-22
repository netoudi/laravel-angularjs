<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Services\ProjectFileService;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;
use CodeProject\Http\Requests;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectFileController extends Controller
{
    /**
     * @var ProjectFileService
     */
    private $service;
    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * @param ProjectFileService $service
     * @param ProjectService $projectService
     */
    public function __construct(ProjectFileService $service, ProjectService $projectService)
    {
        $this->service = $service;
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $projectId
     * @return Response
     */
    public function index($projectId)
    {
        if ($this->checkProjectPermissions($projectId) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->all($projectId);
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

        return $this->service->create($projectId, $request->file('file'), $request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param $projectId
     * @param int $fileId
     * @return Response
     * @internal param int $id
     */
    public function show($projectId, $fileId)
    {
        if ($this->checkProjectPermissions($projectId) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->find($projectId, $fileId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param int $projectId
     * @param int $fileId
     * @return Response
     * @internal param int $id
     */
    public function update(Request $request, $projectId, $fileId)
    {
        if ($this->checkProjectOwner($projectId) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->update($projectId, $fileId, $request->file('file'), $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $projectId
     * @param int $fileId
     * @return Response
     * @internal param int $id
     */
    public function destroy($projectId, $fileId)
    {
        if ($this->checkProjectOwner($projectId) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->delete($projectId, $fileId);
    }

    /**
     * @param $projectId
     * @param $fileId
     * @return array|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function showFile($projectId, $fileId)
    {
        if ($this->checkProjectPermissions($projectId) == false) {
            return ['error' => 'Access Forbidden'];
        }

        return response()->download($this->service->getFilePath($projectId, $fileId));
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
