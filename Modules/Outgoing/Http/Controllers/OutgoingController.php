<?php

namespace Modules\Outgoing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\Outgoing\Entities\Outgoing;

use App\User;

class OutgoingController extends Controller
{
  public $template_data = ['module' => 'outgoing'];

  public function __construct()
  {
    $this->middleware('auth'/*, ['except' => ['index','show']] */);
  }

  /**
    * Display a listing of the resource.
    * @return Response
    */
  public function index()
  {
    $items = Outgoing::with(['OutgoingCosts'])->paginate(10);
    //dd($items);
    return view('outgoing::index', ['items' => $items, 'template_data' => $this->t_d(['template' => 'index'])]);
  }

  /**
    * Show the form for creating a new resource.
    * @return Response
    */
  public function create(Request $request)
  {
    $agents = User::role('agent')->get()->pluck('name','id');
    $model = base64_decode($request['model_class'])::find($request->model_id);

    return view('outgoing::create_or_edit', ['request' => $request, 'model' => $model, 'agents' => $agents, 'template_data' => $this->t_d(['template' => 'create']) ]);
  }

  /**
    * Store a newly created resource in storage.
    * @param Request $request
    * @return Response
    */
  public function store(Request $request)
  {
    $this->validate($request, [
      'user_id' => 'required',
    ]);
    $outgoing_item = Outgoing::create(request()->all());;
    $outgoing_item->name = $request->name;
    $outgoing_item->OutgoingCosts()->create(request()->all());
    $outgoing_item->save();
    
    // Перенаправлять на страницу Издежки, чтобы можно было добавить файл, А вот оттуда иметь ссылку на смежную модель
    return redirect($request->backroute)->with('success', __('common.outgoing_created'));
  }

  /**
    * Show the specified resource.
    * @param int $id
    * @return Response
    */
  public function show($id)
  {
    $item = Outgoing::find($id);

    $elems_all = $item->OutgoingCosts()->first()->outgoingcostable_type::get()->pluck('name','id');

    return view('outgoing::show', ['item' => $item, 'elems_all' => $elems_all, 'template_data' => $this->t_d(['template' => 'show'])]);
  }

  /**
    * Show the form for editing the specified resource.
    * @param int $id
    * @return Response
    */
  public function edit($id)
  {
    $item = Outgoing::find($id);
    return view('outgoing::create_or_edit', ['item' => $item, 'template_data' => $this->t_d(['template' => 'edit'])]);
  }

  /**
    * Update the specified resource in storage.
    * @param Request $request
    * @param int $id
    * @return Response
    */
  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'name' => 'required',
    ]);

    $item = Outgoing::find($id);

    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }

    $item->fill($request->all());
    $item->save();

    return redirect('outgoing/')->with('success', __('common.outgoing_updated'));
  }

  /**
    * Remove the specified resource from storage.
    * @param int $id
    * @return Response
    */
  public function destroy($id)
  {
    $item = Outgoing::find($id);
    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }
    $item->delete();
    return redirect('outgoing/')->with('success', __('common.outgoing_deleted'));
  }


  /**
   * @param array $data
   * @return array
   */
  public function t_d($data)
  {
    return array_merge($this->template_data, $data);
  }
}
