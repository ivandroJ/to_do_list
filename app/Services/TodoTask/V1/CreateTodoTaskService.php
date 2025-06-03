<?php

namespace App\Services\TodoTask\V1;

use App\Data\V1\TodoTaskData;
use App\Models\TodoTask;
use App\TodoTaskStatusEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreateTodoTaskService
{
    private TodoTaskData $todoTaskData;

    public function execute(TodoTaskData $todoTaskData)
    {
        $this->todoTaskData = $todoTaskData;

        return $this->validateData() ?: $this->createTodoTask();
    }

    private function validateData()
    {
        if (empty($this->todoTaskData->title)) {
            return response()->json([
                'message' => 'Title is required.',
                'errors' => [
                    'title' => 'Title is required.'
                ]
            ], 422);
        }

        if (strlen($this->todoTaskData->title) < 3 || strlen($this->todoTaskData->title) > 250) {
            return response()->json([
                'message' => 'Title must be between 3 and 250 characters long.',
                'errors' => [
                    'title' => 'Title must be between 3 and 250 characters long.'
                ]
            ], 422);
        }

        if (isset($this->todoTaskData->description) && strlen($this->todoTaskData->description) > 1000) {
            return response()->json([
                'message' => 'Description must not exceed 1000 characters.',
                'errors' => [
                    'description' => 'Description must not exceed 1000 characters.'
                ]
            ], 422);
        }

        return null;
    }

    private function createTodoTask()
    {

        return response()->json([
            'message' => 'Tarefa criada com sucesso.',
            'data' => TodoTaskData::from(TodoTask::create([
                'title' => $this->todoTaskData->title,
                'description' => $this->todoTaskData->description,
                'user_id' => Auth::id(),
                'status' => TodoTaskStatusEnum::PENDING->label(),
            ]))
        ], 201);
    }
}
