<?php

namespace App\Models;

use App\TodoTaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
