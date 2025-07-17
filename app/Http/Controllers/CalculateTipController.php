<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CalculateTipAction;
use App\Dtos\TipRequestItem;
use App\Http\Requests\CalculateTipRequest;

final class CalculateTipController extends Controller
{
    public function __invoke(CalculateTipRequest $request, CalculateTipAction $action)
    {
        $tips = $action->handle(
            TipRequestItem::from($request),
        );

        return view('tips.index', $tips->toArray());
    }
}
