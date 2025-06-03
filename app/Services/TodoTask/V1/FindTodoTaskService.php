<?php

namespace App\Services\TodoTask\V1;

use App\Data\V1\TodoTaskData;
use App\Models\TodoTask;
use App\TodoTaskStatusEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FindTodoTaskService
{
    private TodoTask $todoTask;

    public function execute($todo_task_id)
    {
        $this->todoTask = TodoTask::find($todo_task_id);

        return $this->validateData() ?: response()->json([
            'data' => TodoTaskData::from($this->todoTask)
        ]);;
    }

    private function validateData()
    {
        if (!$this->todoTask) {
            return response()->json([
                'message' => 'Task not found.',
                'errors' => [
                    'task' => 'The requested task does not exist.'
                ]
            ], 404);
        }

        if ($this->todoTask->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized.',
                'errors' => [
                    'user' => 'You are not authorized to view this task.'
                ]
            ], 401);
        }

        return null;
    }
}
