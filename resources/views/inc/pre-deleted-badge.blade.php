@if(!empty($item->pre_deleted) && auth()->user()->hasAnyPermission(['delete any '.$template_data['module'],'pre_delete any '.$template_data['module']]))
<span class="badge badge-warning">pre deleted</span>
@endif
