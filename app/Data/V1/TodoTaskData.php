<?php

namespace App\Data\V1;

use DateTime;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;

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
        public ?string $status = null,
        public ?DateTime $created_at = null,
        public ?DateTime $updated_at = null,
    ) {}

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
