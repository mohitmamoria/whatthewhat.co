<?php

namespace App\Actions;

use App\Models\Gamification\Activity;
use App\Models\Gamification\ActivityType;
use App\Models\Gift;
use App\Models\Message;

class SendGiftConfirmationOnWhatsapp
{
    const TEMPLATE_GIFT_CONFIRMATION = 'wtw_gift_status';

    protected array $skuToProduct = [
        'gift-wtw-book-solo-with-shipping' => 'What The What?! Gift (with shipping)',
        'gift-wtw-book-solo-without-shipping' => 'What The What?! Gift (without shipping)',
    ];

    public function __invoke(Activity $activity, Gift $gift)
    {
        if ($activity->type !== ActivityType::WTW_GIFTED) {
            return;
        }

        $message = (new SendMessageOnWhatsapp)(
            $activity->owner,
            Message::TEMPLATE_PREFIX . static::TEMPLATE_GIFT_CONFIRMATION,
            [
                [
                    "type" => "body",
                    "parameters" => [
                        [
                            "type" => "text",
                            "text" => $activity->meta['order_name'],
                        ],
                        [
                            "type" => "text",
                            "text" => $activity->meta['quantity'],
                        ],
                        [
                            "type" => "text",
                            "text" => $this->skuToProduct[$activity->meta['sku']],
                        ],
                        [
                            "type" => "text",
                            "text" => route('gift.show', ['gift' => $gift->name]),
                        ],
                    ],
                ],
            ]
        );
    }
}
