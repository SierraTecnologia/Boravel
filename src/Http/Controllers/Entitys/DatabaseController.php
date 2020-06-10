<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Boravel\Models\Digital\Infra\Database;

class DatabaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $databases = Database::orderBy('id', 'DESC')->get();

        return view('databases.index', compact('databases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('databases.create');
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
        'database_name'=>'required',
        'database_price'=> 'required|integer',
        'database_qty' => 'required|integer'
      ]);
      $database = new Database([
        'database_name' => $request->get('database_name'),
        'database_price'=> $request->get('database_price'),
        'database_qty'=> $request->get('database_qty')
      ]);
      $database->save();
      return redirect('/databases')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $database = Database::findOrFail($id);
        return view('databases.show', compact('database'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $database = Database::findOrFail($id);

        return view('databases.edit', compact('database'));
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
            'database_name'=>'required',
            'database_price'=> 'required|integer',
            'database_qty' => 'required|integer'
        ]);

        $database = Database::findOrFail($id);
        $database->database_name = $request->get('database_name');
        $database->database_price = $request->get('database_price');
        $database->database_qty = $request->get('database_qty');
        $database->save();

        return redirect('/databases')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $database = Database::findOrFail($id);
        $database->delete();

        return redirect('/databases')->with('success', 'Stock has been deleted Successfully');
    }
}