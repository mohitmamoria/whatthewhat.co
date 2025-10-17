<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Player;
use App\Models\Product;
use App\Services\Shopify\Shopify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ShopController extends Controller
{
    public function buy(Request $request)
    {
        $product = Product::first();

        return inertia('Shop/Buy', [
            'product' => ProductResource::make($product),
        ]);
    }

    public function checkout(Request $request)
    {
        $ref = $request->input('ref');
        $referrer = null;
        if ($ref) {
            $referrer = Player::byReferrerCode($ref);
        }

        $validated = request()->validate([
            'variant' => ['required'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        // check variant exists
        $product = Product::first();
        $variant = collect($product->variants)->firstWhere('id', $validated['variant']);
        if (is_null($variant)) {
            throw ValidationException::withMessages(['variant' => 'Invalid variant selected']);
        }

        $cachedCart = Cache::get($this->getCartCacheKey());
        if ($cachedCart) {
            $cachedCart = json_decode($cachedCart, true);

            $checkoutUrl = $this->reuseCachedCart($cachedCart, $validated['variant'], $validated['quantity']);
            return Inertia::location($checkoutUrl);
        } else {
            $checkoutUrl = $this->createFreshCart($validated['variant'], $validated['quantity'], $referrer?->referrer_code);
            return Inertia::location($checkoutUrl);
        }
    }

    private function reuseCachedCart(array $cachedCart, string $variantId, int $quantity): string
    {
        // Remove existing lines
        Shopify::storefront()->call('storefront/removeCartLines', [
            'cartId' => $cachedCart['id'],
            'lineIds' => $cachedCart['lines'],
        ]);

        // Add new lines
        $response = Shopify::storefront()->call('storefront/addCartLines', [
            'cartId' => $cachedCart['id'],
            'lines' => [
                [
                    'merchandiseId' => $variantId,
                    'quantity' => $quantity,
                ],
            ],
        ]);

        // Cache the cart
        Cache::put($this->getCartCacheKey(), json_encode($this->turnCartCacheable(
            data_get($response, 'cartLinesAdd'),
        )), now()->addMinutes(20));

        return data_get($response, 'cartLinesAdd.cart.checkoutUrl');
    }

    private function createFreshCart(string $variantId, int $quantity, ?string $ref): string
    {
        $attributes = [];
        if ($ref) {
            $attributes[] = ['key' => 'ref', 'value' => $ref];
        }

        $response = Shopify::storefront()->call('storefront/createCart', [
            'input' => [
                'attributes' => $attributes,
                'lines' => [
                    [
                        'merchandiseId' => $variantId,
                        'quantity' => $quantity
                    ],
                ],
            ]
        ]);

        // Cache the cart
        Cache::put($this->getCartCacheKey(), json_encode($this->turnCartCacheable(
            data_get($response, 'cartCreate'),
        )), now()->addMinutes(20));

        return data_get($response, 'cartCreate.cart.checkoutUrl');
    }

    protected function turnCartCacheable($shopifyCart)
    {
        /**
         * SCHEMA:
         *
         * $cart = [
         * 'id' => 'ID',
         * 'checkoutUrl' => 'URL'
         * 'lines' => ['ID1', 'ID2']
         * ]
         */
        return [
            'id' => data_get($shopifyCart, 'cart.id'),
            'checkoutUrl' => data_get($shopifyCart, 'cart.checkoutUrl'),
            'lines' => collect(data_get($shopifyCart, 'cart.lines.edges'))->pluck('node.id'),
        ];
    }

    private function getCartCacheKey()
    {
        return 'cart:' . $this->getVisitorId();
    }

    private function getVisitorId()
    {
        if (!session()->has('visitor_id')) {
            session()->put('visitor_id', (string) Str::uuid());
        }

        return session()->get('visitor_id');
    }
}
