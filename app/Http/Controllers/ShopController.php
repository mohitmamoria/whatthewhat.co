<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Shopify\Shopify;
use Illuminate\Http\Request;
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

        $response = Shopify::storefront()->call('storefront/createCart', [
            'input' => [
                'attributes' => [
                    ['key' => 'ref', 'value' => 'preorder-campaign'],
                    ['key' => 'note', 'value' => 'Yay!'],
                ],
                'lines' => [
                    [
                        'merchandiseId' => $validated['variant'],
                        'quantity' => $validated['quantity']
                    ],
                ],
            ]
        ]);

        $checkoutUrl = data_get($response, 'cartCreate.cart.checkoutUrl');

        return Inertia::location($checkoutUrl);
    }
}
