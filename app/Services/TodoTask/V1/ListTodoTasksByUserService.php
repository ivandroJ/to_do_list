<?php

namespace App\Services\TodoTask\V1;

use App\Data\V1\TodoTaskData;
use App\Models\TodoTask;
use App\TodoTaskStatusEnum;
use Illuminate\Support\Facades\Auth;

class ListTodoTasksByUserService
{
    public function execute($by_status = null)
    {
        $query = TodoTask::where('user_id', Auth::id())
            ->when($by_status, function ($query) use ($by_status) {
                return $query->where('status', $by_status);
            });


        return $this->validate($by_status) ?:
            response()->json([
                'data' => $query->get()->map(fn($task) => TodoTaskData::from($task))
            ]);
    }

    private function validate($status)
    {
        if (!is_null($status)) {

            $validStatuses = array_map(fn($case) => $case->label(), TodoTaskStatusEnum::cases());

            if (!in_array($status, $validStatuses)) {
                return response()->json([
                    'message' => 'Invalid status provided.',
                    'errors' => [
                        'status' => 'The provided status is not valid.'
                    ]
                ], 422);
            }
        }

        return null;
    }
}
