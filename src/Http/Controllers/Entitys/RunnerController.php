<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Boravel\Models\Digital\Bot\Runner;

class RunnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Runner::orderBy('id', 'DESC')->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.create');
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
        'total'=>'required',
        'money'=> 'required|integer',
        'gateway' => 'required|integer'
      ]);
      $order = new Runner([
        'total' => $request->get('total'),
        'money'=> $request->get('money'),
        'gateway'=> $request->get('gateway')
      ]);
      $order->save();
      return redirect('/orders')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Runner::findOrFail($id);
        return view('orders.show', compact('order'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Runner::find($id);

        return view('orders.edit', compact('order'));
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
            'total'=>'required',
            'money'=> 'required|integer',
            'gateway' => 'required|integer'
        ]);

        $order = Runner::findOrFail($id);
        $order->total = $request->get('total');
        $order->money = $request->get('money');
        $order->gateway = $request->get('gateway');
        $order->save();

        return redirect('/orders')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Runner::findOrFail($id);
        $order->delete();

        return redirect('/orders')->with('success', 'Stock has been deleted Successfully');
    }
}