<?php

namespace Modules\File\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\File\Entities\File;

class FileController extends Controller
{
  use \App\Traits\filesHandleTrait;
  public $template_data = ['module' => 'file'];

  public function __construct()
  {
    $this->middleware('auth'/*, ['except' => ['index','show']] */);
  }

  public function create(Request $request)
  {
    return view('file::create', ['model' => $request->query('model'), 'model_id' => $request->query('model_id'), 'template_data' => $this->t_d(['template' => 'create']) ]);
  }


  public function store(Request $request){
    $this->validate($request, [
      'files' => 'required',
    ]);

    if(strtolower($request->model) !== "user"){
      $model_elem = 'Modules\\' .$request->model. '\Entities\\'.$request->model;
    }else{
      $model_elem = 'App\User';
    }
    $model_elem = $model_elem::find($request->model_id);

    \App\Traits\filesHandleTrait::storeModelFiles($request->file('files'), $model_elem); // filesHandleTrait

    return redirect()->route(strtolower($request->model).'.show', $request->model_id)->with('success', __('common.file_uploaded'));
  }

  public function destroy(Request $request)
  {
    if(strtolower($request->model) !== "user"){
      $model_elem = 'Modules\\' .$request->model. '\Entities\\'.$request->model;
    }else{
      $model_elem = 'App\User';
    }
    $model_elem = $model_elem::find($request->model_id);

    //\App\Traits\filesHandleTrait::storeModelFiles($request->file('files'), $model_elem); // filesHandleTrait

    $file_item = $model_elem->Files()->find($request->file_id);
    
    if(\File::delete(public_path($file_item->path))){
      $file_item->delete();
      return redirect()->route(strtolower($request->model).'.show', $request->model_id)->with('success', __('common.file_removed'));
    }else{
      return redirect()->route(strtolower($request->model).'.show', $request->model_id)->with('danger', __('common.file_was_not_removed'));
    }
  }

  public function t_d($data)
  {
    return array_merge($this->template_data, $data);
  }
}
