<?php

declare(strict_types=1);

/**
 * Allows to convert date for API response
 * @param \Carbon\Carbon $date
 * @param string $format
 * @return array
 */
function dateResponseFormat(\Carbon\Carbon $date, string $format = '')
{
    if (empty($format)) {
        $format = 'd m, Y h:i a';
    }

    return [
        'object' => $date,
        'formatted' => $date->format($format),
    ];
}