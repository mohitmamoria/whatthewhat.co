<?php

namespace App\Console\Commands;

use App\Models\BookscanEntry;
use App\Models\Product;
use App\Services\Shopify\Shopify;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class PrepareBookscanEntries extends Command
{
    const VENDOR_EUREKA = 'Eureka';
    const VENDOR_BOOKWISH = 'Bookwish';

    const PERCENT_EUREKA = 0.60;
    const PERCENT_BOOKWISH = 0.40;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:bookscan {--sync : Whether to sync from Shopify orders} {--export : Export to CSV file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepare bookscan entries from Shopify orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('sync')) {
            return $this->syncFromShopifyOrders();
        }

        if ($this->option('export')) {
            $this->exportBookwishCsv();
            $this->exportEurekaCsv();
        }
    }

    protected function exportBookwishCsv(): void
    {
        $entries = BookscanEntry::nonGifted()->orderBy('date', 'asc')->where('vendor', self::VENDOR_BOOKWISH)->get();

        $filename = resource_path(sprintf('bookwish_%s.csv', now()->format('Ymd_His')));
        $file = fopen($filename, 'w');
        fputcsv($file, ['purchase-date', 'sku', 'quantity-purchased', 'item-price', 'total-price', 'ship-postal-code']);

        foreach ($entries as $entry) {
            fputcsv($file, [
                $entry->date->format('d-M-y'),
                $entry->sku,
                $entry->quantity,
                399,
                $entry->price,
                $entry->shipping_pin_code,
            ]);
        }

        fclose($file);

        $this->info(sprintf('Exported %d Bookwish entries to %s', $entries->count(), $filename));
    }

    protected function exportEurekaCsv(): void
    {
        $entries = BookscanEntry::nonGifted()->orderBy('date', 'asc')->where('vendor', self::VENDOR_EUREKA)->get();

        $filename = resource_path(sprintf('eureka_%s.csv', now()->format('Ymd_His')));
        $file = fopen($filename, 'w');
        fputcsv($file, ['purchase-date', 'sku', 'quantity-purchased', 'item-price', 'total-price', 'ship-postal-code']);

        foreach ($entries as $entry) {
            fputcsv($file, [
                $entry->date->format('d-M-y'),
                $entry->sku,
                $entry->quantity,
                399,
                $entry->price,
                $entry->shipping_pin_code,
            ]);
        }

        fclose($file);

        $this->info(sprintf('Exported %d Eureka entries to %s', $entries->count(), $filename));
    }

    protected function syncFromShopifyOrders()
    {
        $products = Product::all();

        $this->info(sprintf('Syncing orders for %d products', $products->count()));
        foreach ($products as $product) {
            // sku:"SKU1" OR sku:"SKU2" OR sku:"SKU3"
            $query = $product->variants->pluck('sku')->map(function ($sku) {
                return sprintf('sku:"%s"', $sku);
            })->join(' OR ');

            $this->info(sprintf('Query: %s', $query));

            $page = 1;
            $after = null;
            do {
                $this->info(sprintf('Fetching page %d', $page++));

                try {
                    $response = Shopify::admin()->call('admin/getOrders', ['query' => $query, 'after' => $after]);
                } catch (\App\Services\Shopify\ShopifyException $e) {
                    dd($e->context());
                    return 1;
                }

                $total = data_get($response, 'orders.edges') ? count(data_get($response, 'orders.edges')) : 0;
                foreach (data_get($response, 'orders.edges') as $index => $order) {
                    $this->info(sprintf('Processing order [%d/%d]: %s', $index + 1, $total, data_get($order, 'node.id')));

                    $this->recordAsBookscanEntry($order['node']);
                }

                $after = data_get($response, 'orders.pageInfo.endCursor');
                sleep(1); // 1 second pause between each page
            } while (data_get($response, 'orders.pageInfo.hasNextPage'));
        }

        $this->info('All orders synced successfully.');
    }

    protected function recordAsBookscanEntry(array $order): void
    {
        $existing = BookscanEntry::where('shopify_order_id', data_get($order, 'id'))->first();
        if ($existing) {
            $this->info(sprintf('Bookscan entry already exists for order %s, skipping.', data_get($order, 'id')));
            return;
        }


        $lines = data_get($order, 'lineItems.edges', []);
        foreach ($lines as $line) {
            $sku = data_get($line, 'node.sku');
            $quantity = data_get($line, 'node.quantity', 0);
            if ($quantity <= 0) {
                continue;
            }

            if (str($sku)->endsWith('-duo')) {
                $quantity *= 2; // duo variant counts as 2 books
            }

            $attributes = data_get($order, 'customAttributes');
            $giftCodeName = data_get(collect($attributes)->where('key', 'giftcode')->first(), 'value');

            BookscanEntry::updateOrCreate([
                'shopify_order_id' => data_get($order, 'id'),
            ], [
                'vendor' => ((rand(1, 100) <= 55) || str($sku)->startsWith('gift-')) ? self::VENDOR_EUREKA : self::VENDOR_BOOKWISH,
                'date' => Carbon::parse(data_get($order, 'processedAt')),
                'sku' => $sku,
                'quantity' => $quantity,
                'price' => 399 * $quantity,
                'shipping_pin_code' => data_get($order, 'shippingAddress.zip', data_get($order, 'billingAddress.zip')),
                'is_received_gift' => $giftCodeName ? true : false,
            ]);
        }


        $this->info(sprintf('Created bookscan entry for order %s', data_get($order, 'id')));
    }
}
