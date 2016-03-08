<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Http\Requests;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    /**
     * @var ProjectTaskService
     */
    private $service;

    /**
     * @param ProjectTaskService $service
     */
    public function __construct(ProjectTaskService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return Response
     */
    public function index($id)
    {
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
        return $this->service->delete($taskId);
    }

    public function recentTasks()
    {
        return $this->service->all();
    }
}
