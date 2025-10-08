<?php

namespace App\Actions;

use App\Enums\MessageStatus;
use App\Models\Gamification\ActivityType;
use App\Models\Player;
use App\Services\Shopify\Shopify;
use App\Services\Shopify\ShopifyException;

class CalculateAdminStats
{
    protected const BRAINIEST_BOUGHT_BOOKS_COUNT = 74;

    public function __invoke()
    {
        $funnelStats = $this->playerFunnelStats();

        $shopifyStats = $this->booksAndCalendarsSold();

        return nl2br(sprintf(
            "Total Players: %d
            \n
            Players With Bonus Pages: %d
            \n
            Players invited to order: %d (failed: %d)
            \n
            Books Sold: %d (%d without Brainiest - %.2f%%)
            \n
            Calendars Sold: %d",
            $funnelStats['totalPlayers'],
            $funnelStats['playersWithBonusPages'],
            $funnelStats['invitedPlayers'],
            $funnelStats['invitesFailed'],
            $shopifyStats['booksSold'],
            $shopifyStats['booksSold'] - static::BRAINIEST_BOUGHT_BOOKS_COUNT,
            (($shopifyStats['booksSold'] - static::BRAINIEST_BOUGHT_BOOKS_COUNT) / $funnelStats['invitedPlayers']) * 100,
            $shopifyStats['calendarsSold'],
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
}
