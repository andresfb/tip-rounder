<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;

describe('AppServiceProvider', function (): void {
    it('can be instantiated', function (): void {
        $app = new Application();
        $provider = new AppServiceProvider($app);
        
        expect($provider)->toBeInstanceOf(AppServiceProvider::class);
    });

    it('has empty register method', function (): void {
        $app = new Application();
        $provider = new AppServiceProvider($app);
        
        $result = $provider->register();
        
        expect($result)->toBeNull();
    });

    it('configures vite aggressive prefetching in boot method', function (): void {
        $app = new Application();
        $app['env'] = 'local';
        
        $request = new Request();
        $app['request'] = $request;
        
        $provider = new AppServiceProvider($app);
        
        Vite::spy();
        
        $provider->boot();
        
        Vite::shouldHaveReceived('useAggressivePrefetching')->once();
    });

    it('forces https scheme in production environment', function (): void {
        $app = new Application();
        $app['env'] = 'production';
        
        $request = new Request();
        $app['request'] = $request;
        
        $provider = new AppServiceProvider($app);
        
        URL::spy();
        
        $provider->boot();
        
        URL::shouldHaveReceived('forceScheme')->with('https')->once();
        expect($request->server->get('HTTPS'))->toBe('on');
    });

    it('forces http scheme in non-production environment', function (): void {
        $app = new Application();
        $app['env'] = 'local';
        
        $request = new Request();
        $app['request'] = $request;
        
        $provider = new AppServiceProvider($app);
        
        URL::spy();
        
        $provider->boot();
        
        URL::shouldHaveReceived('forceScheme')->with('http')->once();
    });

    it('is a final class', function (): void {
        $reflection = new ReflectionClass(AppServiceProvider::class);
        
        expect($reflection->isFinal())->toBeTrue();
    });

    it('extends base service provider', function (): void {
        $app = new Application();
        $provider = new AppServiceProvider($app);
        
        expect($provider)->toBeInstanceOf(Illuminate\Support\ServiceProvider::class);
    });
});