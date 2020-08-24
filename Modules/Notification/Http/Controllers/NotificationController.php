<?php

namespace Modules\Notification\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\Notification\Entities\Notification;
use Modules\Notification\Entities\NotificationViews;

class NotificationController extends Controller
{
  public $template_data = ['module' => 'notification'];

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
    $items = Notification::with(["NotificationViews" => function($q){
      $q->where('notification_views.user_id', '=', auth()->user()->id);
    }, "User", "model"])->orderBy('id','desc')->paginate(30);
    
    return view('notification::index', ['items' => $items, 'template_data' => $this->t_d(['template' => 'index'])]);
  }

  /**
    * Show the form for creating a new resource.
    * @return Response
    */
  public function create()
  {
    return view('notification::create', ['template_data' => $this->t_d(['template' => 'create']) ]);
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

    $item = new Notification;
    $item->name = $request->input('name');
    $item->description = $request->input('description');
    $item->user_id = auth()->user()->id;
    $item->save();

    return redirect('notification/')->with('success', __('common.notification_created'));
  }

  /**
    * Show the specified resource.
    * @param int $id
    * @return Response
    */
  public function show($id)
  {
    $item = Notification::find($id);
    return view('notification::show', ['item' => $item, 'template_data' => $this->t_d(['template' => 'show'])]);
  }

  /**
    * Show the form for editing the specified resource.
    * @param int $id
    * @return Response
    */
  public function edit($id)
  {
    $item = Notification::find($id);
    return view('notification::edit', ['item' => $item, 'template_data' => $this->t_d(['template' => 'edit'])]);
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

    $item = Notification::find($id);

    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }

    $item->name = $request->input('name');
    $item->description = $request->input('description');
    $item->save();

    return redirect('notification/')->with('success', __('common.notification_updated'));
  }

  /**
    * Remove the specified resource from storage.
    * @param int $id
    * @return Response
    */
  public function destroy($id)
  {
    $item = Notification::find($id);
    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }
    $item->delete();
    return redirect('notification/')->with('success', __('common.notification_deleted'));
  }
  
  /**
   * @param array $data
   * @return array
   */
  public function t_d($data)
  {
    return array_merge($this->template_data, $data);
  }

  public function viewAdd(Request $request)
  {
    $item = new NotificationViews;
    $item->user_id = $request->user_id;
    $item->notification_id = $request->id;
    $item->save();
    if($request->ajax()){
      return true;
    }
    return redirect('notification/');
  }
  public function viewRemove(Request $request)
  {
    $item = NotificationViews::where("user_id", $request->user_id)->where("notification_id", $request->id)->first();
    $item->delete();
    if($request->ajax()){
      return true;
    }
    return redirect('notification/');
  }
}
