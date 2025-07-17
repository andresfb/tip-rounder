<?php

declare(strict_types=1);

namespace App\Actions;

use App\Dtos\TipRequestItem;
use App\Dtos\TipResultsItem;

final readonly class CalculateTipAction
{
    public function handle(TipRequestItem $item): TipResultsItem
    {
        $tip = round($item->bill * ($item->tip / 100), 2);
        $total = $item->bill + $tip;

        $upperTotal = (int) ceil($total);
        $lowerTotal = (int) floor($total);

        $upperTip = $upperTotal - $item->bill;
        $lowerTip = $lowerTotal - $item->bill;

        $upperTipPercent = round(($upperTip / $item->bill) * 100, 2);
        $lowerTipPercent = round(($lowerTip / $item->bill) * 100, 2);

        return new TipResultsItem(
            bill: $item->bill,
            tip: $tip,
            total: $total,
            tipPercent: $item->tip,
            upperTotal: $upperTotal,
            lowerTotal: $lowerTotal,
            upperTip: $upperTip,
            lowerTip: $lowerTip,
            upperTipPercent: $upperTipPercent,
            lowerTipPercent: $lowerTipPercent,
        );
    }
}
