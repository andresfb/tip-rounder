<?php

declare(strict_types=1);

use App\Actions\CalculateTipAction;
use App\Http\Controllers\CalculateTipController;
use App\Http\Requests\CalculateTipRequest;
use Illuminate\View\View;

describe('CalculateTipController', function (): void {
    it('handles tip calculation request properly', function (): void {
        $response = $this->post('/tip', [
            'bill' => 100.00,
            'tip' => 20.00,
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('tips.index');
        $response->assertViewHas('bill', 100.00);
        $response->assertViewHas('tip', 20.00);
        $response->assertViewHas('total', 120.00);
        $response->assertViewHas('tipPercent', 20.00);
    });

    it('is invokable', function (): void {
        $controller = new CalculateTipController();

        try {
            $reflection = new ReflectionClass($controller);
            $method = $reflection->getMethod('__invoke');
        } catch (Exception $e) {
            assert(false, 'Reflection failed: ' . $e->getMessage());
        }

        expect($method->isPublic())->toBeTrue();
        expect($method->getName())->toBe('__invoke');
    });

    it('has correct method signature', function (): void {
        $controller = new CalculateTipController();

        try {
            $reflection = new ReflectionClass($controller);
            $method = $reflection->getMethod('__invoke');
        } catch (Exception $e) {
            assert(false, 'Reflection failed: ' . $e->getMessage());
        }
        $parameters = $method->getParameters();

        expect($parameters)->toHaveCount(2);
        expect($parameters[0]->getName())->toBe('request');
        expect($parameters[0]->getType()?->getName())->toBe(CalculateTipRequest::class);
        expect($parameters[1]->getName())->toBe('action');
        expect($parameters[1]->getType()?->getName())->toBe(CalculateTipAction::class);

        $returnType = $method->getReturnType();
        expect($returnType?->getName())->toBe(View::class);
    });

    it('is a final class', function (): void {
        $reflection = new ReflectionClass(CalculateTipController::class);

        expect($reflection->isFinal())->toBeTrue();
    });

    it('extends base controller', function (): void {
        $controller = new CalculateTipController();

        expect($controller)->toBeInstanceOf(App\Http\Controllers\Controller::class);
    });
});
