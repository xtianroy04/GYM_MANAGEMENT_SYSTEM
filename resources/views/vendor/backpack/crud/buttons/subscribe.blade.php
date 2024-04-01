@if(auth('backpack')->user() && in_array(2, explode(',', auth('backpack')->user()->capabilities)))
  @if ($crud->hasAccess('subscribe'))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/subscribe') }}" class="btn btn-sm btn-link"><i class="la la-money-bill-wave"></i> Payments</a>
  @endif
@endif
