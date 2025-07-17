<?php

declare(strict_types=1);

namespace App\Dtos;

use Spatie\LaravelData\Data;

final class TipRequestItem extends Data
{
    public function __construct(
        public readonly float $bill,
        public readonly float $tip,
    ) {}
}
