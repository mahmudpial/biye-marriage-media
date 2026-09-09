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

if (! function_exists('site_setting_image')) {
    /**
     * Get a site setting image URL safely.
     */
    function site_setting_image(string $key, ?string $default = null): string
    {
        return SiteSetting::getImage($key, $default);
    }
}

if (! function_exists('site_setting_rgb')) {
    /**
     * Get a site setting color converted to "r, g, b" string.
     */
    function site_setting_rgb(string $key, string $defaultHex): string
    {
        return SiteSetting::getHexRgb($key, $defaultHex);
    }
}
