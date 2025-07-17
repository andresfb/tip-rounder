<?php

declare(strict_types=1);

use App\Http\Requests\CalculateTipRequest;
use Illuminate\Support\Facades\Validator;

describe('CalculateTipRequest', function (): void {
    it('is authorized by default', function (): void {
        $request = new CalculateTipRequest();

        expect($request->authorize())->toBeTrue();
    });

    it('has correct validation rules', function (): void {
        $request = new CalculateTipRequest();

        $rules = $request->rules();

        expect($rules)->toBe([
            'bill' => 'required|numeric|min:0.01',
            'tip' => 'required|numeric|min:1|max:100',
        ]);
    });

    describe('bill validation', function (): void {
        it('passes with valid bill amount', function (): void {
            $validator = Validator::make(
                ['bill' => 100.00, 'tip' => 20.00],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->passes())->toBeTrue();
        });

        it('fails when bill is missing', function (): void {
            $validator = Validator::make(
                ['tip' => 20.00],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->fails())->toBeTrue();
            expect($validator->errors()->has('bill'))->toBeTrue();
        });

        it('fails when bill is not numeric', function (): void {
            $validator = Validator::make(
                ['bill' => 'invalid', 'tip' => 20.00],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->fails())->toBeTrue();
            expect($validator->errors()->has('bill'))->toBeTrue();
        });

        it('fails when bill is zero', function (): void {
            $validator = Validator::make(
                ['bill' => 0, 'tip' => 20.00],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->fails())->toBeTrue();
            expect($validator->errors()->has('bill'))->toBeTrue();
        });

        it('fails when bill is negative', function (): void {
            $validator = Validator::make(
                ['bill' => -10.00, 'tip' => 20.00],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->fails())->toBeTrue();
            expect($validator->errors()->has('bill'))->toBeTrue();
        });

        it('passes with minimum bill amount', function (): void {
            $validator = Validator::make(
                ['bill' => 0.01, 'tip' => 20.00],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->passes())->toBeTrue();
        });

        it('passes with decimal bill amount', function (): void {
            $validator = Validator::make(
                ['bill' => 25.75, 'tip' => 20.00],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->passes())->toBeTrue();
        });
    });

    describe('tip validation', function (): void {
        it('passes with valid tip percentage', function (): void {
            $validator = Validator::make(
                ['bill' => 100.00, 'tip' => 20.00],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->passes())->toBeTrue();
        });

        it('fails when tip is missing', function (): void {
            $validator = Validator::make(
                ['bill' => 100.00],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->fails())->toBeTrue();
            expect($validator->errors()->has('tip'))->toBeTrue();
        });

        it('fails when tip is not numeric', function (): void {
            $validator = Validator::make(
                ['bill' => 100.00, 'tip' => 'invalid'],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->fails())->toBeTrue();
            expect($validator->errors()->has('tip'))->toBeTrue();
        });

        it('fails when tip is zero', function (): void {
            $validator = Validator::make(
                ['bill' => 100.00, 'tip' => 0],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->fails())->toBeTrue();
            expect($validator->errors()->has('tip'))->toBeTrue();
        });

        it('fails when tip is negative', function (): void {
            $validator = Validator::make(
                ['bill' => 100.00, 'tip' => -5.00],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->fails())->toBeTrue();
            expect($validator->errors()->has('tip'))->toBeTrue();
        });

        it('passes with minimum tip percentage', function (): void {
            $validator = Validator::make(
                ['bill' => 100.00, 'tip' => 1.00],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->passes())->toBeTrue();
        });

        it('passes with maximum tip percentage', function (): void {
            $validator = Validator::make(
                ['bill' => 100.00, 'tip' => 100.00],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->passes())->toBeTrue();
        });

        it('fails when tip exceeds maximum', function (): void {
            $validator = Validator::make(
                ['bill' => 100.00, 'tip' => 101.00],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->fails())->toBeTrue();
            expect($validator->errors()->has('tip'))->toBeTrue();
        });

        it('passes with decimal tip percentage', function (): void {
            $validator = Validator::make(
                ['bill' => 100.00, 'tip' => 18.75],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->passes())->toBeTrue();
        });
    });

    describe('combined validation', function (): void {
        it('passes with both valid values', function (): void {
            $validator = Validator::make(
                ['bill' => 50.25, 'tip' => 18.50],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->passes())->toBeTrue();
        });

        it('fails when both values are invalid', function (): void {
            $validator = Validator::make(
                ['bill' => 'invalid', 'tip' => 'invalid'],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->fails())->toBeTrue();
            expect($validator->errors()->has('bill'))->toBeTrue();
            expect($validator->errors()->has('tip'))->toBeTrue();
        });

        it('fails when both values are missing', function (): void {
            $validator = Validator::make(
                [],
                (new CalculateTipRequest())->rules()
            );

            expect($validator->fails())->toBeTrue();
            expect($validator->errors()->has('bill'))->toBeTrue();
            expect($validator->errors()->has('tip'))->toBeTrue();
        });
    });
});
