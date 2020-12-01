<?php

namespace Modules\ModxResource\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\ModxResource\Entities\ModxResource;
use Modules\ModxResource\Entities\UserResourses;

use App\Http\Resources\ApiTransform;
use Illuminate\Support\Facades\DB;

class ModxResourceController extends Controller
{
  public $template_data = ['module' => 'modxresource'];

  private $mic_all = [];

  public function __construct()
  {
    $this->middleware('auth'/*, ['except' => ['index','show']] */);
  }

  public function micGlue($resource){
    if(!empty($resource['children'])){
      foreach($resource['children'] as $k => $coll){
        $resource['children'][$k] = $this->micGlue($coll);
      }
    }
    if(empty($resource['mic'])){
      $resource['mic'] = array_filter($this->mic_all, function($mic) use ($resource){
        return $mic['st_material_id'] == $resource['id'];
      });
    }
    return $resource;
  }

  /**
    * Show the specified resource.
    * @param int $id
    * @return Response
    */
  public function getMaterialTree(Request $request)
  {
    $request = $request->json()->all();
    $data = ModxResource::select(["id"])->with(['children','tv'])->find(18166);
    if(count($request['userPermissions'])){
      $this->mic_all = ModxResource::with(['tv'])->select(["id", "template", "menutitle", "st_city_id", "st_material_id", "st_material_price"])
      ->where("template", 12)
      ->whereIn("st_material_id", array_merge(...$request['userPermissions']))
      ->whereIn("st_city_id", array_keys($request['userPermissions']))
      ->get()->toArray();
      // $ta = [];
      foreach($this->mic_all as $k => $v){
        if(!count($v['tv'])){
          $this->mic_all[$k]['tv'] = [
            ['name' => 'phone', 'value' => ''],
            ['name' => 'email', 'value' => '']
          ];
        }
      }

     // return response()->json($ta);
      //return response()->json($this->mic_all);
      $data = $this->micGlue($data->toArray());
    }
    

    if(\Request::is('api/*')){
      return new ApiTransform($data['children']);
    }
  }

  public function getCityList(Request $request){
    $request = $request->json()->all();
    $fields = ["id", "alias", "template", "menutitle", "pagetitle"];
    if(!empty($request['city_ids'])){
      $data = ModxResource::where("template", 9)
      ->whereIn("id", $request['city_ids'])
      ->select($fields)->get();
    }else{
      $data = ModxResource::where("template", 9)
      ->select($fields)->get();
    }
    if(\Request::is('api/*')){
      return new ApiTransform($data);
    }
  }

  public function userPermissionGet(Request $request){
    $user_id = $this->get_user_id($request);
    $UserResourses = UserResourses::where(["user_id" => $user_id])->orderBy('material_id')->get();
    $data_to_return = [];
    foreach($UserResourses as $item){
      $city_id = intval($item['city_id']);
      if(empty($data_to_return[$city_id])){
        $data_to_return[$city_id] = [];
      }
      $data_to_return[$city_id][] = intval($item['material_id']);
    }
    if(\Request::is('api/*')){
      return json_encode($data_to_return);
    }
  }

  public function userPermissionUpdate(Request $request){
    $user_id = $this->get_user_id($request);
    $data = $request->json()->all();
    $UserResourses = UserResourses::where(["user_id" => $user_id, "city_id" => $data['city_id']])->delete();

    $data_to_insert = [];
    foreach($data['materials'] as $m){
      $data_to_insert[] = [
        'user_id' => $data['user_id'],
        'city_id' => $data['city_id'],
        'material_id' => $m,
      ];
    }
    $result = UserResourses::insert($data_to_insert);
    return $this->userPermissionGet($request);
  }

  public function clearModxCache(){
    \File::deleteDirectory($_SERVER['DOCUMENT_ROOT'].'/../ccoorree/cache/aa_set_paceholders');
    // if (is_dir($dir)) {
    //   $objects = scandir($dir);
    //   foreach ($objects as $object) {
    //     if ($object != "." && $object != "..") {
    //       if (filetype($dir . "/" . $object) == "dir") {
    //         $this->clearModxCache($dir . "/" . $object);
    //       } else {
    //         unlink($dir . "/" . $object);
    //       }
    //     }
    //   }
    //   reset($objects);
    //   rmdir($dir);
    // }
  }

  public function updateField(Request $request)
  {
    $data = $request->json()->all();
    // Переписать на валидатор нормальный
    if(empty($data['city_id'])){
      return response()->json(['message' => 'Не указан город'], 422);
    }
    if(empty($data['material_ids'])){
      return response()->json(['message' => 'Не указан материал'], 422);
    }
    $user_id = $this->get_user_id($request);
    $UserResourses = UserResourses::select(['city_id','material_id'])
    ->where(["user_id" => $user_id, "city_id" => $data['city_id']])
    ->whereIn("material_id", $data['material_ids'])
    ->get()->pluck("city_id", "material_id");

    foreach($data['material_ids'] as $mk => $material_id){
      $validate = false;
      foreach($UserResourses as $m_id => $c_id){
        if($material_id === $m_id && $data['city_id'] === $c_id){
          $validate = true;
          break;
        }
      }
      if(!$validate){
        unset($data['material_ids'][$mk]);
      }
    }


    if(!empty($data['city_id']) && count($data['material_ids'])){
      switch($data['type']){
        case "phone":
          //DB::enableQueryLog();
          $affected = DB::table('quzat_site_tmplvar_contentvalues')
          ->where("tmplvarid", 26)
          ->whereIn("contentid", function ($query) use ($data) {
            $query->select("id")
            ->from('quzat_site_content')
            ->where("st_city_id", $data['city_id'])
            ->whereIn("st_material_id", $data['material_ids']);
          })
          ->update(['value' => $data['value']]);
          //var_dump($result);
          //print_r(DB::getQueryLog());
          //return;
        break;
        case "email":
          $affected = DB::table('quzat_site_tmplvar_contentvalues')
          ->where("tmplvarid", 27)
          ->whereIn("contentid", function ($query) use ($data) {
            $query->select("id")
            ->from('quzat_site_content')
            ->where("st_city_id", $data['city_id'])
            ->whereIn("st_material_id", $data['material_ids']);
          })
          ->update(['value' => $data['value']]);
        break;
        case "material_price":
          $affected = DB::table('quzat_site_tmplvar_contentvalues')
          ->where("tmplvarid", 29)
          ->whereIn("contentid", function ($query) use ($data) {
            $query->select("id")
            ->from('quzat_site_content')
            ->where("st_city_id", $data['city_id'])
            ->whereIn("st_material_id", $data['material_ids']);
          })
          ->update(['value' => $data['value']]);
  
          $affected = DB::table('quzat_site_content')
          ->where("template", 12)
          ->where("st_city_id", $data['city_id'])
          ->whereIn("st_material_id", $data['material_ids'])
          ->update(['st_material_price' => $data['value']]);
        break;
      }
      $this->clearModxCache();
    }else{
      return response()->json(['message' => 'Указанные материалы были отклонены, т.к. не доступны для данного пользователя'], 422);
    }
    if(\Request::is('api/*')){
      return new ApiTransform(array_merge($request->json()->all(), ['affected' => $affected]));
    }
  }

  public function index(){
    return view('modxresource::index');
  }

  public function show($id)
  {
    //$data = ModxResource::with(['tv','children'])->find($id);
    //$data = $data->children;
    return view('modxresource::show');
  }
  
  public function get_user_id($request){
    if(auth()->user()->hasRole('admin')){
      if(empty($request->user_id)){
        $data = $request->json()->all();
        $user_id = $data['user_id'];
      }else{
        $user_id = $request->user_id;
      }
    }else{
      $user_id = auth()->user()->id;
    }
    return $user_id;
  }
  /*
  public function cityFilter($resource, Array $city_ids){
    if(!empty($resource['children'])){
      foreach($resource['children'] as $k => $coll){
        $resource['children'][$k] = $this->cityFilter($coll, $city_ids);
      }
    }
    if(!empty($resource['mic'])){
      foreach($resource['mic'] as $k => $v){
        if(!in_array(intval($v['st_city_id']), $city_ids)){
          unset($resource['mic'][$k]);
        }
      }
    }
    return $resource;
  }
  */
}
