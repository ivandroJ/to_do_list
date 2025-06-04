<?php

namespace App\Models;

use App\TodoTaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="TodoTask",
 *     type="object",
 *     title="TodoTask",
 *     required={"title", "description", "user_id", "status"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="status", type="string", enum={"Pendente", "Em andamento", "Concluída"}, description="Todo Task Status"),
 *     @OA\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true)
 * )
 */
class TodoTask extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'user_id',
        'status',
    ];

    public $timestamps = true;

    public function scopePeding($query)
    {
        return $query->where('status', TodoTaskStatusEnum::PENDING->label());
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', TodoTaskStatusEnum::COMPLETED->label());
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', TodoTaskStatusEnum::IN_PROGRESS->label());
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPeding()
    {
        return $this->status ===  TodoTaskStatusEnum::PENDING->label();
    }

    public function isCompleted()
    {
        return $this->status ===  TodoTaskStatusEnum::COMPLETED->label();
    }

    public function isInProgress()
    {
        return $this->status ===  TodoTaskStatusEnum::IN_PROGRESS->label();
    }
}
