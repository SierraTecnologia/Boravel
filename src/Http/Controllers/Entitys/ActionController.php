<?php

namespace Boravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Boravel\Actions\Action;
use Boravel\Models\Digital\Bot\Runner;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelForActions = Action::getModels();

        return view(
            'actions.index',
            compact('modelForActions')
        );
    }

    protected function modelFromString($model)
    {
        return str_replace('_', '\\', $model);
    }

    public function actionsForModel($model)
    {
        $model = $this->modelFromString($model);
        $actionsForModels = Action::getOnlyActionsForModel($model);
        $models = $model::all();

        return view(
            'actions.model',
            compact(
                'actionsForModels',
                'models'
            )
        );
    }

    public function executeAction($modelId, $actionCod)
    {
        if (!$action = Action::getActionByCode($actionCod)){
            abort(404, 'Action not Found.');
        }
        $modelClass = $action->classAfetada;
        if (!$model = $modelClass::find($modelId)){
            abort(404, 'Model not Found.');
        }

        $runner = (new Runner())->usingAction($action)->usingTarget($model)->run();

        return view(
            'actions.execute',
            compact(
                'runner'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('actions.create');
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
        'gateway_name'=>'required',
        'gateway_price'=> 'required|integer',
        'gateway_qty' => 'required|integer'
      ]);
      $gateway = new Action([
        'gateway_name' => $request->get('gateway_name'),
        'gateway_price'=> $request->get('gateway_price'),
        'gateway_qty'=> $request->get('gateway_qty')
      ]);
      $gateway->save();
      return redirect('/actions')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gateway = Action::findOrFail($id);
        return view('actions.show', compact('gateway'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gateway = Action::findOrFail($id);

        return view('actions.edit', compact('gateway'));
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
            'gateway_name'=>'required',
            'gateway_price'=> 'required|integer',
            'gateway_qty' => 'required|integer'
        ]);

        $gateway = Action::findOrFail($id);
        $gateway->gateway_name = $request->get('gateway_name');
        $gateway->gateway_price = $request->get('gateway_price');
        $gateway->gateway_qty = $request->get('gateway_qty');
        $gateway->save();

        return redirect('/actions')->with('success', 'Stock has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gateway = Action::findOrFail($id);
        $gateway->delete();

        return redirect('/actions')->with('success', 'Stock has been deleted Successfully');
    }
}