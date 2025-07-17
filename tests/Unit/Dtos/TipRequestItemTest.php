<?php

declare(strict_types=1);

use App\Dtos\TipRequestItem;
use App\Http\Requests\CalculateTipRequest;

describe('TipRequestItem', function (): void {
    it('can be created with bill and tip values', function (): void {
        $item = new TipRequestItem(bill: 100.00, tip: 20.00);

        expect($item->bill)->toBe(100.00);
        expect($item->tip)->toBe(20.00);
    });

    it('can be created from form request', function (): void {
        $request = new CalculateTipRequest();
        $request->replace(['bill' => 50.25, 'tip' => 18.5]);

        $item = TipRequestItem::from($request);

        expect($item->bill)->toBe(50.25);
        expect($item->tip)->toBe(18.5);
    });

    it('can be created from array', function (): void {
        $data = ['bill' => 75.50, 'tip' => 15.0];

        $item = TipRequestItem::from($data);

        expect($item->bill)->toBe(75.50);
        expect($item->tip)->toBe(15.0);
    });

    it('has readonly properties', function (): void {
        $item = new TipRequestItem(bill: 100.00, tip: 20.00);

        try {
            $reflection = new ReflectionClass($item);
            $constructor = $reflection->getConstructor();
            $parameters = $constructor?->getParameters();

            foreach ($parameters as $parameter) {
                expect($parameter->getType()?->getName())->toBe('float');
            }
        } catch (Exception $e) {
            assert(false, 'Reflection failed: ' . $e->getMessage());
        }
    });

    it('extends spatie data class', function (): void {
        $item = new TipRequestItem(bill: 100.00, tip: 20.00);

        expect($item)->toBeInstanceOf(Spatie\LaravelData\Data::class);
    });

    it('can be converted to array', function (): void {
        $item = new TipRequestItem(bill: 100.00, tip: 20.00);

        $array = $item->toArray();

        expect($array)->toBe([
            'bill' => 100.00,
            'tip' => 20.00,
        ]);
    });

    it('can be converted to json', function (): void {
        $item = new TipRequestItem(bill: 100.00, tip: 20.00);

        $json = $item->toJson();

        expect($json)->toBe('{"bill":100,"tip":20}');
    });

    it('handles float precision correctly', function (): void {
        $item = new TipRequestItem(bill: 33.33, tip: 18.75);

        expect($item->bill)->toBe(33.33);
        expect($item->tip)->toBe(18.75);
    });
});
