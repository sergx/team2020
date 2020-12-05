<?php

namespace Modules\Buyer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\Buyer\Entities\Buyer;
use Modules\Buyer\Transformers\ApiTransform;

use Illuminate\Support\Str;

class BuyerController extends Controller
{
  public $template_data = ['module' => 'buyer'];
  /**
   * Create a new controller instance.
   *
   * @return void
   */
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
    //$org = Buyer::with(['productCategories', 'productCategories.products'])->where('id', $id)->first();
    $items = Buyer::with(['Files'])->paginate(125);
    if(\Request::is('api/*')){
      return ApiTransform::collection($items);
    }else{
      return view('buyer::index', ['items' => $items, 'template_data' => $this->t_d(['template' => 'index'])]);
    }
  }

  public function search(Request $request)
  {
    $q = $request->q;
    if(empty($q)){
      return redirect()->route('buyer.index');
    }
    
    $items = Buyer::with(['Files']);
    $columns = ['name', 'description', 'description_material', 'place'];
    foreach($columns as $column){
      $items->orWhere($column, 'LIKE', '%' . $q . '%');
    }
    $items = $items->paginate(99999);
    if(!count($items)){
      return redirect()->route('buyer.index')->with('error', "По запросу <strong>".$q."</strong> ничего не найдено");
    }

    $items = $this->searchHighlight($items, $q, $columns);

    if(\Request::is('api/*')){
      return ApiTransform::collection($items);
    }else{
      return view('buyer::index', ['items' => $items, 'q' => $q, 'template_data' => $this->t_d(['template' => 'index'])]);
    }
  }

  public function searchHighlight($items, $q, $columns){
    $open_tag = "<span style='background-color:#ffde19'>";
    $close_tag = "</span>";

    foreach($items as $k => $item){
      foreach($columns as $column){
        if(mb_stripos($item->$column, $q) !== false){
          $new_str = \mb_substr_replace($item->$column, $open_tag, mb_stripos($item->$column, $q), 0);
          $item->$column = \mb_substr_replace($new_str, $close_tag, mb_stripos($new_str, $q) + Str::length($q), 0);
        }
      }
    }
    return $items;
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create()
  {
    return view('buyer::create_or_edit', ['template_data' => $this->t_d(['template' => 'create']) ]);
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
    ]);

    $item = new Buyer;
    $item->fill($request->all());
    $item->user_id = auth()->user()->id;
    $item->save();
    if(\Request::is('api/*')){
      return new ApiTransform($item);
    }else{
      //return redirect('buyer/')->with('success', __('common.buyer_created'));
      return redirect()->route('buyer.show', $item->id)->with('success', __('common.buyer_updated'));
    }
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Response
   */
  public function show($id)
  {
    //$item = Buyer::where('id', $id)->first();
    $item = Buyer::with(['Files'])->find($id);
    if(\Request::is('api/*')){
      return new ApiTransform($item);
    }else{
      return view('buyer::show', ['item' => $item, 'template_data' => $this->t_d(['template' => 'show'])]);
    }
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Response
   */
  public function edit($id)
  {
    $item = Buyer::find($id);
    if(\Request::is('api/*')){
      return new ApiTransform($item);
    }else{
      return view('buyer::create_or_edit', ['item' => $item, 'template_data' => $this->t_d(['template' => 'edit'])]);
    }
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

    $item = Buyer::find($id);

    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }

    $item->fill($request->all());
    $item->save();
    if(\Request::is('api/*')){
      return new ApiTransform($item);
    }else{
      //return redirect('buyer/')->with('success', __('common.buyer_updated'));
      return redirect()->route('buyer.show', $id)->with('success', __('common.buyer_updated'));
    }
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy($id)
  {
    $item = Buyer::find($id);
    
    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }

    $item->delete();
    if(\Request::is('api/*')){
      return new ApiTransform($item);
    }else{
      return redirect('buyer/')->with('success', __('common.buyer_deleted'));
    }
  }

  /**
   * Array_merge to $template_data
   * @param array $data
   */
  public function t_d($data)
  {
    return array_merge($this->template_data, $data);
  }
}
