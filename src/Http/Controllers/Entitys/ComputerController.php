<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Boravel\Models\Digital\Infra\Computer;

class ComputerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $computers = Computer::orderBy('id', 'DESC')->get();

        return view('computers.index', compact('computers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('computers.create');
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
        'computer_name'=>'required',
        'computer_price'=> 'required|integer',
        'computer_qty' => 'required|integer'
      ]);
      $computer = new Computer([
        'computer_name' => $request->get('computer_name'),
        'computer_price'=> $request->get('computer_price'),
        'computer_qty'=> $request->get('computer_qty')
      ]);
      $computer->save();
      return redirect('/computers')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $computer = Computer::findOrFail($id);
        return view('computers.show', compact('computer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $computer = Computer::findOrFail($id);

        return view('computers.edit', compact('computer'));
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
            'computer_name'=>'required',
            'computer_price'=> 'required|integer',
            'computer_qty' => 'required|integer'
        ]);

        $computer = Computer::findOrFail($id);
        $computer->computer_name = $request->get('computer_name');
        $computer->computer_price = $request->get('computer_price');
        $computer->computer_qty = $request->get('computer_qty');
        $computer->save();

        return redirect('/computers')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $computer = Computer::findOrFail($id);
        $computer->delete();

        return redirect('/computers')->with('success', 'Stock has been deleted Successfully');
    }
}