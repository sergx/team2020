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
    if(strtolower($request->model) !== "user"){
      $model_elem = 'Modules\\' .$request->model. '\Entities\\'.$request->model;
    }else{
      $model_elem = 'App\User';
    }
    $model_elem = $model_elem::find($request->model_id);

    $item = new PersonContact;
    $item->fill($request->all());
    
    $item->user_id = auth()->user()->id;
    $item->contactable_type = get_class($model_elem);
    $item->contactable_id = $model_elem->id;

    $model_elem->PersonContacts()->save($item);
    
    return redirect()->route(strtolower($request->model).'.show', $request->model_id)->with('success', __('common.personcontact_created'));
  }


  public function destroy(Request $request)
  {
    if(strtolower($request->model) !== "user"){
      $model_elem = 'Modules\\' .$request->model. '\Entities\\'.$request->model;
    }else{
      $model_elem = 'App\User';
    }
    $model_elem = $model_elem::find($request->model_id);

    $personcontact_item = $model_elem->PersonContacts()->find($request->personcontact_id);
    
    $personcontact_item->delete();
    return redirect()->route(strtolower($request->model).'.show', $request->model_id)->with('success', __('common.personcontact_removed'));
  }


  public function t_d($data)
  {
    return array_merge($this->template_data, $data);
  }
}
