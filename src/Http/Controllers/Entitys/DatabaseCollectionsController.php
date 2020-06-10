<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Boravel\Models\Digital\Infra\DatabaseCollection;

class DatabaseCollectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $databaseCollections = DatabaseCollection::orderBy('id', 'DESC')->get();

        return view('databaseCollections.index', compact('databaseCollections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('databaseCollections.create');
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
        'databaseCollection_name'=>'required',
        'databaseCollection_price'=> 'required|integer',
        'databaseCollection_qty' => 'required|integer'
      ]);
      $databaseCollection = new DatabaseCollection([
        'databaseCollection_name' => $request->get('databaseCollection_name'),
        'databaseCollection_price'=> $request->get('databaseCollection_price'),
        'databaseCollection_qty'=> $request->get('databaseCollection_qty')
      ]);
      $databaseCollection->save();
      return redirect('/databaseCollections')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $databaseCollection = DatabaseCollection::findOrFail($id);
        return view('databaseCollections.show', compact('databaseCollection'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $databaseCollection = DatabaseCollection::findOrFail($id);

        return view('databaseCollections.edit', compact('databaseCollection'));
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
            'databaseCollection_name'=>'required',
            'databaseCollection_price'=> 'required|integer',
            'databaseCollection_qty' => 'required|integer'
        ]);

        $databaseCollection = DatabaseCollection::findOrFail($id);
        $databaseCollection->databaseCollection_name = $request->get('databaseCollection_name');
        $databaseCollection->databaseCollection_price = $request->get('databaseCollection_price');
        $databaseCollection->databaseCollection_qty = $request->get('databaseCollection_qty');
        $databaseCollection->save();

        return redirect('/databaseCollections')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $databaseCollection = DatabaseCollection::findOrFail($id);
        $databaseCollection->delete();

        return redirect('/databaseCollections')->with('success', 'Stock has been deleted Successfully');
    }
}