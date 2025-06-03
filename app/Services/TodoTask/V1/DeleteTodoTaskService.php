<?php

namespace App\Services\TodoTask\V1;

use App\Data\V1\TodoTaskData;
use App\Models\TodoTask;
use App\TodoTaskStatusEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DeleteTodoTaskService
{

    public function execute($todo_task_id)
    {
        $todoTask = TodoTask::find($todo_task_id);

        if (!$todoTask) {
            return response()->json([
                'message' => 'Task not found.',
                'errors' => [
                    'task' => 'The requested task does not exist.'
                ]
            ], 404);
        }

        if ($todoTask->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized.',
                'errors' => [
                    'user' => 'You are not authorized to delete this task.'
                ]
            ], 401);
        }

        $todoTask->delete();

        return response()->json([
            'message' => 'Task deleted successfully.'
        ], 204);
    }

    
}
