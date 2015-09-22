<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Services\ProjectMemberService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;

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
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
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
