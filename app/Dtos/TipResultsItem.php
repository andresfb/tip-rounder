<?php

declare(strict_types=1);

namespace App\Dtos;

use Spatie\LaravelData\Data;

final class TipResultsItem extends Data
{
    public function __construct(
        public readonly float $bill,
        public readonly float $tip,
        public readonly float $total,
        public readonly float $tipPercent,
        public readonly float $upperTotal,
        public readonly float $lowerTotal,
        public readonly float $upperTip,
        public readonly float $lowerTip,
        public readonly float $upperTipPercent,
        public readonly float $lowerTipPercent,
    ) {}
}
