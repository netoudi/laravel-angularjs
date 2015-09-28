<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Services\ProjectFileService;
use Illuminate\Http\Request;
use CodeProject\Http\Requests;

class ProjectFileController extends Controller
{
    /**
     * @var ProjectFileService
     */
    private $service;

    /**
     * @param ProjectFileService $service
     */
    public function __construct(ProjectFileService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $projectId
     * @return Response
     */
    public function index($projectId)
    {
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
        return $this->service->delete($projectId, $fileId);
    }
}
