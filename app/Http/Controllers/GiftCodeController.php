<?php

namespace App\Http\Controllers;

use App\Http\Resources\GiftCodeResource;
use App\Models\Gift;
use App\Models\GiftCode;
use App\Models\Product;
use App\Services\Shopify\Shopify;
use App\Services\Shopify\ShopifyException;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GiftCodeController extends Controller
{
    const VARIANT_SKU = 'wtw-book-solo';
    const QUANTITY = 1;

    public function show(Request $request, Gift $gift, GiftCode $giftCode)
    {
        $giftCode->load('gift');

        return inertia('GiftCodes/Show', [
            'giftCode' => GiftCodeResource::make($giftCode),
        ]);
    }

    public function checkout(Request $request, Gift $gift, GiftCode $giftCode)
    {
        // Create shopify gift card, if not already created
        if ($giftCard->meta['shopify_gift_card_id'] ?? null === null) {
            // Create gift card via Shopify API
            $response = Shopify::admin()->call('admin/createGiftCard', [
                'input' => [
                    'note' => "Via Gift Code: {$giftCode->name}",
                    'code' => $giftCode->code,
                    'initialValue' => sprintf('%0.2f', $giftCode->value),
                ]
            ]);

            $giftCode->meta = array_merge($giftCode->meta ?? [], [
                'shopify_gift_card_id' => data_get($response, 'giftCardCreate.giftCard.id'),
            ]);
            $giftCode->save();
        }

        // Create checkout link with the gift card applied
        $attributes[] = ['key' => 'giftcode', 'value' => $giftCode->name];
        $response = Shopify::storefront()->call('storefront/createCart', [
            'input' => [
                'attributes' => $attributes,
                'lines' => [
                    [
                        'merchandiseId' => $this->getVariantIdBySku(static::VARIANT_SKU),
                        'quantity' => static::QUANTITY,
                    ],
                ],
                'giftCardCodes' => [$giftCode->code],
            ]
        ]);

        return Inertia::location(data_get($response, 'cartCreate.cart.checkoutUrl'));
    }

    protected function getVariantIdBySku(string $sku): ?string
    {
        return Product::bySku($sku)->variants->where('sku', $sku)->first()?->id;
    }
}
