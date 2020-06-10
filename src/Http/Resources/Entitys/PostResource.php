<?php

namespace SiObject\Http\Resources\Entitys;

use SiObjects\Manipule\Entities\PostEntity;
use SiObjects\Manipule\Entities\TagEntity;
use function SiUtils\Helper\to_object;

/**
 * Class PostResource.
 *
 * @package SiObject\Http\Resources\Entitys
 */
class PostResource extends PostPlainResource
{
    /**
     * @var PostEntity
     */
    public $resource;

    /**
     * @inheritdoc
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'photo' => to_object($this->resource->getPhoto(), PhotoResource::class),
            'tags' => collect($this->resource->getTags())->map(function (TagEntity $tag) {
                return to_object($tag, TagPlainResource::class);
            }),
        ]);
    }
}
