<?php

namespace Boravel\Http\Controllers\Modules\Interactions;



/**
 * Class SearchController.
 *
 * @author Amrani Houssain <amranidev@gmail.com>
 */
class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $questions = \App\Models\User::all()->count();
        

        return view(
            'admin.dashboard.dashboard',
            compact(
                'users',
                'roles',
                'permissions',
                'entities'
            )
        );
    }
}
