<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use Boravel\Models\Role;
use Boravel\Models\Customer;
use Auth;

class UserController extends Controller
{

    public function __construct()
    {
        if ($user = Auth::check() && !$user->isAdmin()) {
            return abort(401, 'Usuário sem permissão para acesso a esta página.');
        }

        parent::__construct();   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminUsers = User::where('role_id', [Role::$GOOD, Role::$ADMIN])->orderBy('id', 'DESC')->get();
        $businessUsers = User::where('role_id', [Role::$USER])->orderBy('id', 'DESC')->get();
        $businessUsers = User::where('role_id', [Role::$CLIENT])->orderBy('id', 'DESC')->get();
        $customerUsers = Customer::count();

        return view(
            'users.index',
            compact(
                'adminUsers',
                'businessUsers',
                'businessUsers',
                'customerUsers'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'user_name'=>'required',
        'user_price'=> 'required|integer',
        'user_qty' => 'required|integer'
      ]);
      $user = new User([
        'user_name' => $request->get('user_name'),
        'user_price'=> $request->get('user_price'),
        'user_qty'=> $request->get('user_qty')
      ]);
      $user->save();
      return redirect('/users')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_name'=>'required',
            'user_price'=> 'required|integer',
            'user_qty' => 'required|integer'
        ]);

        $user = User::findOrFail($id);
        $user->user_name = $request->get('user_name');
        $user->user_price = $request->get('user_price');
        $user->user_qty = $request->get('user_qty');
        $user->save();

        return redirect('/users')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/users')->with('success', 'Stock has been deleted Successfully');
    }
}