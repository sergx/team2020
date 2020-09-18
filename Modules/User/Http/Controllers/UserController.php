<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


use App\User;



class UserController extends Controller
{

  public $template_data = ['module' => 'user'];
  /**
    * Display a listing of the resource.
    * @return Response
    */
  public function index()
  {

    $roles = Role::all();
    $items = User::with(['roles'])->paginate(10);
    //dd(auth()->user());
    return view('user::index', ['items' => $items, 'roles' => $roles, 'template_data' => $this->t_d(['template' => 'index'])]);
  }

  public function roleUpdate(Request $request)
  {
    $user = User::find($request['user_id']);
    $role = Role::find($request['role_id']);
    if(!$user->hasRole([$role->name])){
      $user->assignRole($role);
      return redirect('user/')->with('success', "Пользователю ".$user->name." присвоена роль ".__('common.role_'.$role->name));
    }else{
      $user->removeRole($role);
      return redirect('user/')->with('success', "Пользователю ".$user->name." отменена роль ".__('common.role_'.$role->name));
    }
  }

  /**
    * Show the form for creating a new resource.
    * @return Response
    */
  public function create()
  {
    return view('user::create');
  }

  /**
    * Store a newly created resource in storage.
    * @param Request $request
    * @return Response
    */
  public function store(Request $request)
  {
    //
  }

  /**
    * Show the specified resource.
    * @param int $id
    * @return Response
    */
  public function show($id)
  {
    $item = User::with(['PersonContacts', 'Files', 'roles'])->find($id);
    //dd($item);
    return view('user::show', ['item' => $item, 'template_data' => $this->t_d(['template' => 'index'])]);
  }

  /**
    * Show the form for editing the specified resource.
    * @param int $id
    * @return Response
    */
  public function edit($id)
  {
    return view('user::edit');
  }

  /**
    * Update the specified resource in storage.
    * @param Request $request
    * @param int $id
    * @return Response
    */
  public function update(Request $request, $id)
  {
    //
  }

  /**
    * Remove the specified resource from storage.
    * @param int $id
    * @return Response
    */
  public function destroy($id)
  {
    //
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
