<?php

namespace Boravel\Http\Controllers\Modules\Wiki;

use Boravel\Http\Requests\CreateLanguageRequest as CreateRequest;
use Boravel\Http\Requests\CreateLanguageRequest as UpdateRequest;
use Boravel\Language as Model;

class LanguageController extends ResourceController
{
    /**
     * Class constructor.
     *
     * @param  Model
     * @return void
     */
    public function __construct(Model $resource)
    {
        parent::__construct($resource);
    }

    /**
     * Create a new resource.
     *
     * @param  CreateRequest
     * @return Response
     */
    public function store(CreateRequest $request)
    {
        return parent::_store($request);
    }

    /**
     * Update an exsiting resource.
     *
     * @param  UpdateRequest
     * @param  int           $id
     * @return Response
     */
    public function update(UpdateRequest $request, $id)
    {
        return parent::_update($request, $id);
    }
}
