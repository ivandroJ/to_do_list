<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\V1\TodoTaskData;
use App\Http\Controllers\Controller;
use App\Models\TodoTask;
use App\Services\TodoTask\V1\CreateTodoTaskService;
use App\Services\TodoTask\V1\ListTodoTasksByUserService;
use Illuminate\Http\Request;

class TodoTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListTodoTasksByUserService $listTodoTasksByUserService)
    {
        return response()->json([
            'message' => 'Lista de tarefas obtida com sucesso.',
            'data' => $listTodoTasksByUserService->execute()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreateTodoTaskService $createTodoTaskService)
    {
        $todoTaskData = TodoTaskData::from($request->only('title', 'description'));

        return response()->json([
            'message' => 'Tarefa criada com sucesso.',
            'data' => $createTodoTaskService->execute($todoTaskData)
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(TodoTask $todoTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TodoTask $todoTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TodoTask $todoTask)
    {
        //
    }
}
