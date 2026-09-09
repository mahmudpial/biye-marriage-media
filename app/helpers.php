<?php

use App\Models\SiteSetting;

if (! function_exists('site_setting')) {
    /**
     * Get a site setting by key with optional fallback.
     */
    function site_setting(string $key, mixed $default = null): mixed
    {
        return SiteSetting::get($key, $default);
    }
}

if (! function_exists('site_setting_json')) {
    /**
     * Get a JSON site setting decoded as array with optional fallback.
     *
     * @param  array<int|string, mixed>  $default
     * @return array<int|string, mixed>
     */
    function site_setting_json(string $key, array $default = []): array
    {
        return SiteSetting::getJson($key, $default);
    }
}
