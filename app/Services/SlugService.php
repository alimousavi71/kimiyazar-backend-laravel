<?php

namespace App\Services;

use Illuminate\Support\Str;

class SlugService
{
    /**
     * Generate a slug from Persian/Arabic text while preserving Persian characters.
     *
     * @param string $value
     * @param string $separator
     * @return string
     */
    public static function makeSlug(string $value, string $separator = '-'): string
    {
        // Normalize common Arabic characters to Persian equivalents
        $value = str_replace(['ي', 'ك'], ['ی', 'ک'], $value);

        // Lowercase and trim
        $value = trim(mb_strtolower($value, 'UTF-8'));

        // Replace any whitespace or underscore with the separator
        $value = preg_replace('/[\s_]+/u', $separator, $value);

        // Allow Persian letters, English letters, digits, and separator; drop others
        $value = preg_replace('/[^0-9a-zA-Zآ-یءئإأؤۀکگپچژ\s' . preg_quote($separator, '/') . ']+/u', '', $value);

        // Collapse multiple separators
        $value = preg_replace('/' . preg_quote($separator, '/') . '+/', $separator, $value);

        // Trim separators
        $value = trim($value, $separator);

        // Fallback if empty
        return $value !== '' ? $value : Str::random(8);
    }

    /**
     * Make slug unique by checking existing slugs and appending number if needed.
     *
     * @param string $baseSlug
     * @param callable $existsCallback Function that checks if slug exists: fn(string $slug): bool
     * @param string $separator
     * @return string
     */
    public static function makeUnique(string $baseSlug, callable $existsCallback, string $separator = '-'): string
    {
        $slug = $baseSlug;
        $counter = 1;

        while ($existsCallback($slug)) {
            $slug = $baseSlug . $separator . $counter;
            $counter++;
        }

        return $slug;
    }
}
