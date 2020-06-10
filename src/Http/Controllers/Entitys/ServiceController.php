<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Boravel\Models\Components\Integrations\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::orderBy('id', 'DESC')->get();

        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services.create');
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
        'service_name'=>'required',
        'service_price'=> 'required|integer',
        'service_qty' => 'required|integer'
      ]);
      $service = new Service([
        'service_name' => $request->get('service_name'),
        'service_price'=> $request->get('service_price'),
        'service_qty'=> $request->get('service_qty')
      ]);
      $service->save();
      return redirect('/services')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);

        return view('services.edit', compact('service'));
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
            'service_name'=>'required',
            'service_price'=> 'required|integer',
            'service_qty' => 'required|integer'
        ]);

        $service = Service::findOrFail($id);
        $service->service_name = $request->get('service_name');
        $service->service_price = $request->get('service_price');
        $service->service_qty = $request->get('service_qty');
        $service->save();

        return redirect('/services')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect('/services')->with('success', 'Stock has been deleted Successfully');
    }
}