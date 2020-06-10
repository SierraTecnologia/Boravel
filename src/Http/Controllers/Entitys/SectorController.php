<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Boravel\Models\Identity\Business\Sector;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sectors = Sector::orderBy('id', 'DESC')->get();

        return view('sectors.index', compact('sectors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sectors.create');
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
        'sector_name'=>'required',
        'sector_price'=> 'required|integer',
        'sector_qty' => 'required|integer'
      ]);
      $sector = new Sector([
        'sector_name' => $request->get('sector_name'),
        'sector_price'=> $request->get('sector_price'),
        'sector_qty'=> $request->get('sector_qty')
      ]);
      $sector->save();
      return redirect('/sectors')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sector = Sector::findOrFail($id);
        return view('sectors.show', compact('sector'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sector = Sector::findOrFail($id);

        return view('sectors.edit', compact('sector'));
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
            'sector_name'=>'required',
            'sector_price'=> 'required|integer',
            'sector_qty' => 'required|integer'
        ]);

        $sector = Sector::findOrFail($id);
        $sector->sector_name = $request->get('sector_name');
        $sector->sector_price = $request->get('sector_price');
        $sector->sector_qty = $request->get('sector_qty');
        $sector->save();

        return redirect('/sectors')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sector = Sector::findOrFail($id);
        $sector->delete();

        return redirect('/sectors')->with('success', 'Stock has been deleted Successfully');
    }
}