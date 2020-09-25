<?php

namespace Modules\Outgoing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\Outgoing\Entities\OutgoingCost;

class OutgoingCostController extends Controller
{
  public $template_data = ['module' => 'outgoingcost'];

  public function __construct()
  {
    $this->middleware('auth'/*, ['except' => ['index','show']] */);
  }

  /**
    * Show the form for creating a new resource.
    * @return Response
    */
  // public function create()
  // {
  //   return view('outgoing::create', ['template_data' => $this->t_d(['template' => 'create']) ]);
  // }

  /**
    * Store a newly created resource in storage.
    * @param Request $request
    * @return Response
    */
  public function store(Request $request)
  {
    $this->validate($request, [
      'outgoingcostable_type',
      'outgoingcostable_id',
    ]);

    $item = new OutgoingCost;
    $item->fill($request->all());
    $item->save();

    return redirect()->route('outgoing.show', $request->outgoing_id)->with('success', __('common.outgoingcost_created'));
  }

  /**
    * Show the specified resource.
    * @param int $id
    * @return Response
    */
  // public function show($id)
  // {
  //   $item = Outgoing::find($id);
  //   return view('outgoing::show', ['item' => $item, 'template_data' => $this->t_d(['template' => 'show'])]);
  // }

  /**
    * Show the form for editing the specified resource.
    * @param int $id
    * @return Response
    */
  // public function edit($id)
  // {
  //   $item = Outgoing::find($id);
  //   return view('outgoing::edit', ['item' => $item, 'template_data' => $this->t_d(['template' => 'edit'])]);
  // }

  /**
    * Update the specified resource in storage.
    * @param Request $request
    * @param int $id
    * @return Response
    */
  // public function update(Request $request, $id)
  // {
  //   $this->validate($request, [
  //     'name' => 'required',
  //   ]);

  //   $item = Outgoing::find($id);

  //   if(auth()->user()->id !== $item->user_id){
  //     return redirect()->route('home')->with('error', __('common.Unauthorized'));
  //   }

  //   $item->name = $request->input('name');
  //   $item->description = $request->input('description');
  //   $item->save();

  //   return redirect('outgoing/')->with('success', __('common.outgoing_updated'));
  // }

  /**
    * Remove the specified resource from storage.
    * @param int $id
    * @return Response
    */
  public function destroy(Request $request)
  {
    $item = OutgoingCost::find($request->id);
    $item->delete();
    return redirect()->route('outgoing.show', $request->outgoing_id)->with('success', __('common.outgoingcost_deleted'));
  }


  /**
   * @param array $data
   * @return array
   */
  // public function t_d($data)
  // {
  //   return array_merge($this->template_data, $data);
  // }
}
