
@inject('SideMenu', 'App\Services\SideMenuService')
{{-- inject выполнен без активации провайдера --}}
<ul class="list-group">
  @hasanyrole('admin')
  <li class="list-group-item d-flex align-items-center">
    <a href="{{ route('user.index') }}">{{ __('common.user_title') }}</a>
  </li>
  @endhasanyrole
  @hasanyrole('page_renter|admin')
  <li class="list-group-item d-flex align-items-center">
    <a href="/fastedit/user_price/{{auth()->user()->id}}">Редактировать контакты и цены</a>
  </li>
  @endhasanyrole
  @hasanyrole('agent|admin|office_manager')
  <li class="list-group-item d-flex align-items-center">
    <a href="{{ route('buyer.index') }}" class="mr-auto">{{ __('common.buyer_title') }}</a>
    <a href="{{ route('buyer.create') }}" class="btn btn-sm btn-primary text-nowrap">+ {{-- __('common.create') --}}</a>
  </li>
  {{$SideMenu->getSubItems("buyer")}}
  <li class="list-group-item d-flex align-items-center">
    <a href="{{ route('seller.index') }}" class="mr-auto">{{ __('common.seller_title') }}</a>
    <a href="{{ route('seller.create') }}" class="btn btn-sm btn-primary text-nowrap">+ {{-- __('common.create') --}}</a>
  </li>
  {{$SideMenu->getSubItems("seller")}}
  <li class="list-group-item d-flex align-items-center">
    <a href="{{ route('materialsklad.index') }}" class="mr-auto">{{ __('common.materialsklad_title') }}</a>
    <a href="{{ route('materialsklad.create') }}" class="btn btn-sm btn-primary text-nowrap">+ {{-- __('common.create') --}}</a>
  </li>
  {{$SideMenu->getSubItems("materialsklad")}}
  <li class="list-group-item d-flex align-items-center">
    <a href="{{ route('materialrezerv.index') }}" class="mr-auto">{{ __('common.materialrezerv_title') }}</a>
    <a href="{{ route('materialrezerv.create') }}" class="btn btn-sm btn-primary text-nowrap">+ {{-- __('common.create') --}}</a>
  </li>
  {{$SideMenu->getSubItems("materialrezerv")}}
  <li class="list-group-item d-flex align-items-center">
    <a href="{{ route('punktpriem.index') }}" class="mr-auto">{{ __('common.punktpriem_title') }}</a>
    <a href="{{ route('punktpriem.create') }}" class="btn btn-sm btn-primary text-nowrap">+ {{-- __('common.create') --}}</a>
  </li>
  {{$SideMenu->getSubItems("punktpriem")}}
  <li class="list-group-item d-flex align-items-center">
    <a href="{{ route('deal.index') }}" class="mr-auto">{{ __('common.deal_title') }}</a>
    <a href="{{ route('deal.create') }}" class="btn btn-sm btn-primary text-nowrap">+ {{-- __('common.create') --}}</a>
  </li>
  {{$SideMenu->getSubItems("deal")}}
  @else
    Ваша учетная запись ожидает подтверждения
  @endhasanyrole
</ul>
