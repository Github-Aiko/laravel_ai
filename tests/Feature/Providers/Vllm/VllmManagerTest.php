<?php

use Laravel\Ai\Ai;
use Laravel\Ai\Contracts\Providers\EmbeddingProvider;
use Laravel\Ai\Contracts\Providers\TextProvider;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Gateway\Vllm\VllmGateway;
use Laravel\Ai\Providers\VllmProvider;

test('can resolve vllm text provider', function () {
    $provider = Ai::textProvider('vllm');

    expect($provider)->toBeInstanceOf(VllmProvider::class)
        ->toBeInstanceOf(TextProvider::class)
        ->and($provider->driver())->toBe('vllm');
});

test('can resolve vllm embedding provider', function () {
    $provider = Ai::embeddingProvider('vllm');

    expect($provider)->toBeInstanceOf(VllmProvider::class)
        ->toBeInstanceOf(EmbeddingProvider::class);
});

test('vllm provider exposes sane defaults', function () {
    $provider = Ai::textProvider('vllm');

    expect($provider->defaultTextModel())->toBeString()->not->toBeEmpty()
        ->and($provider->defaultEmbeddingsModel())->toBeString()->not->toBeEmpty()
        ->and($provider->defaultEmbeddingsDimensions())->toBeInt();
});

test('vllm provider text gateway is the vllm gateway', function () {
    $provider = Ai::textProvider('vllm');

    expect($provider->textGateway())->toBeInstanceOf(VllmGateway::class);
});

test('lab enum includes vllm', function () {
    expect(Lab::Vllm->value)->toBe('vllm');
});
