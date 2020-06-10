<?php

namespace Boravel\Traits\Actions;

use Boravel\Resources\MixedContentItem;

trait ManagesMixedContent
{
    public function mixedContent(int $siteId): array
    {
        return $this->transformCollection(
            $this->get("mixed-content/$siteId")['data'],
            MixedContentItem::class
        );
    }
}
