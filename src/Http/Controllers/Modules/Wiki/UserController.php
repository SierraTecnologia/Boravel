<?php

namespace Boravel\Http\Controllers\Modules\Wiki;

use Boravel\Http\Requests\CreateUserRequest as CreateRequest;
use Boravel\Http\Requests\CreateUserRequest as UpdateRequest;
use Boravel\User as Model;

class UserController extends ResourceController
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
		$this->setEagerLoadedRelationships('language', 'provider', 'role');
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
	 * @param  int $id
	 * @return Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		return parent::_update($request, $id);
	}

	/**
	 * Display a form for saving a resource.
	 *
	 * @param  string $subtitle Page subtitle.
	 * @param  string $action   Form route sufix.
	 * @param  string $method   Form method.
	 * @return Response
	 */
	protected function showForm($subtitle, $action, $method = 'POST')
	{
		view()->share([
			'languages' => \RicardoSierra\Translation\Models\Language::orderBy('name')->withTrashed()->lists('name', 'id'),
			'providers' => \App\Models\Provider::orderBy('name')->withTrashed()->lists('name', 'id'),
			'role' => \App\Role::orderBy('name')->lists('name', 'id'),
		]);

		return parent::showForm($subtitle, $action, $method);
	}
}
