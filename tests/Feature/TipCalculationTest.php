<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Tip Calculation Feature', function (): void {
    it('can calculate tip with valid data', function (): void {
        $response = $this->post('/tip', [
            'bill' => 100.00,
            'tip' => 20.00,
        ]);
        
        $response->assertStatus(200);
        $response->assertViewIs('tips.index');
        $response->assertViewHas([
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

    it('can calculate tip with rounding scenarios', function (): void {
        $response = $this->post('/tip', [
            'bill' => 25.75,
            'tip' => 18.50,
        ]);
        
        $response->assertStatus(200);
        $response->assertViewIs('tips.index');
        $response->assertViewHas('bill', 25.75);
        $response->assertViewHas('tip', 4.76);
        $viewData = $response->viewData('total');
        expect(round($viewData, 2))->toBe(30.51);
        $response->assertViewHas('tipPercent', 18.50);
        $response->assertViewHas('upperTotal', 31.0);
        $response->assertViewHas('lowerTotal', 30.0);
        $response->assertViewHas('upperTip', 5.25);
        $response->assertViewHas('lowerTip', 4.25);
        $upperTipPercent = $response->viewData('upperTipPercent');
        $lowerTipPercent = $response->viewData('lowerTipPercent');
        expect(round($upperTipPercent, 2))->toBe(20.39);
        expect(round($lowerTipPercent, 2))->toBe(16.5);
    });

    it('validates required fields', function (): void {
        $response = $this->post('/tip', []);
        
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['bill', 'tip']);
    });

    it('validates bill is numeric', function (): void {
        $response = $this->post('/tip', [
            'bill' => 'invalid',
            'tip' => 20.00,
        ]);
        
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['bill']);
    });

    it('validates bill minimum value', function (): void {
        $response = $this->post('/tip', [
            'bill' => 0,
            'tip' => 20.00,
        ]);
        
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['bill']);
    });

    it('validates tip is numeric', function (): void {
        $response = $this->post('/tip', [
            'bill' => 100.00,
            'tip' => 'invalid',
        ]);
        
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['tip']);
    });

    it('validates tip minimum value', function (): void {
        $response = $this->post('/tip', [
            'bill' => 100.00,
            'tip' => 0,
        ]);
        
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['tip']);
    });

    it('validates tip maximum value', function (): void {
        $response = $this->post('/tip', [
            'bill' => 100.00,
            'tip' => 101.00,
        ]);
        
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['tip']);
    });

    it('allows minimum valid bill amount', function (): void {
        $response = $this->post('/tip', [
            'bill' => 0.01,
            'tip' => 20.00,
        ]);
        
        $response->assertStatus(200);
        $response->assertViewIs('tips.index');
        $response->assertViewHas('bill', 0.01);
    });

    it('allows minimum valid tip percentage', function (): void {
        $response = $this->post('/tip', [
            'bill' => 100.00,
            'tip' => 1.00,
        ]);
        
        $response->assertStatus(200);
        $response->assertViewIs('tips.index');
        $response->assertViewHas('tipPercent', 1.00);
    });

    it('allows maximum valid tip percentage', function (): void {
        $response = $this->post('/tip', [
            'bill' => 100.00,
            'tip' => 100.00,
        ]);
        
        $response->assertStatus(200);
        $response->assertViewIs('tips.index');
        $response->assertViewHas('tipPercent', 100.00);
    });

    it('handles decimal values correctly', function (): void {
        $response = $this->post('/tip', [
            'bill' => 33.33,
            'tip' => 18.75,
        ]);
        
        $response->assertStatus(200);
        $response->assertViewIs('tips.index');
        $response->assertViewHas('bill', 33.33);
        $response->assertViewHas('tipPercent', 18.75);
    });

    it('respects rate limiting', function (): void {
        for ($i = 0; $i < 30; $i++) {
            $response = $this->post('/tip', [
                'bill' => 100.00,
                'tip' => 20.00,
            ]);
            $response->assertStatus(200);
        }
        
        $response = $this->post('/tip', [
            'bill' => 100.00,
            'tip' => 20.00,
        ]);
        
        $response->assertStatus(429);
    });

    it('handles edge case with small bill amounts', function (): void {
        $response = $this->post('/tip', [
            'bill' => 1.50,
            'tip' => 20.00,
        ]);
        
        $response->assertStatus(200);
        $response->assertViewIs('tips.index');
        $response->assertViewHas('bill', 1.50);
        $response->assertViewHas('tip', 0.30);
        $response->assertViewHas('total', 1.80);
        $response->assertViewHas('upperTotal', 2.0);
        $response->assertViewHas('lowerTotal', 1.0);
        $response->assertViewHas('upperTip', 0.50);
        $response->assertViewHas('lowerTip', -0.50);
        $response->assertViewHas('upperTipPercent', 33.33);
        $response->assertViewHas('lowerTipPercent', -33.33);
    });

    it('handles high tip percentages correctly', function (): void {
        $response = $this->post('/tip', [
            'bill' => 50.00,
            'tip' => 50.00,
        ]);
        
        $response->assertStatus(200);
        $response->assertViewIs('tips.index');
        $response->assertViewHas('bill', 50.00);
        $response->assertViewHas('tip', 25.00);
        $response->assertViewHas('total', 75.00);
        $response->assertViewHas('tipPercent', 50.00);
        $response->assertViewHas('upperTotal', 75.0);
        $response->assertViewHas('lowerTotal', 75.0);
        $response->assertViewHas('upperTip', 25.0);
        $response->assertViewHas('lowerTip', 25.0);
        $response->assertViewHas('upperTipPercent', 50.00);
        $response->assertViewHas('lowerTipPercent', 50.00);
    });

    it('has correct route name', function (): void {
        $response = $this->post(route('tip'), [
            'bill' => 100.00,
            'tip' => 20.00,
        ]);
        
        $response->assertStatus(200);
        $response->assertViewIs('tips.index');
    });

    it('can access home page', function (): void {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertViewHas('tip');
    });

    it('can access home page by route name', function (): void {
        $response = $this->get(route('home'));
        
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    });
});