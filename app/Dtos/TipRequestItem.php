<?php

namespace App\Dtos;

use Spatie\LaravelData\Data;

class TipRequestItem extends Data
{
    public function __construct(
        public readonly float $bill,
        public readonly float $tip,
    ) {}
}
