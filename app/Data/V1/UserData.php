<?php

namespace App\Data\V1;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public ?int $id = null,
        #[Required, Max(255)]
        public ?string $name,
        #[Required, Max(255)]
        public ?string $password,
        #[Required, Email]
        public ?string $email,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {}
}
