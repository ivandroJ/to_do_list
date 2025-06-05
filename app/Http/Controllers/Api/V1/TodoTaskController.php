<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\V1\TodoTaskData;
use App\Http\Controllers\Controller;
use App\Http\Requests\TodoTask\V1\StoreTodoTaskRequest;
use App\Http\Requests\TodoTask\V1\UpdateTodoTaskRequest;
use App\Services\TodoTask\V1\CreateTodoTaskService;
use App\Services\TodoTask\V1\DeleteTodoTaskService;
use App\Services\TodoTask\V1\FindTodoTaskService;
use App\Services\TodoTask\V1\ListTodoTasksByUserService;
use App\Services\TodoTask\V1\UpdateTodoTaskStatusService;
use Illuminate\Http\Request;

class TodoTaskController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/v1/todo-tasks",
     *     summary="Get a list of todo tasks for the authenticated user",
     *     tags={"TodoTasks"},
    *     @OA\Parameter(
    *         name="by_status",
    *         in="query",
    *         description="Filter tasks by status. Allowed values: Pendente, Em andamento, Concluida",
    *         required=false,
    *         @OA\Schema(
    *             type="string",
    *             enum={"Pendente", "Em andamento", "Concluida"}
    *         )
    *     ),
     *  @OA\Response(
     *         response=200,
     *         description="List of todo tasks",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TodoTask"))
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index(Request $request, ListTodoTasksByUserService $listTodoTasksByUserService)
    {
        return $listTodoTasksByUserService->execute($request->input('by_status', null));
    }

    /**
     * @OA\Post(
     *     path="/api/v1/todo-tasks",
     *     summary="Create a new todo task",
     *     tags={"TodoTasks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TodoTask")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Todo task created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TodoTask")
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function store(StoreTodoTaskRequest $request, CreateTodoTaskService $createTodoTaskService)
    {
        $todoTaskData = TodoTaskData::from($request->only('title', 'description'));

        return $createTodoTaskService->execute($todoTaskData);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/todo-tasks/{id}",
     *     summary="Get a specific todo task by ID",
     *     tags={"TodoTasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the todo task",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo task details",
     *         @OA\JsonContent(ref="#/components/schemas/TodoTask")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Todo task not found"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function show($id, FindTodoTaskService $findTodoTaskService)
    {
        return $findTodoTaskService->execute($id);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/todo-tasks/{id}",
     *     summary="Update the status of a todo task",
     *     tags={"TodoTasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the todo task",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"status"},
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 description="The new status for the todo task"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo task status updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TodoTask")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid status provided"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function update(UpdateTodoTaskRequest $request, $id)
    {
        $updateTodoTaskStatusService = new UpdateTodoTaskStatusService($id, $request->input('status'));

        return $updateTodoTaskStatusService->execute();
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/todo-tasks/{id}",
     *     summary="Delete a todo task",
     *     tags={"TodoTasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the todo task",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Todo task deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Todo task not found"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function destroy($id, DeleteTodoTaskService $deleteTodoTaskService)
    {
        return $deleteTodoTaskService->execute($id);
    }
}
