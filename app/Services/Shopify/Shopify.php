<?php

namespace App\Services\Shopify;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use App\Services\Shop;

class Shopify
{
    protected static array $queryCache = [];

    public function __construct(
        protected string $domain,
        protected string $token,
        protected string $mode = 'admin',
        protected string $apiVersion = '2025-10'
    ) {}

    /** Factory for Admin GraphQL */
    public static function admin(): self
    {
        return new self(
            domain: config('services.shopify.domain'),
            token: config('services.shopify.admin_access_token'),
            mode: 'admin',
        );
    }

    /** Factory for Storefront GraphQL */
    public static function storefront(): self
    {
        return new self(
            domain: config('services.shopify.domain'),
            token: config('services.shopify.storefront_access_token'),
            mode: 'storefront',
        );
    }

    /** Core caller. Set $throwOnUserErrors=false to handle them yourself. */
    public function call(string $query, array $variables = [], bool $throwOnUserErrors = true): array
    {
        $query = $this->loadQuery($query);

        $endpoint = $this->endpoint();
        $response = $this->client($this->headers())
            ->post($endpoint, [
                'query'     => $query,
                'variables' => $variables,
            ]);

        if ($response->failed()) {
            throw new ShopifyException(
                'HTTP error calling Shopify GraphQL',
                $response->status(),
                [
                    'body'   => $response->json() ?: $response->body(),
                    'mode'   => $this->mode,
                    'endpoint' => $endpoint,
                ]
            );
        }

        $json = $response->json();

        // Transport-level GraphQL errors (syntax, auth, etc.)
        if (isset($json['errors']) && !empty($json['errors'])) {
            throw new ShopifyException(
                'GraphQL transport error',
                0,
                ['errors' => $json['errors']]
            );
        }

        // Optionally throw on userErrors from mutation payloads
        if ($throwOnUserErrors) {
            $this->throwIfUserErrors($json);
        }

        return $json['data'];
    }

    protected function client(array $headers): PendingRequest
    {
        return Http::withHeaders($headers)
            ->timeout(20)
            ->retry(2, 200, throw: false);
    }

    protected function endpoint(): string
    {
        return match ($this->mode) {
            'admin' => "https://{$this->domain}/admin/api/{$this->apiVersion}/graphql.json",
            'storefront' => "https://{$this->domain}/api/{$this->apiVersion}/graphql.json",
            default => throw new \InvalidArgumentException("Invalid Shopify mode: {$this->mode}"),
        };
    }

    protected function headers(): array
    {
        return match ($this->mode) {
            'admin' => [
                'Content-Type' => 'application/json',
                'X-Shopify-Access-Token' => $this->token,
            ],
            'storefront' => [
                'Content-Type' => 'application/json',
                'X-Shopify-Storefront-Access-Token' => $this->token,
            ],
            default => throw new \InvalidArgumentException("Invalid Shopify mode: {$this->mode}"),
        };
    }

    public static function loadQuery(string $name): string
    {
        if (!isset(self::$queryCache[$name])) {
            self::$queryCache[$name] = file_get_contents(resource_path("graphql/{$name}.gql"));
        }

        return self::$queryCache[$name];
    }

    /** Walk the response and throw if any payload contains userErrors */
    protected function throwIfUserErrors(array $json): void
    {
        if (!isset($json['data']) || !is_array($json['data'])) return;

        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($json['data']));
        foreach ($iterator as $key => $val) {
            if ($key === 'userErrors' && is_array($val) && !empty($val)) {
                throw new ShopifyException('userErrors from Shopify GraphQL', 0, ['userErrors' => $val, 'data' => $json['data']]);
            }
        }
    }
}
