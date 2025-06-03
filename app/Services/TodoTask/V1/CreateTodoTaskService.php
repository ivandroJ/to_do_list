<?php

namespace App\Services\TodoTask\V1;

use App\Data\V1\TodoTaskData;
use App\Models\TodoTask;
use App\TodoTaskStatusEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreateTodoTaskService
{

    public function execute(TodoTaskData $todoTaskData): TodoTaskData
    {
        $data = [
            'user_id' => Auth::user()->id,
            'status' => "Pendente",
        ] + $todoTaskData->toArray();

        // Validate and process the data as needed
        return TodoTaskData::from(TodoTask::create($data));
    }
}
