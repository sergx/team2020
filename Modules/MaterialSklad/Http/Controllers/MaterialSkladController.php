<?php

namespace Modules\MaterialSklad\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\MaterialSklad\Entities\MaterialSklad;
use Modules\Seller\Entities\Seller;

class MaterialSkladController extends Controller
{
  public $template_data = ['module' => 'materialsklad'];

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
    $items = MaterialSklad::paginate(10);
    return view('materialsklad::index', ['items' => $items, 'template_data' => $this->t_d(['template' => 'index'])]);
  }

  /**
    * Show the form for creating a new resource.
    * @return Response
    */
  public function create()
  {
    $seller = Seller::get()->pluck('name','id');
    return view('materialsklad::create', [
      'seller' => $seller,
      'template_data' => $this->t_d(['template' => 'create']) ]);
  }

  /**
    * Store a newly created resource in storage.
    * @param Request $request
    * @return Response
    */
  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'volume' => 'required',
      'seller_id' => 'required',
    ]);

    $item = new MaterialSklad;
    $item->fill($request->all());
    $item->user_id = auth()->user()->id;
    $item->save();

    return redirect('materialsklad/')->with('success', __('common.materialsklad_created'));
  }

  /**
    * Show the specified resource.
    * @param int $id
    * @return Response
    */
  public function show($id)
  {
    $item = MaterialSklad::with(['Seller'])->find($id);

    return view('materialsklad::show', ['item' => $item, 'template_data' => $this->t_d(['template' => 'show'])]);
  }

  /**
    * Show the form for editing the specified resource.
    * @param int $id
    * @return Response
    */
  public function edit($id)
  {
    $item = MaterialSklad::find($id);
    return view('materialsklad::edit', ['item' => $item, 'template_data' => $this->t_d(['template' => 'edit'])]);
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

    $item = MaterialSklad::find($id);

    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }

    $item->name = $request->input('name');
    $item->description = $request->input('description');
    $item->place = $request->input('place');
    $item->volume = $request->input('volume');
    $item->contacts = $request->input('contacts');
    $item->save();

    return redirect('materialsklad/')->with('success', __('common.materialsklad_updated'));
  }

  /**
    * Remove the specified resource from storage.
    * @param int $id
    * @return Response
    */
  public function destroy($id)
  {
    $item = MaterialSklad::find($id);

    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }

    $item->delete();
    return redirect('materialsklad/')->with('success', __('common.materialsklad_deleted'));
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
