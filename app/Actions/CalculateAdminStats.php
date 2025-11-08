<?php

namespace App\Actions;

use App\Enums\MessageStatus;
use App\Models\Gamification\ActivityType;
use App\Models\Gift;
use App\Models\Player;
use App\Services\Shopify\Shopify;
use App\Services\Shopify\ShopifyException;

class CalculateAdminStats
{
    public function __invoke()
    {
        $funnelStats = $this->playerFunnelStats();

        $shopifyStats = $this->booksAndCalendarsSold();

        $giftStats = $this->giftStats();

        return nl2br(sprintf(
            "Total Players: %d
            \n
            Players With Bonus Pages: %d
            \n
            Players invited to order: %d (failed: %d -- %.2f%%)
            \n
            Books Sold: %d (with gifts: %d)
            \n
            Calendars Sold: %d
            \n
            Gifts Available: %d (of %d given)",
            $funnelStats['totalPlayers'],
            $funnelStats['playersWithBonusPages'],
            $funnelStats['invitedPlayers'],
            $funnelStats['invitesFailed'],
            ($funnelStats['invitesFailed'] / ($funnelStats['invitedPlayers'] + $funnelStats['invitesFailed'])) * 100,
            $shopifyStats['booksSold'],
            ($shopifyStats['booksSold'] + $giftStats['totalGiftsAvailable']),
            $shopifyStats['calendarsSold'],
            $giftStats['totalGiftsAvailable'],
            $giftStats['totalGiftsGiven']
        ));
    }

    protected function playerFunnelStats()
    {
        $totalPlayers = Player::count();
        $playersWithBonusPages = Player::whereHas('activities', function ($query) {
            $query->where('type', ActivityType::WTW_BONUS_PAGES_DOWNLOADED);
        })->count();

        $invitedPlayers = Player::whereHas('activities', function ($query) {
            $query->where('type', ActivityType::WTW_BONUS_PAGES_DOWNLOADED);
        })->whereHas('messages', function ($query) {
            $query->where('body->content', '__t:preorders_invite')
                ->whereNot('status', MessageStatus::FAILED);
        })->count();

        $invitesFailed = Player::whereHas('messages', function ($query) {
            $query->where('body->content', '__t:preorders_invite')->where('status', MessageStatus::FAILED);
        })->whereDoesntHave('messages', function ($query) {
            $query->where('body->content', '__t:preorders_invite')->whereNot('status', MessageStatus::FAILED);
        })->count();

        return compact('totalPlayers', 'playersWithBonusPages', 'invitedPlayers', 'invitesFailed');
    }

    protected function booksAndCalendarsSold()
    {
        try {
            $response = Shopify::admin()->call('admin/getAnalytics', [
                'query' => "FROM sales
                SHOW net_items_sold, gross_sales, discounts, returns, net_sales, taxes,
                    total_sales
                WHERE product_title = 'What The What?!'
                GROUP BY product_title, product_variant_title, product_variant_sku
                    WITH TOTALS, CURRENCY 'INR'
                SINCE startOfDay(-90d) UNTIL today
                ORDER BY total_sales DESC
                LIMIT 1000
                VISUALIZE total_sales TYPE horizontal_bar"
            ]);
        } catch (ShopifyException $e) {
            dd($e->context());
        }

        $rows = data_get(
            $response,
            'shopifyqlQuery.tableData.rows'
        );

        $rows = collect($rows)->select(['product_variant_sku', 'net_items_sold']);

        $booksSold = $rows->sum(function ($row) {
            $count = (int) $row['net_items_sold'];

            // duo variant counts as 2 books per sale
            if (str_contains($row['product_variant_sku'], 'duo')) {
                $count *= 2;
            }

            return $count;
        });

        $calendarsSold = $rows->sum(function ($row) {
            // only calendar variant counts
            if (!str_contains($row['product_variant_sku'], 'calendar')) {
                return 0;
            }

            $count = (int) $row['net_items_sold'];

            // duo variant counts as 2 calendarts per sale
            if (str_contains($row['product_variant_sku'], 'duo')) {
                $count *= 2;
            }

            return $count;
        });

        return compact('booksSold', 'calendarsSold');
    }

    protected function giftStats()
    {
        $gifts = Gift::all();

        $totalGiftsGiven = 0;
        $totalGiftsAvailable = 0;
        foreach ($gifts as $gift) {
            $totalGiftsGiven += $gift->quantity;
            if ($gift->is_available_for_all) {
                $totalGiftsAvailable += $gift->ready_codes_count;
            }
        }

        return compact('totalGiftsGiven', 'totalGiftsAvailable');
    }
}
