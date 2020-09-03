<?php

namespace Modules\MaterialRezerv\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\MaterialRezerv\Entities\MaterialRezerv;
use Modules\Seller\Entities\Seller;

class MaterialRezervController extends Controller
{
  public $template_data = ['module' => 'materialrezerv'];

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
    $items = MaterialRezerv::paginate(10);
    return view('materialrezerv::index', ['items' => $items, 'template_data' => $this->t_d(['template' => 'index'])]);
  }

  /**
    * Show the form for creating a new resource.
    * @return Response
    */
  public function create()
  {
    $seller = Seller::get()->pluck('name','id');
    return view('materialrezerv::create', [
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

    $item = new MaterialRezerv;
    $item->fill($request->all());
    $item->user_id = auth()->user()->id;
    $item->save();

    return redirect('materialrezerv/')->with('success', __('common.materialrezerv_created'));
  }

  /**
    * Show the specified resource.
    * @param int $id
    * @return Response
    */
  public function show($id)
  {
    $item = MaterialRezerv::with(['Seller'])->find($id);
    return view('materialrezerv::show', ['item' => $item, 'template_data' => $this->t_d(['template' => 'show'])]);
  }

  /**
    * Show the form for editing the specified resource.
    * @param int $id
    * @return Response
    */
  public function edit($id)
  {
    $item = MaterialRezerv::find($id);
    $seller = Seller::get()->pluck('name','id');
    return view('materialrezerv::edit', ['item' => $item, 'seller' => $seller, 'template_data' => $this->t_d(['template' => 'edit'])]);
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

    $item = MaterialRezerv::find($id);

    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }

    $item->name = $request->input('name');
    $item->description = $request->input('description');
    $item->save();

    return redirect('materialrezerv/')->with('success', __('common.materialrezerv_updated'));
  }

  /**
    * Remove the specified resource from storage.
    * @param int $id
    * @return Response
    */
  public function destroy($id)
  {
    $item = MaterialRezerv::find($id);
    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }
    $item->delete();
    return redirect('materialrezerv/')->with('success', __('common.materialrezerv_deleted'));
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
