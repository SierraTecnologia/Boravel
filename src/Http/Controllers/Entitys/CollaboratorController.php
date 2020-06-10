<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Boravel\Models\Identity\Business\Collaborator;

class CollaboratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collaborators = Collaborator::orderBy('id', 'DESC')->get();

        return view('collaborators.index', compact('collaborators'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('collaborators.create');
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
        'customer_name'=>'required',
        'customer_price'=> 'required|integer',
        'customer_qty' => 'required|integer'
      ]);
      $customer = new Collaborator([
        'customer_name' => $request->get('customer_name'),
        'customer_price'=> $request->get('customer_price'),
        'customer_qty'=> $request->get('customer_qty')
      ]);
      $customer->save();
      return redirect('/collaborators')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Collaborator::findOrFail($id);
        return view('collaborators.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Collaborator::findOrFail($id);

        return view('collaborators.edit', compact('customer'));
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
            'customer_name'=>'required',
            'customer_price'=> 'required|integer',
            'customer_qty' => 'required|integer'
        ]);

        $customer = Collaborator::findOrFail($id);
        $customer->customer_name = $request->get('customer_name');
        $customer->customer_price = $request->get('customer_price');
        $customer->customer_qty = $request->get('customer_qty');
        $customer->save();

        return redirect('/collaborators')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Collaborator::findOrFail($id);
        $customer->delete();

        return redirect('/collaborators')->with('success', 'Stock has been deleted Successfully');
    }
}