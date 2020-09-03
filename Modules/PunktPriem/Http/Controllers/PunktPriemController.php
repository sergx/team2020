<?php

namespace Modules\PunktPriem\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\PunktPriem\Entities\PunktPriem;

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
    return view('punktpriem::create', ['template_data' => $this->t_d(['template' => 'create']) ]);
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

    $item = new PunktPriem;
    $item->name = $request->input('name');
    $item->description = $request->input('description');
    $item->address = $request->input('address');
    $item->phone = $request->input('phone');
    $item->email = $request->input('email');
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
    return view('punktpriem::edit', ['item' => $item, 'template_data' => $this->t_d(['template' => 'edit'])]);
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

    $item->name = $request->input('name');
    $item->description = $request->input('description');
    $item->address = $request->input('address');
    $item->phone = $request->input('phone');
    $item->email = $request->input('email');
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


  /**
   * @param array $data
   * @return array
   */
  public function t_d($data)
  {
    return array_merge($this->template_data, $data);
  }
}
