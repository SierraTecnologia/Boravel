<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Boravel\Models\Digital\Infra\Ambiente;

class AmbienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ambientes = Ambiente::orderBy('id', 'DESC')->get();

        return view('ambientes.index', compact('ambientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ambientes.create');
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
        'ambiente_name'=>'required',
        'ambiente_price'=> 'required|integer',
        'ambiente_qty' => 'required|integer'
      ]);
      $ambiente = new Ambiente([
        'ambiente_name' => $request->get('ambiente_name'),
        'ambiente_price'=> $request->get('ambiente_price'),
        'ambiente_qty'=> $request->get('ambiente_qty')
      ]);
      $ambiente->save();
      return redirect('/ambientes')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ambiente = Ambiente::findOrFail($id);
        return view('ambientes.show', compact('ambiente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ambiente = Ambiente::findOrFail($id);

        return view('ambientes.edit', compact('ambiente'));
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
            'ambiente_name'=>'required',
            'ambiente_price'=> 'required|integer',
            'ambiente_qty' => 'required|integer'
        ]);

        $ambiente = Ambiente::findOrFail($id);
        $ambiente->ambiente_name = $request->get('ambiente_name');
        $ambiente->ambiente_price = $request->get('ambiente_price');
        $ambiente->ambiente_qty = $request->get('ambiente_qty');
        $ambiente->save();

        return redirect('/ambientes')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ambiente = Ambiente::findOrFail($id);
        $ambiente->delete();

        return redirect('/ambientes')->with('success', 'Stock has been deleted Successfully');
    }
}