<?php

namespace Boravel\Http\Controllers\Modules\Production;

use Boravel\Http\Controllers\Controller;
use App\Rpg;
use App\RpgCategory;
use Boravel\Models\System\Language;
use Illuminate\Support\Facades\Input;
use SiObject\Http\Requests\Admin\RpgRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;

class RpgController extends Controller {

    public function __construct()
    {
        view()->share('type', 'rpg');
    }
    
    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.rpg.index');
    }

    public function menu()
    {
        $this->menu[ProductionType::$RPG][Stage::$ESBOCO] = [

        ];

        $this->menu[ProductionType::$RPG][Stage::$HISTORY] = [
            
        ];

        $this->menu[ProductionType::$RPG][Stage::$ROTEIRO] = [
            
        ];

        $this->menu[ProductionType::$RPG][Stage::$PRODUCTION] = [
            
        ];
    }
}
