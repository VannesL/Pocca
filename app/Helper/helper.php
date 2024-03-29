<?php

if (!function_exists('rupiah')) {
    function rupiah(int|string $number = null, $formatCurrency = false): string
    {
        if (is_null($number)) return number_format(0, 0, ',', '.');

        if ($formatCurrency) {
            return "Rp " . number_format((float)$number, 0, ',', '.');
        }

        return number_format((float)$number, 0, ',', '.');
    }
}

if (!function_exists('rating')) {
    function rating(float $rate): float
    {
        return round($rate, 1);
    }
}
