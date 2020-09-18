<?php

namespace Modules\Deal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\Deal\Entities\Deal;
use Modules\Buyer\Entities\Buyer;
use Modules\Seller\Entities\Seller;
use Modules\MaterialRezerv\Entities\MaterialRezerv;
use Modules\MaterialSklad\Entities\MaterialSklad;

use App\User;

use Modules\Notification\Entities\Notification;

class DealController extends Controller
{
  //use \App\Traits\NotificationTrait; // addNotification

  public $template_data = ['module' => 'deal'];
  
  private $validate = [

    // 'material_name' => 'required',
    // 'material_volume' => 'required',
    // 'material_place' => 'required',
    // 'seller_name' => 'required',
    // 'seller_phone' => 'required',
    // 'seller_price' => 'required',
    // 'buyer_name' => 'required',
    // 'buyer_phone' => 'required',
    
    'buyer_price' => 'required',
    'buyer_id' => 'required',
    
  ];


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
    //dd(auth()->user()->hasRole('admin'));

    $items = Deal::orderBy('id', 'desc')->paginate(30);
    //dd($items);
    return view('deal::index', ['items' => $items, 'template_data' => $this->t_d(['template' => 'index'])]);
  }

  /**
    * Show the form for creating a new resource.
    * @return Response
    */
  public function create()
  {
    $buyers = Buyer::get()->pluck('name','id');
    $agents = User::role('agent')->get()->pluck('name','id');
    $sellers = Seller::get()->pluck('name','id');
    $materials_rezerv = MaterialRezerv::get()->pluck('name','id');
    $materials_sklad = MaterialSklad::get()->pluck('name','id');
    return view('deal::create_or_edit', [
      'buyers' => $buyers,
      'sellers' => $sellers,
      'agents' => $agents,
      'materials_rezerv' => $materials_rezerv,
      'materials_sklad' => $materials_sklad,
      'template_data' => $this->t_d(['template' => 'create']) ]);
  }

  /**
    * Store a newly created resource in storage.
    * @param Request $request
    * @return Response
    */
  public function store(Request $request)
  {
    $this->validate($request, $this->validate);

    $deal_item = new Deal;
    
    $deal_item->fill($request->all());
    if($request->hasFile('images'))
    {
      $folder_store = 'deals/' . $deal_item->id . '/images/';
      \App\Traits\filesHandleTrait::storeModelFiles($request->file('images'), $deal_item);
    }

    $deal_item->save();

    if(!empty($request->buyer_id)){
      $deal_item->Buyer()->sync([$request->buyer_id]);
    }else{
      $deal_item->Buyer()->detach();
    }
    if(!empty($request->seller_id)){
      $deal_item->Seller()->sync([$request->seller_id]);
    }else{
      $deal_item->Seller()->detach();
    }
    if(!empty($request->materialrezerv_id)){
      $deal_item->MaterialRezerv()->sync([$request->materialrezerv_id]);
    }else{
      $deal_item->MaterialRezerv()->detach();
    }
    if(!empty($request->materialsklad_id)){
      $deal_item->MaterialSklad()->sync([$request->materialsklad_id]);
    }else{
      $deal_item->MaterialSklad()->detach();
    }


    \App\Traits\NotificationTrait::addNotification(get_class($deal_item), $deal_item->id, [
      "formal_key" => 'common.deal_formal_created',
    ]);

    return redirect('deal/')->with('success', __('common.deal_created'));
  }

  /**
    * Show the specified resource.
    * @param int $id
    * @return Response
    */
  public function show($id)
  {
    $deal_item = Deal::where('id', $id)->with([
      'Files',
      'Buyer',
      'Seller',
      'MaterialRezerv',
      'MaterialSklad',
      'Notification' => function($query) {
      $query->orderBy('id', 'desc');
    }])->first();
    //dd($deal_item->MaterialRezerv[0]);
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
    $item = Deal::where('id', $id)->with([
      'Files',
      'Buyer',
      'Seller',
      'MaterialRezerv',
      'MaterialSklad',
      'Notification' => function($query) {
      $query->orderBy('id', 'desc');
    }])->first();
    $buyers = Buyer::get()->pluck('name','id');
    $agents = User::role('agent')->get()->pluck('name','id');
    $sellers = Seller::get()->pluck('name','id');
    $materials_rezerv = MaterialRezerv::get()->pluck('name','id');
    $materials_sklad = MaterialSklad::get()->pluck('name','id');
    return view('deal::create_or_edit', [
      'item' => $item,
      'buyers' => $buyers,
      'sellers' => $sellers,
      'agents' => $agents,
      'materials_rezerv' => $materials_rezerv,
      'materials_sklad' => $materials_sklad,
      'template_data' => $this->t_d(['template' => 'create']) ]);
  }

  /**
    * Update the specified resource in storage.
    * @param Request $request
    * @param int $id
    * @return Response
    */
  public function update(Request $request, $id)
  {
    $this->validate($request, $this->validate);

    $deal_item = Deal::find($id);
    //dd($request->all());
    // Формируем Уведомления
    foreach($request->all() as $key => $value){
      if(in_array($key, $deal_item->getFillable()) && $value !== $deal_item{$key}){
        \App\Traits\NotificationTrait::addNotification(get_class($deal_item), $deal_item->id, [
          "formal_key" => 'common.deal_formal_'.$key.'_changed',
          "old_value" => $deal_item{$key},
          "new_value" => $value,
        ]);
      }
    }
    
    $deal_item->fill($request->all());

    // Обрабатываем фотографии
    if($request->hasFile('images'))
    {
      $folder_store = 'deals/' . $deal_item->id . '/images/';
      \App\Traits\filesHandleTrait::storeModelFiles($request->file('images'), $deal_item);

      \App\Traits\NotificationTrait::addNotification(get_class($deal_item), $deal_item->id, [
        "formal_key" => 'common.deal_formal_images_changed',
      ]);
    }

    $deal_item->save();

    if(!empty($request->buyer_id)){
      $deal_item->Buyer()->sync([$request->buyer_id]);
    }else{
      $deal_item->Buyer()->detach();
    }
    if(!empty($request->seller_id)){
      $deal_item->Seller()->sync([$request->seller_id]);
    }else{
      $deal_item->Seller()->detach();
    }
    if(!empty($request->materialrezerv_id)){
      $deal_item->MaterialRezerv()->sync([$request->materialrezerv_id]);
    }else{
      $deal_item->MaterialRezerv()->detach();
    }
    if(!empty($request->materialsklad_id)){
      $deal_item->MaterialSklad()->sync([$request->materialsklad_id]);
    }else{
      $deal_item->MaterialSklad()->detach();
    }

    return redirect('deal/')->with('success', __('common.deal_updated'));
  }

  public function statusUpdate(Request $request, $id)
  {
    $deal_item = Deal::find($id);
    if(auth()->user()->hasPermissionTo('change deal status')){
      \App\Traits\NotificationTrait::addNotification(get_class($deal_item), $deal_item->id, [
        "formal_key" => 'deal_formal_status_changed',
        "old_value" => $deal_item->status,
        "new_value" => $request['status'],
      ]);

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

  // public function transferToUser(Request $request)
  // {
    
  //   //return array_merge($this->template_data, $data);
  // }
}
