<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Boravel\Models\Digital\Infra\Domain;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domains = Domain::orderBy('id', 'DESC')->get();

        return view('domains.index', compact('domains'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('domains.create');
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
        'domain_name'=>'required',
        'domain_price'=> 'required|integer',
        'domain_qty' => 'required|integer'
      ]);
      $domain = new Domain([
        'domain_name' => $request->get('domain_name'),
        'domain_price'=> $request->get('domain_price'),
        'domain_qty'=> $request->get('domain_qty')
      ]);
      $domain->save();
      return redirect('/domains')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $domain = Domain::findOrFail($id);
        return view('domains.show', compact('domain'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $domain = Domain::findOrFail($id);

        return view('domains.edit', compact('domain'));
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
            'domain_name'=>'required',
            'domain_price'=> 'required|integer',
            'domain_qty' => 'required|integer'
        ]);

        $domain = Domain::findOrFail($id);
        $domain->domain_name = $request->get('domain_name');
        $domain->domain_price = $request->get('domain_price');
        $domain->domain_qty = $request->get('domain_qty');
        $domain->save();

        return redirect('/domains')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $domain = Domain::findOrFail($id);
        $domain->delete();

        return redirect('/domains')->with('success', 'Stock has been deleted Successfully');
    }
}