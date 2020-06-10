<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Boravel\Models\Digital\Infra\Logger;

class LoggerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loggers = Logger::all();

        return view('loggers.index', compact('loggers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('loggers.create');
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
        'analysi_name'=>'required',
        'analysi_price'=> 'required|integer',
        'analysi_qty' => 'required|integer'
      ]);
      $analysi = new Logger([
        'analysi_name' => $request->get('analysi_name'),
        'analysi_price'=> $request->get('analysi_price'),
        'analysi_qty'=> $request->get('analysi_qty')
      ]);
      $analysi->save();
      return redirect('/loggers')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $logger = Logger::findOrFail($id);
        return view('loggers.show', compact('logger'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $logger = Logger::findOrFail($id);

        return view('loggers.edit', compact('logger'));
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
            'logger_name'=>'required',
            'logger_price'=> 'required|integer',
            'logger_qty' => 'required|integer'
        ]);

        $logger = Logger::findOrFail($id);
        $logger->logger_name = $request->get('logger_name');
        $logger->logger_price = $request->get('logger_price');
        $logger->logger_qty = $request->get('logger_qty');
        $logger->save();

        return redirect('/loggers')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $logger = Logger::findOrFail($id);
        $logger->delete();

        return redirect('/loggers')->with('success', 'Stock has been deleted Successfully');
    }
}