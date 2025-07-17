<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="fantasy">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="apple-touch-icon" href="/images/tips.png">

        <title>{{ config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="text-base-content pt-6 transition-colors duration-500 bg-base-300 min-h-screen flex items-center justify-center">
        <main>
            <article class="content">
                <div class="card w-80 lg:w-96 bg-base-100 card-xl shadow-sm">
                    <form
                        hx-post="{{ route('tip') }}"
                        hx-target="closest .content"
                        hx-swap="outerHTML"
                        hx-push-url="true"
                    >
                        @csrf

                        <div class="card-body">
                            <h2 class="card-title text-secondary mb-4">
                                <x-phosphor-tip-jar-fill class="w-12 h-12" />
                                {{ config('app.name') }}
                            </h2>
                            <div class="card-description">

                                <fieldset class="fieldset mb-2">
                                    <legend class="fieldset-legend">Service Charge</legend>
                                    <label class="input">
                                        <span class="label">$</span>
                                        <input name="bill" type="number" min="1" step="0.01" required />
                                    </label>
                                    <p class="label">Required</p>
                                </fieldset>

                                <fieldset class="fieldset mb-5">
                                    <legend class="fieldset-legend">Tip</legend>
                                    <label class="input">
                                        <span class="label">%</span>
                                        <input name="tip" type="number" placeholder="Tip" min="10" step="1" max="100" value="{{ $tip }}" required />
                                    </label>
                                    <p class="label">Minimum of 10%</p>
                                </fieldset>

                            </div>

                            <div class="justify-end card-actions">
                                <button class="btn btn-primary" type="submit">Calculate</button>
                            </div>
                        </div>

                    </form>
                </div>
            </article>
        </main>
    </body>
</html>
