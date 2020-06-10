<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Contact;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class ContactRepository
{
    protected $translationRepo;

    public function __construct()
    {
        $this->translationRepo = app(TranslationRepository::class);
    }

    /**
     * Returns all ContactS.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Contact::orderBy('created_at', 'desc')->get();
    }

    /**
     * Returns all paginated ContactS.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function paginated()
    {
        $model = app(Contact::class);

        if (isset(request()->dir) && isset(request()->field)) {
            $model = $model->orderBy(request()->field, request()->dir);
        } else {
            $model = $model->orderBy('created_at', 'desc');
        }

        return $model->paginate(config('sicms.pagination', 25));
    }

    /**
     * Returns all published Contacts.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findContactsByDate($date)
    {
        return Contact::where('is_published', 1)->where('published_at', '<=', Carbon::now()->format('Y-m-d h:i:s'))->orderBy('created_at', 'desc')->where('start_date', '<=', $date)->where('end_date', '>=', $date)->get();
    }

    /**
     * Returns all published Contacts.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function published()
    {
        return Contact::where('is_published', 1)->where('published_at', '<=', Carbon::now()->format('Y-m-d h:i:s'))->orderBy('created_at', 'desc')->paginate(Config::get('sicms.pagination', 25));
    }

    /**
     * Search Contact.
     *
     * @param string $input
     *
     * @return Contact
     */
    public function search($input)
    {
        $query = Contact::orderBy('created_at', 'desc');
        $query->where('id', 'LIKE', '%'.$input['term'].'%');

        $columns = Schema::getColumnListing('contacts');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$input['term'].'%');
        }

        return [$query, $input['term'], $query->paginate(Config::get('sicms.pagination', 25))->render()];
    }

    /**
     * Stores Contact into database.
     *
     * @param array $input
     *
     * @return Contact
     */
    public function store($input)
    {
        $input['is_published'] = (isset($input['is_published'])) ? (bool) $input['is_published'] : 0;
        $input['published_at'] = (isset($input['published_at']) && !empty($input['published_at'])) ? $input['published_at'] : Carbon::now()->format('Y-m-d h:i:s');

        return Contact::create($input);
    }

    /**
     * Find Contact by given id.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Contact
     */
    public function findContactById($id)
    {
        return Contact::find($id);
    }

    /**
     * Updates Contact into database.
     *
     * @param Contact $contact
     * @param array $input
     *
     * @return Contact
     */
    public function update($contact, $payload)
    {
        if (!empty($payload['lang']) && $payload['lang'] !== config('sicms.default-language', 'en')) {
            return $this->translationRepo->createOrUpdate($contact->id, 'App\Models\Contact', $payload['lang'], $payload);
        } else {
            $payload['is_published'] = (isset($payload['is_published'])) ? (bool) $payload['is_published'] : 0;
            $payload['published_at'] = (isset($payload['published_at']) && !empty($payload['published_at'])) ? $payload['published_at'] : Carbon::now()->format('Y-m-d h:i:s');

            unset($payload['lang']);

            return $contact->update($payload);
        }
    }
}
