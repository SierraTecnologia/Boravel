<?php

namespace Boravel\Services\Manifest\Contracts;

/**
 * Interface Manifest.
 *
 * @package Boravel\Services\SiteMap\Contracts
 */
interface Manifest
{
    /**
     * Get manifest content.
     *
     * @return array
     */
    public function get(): array;
}
