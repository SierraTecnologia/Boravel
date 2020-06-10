<?php

/*
 * This file is part of the ricardosierra/laravel-boss
 *
 * (c) ricardosierra <contato@ricardosierra.com.br>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Boss\Traits;

use Boss\Boss;

use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanLike;
use Overtrue\LaravelFollow\Traits\CanFavorite;
use Overtrue\LaravelFollow\Traits\CanSubscribe;
use Overtrue\LaravelFollow\Traits\CanVote;
use Overtrue\LaravelFollow\Traits\CanBookmark;


/**
 * Trait CanFeedBack.
 */
trait isClient
{
    use CanFollow, CanBookmark, CanLike, CanFavorite, CanSubscribe, CanVote;

    /**
     * Check if user is isLikedBy by given user.
     *
     * @param int $user
     *
     * @return bool
     */
    public function isLikedBy($user)
    {
        return Boss::isRelationExists($this, 'likers', $user);
    }

    /**
     * Return bossers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likers()
    {
        return $this->morphToMany(config('boss.user_model'), config('boss.morph_prefix'), config('boss.bossable_table'))
                    ->wherePivot('relation', '=', Boss::RELATION_LIKE)
                    ->withPivot('bossable_type', 'relation', 'created_at');
    }

    /**
     * Alias of likers.
     *
     * @return mixed
     */
    public function fans()
    {
        return $this->likers();
    }
}
