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
    $data = ModxResource::select(["id"])->with(['children','tv'])->find(18166);
    if(count($request['userPermissions'])){
      $this->mic_all = ModxResource::with(['tv'])->select(["id", "template", "menutitle", "st_city_id", "st_material_id", "st_material_price"])
      ->where("template", 12)
      ->whereIn("st_material_id", array_merge(...$request['userPermissions']))
      ->whereIn("st_city_id", array_keys($request['userPermissions']))
      ->get()->toArray();
      foreach($this->mic_all as $k => $v){
        if(!count($v['tv'])){
          $this->mic_all[$k]['tv'] = [
            ['name' => 'phone', 'value' => ''],
            ['name' => 'email', 'value' => '']
          ];
        }
      }
      $data = $this->micGlue($data->toArray());
    }
    

    if(\Request::is('api/*')){
      return new ApiTransform($data['children']);
    }
  }

  public function getCityList(Request $request){
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

  public function getUnicIdForUserResourses($request){
    $this->validate($request,
      [
        'id' => 'required',
        'route_name' => 'required',
      ],
      [
        'id.required' => 'Не указан id',
        'route_name.required' => 'Не указан route_name',
      ]
    );

    // Сгенерировать уникальный идентификатор: user = 1000000; punktpriem = 2000000
    switch($request['route_name']){
      case 'FastEdit':
      case 'FastEditUserPrice':
      case 'FastEditUserPermission':
        $unic_id = 1000000 + $request['id'];
      break;
      case 'FastEditPunktPriemPermission':
        $unic_id = 2000000 + $request['id'];
      break;
    }
    return $unic_id;
  }

  public function userPermissionGet(Request $request){
    $unic_id = $this->getUnicIdForUserResourses($request);

    $UserResourses = UserResourses::where(["unic_id" => $unic_id])->orderBy('material_id')->get();
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
    return $data_to_return;
  }

  public function userPermissionUpdate(Request $request){
    //$user_id = $this->get_user_id($request);
    $unic_id = $this->getUnicIdForUserResourses($request);
    $UserResourses = UserResourses::where(["unic_id" => $unic_id, "city_id" => $request['city_id']])->delete();

    $data_to_insert = [];
    foreach($request['materials'] as $m){
      $data_to_insert[] = [
        'unic_id' => $unic_id,
        'city_id' => $request['city_id'],
        'material_id' => $m,
      ];
    }
    $result = UserResourses::insert($data_to_insert);
    return $this->userPermissionGet($request);
  }

  public function clearModxCache(){
    \File::deleteDirectory('/home/h901102646/scraptraffic.com/ccoorree/cache');
    // \File::deleteDirectory($_SERVER['DOCUMENT_ROOT'].'/../ccoorree/cache/aa_set_paceholders');
  }

  public function updateField(Request $request)
  {
    // Переписать на валидатор нормальный
    if(empty($request['city_id'])){
      return response()->json(['message' => 'Не указан город'], 422);
    }
    if(empty($request['material_ids'])){
      return response()->json(['message' => 'Не указан материал'], 422);
    }
    $unic_id = $this->getUnicIdForUserResourses($request);
    //$user_id = $this->get_user_id($request);
    
    $UserResourses = UserResourses::select(['city_id','material_id'])
    ->where(["unic_id" => $unic_id, "city_id" => $request['city_id']])
    ->whereIn("material_id", $request['material_ids'])
    ->get()->pluck("city_id", "material_id");

    foreach($request['material_ids'] as $mk => $material_id){
      $validate = false;
      foreach($UserResourses as $m_id => $c_id){
        if($material_id === $m_id && $request['city_id'] === $c_id){
          $validate = true;
          break;
        }
      }
      if(!$validate){
        unset($request['material_ids'][$mk]);
      }
    }

    $tmplvarids = [
      'phone' => 26,
      'email' => 27,
      'material_price' => 29,
    ];

    if(!empty($request['city_id']) && count($request['material_ids']) && !empty($tmplvarids[ $request['type'] ])){

      foreach($request['material_ids'] as $material_id){
        $contentid = DB::table('quzat_site_content')
        ->where("st_city_id", $request['city_id'])
        ->where("st_material_id", $material_id)
        ->pluck('id');

        $contentid = $contentid[0];
        // var_dump($contentid);
        // die;
        //DB::enableQueryLog();
        $query = DB::table('quzat_site_tmplvar_contentvalues')
        ->updateOrInsert(
          [ 'tmplvarid' => $tmplvarids[ $request['type'] ],
            'contentid' => $contentid
          ],
          [ 'value' => $request['value'] ]
        );
        //print_r(DB::getQueryLog());
        //print_r($query);
        //die;
      }

      if($request['type'] == 'material_price'){
        DB::table('quzat_site_content')
        ->where("template", 12)
        ->where("st_city_id", $request['city_id'])
        ->whereIn("st_material_id", $request['material_ids'])
        ->update(['st_material_price' => $request['value']]);
      }
      $this->clearModxCache();
    }else{
      return response()->json(['message' => 'Указанные материалы были отклонены, т.к. не доступны для данного пользователя'], 422);
    }
    if(\Request::is('api/*')){
      return new ApiTransform(array_merge($request->all(), []));
    }
  }

  public function index(){
    return view('modxresource::index');
  }

  public function show(Request $request)
  {
    //dd($this->userPermissionGet($request));
    return view('modxresource::show');
  }
  
  public function get_user_id($request){
    if(empty($request->user_id)){
      $data = $request->json()->all();
      $user_id = $data['user_id'];
    }else{
      $user_id = $request->user_id;
    }

    if(!auth()->user()->hasRole('admin') && $user_id != auth()->user()->id){
      return 0;
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
