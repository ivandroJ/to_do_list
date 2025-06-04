<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\V1\TodoTaskData;
use App\Http\Controllers\Controller;
use App\Http\Requests\TodoTask\V1\StoreTodoTaskRequest;
use App\Http\Requests\TodoTask\V1\UpdateTodoTaskRequest;
use App\Models\TodoTask;
use App\Services\TodoTask\V1\CreateTodoTaskService;
use App\Services\TodoTask\V1\DeleteTodoTaskService;
use App\Services\TodoTask\V1\FindTodoTaskService;
use App\Services\TodoTask\V1\ListTodoTasksByUserService;
use App\Services\TodoTask\V1\UpdateTodoTaskStatusService;
use App\TodoTaskStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ListTodoTasksByUserService $listTodoTasksByUserService)
    {
        return $listTodoTasksByUserService->execute($request->input('by_status', null));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoTaskRequest $request, CreateTodoTaskService $createTodoTaskService)
    {
        $todoTaskData = TodoTaskData::from($request->only('title', 'description'));

        return $createTodoTaskService->execute($todoTaskData);
    }


    /**
     * Display the specified resource.
     */
    public function show($id, FindTodoTaskService $findTodoTaskService)
    {
        return $findTodoTaskService->execute($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoTaskRequest $request, $id)
    {
        $updateTodoTaskStatusService = new UpdateTodoTaskStatusService($id, $request->input('status'));

        return $updateTodoTaskStatusService->execute();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, DeleteTodoTaskService $deleteTodoTaskService)
    {
        return $deleteTodoTaskService->execute($id);
    }
}
