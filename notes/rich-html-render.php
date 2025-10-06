<?php

$json = '{"type":"root","children":[{"type":"paragraph","children":[{"type":"text","value":"The essentials!"}]},{"type":"paragraph","children":[{"type":"text","value":"You get a signed copy of the book with free good good goodies!"}]},{"type":"paragraph","children":[{"type":"text","value":"Nothing more, nothing less."}]}]}';

$value = json_decode($json, true);

(new App\Services\Shopify\ShopifyRichText)->render($value);
