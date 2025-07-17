<?php

declare(strict_types=1);

use App\Actions\CalculateTipAction;
use App\Dtos\TipRequestItem;
use App\Dtos\TipResultsItem;

describe('CalculateTipAction', function (): void {
    it('calculates tip correctly for basic case', function (): void {
        $action = new CalculateTipAction();
        $request = new TipRequestItem(bill: 100.00, tip: 20.00);

        $result = $action->handle($request);

        expect($result)->toBeInstanceOf(TipResultsItem::class);
        expect($result->bill)->toBe(100.00);
        expect($result->tip)->toBe(20.00);
        expect($result->total)->toBe(120.00);
        expect($result->tipPercent)->toBe(20.00);
        expect($result->upperTotal)->toBe(120.0);
        expect($result->lowerTotal)->toBe(120.0);
        expect($result->upperTip)->toBe(20.0);
        expect($result->lowerTip)->toBe(20.0);
        expect($result->upperTipPercent)->toBe(20.00);
        expect($result->lowerTipPercent)->toBe(20.00);
    });

    it('calculates tip correctly with rounding up', function (): void {
        $action = new CalculateTipAction();
        $request = new TipRequestItem(bill: 25.75, tip: 18.50);

        $result = $action->handle($request);

        expect($result->bill)->toBe(25.75);
        expect($result->tip)->toBe(4.76);
        expect(round($result->total, 2))->toBe(30.51);
        expect($result->tipPercent)->toBe(18.50);
        expect($result->upperTotal)->toBe(31.0);
        expect($result->lowerTotal)->toBe(30.0);
        expect($result->upperTip)->toBe(5.25);
        expect($result->lowerTip)->toBe(4.25);
        expect(round($result->upperTipPercent, 2))->toBe(20.39);
        expect(round($result->lowerTipPercent, 2))->toBe(16.5);
    });

    it('calculates tip correctly with rounding down', function (): void {
        $action = new CalculateTipAction();
        $request = new TipRequestItem(bill: 50.25, tip: 15.00);

        $result = $action->handle($request);

        expect($result->bill)->toBe(50.25);
        expect($result->tip)->toBe(7.54);
        expect($result->total)->toBe(57.79);
        expect($result->tipPercent)->toBe(15.00);
        expect($result->upperTotal)->toBe(58.0);
        expect($result->lowerTotal)->toBe(57.0);
        expect($result->upperTip)->toBe(7.75);
        expect($result->lowerTip)->toBe(6.75);
        expect($result->upperTipPercent)->toBe(15.42);
        expect($result->lowerTipPercent)->toBe(13.43);
    });

    it('handles small bills correctly', function (): void {
        $action = new CalculateTipAction();
        $request = new TipRequestItem(bill: 1.50, tip: 20.00);

        $result = $action->handle($request);

        expect($result->bill)->toBe(1.50);
        expect($result->tip)->toBe(0.30);
        expect($result->total)->toBe(1.80);
        expect($result->tipPercent)->toBe(20.00);
        expect($result->upperTotal)->toBe(2.0);
        expect($result->lowerTotal)->toBe(1.0);
        expect($result->upperTip)->toBe(0.50);
        expect($result->lowerTip)->toBe(-0.50);
        expect($result->upperTipPercent)->toBe(33.33);
        expect($result->lowerTipPercent)->toBe(-33.33);
    });

    it('handles high tip percentages correctly', function (): void {
        $action = new CalculateTipAction();
        $request = new TipRequestItem(bill: 100.00, tip: 50.00);

        $result = $action->handle($request);

        expect($result->bill)->toBe(100.00);
        expect($result->tip)->toBe(50.00);
        expect($result->total)->toBe(150.00);
        expect($result->tipPercent)->toBe(50.00);
        expect($result->upperTotal)->toBe(150.0);
        expect($result->lowerTotal)->toBe(150.0);
        expect($result->upperTip)->toBe(50.0);
        expect($result->lowerTip)->toBe(50.0);
        expect($result->upperTipPercent)->toBe(50.00);
        expect($result->lowerTipPercent)->toBe(50.00);
    });

    it('handles minimum tip percentages correctly', function (): void {
        $action = new CalculateTipAction();
        $request = new TipRequestItem(bill: 100.00, tip: 1.00);

        $result = $action->handle($request);

        expect($result->bill)->toBe(100.00);
        expect($result->tip)->toBe(1.00);
        expect($result->total)->toBe(101.00);
        expect($result->tipPercent)->toBe(1.00);
        expect($result->upperTotal)->toBe(101.0);
        expect($result->lowerTotal)->toBe(101.0);
        expect($result->upperTip)->toBe(1.0);
        expect($result->lowerTip)->toBe(1.0);
        expect($result->upperTipPercent)->toBe(1.00);
        expect($result->lowerTipPercent)->toBe(1.00);
    });

    it('handles decimal precision correctly', function (): void {
        $action = new CalculateTipAction();
        $request = new TipRequestItem(bill: 33.33, tip: 18.75);

        $result = $action->handle($request);

        expect($result->bill)->toBe(33.33);
        expect($result->tip)->toBe(6.25);
        expect(round($result->total, 2))->toBe(39.58);
        expect($result->tipPercent)->toBe(18.75);
        expect($result->upperTotal)->toBe(40.0);
        expect($result->lowerTotal)->toBe(39.0);
        expect(round($result->upperTip, 2))->toBe(6.67);
        expect(round($result->lowerTip, 2))->toBe(5.67);
        expect(round($result->upperTipPercent, 2))->toBe(20.01);
        expect(round($result->lowerTipPercent, 2))->toBe(17.01);
    });
});
