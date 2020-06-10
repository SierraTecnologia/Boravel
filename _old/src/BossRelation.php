<?php

/*
 * This file is part of the ricardosierra/laravel-boss
 *
 * (c) ricardosierra <contato@ricardosierra.com.br>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Boss;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use InvalidArgumentException;

/**
 * Class BossRelation.
 */
class BossRelation extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $with = ['bossable'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function bossable()
    {
        return $this->morphTo(config('boss.morph_prefix', 'bossable'));
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null                           $type
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query, $type = null)
    {
        $query->select('bossable_id', 'bossable_type', \DB::raw('COUNT(*) AS count'))
                        ->groupBy('bossable_id', 'bossable_type')
                        ->orderByDesc('count');

        if ($type) {
            $query->where('bossable_type', $this->normalizeBossableType($type));
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function getTable()
    {
        if (!$this->table) {
            $this->table = config('boss.bossable_table', 'bossables');
        }

        return parent::getTable();
    }

    /**
     * {@inheritdoc}
     */
    public function getDates()
    {
        return [parent::CREATED_AT];
    }

    /**
     * @param string $type
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    protected function normalizeBossableType($type)
    {
        $morphMap = Relation::morphMap();

        if (!empty($morphMap) && in_array($type, $morphMap, true)) {
            $type = array_search($type, $morphMap, true);
        }

        if (class_exists($type)) {
            return $type;
        }

        $namespace = config('boss.model_namespace', 'App');

        $modelName = $namespace.'\\'.studly_case($type);

        if (!class_exists($modelName)) {
            throw new InvalidArgumentException("Model {$modelName} not exists. Please check your config 'boss.model_namespace'.");
        }

        return $modelName;
    }
}
