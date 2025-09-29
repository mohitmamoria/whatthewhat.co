<?php

namespace App\Services\Idempotency;

class Idempotency
{
    public static function key(string $prefix, array $facts = []): string
    {
        if (count($facts) === 0) {
            throw new \InvalidArgumentException('At least one fact is required to generate an idempotency key.');
        }

        // sort keys for stability
        ksort($facts);

        // canonical JSON without spaces
        $payload = json_encode($facts, JSON_UNESCAPED_SLASHES);

        // hash to keep it short & avoid leaking PII
        $digest = hash('sha256', $payload, true);

        // base32 no padding, shorter than hex; keep ~26-32 chars
        $b32 = rtrim(strtr(base64_encode($digest), '+/', '-_'), '=');

        // final form: prefix:hash
        return substr($prefix . ':' . $b32, 0, 80); // guard max length
    }
}
