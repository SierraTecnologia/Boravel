<?php

namespace Boravel\Http\Controllers\Modules\Calendar;

use Boravel\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use SiObject\Http\Requests\Admin\ArticleRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;

class HomeController extends Controller
{

    public function __construct()
    {
        view()->share('type', 'home');
    }
    
    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        // Show the page
        return view('gp.home.index');
    }

    public function menu()
    {
        $this->menu[] = 'Agendamentos';
        $this->menu[] = 'Historico';
        $this->menu[] = 'Agendamentos';
        $this->menu[] = 'Agendamentos';
    }
}
