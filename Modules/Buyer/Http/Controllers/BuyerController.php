<?php

namespace Modules\Buyer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\Buyer\Entities\Buyer;
use Modules\Buyer\Transformers\APIBuyer;


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
    $items = Buyer::with(['Files'])->paginate(10);
    if(\Request::is('api/*')){
      return APIBuyer::collection($items);
    }else{
      return view('buyer::index', ['items' => $items, 'template_data' => $this->t_d(['template' => 'index'])]);
    }
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
      return new APIBuyer($item);
    }else{
      return redirect('buyer/')->with('success', __('common.buyer_created'));
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
      return new APIBuyer($item);
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
      return new APIBuyer($item);
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
      return new APIBuyer($item);
    }else{
      return redirect('buyer/')->with('success', __('common.buyer_updated'));
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
      return new APIBuyer($item);
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
