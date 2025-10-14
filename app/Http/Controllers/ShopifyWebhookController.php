<?php

namespace App\Http\Controllers;

use App\Actions\RecordShopifyOrderForPlayer;
use App\Services\Shopify\Shopify;
use Illuminate\Http\Request;

class ShopifyWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        // Skip processing invalid requests
        if (!$this->isVerified($request)) {
            return 'OK?';
        }

        $topic = $request->header('X-Shopify-Topic');
        $topic = "orders/create";
        $method = str($topic)->replace('/', '-')->camel()->toString();

        if (!method_exists($this, $method)) {
            return 'OK';
        }

        $this->$method(json_decode($request->getContent(), true));

        \Log::info('SHOPIFY_WEBHOOK', [$method]);

        return 'OK';
    }

    protected function ordersCreate(array $payload)
    {
        $id = data_get($payload, 'admin_graphql_api_id');

        $order = Shopify::admin()->call('admin/getOrder', compact('id'));

        (new RecordShopifyOrderForPlayer)($order);
    }

    protected function isVerified(Request $request)
    {
        $hmacHeader = $request->header('X-Shopify-Hmac-Sha256');
        $data = $request->getContent();

        $calculated = base64_encode(
            hash_hmac('sha256', $data, config('services.shopify.webhook_verify_token'), true)
        );

        return ($calculated === $hmacHeader);
    }
}
