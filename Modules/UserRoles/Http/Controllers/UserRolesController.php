<?php

namespace Modules\UserRoles\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

use Modules\UserRoles\Entities\UserRoles;

class UserRolesController extends Controller
{
  public $template_data = ['module' => 'userroles'];

  public function __construct()
  {
    // https://spatie.be/docs/laravel-permission/v3/basic-usage/middleware
    $this->middleware(['auth', 'role:admin']);
    app()[PermissionRegistrar::class]->forgetCachedPermissions();
  }

  /**
    * Display a listing of the resource.
    * @return Response
    */
  public function index()
  {
    $roles = Role::with(['permissions'])->get();
    $permissions = Permission::with(['roles'])->get();
    $permissions_pluck = Permission::all()->pluck('name','id');
    //dd($permissions);

    return view('userroles::index', [
      'roles' => $roles,
      'permissions' => $permissions,
      'permissions_pluck' => $permissions_pluck,
      'template_data' => $this->t_d(['template' => 'index'])]);
  }
  
  public function addPermission(Request $request){
    $this->validate($request, [
      'permission' => 'required'
    ]);
    
    Permission::create(['name' => $request->permission]);
    return redirect('userroles/')->with('success', "Permission ".$request->permission." created");
  }

  public function addRole(Request $request){
    $this->validate($request, [
      'role' => 'required'
    ]);
    
    Role::create(['name' => $request->role]);
    return redirect('userroles/')->with('success', "Role ".$request->role." created");
  }

  public function permissionToRole(Request $request){
    $role = Role::find($request->role_id);
    $permission = Permission::find($request->permission);
    $role->givePermissionTo($permission->id);
    return redirect('userroles/')->with('success', "Permission ".$permission->name." granded to role ".$role->name);
  }

  public function removePermission(Request $request){
    $permission = Permission::find($request->permission);
    $permission_name = $permission->name;
    $permission->delete();
    return redirect('userroles/')->with('success', "Role ".$permission_name." removed");
  }

  public function permissionRevokeRole(Request $request){
    $role = Role::find($request->role_id);
    $role->revokePermissionTo($request->permission);
    return redirect('userroles/')->with('success', "Permission ".$request->permission." Revoked from role ".$role->name);
  }

  /**
    * Show the form for creating a new resource.
    * @return Response
    */
  public function create()
  {
    return view('userroles::create', ['template_data' => $this->t_d(['template' => 'create']) ]);
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

    $item = new UserRoles;
    $item->name = $request->input('name');
    $item->description = $request->input('description');
    $item->user_id = auth()->user()->id;
    $item->save();

    return redirect('userroles/')->with('success', __('common.userroles_created'));
  }

  /**
    * Show the specified resource.
    * @param int $id
    * @return Response
    */
  public function show($id)
  {
    $item = UserRoles::find($id);
    return view('userroles::show', ['item' => $item, 'template_data' => $this->t_d(['template' => 'show'])]);
  }

  /**
    * Show the form for editing the specified resource.
    * @param int $id
    * @return Response
    */
  public function edit($id)
  {
    $item = UserRoles::find($id);
    return view('userroles::edit', ['item' => $item, 'template_data' => $this->t_d(['template' => 'edit'])]);
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

    $item = UserRoles::find($id);

    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }

    $item->name = $request->input('name');
    $item->description = $request->input('description');
    $item->save();

    return redirect('userroles/')->with('success', __('common.userroles_updated'));
  }

  /**
    * Remove the specified resource from storage.
    * @param int $id
    * @return Response
    */
  public function destroy($id)
  {
    $item = UserRoles::find($id);
    if(auth()->user()->id !== $item->user_id){
      return redirect()->route('home')->with('error', __('common.Unauthorized'));
    }
    $item->delete();
    return redirect('userroles/')->with('success', __('common.userroles_deleted'));
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
