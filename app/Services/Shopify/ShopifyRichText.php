<?php

namespace App\Services\Shopify;

/**
 * Minimal renderer for Shopify rich-text metafields.
 * Supports: paragraph, heading (h1–h6), text (bold/italic/underline/strikethrough/code),
 * lists (ul/ol + list_item), link, quote, hr, code_block, hard_break.
 * Unknown nodes are ignored (fail-safe).
 */
class ShopifyRichText
{
    public static function render(?string $json): string
    {
        if (is_null($json)) {
            return '';
        }
        $doc = json_decode($json, true);
        $html = static::renderNode($doc);

        return $html;
    }

    private static function renderNode($node): string
    {
        if (is_array($node) && array_key_exists('type', $node)) {
            return static::renderTypedNode($node);
        }
        // Root documents are often an array of nodes or an object with "children"
        if (is_array($node) && array_key_exists('children', $node)) {
            return static::renderChildren($node['children']);
        }
        if (is_array($node)) {
            // Could be a list of nodes
            return static::renderChildren($node);
        }
        return '';
    }

    private static function renderTypedNode(array $n): string
    {
        $type = $n['type'] ?? 'paragraph';
        $childrenHtml = static::renderChildren($n['children'] ?? []);

        switch ($type) {
            case 'paragraph':
                return $childrenHtml !== '' ? "<p>{$childrenHtml}</p>" : '';
            case 'heading':
                $level = (int)($n['level'] ?? 2);
                $level = max(1, min(6, $level));
                return "<h{$level}>{$childrenHtml}</h{$level}>";
            case 'text':
                return static::renderTextLeaf($n);
            case 'list':
                $tag = (($n['listType'] ?? 'unordered') === 'ordered') ? 'ol' : 'ul';
                return "<{$tag}>{$childrenHtml}</{$tag}>";
            case 'list-item':
                return "<li>{$childrenHtml}</li>";
            case 'link':
                $url = htmlspecialchars($n['url'] ?? '#', ENT_QUOTES, 'UTF-8');
                $title = isset($n['title']) ? ' title="' . htmlspecialchars($n['title'], ENT_QUOTES, 'UTF-8') . '"' : '';
                $rel = ' rel="noopener nofollow"';
                $target = (isset($n['target']) && $n['target'] === '_blank') ? ' target="_blank"' : '';
                return "<a href=\"{$url}\"{$title}{$target}{$rel}>{$childrenHtml}</a>";
            case 'blockquote':
                return "<blockquote>{$childrenHtml}</blockquote>";
            case 'horizontal_rule':
                return "<hr/>";
            case 'hard_break':
                return "<br/>";
            case 'code_block':
                $code = htmlspecialchars($n['code'] ?? strip_tags($childrenHtml), ENT_QUOTES, 'UTF-8');
                return "<pre><code>{$code}</code></pre>";
            case 'inline_object':
            case 'block_object':
                return '';
            default:
                // Unknown node -> render its children (be permissive)
                return $childrenHtml;
        }
    }

    private static function renderChildren(array $children): string
    {
        $out = '';
        foreach ($children as $c) {
            $out .= static::renderNode($c);
        }
        return $out;
    }

    private static function renderTextLeaf(array $n): string
    {
        $text = htmlspecialchars($n['value'] ?? '', ENT_QUOTES, 'UTF-8');

        // Marks may appear as booleans or an array; support both styles.
        $marks = [];
        foreach (['bold' => 'strong', 'italic' => 'em', 'underline' => 'u', 'strikethrough' => 's', 'code' => 'code'] as $flag => $tag) {
            if (!empty($n[$flag]) || (isset($n['marks']) && in_array($flag, (array)$n['marks'], true))) {
                $marks[] = $tag;
            }
        }
        foreach ($marks as $tag) {
            $text = "<{$tag}>{$text}</{$tag}>";
        }
        return $text;
    }
}
