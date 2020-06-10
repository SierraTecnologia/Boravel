<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Boravel\Models\Digital\Code\Language;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::orderBy('id', 'DESC')->get();

        return view('languages.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('languages.create');
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
        'language_name'=>'required',
        'language_price'=> 'required|integer',
        'language_qty' => 'required|integer'
      ]);
      $language = new Language([
        'language_name' => $request->get('language_name'),
        'language_price'=> $request->get('language_price'),
        'language_qty'=> $request->get('language_qty')
      ]);
      $language->save();
      return redirect('/languages')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $language = Language::findOrFail($id);
        return view('languages.show', compact('language'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $language = Language::findOrFail($id);

        return view('languages.edit', compact('language'));
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
            'language_name'=>'required',
            'language_price'=> 'required|integer',
            'language_qty' => 'required|integer'
        ]);

        $language = Language::findOrFail($id);
        $language->language_name = $request->get('language_name');
        $language->language_price = $request->get('language_price');
        $language->language_qty = $request->get('language_qty');
        $language->save();

        return redirect('/languages')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $language = Language::findOrFail($id);
        $language->delete();

        return redirect('/languages')->with('success', 'Stock has been deleted Successfully');
    }
}