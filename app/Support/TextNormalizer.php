<?php

namespace App\Support;

final class TextNormalizer
{
    public static function up(string|null $v, string $fallback = ''): string
    {
        $v = $v ?? $fallback;
        // remove espaços duplicados e normaliza
        $v = preg_replace('/\s+/', ' ', trim($v));
        return mb_strtoupper($v, 'UTF-8');
    }
}

