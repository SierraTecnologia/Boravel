<?php

namespace App\Repositories\Travels\Rooms;

use Carbon\Carbon;
use App\Models\Calendar\Room;
use App\Repositories\CmsRepository;
use App\Repositories\TranslationRepository;

class RoomRepository extends CmsRepository
{
    public $model;

    public $translationRepo;

    public $table;

    public function __construct(Room $model, TranslationRepository $translationRepo)
    {
        $this->model = $model;
        $this->translationRepo = $translationRepo;
        $this->table = config('cms.db-prefix').'rooms';
    }

    /**
     * Returns all published Rooms.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findRoomsByDate($date)
    {
        return $this->model->where('is_published', 1)
            ->where('published_at', '<=', Carbon::now(config('app.timezone'))->format('Y-m-d H:i:s'))
            ->orderBy('created_at', 'desc')->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)->get();
    }

    /**
     * Stores Room into database.
     *
     * @param array $payload
     *
     * @return Room
     */
    public function store($payload)
    {
        $payload['title'] = htmlentities($payload['title']);
        $payload['is_published'] = (isset($payload['is_published'])) ? (bool) $payload['is_published'] : 0;
        $payload['published_at'] = (isset($payload['published_at']) && !empty($payload['published_at'])) ? Carbon::parse($payload['published_at'])->format('Y-m-d H:i:s') : Carbon::now(config('app.timezone'))->format('Y-m-d H:i:s');

        return $this->model->create($payload);
    }

    /**
     * Updates Room into database.
     *
     * @param Room $room
     * @param array $input
     *
     * @return Room
     */
    public function update($room, $payload)
    {
        $payload['title'] = htmlentities($payload['title']);
        if (!empty($payload['lang']) && $payload['lang'] !== config('cms.default-language', 'en')) {
            return $this->translationRepo->createOrUpdate($room->id, 'App\Models\Calendar\Room', $payload['lang'], $payload);
        } else {
            $payload['is_published'] = (isset($payload['is_published'])) ? (bool) $payload['is_published'] : 0;
            $payload['published_at'] = (isset($payload['published_at']) && !empty($payload['published_at'])) ? Carbon::parse($payload['published_at'])->format('Y-m-d H:i:s') : Carbon::now(config('app.timezone'))->format('Y-m-d H:i:s');

            unset($payload['lang']);

            return $room->update($payload);
        }
    }
}
