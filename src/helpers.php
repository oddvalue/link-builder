<?php

use Oddvalue\LinkBuilder\Contracts\Linkable;

if (! function_exists('get_link')) {
    /**
     * Convert a path to a URL.
     *
     * @param  string  $path
     * @return string
     */
    function get_link(Linkable $linkableModel, $options = [])
    {
        return $linkableModel->getLinkGenerator($options);
    }
}

if (! function_exists('url')) {
    /**
     * Convert a path to a URL.
     *
     * @param  string  $path
     * @return string
     */
    function url($path)
    {
        return '/'.ltrim($path, '/');
    }
}
