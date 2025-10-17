<?php

namespace App\Actions;

use App\Models\Gamification\Activity;
use App\Models\Gamification\ActivityType;
use App\Models\Message;

class SendOrderConfirmationOnWhatsapp
{
    const TEMPLATE_ORDER_CONFIRMATION = 'wtw_order_confirmed';

    protected array $skuToProduct = [
        'wtw-book-solo' => 'What The What?! (Curious)',
        'wtw-book-calendar' => 'What The What?! (Curiouser)',
        'wtw-book-calendar-duo' => 'What The What?! (Curiouser and Curiouser)',
    ];

    public function __invoke(Activity $activity)
    {
        if ($activity->type !== ActivityType::WTW_PURCHASED) {
            return;
        }

        $message = (new SendMessageOnWhatsapp)(
            $activity->owner,
            Message::TEMPLATE_PREFIX . static::TEMPLATE_ORDER_CONFIRMATION,
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
                    ],
                ],
            ]
        );
    }
}
