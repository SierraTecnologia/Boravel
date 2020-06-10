<?php

namespace SiObject\Http\Resources\Entitys;

use SiObjects\Manipule\Entities\TagEntity;
use Illuminate\Http\Resources\Json\Resource;
use function SiUtils\Helper\html_purify;
use function SiUtils\Helper\to_string;

/**
 * Class TagPlainResource.
 *
 * @package SiObject\Http\Resources\Entitys
 */
class TagPlainResource extends Resource
{
    /**
     * @var TagEntity
     */
    public $resource;

    /**
     * @inheritdoc
     */
    public function toArray($request)
    {
        return [
            'value' => to_string(html_purify($this->resource->getValue())),
        ];
    }
}
