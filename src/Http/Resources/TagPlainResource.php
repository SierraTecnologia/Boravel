<?php

namespace Boravel\Http\Resources;

use Population\Manipule\Entities\TagEntity;
use Illuminate\Http\Resources\Json\JsonResource as Resource;
use function SiUtils\html_purify;
use function SiUtils\to_string;

/**
 * Class TagPlainResource.
 *
 * @package App\Http\Resources
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
