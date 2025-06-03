<?php

namespace App;

enum TodoTaskStatusEnum
{
    case PENDING;
    case IN_PROGRESS;
    case COMPLETED;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::IN_PROGRESS => 'Em andamento',
            self::COMPLETED => 'Concluída',
        };
    }
}
