<?php

namespace App\Services\TodoTask\V1;

use App\Data\V1\TodoTaskData;
use App\Models\TodoTask;
use Illuminate\Support\Facades\Auth;

class ListTodoTasksByUserService
{
    public function execute($by_status = null)
    {
        $query = TodoTask::where('user_id', Auth::id())
            ->when($by_status, function ($query) use ($by_status) {
                return $query->where('status', $by_status);
            });


        return TodoTaskData::collect(
            Auth::user()->todoTasks
        );
    }
}
