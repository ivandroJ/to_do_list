<?php

namespace App\Services\TodoTask\V1;

use App\Data\V1\TodoTaskData;
use Illuminate\Support\Facades\Auth;

class ListTodoTasksByUserService
{
    public function execute()
    {
        return TodoTaskData::collect(
            Auth::user()->todoTasks
        );
    }
}
