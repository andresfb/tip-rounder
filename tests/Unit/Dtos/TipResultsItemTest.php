<?php

declare(strict_types=1);

use App\Dtos\TipResultsItem;

describe('TipResultsItem', function (): void {
    it('can be created with all required properties', function (): void {
        $item = new TipResultsItem(
            bill: 100.00,
            tip: 20.00,
            total: 120.00,
            tipPercent: 20.00,
            upperTotal: 120.0,
            lowerTotal: 120.0,
            upperTip: 20.0,
            lowerTip: 20.0,
            upperTipPercent: 20.00,
            lowerTipPercent: 20.00
        );

        expect($item->bill)->toBe(100.00);
        expect($item->tip)->toBe(20.00);
        expect($item->total)->toBe(120.00);
        expect($item->tipPercent)->toBe(20.00);
        expect($item->upperTotal)->toBe(120.0);
        expect($item->lowerTotal)->toBe(120.0);
        expect($item->upperTip)->toBe(20.0);
        expect($item->lowerTip)->toBe(20.0);
        expect($item->upperTipPercent)->toBe(20.00);
        expect($item->lowerTipPercent)->toBe(20.00);
    });

    it('has readonly properties', function (): void {
        $item = new TipResultsItem(
            bill: 100.00,
            tip: 20.00,
            total: 120.00,
            tipPercent: 20.00,
            upperTotal: 120.0,
            lowerTotal: 120.0,
            upperTip: 20.0,
            lowerTip: 20.0,
            upperTipPercent: 20.00,
            lowerTipPercent: 20.00
        );

        try {
            $reflection = new ReflectionClass($item);
            $constructor = $reflection->getConstructor();
            $parameters = $constructor?->getParameters();

            foreach ($parameters as $parameter) {
                expect($parameter->getType()?->getName())->toBe('float');
            }
        } catch (Exception $e) {
            assert(false, 'Reflection failed: '.$e->getMessage());
        }
    });

    it('extends spatie data class', function (): void {
        $item = new TipResultsItem(
            bill: 100.00,
            tip: 20.00,
            total: 120.00,
            tipPercent: 20.00,
            upperTotal: 120.0,
            lowerTotal: 120.0,
            upperTip: 20.0,
            lowerTip: 20.0,
            upperTipPercent: 20.00,
            lowerTipPercent: 20.00
        );

        expect($item)->toBeInstanceOf(Spatie\LaravelData\Data::class);
    });

    it('can be converted to array', function (): void {
        $item = new TipResultsItem(
            bill: 100.00,
            tip: 20.00,
            total: 120.00,
            tipPercent: 20.00,
            upperTotal: 120.0,
            lowerTotal: 120.0,
            upperTip: 20.0,
            lowerTip: 20.0,
            upperTipPercent: 20.00,
            lowerTipPercent: 20.00
        );

        $array = $item->toArray();

        expect($array)->toBe([
            'bill' => 100.00,
            'tip' => 20.00,
            'total' => 120.00,
            'tipPercent' => 20.00,
            'upperTotal' => 120.0,
            'lowerTotal' => 120.0,
            'upperTip' => 20.0,
            'lowerTip' => 20.0,
            'upperTipPercent' => 20.00,
            'lowerTipPercent' => 20.00,
        ]);
    });

    it('can be converted to json', function (): void {
        $item = new TipResultsItem(
            bill: 100.00,
            tip: 20.00,
            total: 120.00,
            tipPercent: 20.00,
            upperTotal: 120.0,
            lowerTotal: 120.0,
            upperTip: 20.0,
            lowerTip: 20.0,
            upperTipPercent: 20.00,
            lowerTipPercent: 20.00
        );

        $json = $item->toJson();

        expect($json)->toBe('{"bill":100,"tip":20,"total":120,"tipPercent":20,"upperTotal":120,"lowerTotal":120,"upperTip":20,"lowerTip":20,"upperTipPercent":20,"lowerTipPercent":20}');
    });

    it('handles float precision correctly', function (): void {
        $item = new TipResultsItem(
            bill: 33.33,
            tip: 6.25,
            total: 39.58,
            tipPercent: 18.75,
            upperTotal: 40.0,
            lowerTotal: 39.0,
            upperTip: 6.67,
            lowerTip: 5.67,
            upperTipPercent: 20.01,
            lowerTipPercent: 17.01
        );

        expect($item->bill)->toBe(33.33);
        expect($item->tip)->toBe(6.25);
        expect($item->total)->toBe(39.58);
        expect($item->tipPercent)->toBe(18.75);
        expect($item->upperTotal)->toBe(40.0);
        expect($item->lowerTotal)->toBe(39.0);
        expect($item->upperTip)->toBe(6.67);
        expect($item->lowerTip)->toBe(5.67);
        expect($item->upperTipPercent)->toBe(20.01);
        expect($item->lowerTipPercent)->toBe(17.01);
    });

    it('can handle negative values for lower tip scenarios', function (): void {
        $item = new TipResultsItem(
            bill: 1.50,
            tip: 0.30,
            total: 1.80,
            tipPercent: 20.00,
            upperTotal: 2.0,
            lowerTotal: 1.0,
            upperTip: 0.50,
            lowerTip: -0.50,
            upperTipPercent: 33.33,
            lowerTipPercent: -33.33
        );

        expect($item->lowerTip)->toBe(-0.50);
        expect($item->lowerTipPercent)->toBe(-33.33);
    });

    it('can be created from array', function (): void {
        $data = [
            'bill' => 100.00,
            'tip' => 20.00,
            'total' => 120.00,
            'tipPercent' => 20.00,
            'upperTotal' => 120.0,
            'lowerTotal' => 120.0,
            'upperTip' => 20.0,
            'lowerTip' => 20.0,
            'upperTipPercent' => 20.00,
            'lowerTipPercent' => 20.00,
        ];

        $item = TipResultsItem::from($data);

        expect($item->bill)->toBe(100.00);
        expect($item->tip)->toBe(20.00);
        expect($item->total)->toBe(120.00);
        expect($item->tipPercent)->toBe(20.00);
        expect($item->upperTotal)->toBe(120.0);
        expect($item->lowerTotal)->toBe(120.0);
        expect($item->upperTip)->toBe(20.0);
        expect($item->lowerTip)->toBe(20.0);
        expect($item->upperTipPercent)->toBe(20.00);
        expect($item->lowerTipPercent)->toBe(20.00);
    });
});
