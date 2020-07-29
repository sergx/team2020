<?php

namespace Modules\Deal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\Deal\Entities\Deal;
// use Modules\Deal\Entities\DealLog;

use Modules\Notification\Entities\Notification;

class DealController extends Controller
{
  public $template_data = ['module' => 'deal'];

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
    
    $items = Deal::orderBy('id', 'desc')->paginate(30);
    return view('deal::index', ['items' => $items, 'template_data' => $this->t_d(['template' => 'index'])]);
  }

  /**
    * Show the form for creating a new resource.
    * @return Response
    */
  public function create()
  {
    return view('deal::create', ['template_data' => $this->t_d(['template' => 'create']) ]);
  }

  /**
    * Store a newly created resource in storage.
    * @param Request $request
    * @return Response
    */
  public function store(Request $request)
  {
    //dd($request['material']['name']);
    $this->validate($request, [
      //'name' => 'required',
      'material_name' => 'required',
      'material_volume' => 'required',
      'material_place' => 'required',
      'seller_name' => 'required',
      'seller_phone' => 'required',
      'seller_price' => 'required',
      'buyer_name' => 'required',
      'buyer_phone' => 'required',
      'buyer_price' => 'required',
    ]);

    $deal_item = new Deal;
    //$deal_item->name = $request->input('name');
    //$deal_item->description = $request->input('description');

    $deal_item->material_name = $request['material_name'];
    $deal_item->material_volume = $request['material_volume'];
    $deal_item->material_place = $request['material_place'];
    $deal_item->seller_name = $request['seller_name'];
    $deal_item->seller_phone = $request['seller_phone'];
    $deal_item->seller_price = $request['seller_price'];
    $deal_item->buyer_name = $request['buyer_name'];
    $deal_item->buyer_phone = $request['buyer_phone'];
    $deal_item->buyer_price = $request['buyer_price'];

    $deal_item->user_id = auth()->user()->id;
    $deal_item->save();


    // Оформить это как «событие»
    $notification_item = new Notification;
    $notification_item->user_id = auth()->user()->id;
    $notification_item->model_type = "Modules\Deal\Entities\Deal";
    $notification_item->model_id = $deal_item->id;
    $notification_item->options = array("formal_key" => 'common.deal_formal_created');
    $notification_item->save();



    return redirect('deal/')->with('success', __('common.deal_created'));
  }

  /**
    * Show the specified resource.
    * @param int $id
    * @return Response
    */
  public function show($id)
  {
    $deal_item = Deal::where('id', $id)
     ->with(
       ['Notification' => function($query) {
        $query->orderBy('id', 'desc');
       }]      
    )
    ->first();
    //dd($deal_item);
    
    // @TODO отсортировать наоборот
    //$deal_log = DealLog::where('deal_id', $deal_item->id)->get()->sortDesc();

    return view('deal::show', [
      'deal_item' => $deal_item,
      'template_data' => $this->t_d(['template' => 'show'])
      ]);
  }

  /**
    * Show the form for editing the specified resource.
    * @param int $id
    * @return Response
    */
  public function edit($id)
  {
    $item = Deal::find($id);
    return view('deal::edit', ['item' => $item, 'template_data' => $this->t_d(['template' => 'edit'])]);
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
      //'name' => 'required',
      'material_name' => 'required',
      'material_volume' => 'required',
      'material_place' => 'required',
      'seller_name' => 'required',
      'seller_phone' => 'required',
      'seller_price' => 'required',
      'buyer_name' => 'required',
      'buyer_phone' => 'required',
      'buyer_price' => 'required',
    ]);

    $deal_item = Deal::find($id);

    if(auth()->user()->id !== $deal_item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }
    $item_has_changed = false;
    foreach($request->all() as $key => $value){
      // @TODO - как-то иначе пометить какие поля отслеживать
      if(!in_array($key, ['_token', '_method']) && $value !== $deal_item{$key}){
        // Оформить это как «событие»
        $notification_item = new Notification;
        $notification_item->user_id = auth()->user()->id;
        $notification_item->model_type = "Modules\Deal\Entities\Deal";
        $notification_item->model_id = $deal_item->id;
        $notification_item->options = [
          "formal_key" => 'common.deal_formal_'.$key.'_changed',
          "old_value" => $deal_item{$key},
          "new_value" => $value,
        ];
        $notification_item->save();
        $item_has_changed = true;
      }
    }

    $deal_item->material_name = $request['material_name'];
    $deal_item->material_volume = $request['material_volume'];
    $deal_item->material_place = $request['material_place'];
    $deal_item->seller_name = $request['seller_name'];
    $deal_item->seller_phone = $request['seller_phone'];
    $deal_item->seller_price = $request['seller_price'];
    $deal_item->buyer_name = $request['buyer_name'];
    $deal_item->buyer_phone = $request['buyer_phone'];
    $deal_item->buyer_price = $request['buyer_price'];

    if($item_has_changed){
      $notification_item = new Notification;
      $notification_item->user_id = auth()->user()->id;
      $notification_item->model_type = "Modules\Deal\Entities\Deal";
      $notification_item->model_id = $deal_item->id;
      $notification_item->options = [
        "formal_key" => 'common.deal_formal_status_changed',
        "old_value" => $deal_item->status,
        "new_value" => 'updated',
      ];
      $deal_item->status = 'updated';
      $notification_item->save();
    }
    $deal_item->save();

    return redirect('deal/')->with('success', __('common.deal_updated'));
  }

  public function statusUpdate(Request $request, $id)
  {
    $deal_item = Deal::find($id);
    if(auth()->user()->hasPermissionTo('change deal status')){

      $notification_item = new Notification;
      $notification_item->user_id = auth()->user()->id;
      $notification_item->model_type = "Modules\Deal\Entities\Deal";
      $notification_item->model_id = $deal_item->id;
      $notification_item->options = [
        "formal_key" => 'common.deal_formal_status_changed',
        "old_value" => $deal_item->status,
        "new_value" => $request['status'],
      ];
      $notification_item->save();

      $deal_item->status = $request['status'];
      $deal_item->save();

      return redirect('deal/'.$id)->with('success', __('common.deal_status_'.$request['status']));
    }else{
      return redirect('deal/'.$id)->with('error', __('common.Unauthorized'));
    }
  }

  /**
    * Remove the specified resource from storage.
    * @param int $id
    * @return Response
    */
  public function destroy($id)
  {
    $item = Deal::find($id);
    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }
    $item->delete();
    return redirect('deal/')->with('success', __('common.deal_deleted'));
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
