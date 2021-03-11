<?php

namespace Modules\PunktPriem\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\PunktPriem\Entities\PunktPriem;
use Modules\ModxResource\Entities\ModxResource;

use Illuminate\Support\Str;
use App\User;

class PunktPriemController extends Controller
{
  public $template_data = ['module' => 'punktpriem'];

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
    $items = PunktPriem::paginate(10);
    return view('punktpriem::index', ['items' => $items, 'template_data' => $this->t_d(['template' => 'index'])]);
  }

  /**
    * Show the form for creating a new resource.
    * @return Response
    */
  public function create()
  {
    $cites = ModxResource::where(["template" => 9])->get()->pluck("menutitle","id");;
    $users = User::get()->pluck("name","id");
    return view('punktpriem::create_or_edit', ['cites' => $cites, 'users' => $users, 'template_data' => $this->t_d(['template' => 'create']) ]);
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
      'city_id' => 'required',
      'address' => 'required',
    ]);
    //dd($request->all());
    $item = new PunktPriem;
    $item->fill($request->all());
    $item->user_id = auth()->user()->id;
    $item->save();

    return redirect('punktpriem/')->with('success', __('common.punktpriem_created'));
  }

  /**
    * Show the specified resource.
    * @param int $id
    * @return Response
    */
  public function show($id)
  {
    $item = PunktPriem::with(['PersonContacts','Files'])->find($id);
    return view('punktpriem::show', ['item' => $item, 'template_data' => $this->t_d(['template' => 'show'])]);
  }

  /**
    * Show the form for editing the specified resource.
    * @param int $id
    * @return Response
    */
  public function edit($id)
  {
    $item = PunktPriem::find($id);
    $cites = ModxResource::where(["template" => 9])->get()->pluck("menutitle","id");
    $users = User::get()->pluck("name","id");
    return view('punktpriem::create_or_edit', ['cites' => $cites, 'users' => $users, 'item' => $item, 'template_data' => $this->t_d(['template' => 'edit'])]);
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

    $item = PunktPriem::find($id);

    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }
    $item->fill($request->all());
    $item->save();

    return redirect('punktpriem/')->with('success', __('common.punktpriem_updated'));
  }

  /**
    * Remove the specified resource from storage.
    * @param int $id
    * @return Response
    */
  public function destroy($id)
  {
    $item = PunktPriem::find($id);
    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }
    $item->delete();
    return redirect('punktpriem/')->with('success', __('common.punktpriem_deleted'));
  }

  public function search(Request $request)
  {
    $q = $request->q;
    if(empty($q)){
      return redirect()->route('punktpriem.index');
    }
    
    $items = Punktpriem::with(['Files']);
    $columns = ['name', 'address', 'description'];
    foreach($columns as $column){
      $items->orWhere($column, 'LIKE', '%' . $q . '%');
    }
    $items = $items->paginate(99999);
    if(!count($items)){
      return redirect()->route('punktpriem.index')->with('error', "По запросу <strong>".$q."</strong> ничего не найдено");
    }

    $items = $this->searchHighlight($items, $q, $columns);

    return view('punktpriem::index', ['items' => $items, 'q' => $q, 'template_data' => $this->t_d(['template' => 'index'])]);
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
   * @param array $data
   * @return array
   */
  public function t_d($data)
  {
    return array_merge($this->template_data, $data);
  }
}
