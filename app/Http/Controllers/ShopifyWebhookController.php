<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Services\Shopify\Shopify;
use Exception;
use Illuminate\Http\Request;

class ShopifyWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        // Skip processing invalid requests
        // if (!$this->isVerfied($request)) {
        //     return 'OK?';
        // }

        $topic = $request->header('X-Shopify-Topic');
        $topic = "orders/create";
        $method = str($topic)->replace('/', '-')->camel()->toString();

        if (!method_exists($this, $method)) {
            return 'OK';
        }

        $body = '
        {
        "id": 6257618157747,
        "admin_graphql_api_id": "gid://shopify/Order/6257618157747",
        "app_id": 283439955969,
        "browser_ip": "2401:4900:9153:557f:2940:fb8:d010:8ce7",
        "buyer_accepts_marketing": true,
        "cancel_reason": null,
        "cancelled_at": null,
        "cart_token": "hWN3qWGK1mrXKDRneTxGts4C",
        "checkout_id": 28226285338803,
        "checkout_token": "50c57be4ca80e1e9565bfc2ca274eff8",
        "client_details": {
            "accept_language": "en-IN",
            "browser_height": null,
            "browser_ip": "2401:4900:9153:557f:2940:fb8:d010:8ce7",
            "browser_width": null,
            "session_hash": null,
            "user_agent": "Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1"
        },
        "closed_at": null,
        "confirmation_number": "5CIHNJM8X",
        "confirmed": true,
        "contact_email": "suprajakannan159@gmail.com",
        "created_at": "2025-10-07T22:09:12+05:30",
        "currency": "INR",
        "current_shipping_price_set": {
            "shop_money": { "amount": "80.00", "currency_code": "INR" },
            "presentment_money": { "amount": "80.00", "currency_code": "INR" }
        },
        "current_subtotal_price": "399.00",
        "current_subtotal_price_set": {
            "shop_money": { "amount": "399.00", "currency_code": "INR" },
            "presentment_money": { "amount": "399.00", "currency_code": "INR" }
        },
        "current_total_additional_fees_set": null,
        "current_total_discounts": "0.00",
        "current_total_discounts_set": {
            "shop_money": { "amount": "0.00", "currency_code": "INR" },
            "presentment_money": { "amount": "0.00", "currency_code": "INR" }
        },
        "current_total_duties_set": null,
        "current_total_price": "479.00",
        "current_total_price_set": {
            "shop_money": { "amount": "479.00", "currency_code": "INR" },
            "presentment_money": { "amount": "479.00", "currency_code": "INR" }
        },
        "current_total_tax": "0.00",
        "current_total_tax_set": {
            "shop_money": { "amount": "0.00", "currency_code": "INR" },
            "presentment_money": { "amount": "0.00", "currency_code": "INR" }
        },
        "customer_locale": "en-IN",
        "device_id": null,
        "discount_codes": [],
        "duties_included": false,
        "email": "suprajakannan159@gmail.com",
        "estimated_taxes": false,
        "financial_status": "paid",
        "fulfillment_status": null,
        "landing_site": "/cart/c/hWN3qUxXn6JnoIIOwvLe1w04?key=627a8f353234874bbe4e93b64355b77f",
        "landing_site_ref": null,
        "location_id": null,
        "merchant_business_entity_id": "MTY4MTY4MzE5MTU1",
        "merchant_of_record_app_id": null,
        "name": "IYKYK-#2061",
        "note": null,
        "note_attributes": [{ "name": "ref", "value": "SUPRAJA8488" }],
        "number": 1061,
        "order_number": 2061,
        "order_status_url": "https://iykyk.store/68168319155/orders/f428648edb06585b596d7ae57c0847ae/authenticate?key=151620cd39579230f722949ff19df10b",
        "original_total_additional_fees_set": null,
        "original_total_duties_set": null,
        "payment_gateway_names": ["1 Razorpay"],
        "phone": null,
        "po_number": null,
        "presentment_currency": "INR",
        "processed_at": "2025-10-07T22:09:11+05:30",
        "reference": null,
        "referring_site": "https://whatthewhat.co/",
        "source_identifier": null,
        "source_name": "283439955969",
        "source_url": null,
        "subtotal_price": "399.00",
        "subtotal_price_set": {
            "shop_money": { "amount": "399.00", "currency_code": "INR" },
            "presentment_money": { "amount": "399.00", "currency_code": "INR" }
        },
        "tags": "",
        "tax_exempt": false,
        "tax_lines": [],
        "taxes_included": false,
        "test": false,
        "token": "f428648edb06585b596d7ae57c0847ae",
        "total_cash_rounding_payment_adjustment_set": {
            "shop_money": { "amount": "0.00", "currency_code": "INR" },
            "presentment_money": { "amount": "0.00", "currency_code": "INR" }
        },
        "total_cash_rounding_refund_adjustment_set": {
            "shop_money": { "amount": "0.00", "currency_code": "INR" },
            "presentment_money": { "amount": "0.00", "currency_code": "INR" }
        },
        "total_discounts": "0.00",
        "total_discounts_set": {
            "shop_money": { "amount": "0.00", "currency_code": "INR" },
            "presentment_money": { "amount": "0.00", "currency_code": "INR" }
        },
        "total_line_items_price": "399.00",
        "total_line_items_price_set": {
            "shop_money": { "amount": "399.00", "currency_code": "INR" },
            "presentment_money": { "amount": "399.00", "currency_code": "INR" }
        },
        "total_outstanding": "0.00",
        "total_price": "479.00",
        "total_price_set": {
            "shop_money": { "amount": "479.00", "currency_code": "INR" },
            "presentment_money": { "amount": "479.00", "currency_code": "INR" }
        },
        "total_shipping_price_set": {
            "shop_money": { "amount": "80.00", "currency_code": "INR" },
            "presentment_money": { "amount": "80.00", "currency_code": "INR" }
        },
        "total_tax": "0.00",
        "total_tax_set": {
            "shop_money": { "amount": "0.00", "currency_code": "INR" },
            "presentment_money": { "amount": "0.00", "currency_code": "INR" }
        },
        "total_tip_received": "0.00",
        "total_weight": 400,
        "updated_at": "2025-10-07T22:09:14+05:30",
        "user_id": null,
        "billing_address": {
            "first_name": "Supraja",
            "address1": "R.R(ramya\'s) PG Accommodation",
            "phone": "+917092668488",
            "city": "Chennai",
            "zip": "600096",
            "province": "Tamil Nadu",
            "country": "India",
            "last_name": "K D",
            "address2": "New no. 1/420 old no. 1/339, 2nd Cross Street, Sri Sai Nagar, Thoraipakkam",
            "company": null,
            "latitude": 12.9602737,
            "longitude": 80.2403262,
            "name": "Supraja K D",
            "country_code": "IN",
            "province_code": "TN"
        },
        "customer": {
            "id": 8651853398195,
            "created_at": "2025-10-07T21:59:32+05:30",
            "updated_at": "2025-10-07T22:09:13+05:30",
            "first_name": "Supraja",
            "last_name": "K D",
            "state": "disabled",
            "note": null,
            "verified_email": true,
            "multipass_identifier": null,
            "tax_exempt": false,
            "email": "suprajakannan159@gmail.com",
            "phone": null,
            "currency": "INR",
            "tax_exemptions": [],
            "admin_graphql_api_id": "gid://shopify/Customer/8651853398195",
            "default_address": {
                "id": 9643888312499,
                "customer_id": 8651853398195,
                "first_name": "Supraja",
                "last_name": "K D",
                "company": null,
                "address1": "R.R(ramya\'s) PG Accommodation",
                "address2": "New no. 1/420 old no. 1/339, 2nd Cross Street, Sri Sai Nagar, Thoraipakkam",
                "city": "Chennai",
                "province": "Tamil Nadu",
                "country": "India",
                "zip": "600096",
                "phone": "+917092668488",
                "name": "Supraja K D",
                "province_code": "TN",
                "country_code": "IN",
                "country_name": "India",
                "default": true
            }
        },
        "discount_applications": [],
        "fulfillments": [],
        "line_items": [
            {
                "id": 15034229260467,
                "admin_graphql_api_id": "gid://shopify/LineItem/15034229260467",
                "attributed_staffs": [],
                "current_quantity": 1,
                "fulfillable_quantity": 1,
                "fulfillment_service": "manual",
                "fulfillment_status": null,
                "gift_card": false,
                "grams": 400,
                "name": "What The What?! - Curious",
                "price": "399.00",
                "price_set": {
                    "shop_money": { "amount": "399.00", "currency_code": "INR" },
                    "presentment_money": { "amount": "399.00", "currency_code": "INR" }
                },
                "product_exists": true,
                "product_id": 8348846457011,
                "properties": [],
                "quantity": 1,
                "requires_shipping": true,
                "sales_line_item_group_id": null,
                "sku": "wtw-book-solo",
                "taxable": false,
                "title": "What The What?!",
                "total_discount": "0.00",
                "total_discount_set": {
                    "shop_money": { "amount": "0.00", "currency_code": "INR" },
                    "presentment_money": { "amount": "0.00", "currency_code": "INR" }
                },
                "variant_id": 45040476061875,
                "variant_inventory_management": "shopify",
                "variant_title": "Curious",
                "vendor": "IYKYK",
                "tax_lines": [
                    {
                        "channel_liable": false,
                        "price": "0.00",
                        "price_set": {
                            "shop_money": { "amount": "0.00", "currency_code": "INR" },
                            "presentment_money": { "amount": "0.00", "currency_code": "INR" }
                        },
                        "rate": 0.18,
                        "title": "IGST"
                    }
                ],
                "duties": [],
                "discount_allocations": []
            }
        ],
        "payment_terms": null,
        "refunds": [],
        "shipping_address": {
            "first_name": "Supraja",
            "address1": "R.R(ramya\'s) PG Accommodation",
            "phone": "+917092668488",
            "city": "Chennai",
            "zip": "600096",
            "province": "Tamil Nadu",
            "country": "India",
            "last_name": "K D",
            "address2": "New no. 1/420 old no. 1/339, 2nd Cross Street, Sri Sai Nagar, Thoraipakkam",
            "company": null,
            "latitude": 12.9602737,
            "longitude": 80.2403262,
            "name": "Supraja K D",
            "country_code": "IN",
            "province_code": "TN"
        },
        "shipping_lines": [
            {
                "id": 5037328597171,
                "carrier_identifier": null,
                "code": "Standard",
                "current_discounted_price_set": {
                    "shop_money": { "amount": "80.00", "currency_code": "INR" },
                    "presentment_money": { "amount": "80.00", "currency_code": "INR" }
                },
                "discounted_price": "80.00",
                "discounted_price_set": {
                    "shop_money": { "amount": "80.00", "currency_code": "INR" },
                    "presentment_money": { "amount": "80.00", "currency_code": "INR" }
                },
                "is_removed": false,
                "phone": null,
                "price": "80.00",
                "price_set": {
                    "shop_money": { "amount": "80.00", "currency_code": "INR" },
                    "presentment_money": { "amount": "80.00", "currency_code": "INR" }
                },
                "requested_fulfillment_service_id": null,
                "source": "shopify",
                "title": "Standard",
                "tax_lines": [],
                "discount_allocations": []
            }
        ],
        "returns": [],
        "line_item_groups": []
    }
        ';

        $this->$method(json_decode($body, true));
        // $this->$method(json_decode($request->getContent(), true));

        return 'OK';
    }

    protected function ordersCreate(array $payload)
    {
        $id = data_get($payload, 'admin_graphql_api_id');

        $order = Shopify::admin()->call('admin/getOrder', compact('id'));

        $attributes = data_get($order, 'order.customAttributes');

        $ref = collect($attributes)->where('key', 'ref')->first()['value'];

        $referrer = Player::byReferrerCode($ref);



        dd($order);
    }

    protected function isVerfied(Request $request)
    {
        $hmacHeader = $request->header('X-Shopify-Hmac-Sha256');
        $data = $request->getContent();

        $calculated = base64_encode(
            hash_hmac('sha256', $data, config('services.shopify.webhook_verify_token'), true)
        );

        return ($calculated === $hmacHeader);
    }
}
