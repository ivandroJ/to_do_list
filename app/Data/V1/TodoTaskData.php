<?php

namespace App\Data\V1;

use App\TodoTaskStatusEnum;
use DateTime;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\InArray;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Size;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;

class TodoTaskData extends Data
{
    public function __construct(
        public ?int $id = null,
        #[Required]
        #[Max(250)]
        public ?string $title,
        #[Nullable]
        #[Max(1000)]
        public ?string $description = null,
        #[Nullable]
        #[InArray(TodoTaskStatusEnum::class)]
        public ?string $status = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {

    }

    public static function attributes(): array
    {
        return [
            'title' => 'Título',
            'description' => 'Descrição',
            'status' => 'Status',
            'user_id' => 'ID do usuário',
        ];
    }
}
