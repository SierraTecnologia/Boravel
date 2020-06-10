<?php

namespace Boravel\Services\SiteMap\Contracts;

use SiObject\Mount\SiteMap\Contracts\Builder;

/**
 * Interface SiteMapBuilderService.
 *
 * @package Boravel\Services\SiteMap\Contracts
 */
interface SiteMapBuilder
{
    /**
     * Build the sitemap.
     *
     * @return Builder
     */
    public function build(): Builder;
}
