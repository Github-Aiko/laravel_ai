<?php

namespace Laravel\Ai\Gateway\Vllm\Concerns;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Laravel\Ai\Providers\Provider;

trait CreatesVllmClient
{
    /**
     * Get an HTTP client for the vLLM API.
     */
    protected function client(Provider $provider, ?int $timeout = null): PendingRequest
    {
        $request = Http::baseUrl($this->baseUrl($provider))
            ->timeout($timeout ?? 60)
            ->throw();

        $key = $provider->providerCredentials()['key'] ?? '';

        if (filled($key)) {
            $request = $request->withToken($key);
        }

        return $request;
    }

    /**
     * Get the base URL for the vLLM API.
     */
    protected function baseUrl(Provider $provider): string
    {
        return rtrim($provider->additionalConfiguration()['url'] ?? 'http://localhost:8000/v1', '/');
    }
}
