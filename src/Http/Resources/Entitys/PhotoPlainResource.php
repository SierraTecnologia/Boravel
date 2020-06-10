<?php

namespace SiObject\Http\Resources\Entitys;

use SiObjects\Manipule\Entities\PhotoEntity;
use Illuminate\Http\Resources\Json\Resource;
use function SiUtils\Helper\html_purify;
use function SiUtils\Helper\to_int;
use function SiUtils\Helper\to_string;

/**
 * Class PhotoPlainResource.
 *
 * @package SiObject\Http\Resources\Entitys
 */
class PhotoPlainResource extends Resource
{
    /**
     * @var PhotoEntity
     */
    public $resource;

    /**
     * @inheritdoc
     */
    public function toArray($request)
    {
        return [
            'id' => to_int(html_purify($this->resource->getId())),
            'created_by_user_id' => to_int(html_purify($this->resource->getCreatedByUserId())),
            'avg_color' => to_string(html_purify($this->resource->getAvgColor())),
            'created_at' => to_string(html_purify($this->resource->getCreatedAt()->toAtomString())),
        ];
    }
}
