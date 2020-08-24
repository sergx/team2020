<?php

namespace Modules\PersonContact\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\PersonContact\Entities\PersonContact;

class PersonContactController extends Controller
{
  public $template_data = ['module' => 'personcontact'];

  public function __construct()
  {
    $this->middleware('auth'/*, ['except' => ['index','show']] */);
  }

  // public function index()
  // {
  //   $items = PersonContact::paginate(10);
  //   return view('personcontact::index', ['items' => $items, 'template_data' => $this->t_d(['template' => 'index'])]);
  // }

  public function create(Request $request)
  {
    return view('personcontact::create', ['model' => $request->query('model'), 'model_id' => $request->query('model_id'), 'template_data' => $this->t_d(['template' => 'create']) ]);
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
    ]);

    $model_elem = 'Modules\\' .$request->model. '\Entities\\'.$request->model;
    $model_elem = $model_elem::find($request->model_id);
    
    $item = new PersonContact;
    $item->fill($request->all());
    $item->user_id = auth()->user()->id;
    if($model_elem){
      $item->contactable_type = $model_elem->getClassNamespace();
      $item->contactable_id = $model_elem->id;
    }
    $item->save();
    
    return redirect()->route($request->model.'.show', $request->model_id)->with('success', __('common.personcontact_created'));
  }

  
  // public function show($id)
  // {
  //   $item = PersonContact::find($id);
  //   return view('personcontact::show', ['item' => $item, 'template_data' => $this->t_d(['template' => 'show'])]);
  // }

  
  // public function edit($id)
  // {
  //   $item = PersonContact::find($id);
  //   return view('personcontact::edit', ['item' => $item, 'template_data' => $this->t_d(['template' => 'edit'])]);
  // }

  // public function update(Request $request, $id)
  // {
  //   $this->validate($request, [
  //     'name' => 'required',
  //   ]);

  //   $item = PersonContact::find($id);

  //   if(auth()->user()->id !== $item->user_id){
  //     return redirect()->route('home')->with('error', __('common.Unauthorized'));
  //   }

  //   $item->name = $request->input('name');
  //   $item->description = $request->input('description');
  //   $item->save();

  //   return redirect('personcontact/')->with('success', __('common.personcontact_updated'));
  // }


  // public function destroy($id)
  // {
  //   $item = PersonContact::find($id);
  //   if(auth()->user()->id !== $item->user_id){
  //     return redirect()->route('home')->with('error', __('common.Unauthorized'));
  //   }
  //   $item->delete();
  //   return redirect('personcontact/')->with('success', __('common.personcontact_deleted'));
  // }


  public function t_d($data)
  {
    return array_merge($this->template_data, $data);
  }
}
