<?php

namespace App\Services\TodoTask\V1;

use App\Data\V1\TodoTaskData;
use App\Models\TodoTask;
use App\TodoTaskStatusEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UpdateTodoTaskStatusService
{
    private TodoTask $todoTask;

    public function __construct(
        $todo_task_id,
        private ?String $new_status
    ) {
        $this->todoTask = TodoTask::find($todo_task_id);
    }

    public function execute()
    {
        return match ($this->new_status) {
            TodoTaskStatusEnum::IN_PROGRESS->label() => $this->inProgress(),
            TodoTaskStatusEnum::COMPLETED->label() => $this->completed(),
            null => response()->json([
                'message' => 'Status is required.',
                'errors' => [
                    'status' => 'Status is required.'
                ]
            ], 422),
            default => response()->json([
                'message' => 'Invalid status provided.',
                'errors' => [
                    'status' => 'Invalid status provided. Valid values are: ' . implode(
                        ', ',
                        [TodoTaskStatusEnum::IN_PROGRESS->label(), TodoTaskStatusEnum::COMPLETED->label()]
                    )
                ]
            ], 422),
        };
    }

    private function inProgress()
    {

        if (!$this->todoTask->isPeding()) {
            return response()->json([
                'message' => 'Task must be in pending status to update to in progress.',
                'errors' => [
                    'status' => 'Task must be in pending status to update to in progress.'
                ]
            ], 422);
        }

        return $this->validate() ?: $this->update($this->todoTask, TodoTaskStatusEnum::IN_PROGRESS->label());
    }

    private function completed()
    {

        if (!$this->todoTask->isInProgress()) {
            return response()->json([
                'message' => 'Task must be in progress status to update to completed.',
                'errors' => [
                    'status' => 'Task must be in progress status to update to completed.'
                ]
            ], 422);
        }

        return $this->validate() ?: $this->update($this->todoTask, TodoTaskStatusEnum::COMPLETED->label());
    }

    private function update()
    {

        $this->todoTask->update([
            'status' => $this->new_status
        ]);

        return response()->json([
            'message' => 'Status updated successfully.',
            'data' => TodoTaskData::from($this->todoTask)
        ], 200);
    }

    private function validate()
    {
        if (!$this->todoTask) {
            return response()->json([
                'message' => 'Task not found.',
                'errors' => [
                    'task' => 'The requested task does not exist.'
                ]
            ], 404);
        }

        if (Auth::id() != $this->todoTask->user_id) {

            return response()->json([
                'message' => 'Unauthorized.',
                'errors' => [
                    'user' => 'You are not authorized to update this task.'
                ]
            ], 401);
        }

        return null;
    }
}
