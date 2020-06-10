<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Boravel\Models\Digital\Code\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $creditCards = Project::orderBy('id', 'DESC')->get();

        return view('creditCards.index', compact('creditCards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('creditCards.create');
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
        'creditCard_name'=>'required',
        'creditCard_price'=> 'required|integer',
        'creditCard_qty' => 'required|integer'
      ]);
      $creditCard = new Project([
        'creditCard_name' => $request->get('creditCard_name'),
        'creditCard_price'=> $request->get('creditCard_price'),
        'creditCard_qty'=> $request->get('creditCard_qty')
      ]);
      $creditCard->save();
      return redirect('/creditCards')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $creditCard = Project::findOrFail($id);
        return view('creditCards.show', compact('creditCard'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $creditCard = Project::findOrFail($id);

        return view('creditCards.edit', compact('creditCard'));
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
            'creditCard_name'=>'required',
            'creditCard_price'=> 'required|integer',
            'creditCard_qty' => 'required|integer'
        ]);

        $creditCard = Project::findOrFail($id);
        $creditCard->creditCard_name = $request->get('creditCard_name');
        $creditCard->creditCard_price = $request->get('creditCard_price');
        $creditCard->creditCard_qty = $request->get('creditCard_qty');
        $creditCard->save();

        return redirect('/creditCards')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $creditCard = Project::findOrFail($id);
        $creditCard->delete();

        return redirect('/creditCards')->with('success', 'Stock has been deleted Successfully');
    }
}