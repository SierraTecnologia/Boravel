<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Boravel\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = false;

        return view('settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.create');
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
        'setting_name'=>'required',
        'setting_price'=> 'required|integer',
        'setting_qty' => 'required|integer'
      ]);
      $setting = new Setting([
        'setting_name' => $request->get('setting_name'),
        'setting_price'=> $request->get('setting_price'),
        'setting_qty'=> $request->get('setting_qty')
      ]);
      $setting->save();
      return redirect('/settings')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $setting = Setting::findOrFail($id);
        return view('settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = Setting::findOrFail($id);

        return view('settings.edit', compact('setting'));
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
            'setting_name'=>'required',
            'setting_price'=> 'required|integer',
            'setting_qty' => 'required|integer'
        ]);

        $setting = Setting::findOrFail($id);
        $setting->setting_name = $request->get('setting_name');
        $setting->setting_price = $request->get('setting_price');
        $setting->setting_qty = $request->get('setting_qty');
        $setting->save();

        return redirect('/settings')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        $setting->delete();

        return redirect('/settings')->with('success', 'Stock has been deleted Successfully');
    }
}