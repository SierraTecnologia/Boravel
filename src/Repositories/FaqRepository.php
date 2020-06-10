<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Negocios\Faq;
use App\Repositories\CmsRepository;

class FaqRepository extends CmsRepository
{
    public $model;

    public $translationRepo;

    public $table;

    public function __construct(Faq $model, TranslationRepository $translationRepo)
    {
        $this->model = $model;
        $this->translationRepo = $translationRepo;
        $this->table = config('cms.db-prefix').'faqs';
    }

    /**
     * Stores Faq into database.
     *
     * @param array $payload
     *
     * @return Faq
     */
    public function store($payload)
    {
        $payload['question'] = htmlentities($payload['question']);
        $payload['is_published'] = (isset($payload['is_published'])) ? (bool) $payload['is_published'] : 0;
        $payload['published_at'] = (isset($payload['published_at']) && !empty($payload['published_at'])) ? Carbon::parse($payload['published_at'])->format('Y-m-d H:i:s') : Carbon::now(config('app.timezone'))->format('Y-m-d H:i:s');

        return $this->model->create($payload);
    }

    /**
     * Updates Faq into database.
     *
     * @param Faq   $Faq
     * @param array $input
     *
     * @return Faq
     */
    public function update($item, $payload)
    {
        $payload['question'] = htmlentities($payload['question']);

        if (!empty($payload['lang']) && $payload['lang'] !== config('cms.default-language', 'en')) {
            return $this->translationRepo->createOrUpdate($item->id, 'App\Models\Negocios\Faq', $payload['lang'], $payload);
        } else {
            $payload['is_published'] = (isset($payload['is_published'])) ? (bool) $payload['is_published'] : 0;
            $payload['published_at'] = (isset($payload['published_at']) && !empty($payload['published_at'])) ? Carbon::parse($payload['published_at'])->format('Y-m-d H:i:s') : Carbon::now(config('app.timezone'))->format('Y-m-d H:i:s');

            unset($payload['lang']);

            return $item->update($payload);
        }
    }
}
