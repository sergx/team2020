<?php

namespace Modules\Seller\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\Seller\Entities\Seller;

use Illuminate\Support\Str;

class SellerController extends Controller
{
  public $template_data = ['module' => 'seller'];

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
    $items = Seller::paginate(10);
    return view('seller::index', ['items' => $items, 'template_data' => $this->t_d(['template' => 'index'])]);
  }

  public function search(Request $request)
  {
    $q = $request->q;
    if(empty($q)){
      return redirect()->route('seller.index');
    }
    
    $items = Seller::with(['Files']);
    $columns = ['name', 'place', 'description'];
    foreach($columns as $column){
      $items->orWhere($column, 'LIKE', '%' . $q . '%');
    }
    $items = $items->paginate(99999);
    if(!count($items)){
      return redirect()->route('seller.index')->with('error', "По запросу <strong>".$q."</strong> ничего не найдено");
    }

    $items = $this->searchHighlight($items, $q, $columns);

    return view('seller::index', ['items' => $items, 'q' => $q, 'template_data' => $this->t_d(['template' => 'index'])]);
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
    return view('seller::create_or_edit', ['template_data' => $this->t_d(['template' => 'create']) ]);
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
    //dd($request->all());
    $item = new Seller;

    //$data_to_pass = is_null( request('has_contract') ) ? request()->except('has_contract') : request()->all();
    $item->fill(request()->all());
    $item->user_id = auth()->user()->id;
    $item->save();

    return redirect('seller/')->with('success', __('common.seller_created'));
  }

  /**
    * Show the specified resource.
    * @param int $id
    * @return Response
    */
  public function show($id)
  {
    $item = Seller::with(['PersonContacts', 'MaterialsSklad'])->find($id);
    return view('seller::show', ['item' => $item, 'template_data' => $this->t_d(['template' => 'show'])]);
  }

  /**
    * Show the form for editing the specified resource.
    * @param int $id
    * @return Response
    */
  public function edit($id)
  {
    $item = Seller::find($id);
    return view('seller::create_or_edit', ['item' => $item, 'template_data' => $this->t_d(['template' => 'edit'])]);
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

    $item = Seller::find($id);
    
    //$data_to_pass = is_null( request('has_contract') ) ? request()->except('has_contract') : request()->all(); // 
    $item->fill(request()->all());
    $item->save();

    return redirect('seller/')->with('success', __('common.seller_updated'));
  }

  /**
    * Remove the specified resource from storage.
    * @param int $id
    * @return Response
    */
  public function destroy($id)
  {
    $item = Seller::find($id);

    $item->delete();
    if(strpos(url()->previous(), "/pre-deleted")){
      return redirect()->back();
    }
    return redirect('seller/')->with('success', __('common.seller_deleted'));
  }

  public function preDelete($id)
  {
    $item = Seller::find($id);
    $item->pre_deleted = true;
    $item->save();
    return redirect()->back();
  }

  public function preDeletedList()
  {
    $items = Seller::where(['pre_deleted' => 1])->paginate(50);
    return view('seller::pre_delete', ['items' => $items, 'template_data' => $this->t_d(['template' => 'pre_delete'])]);
  }

  public function keepAlive($id){
    $item = Seller::find($id);
    $item->pre_deleted = false;
    $item->save();
    return redirect()->back();
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
