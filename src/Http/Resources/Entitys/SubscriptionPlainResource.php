<?php

namespace SiObject\Http\Resources\Entitys;

use SiObjects\Manipule\Entities\SubscriptionEntity;
use Illuminate\Http\Resources\Json\Resource;
use function SiUtils\Helper\html_purify;
use function SiUtils\Helper\to_string;

/**
 * Class SubscriptionPlainResource.
 *
 * @package SiObject\Http\Resources\Entitys
 */
class SubscriptionPlainResource extends Resource
{
    /**
     * @var SubscriptionEntity
     */
    public $resource;

    /**
     * @inheritdoc
     */
    public function toArray($request)
    {
        return [
            'email' => to_string(html_purify($this->resource->getEmail())),
            'token' => to_string(html_purify($this->resource->getToken())),
        ];
    }
}
