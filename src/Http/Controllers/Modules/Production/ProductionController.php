<?php

namespace Boravel\Http\Controllers\Modules\Production;

use Boravel\Http\Controllers\Controller;
use App\Models\Production;
use Translation\Models\Language;
use Illuminate\Support\Facades\Input;
use SiObject\Http\Requests\Admin\ProductionRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;

class ProductionController extends Controller {

    public function __construct()
    {
        view()->share('type', 'production');
    }

    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.production.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $languages = Language::lists('name', 'id')->toArray();
        $productioncategories = Production::lists('title', 'id')->toArray();
        return view('admin.production.create_edit', compact('languages', 'productioncategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ProductionRequest $request)
    {
        $production = new Production($request->except('image'));
        $production -> user_id = Auth::id();

        $picture = "";
        if(Input::hasFile('image'))
        {
            $file = Input::file('image');
            $filename = $file->getClientOriginalName();
            $extension = $file -> getClientOriginalExtension();
            $picture = sha1($filename . time()) . '.' . $extension;
        }
        $production -> picture = $picture;
        $production -> save();

        if(Input::hasFile('image'))
        {
            $destinationPath = public_path() . '/images/production/'.$production->id.'/';
            Input::file('image')->move($destinationPath, $picture);
        }
    }
}
