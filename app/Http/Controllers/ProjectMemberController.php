<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Http\Requests;
use CodeProject\Services\ProjectMemberService;
use Illuminate\Http\Request;

class ProjectMemberController extends Controller
{
    /**
     * @var ProjectMemberService
     */
    private $service;

    /**
     * @param ProjectMemberService $service
     */
    public function __construct(ProjectMemberService $service)
    {
        $this->service = $service;
        $this->middleware('check.project.owner', ['except' => ['index', 'show']]);
        $this->middleware('check.project.permission', ['except' => ['index', 'show']]);
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
     * @param  int $projectId
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
     * @param int $memberId
     * @return Response
     */
    public function show($id, $memberId)
    {
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
        return $this->service->delete($id, $memberId);
    }
}
