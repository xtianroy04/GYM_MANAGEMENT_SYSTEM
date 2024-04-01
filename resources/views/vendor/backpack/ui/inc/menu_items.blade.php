<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
@auth('backpack')
    @php
        $user = auth()->guard('backpack')->user();
        if($user && strpos($user->capabilities, '') !== false) {
            $capabilities = explode(',', $user->capabilities);
        }
    @endphp

    @isset($capabilities)
        @if(in_array('1', $capabilities))
             <x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')" />
        @endif

        @if(in_array('5', $capabilities))
             <x-backpack::menu-item title="Members" icon="la la-users" :link="backpack_url('member')" />
        @endif

        @if(in_array('3', $capabilities))
             <x-backpack::menu-item title="Payments" icon="la la-money-bill-wave" :link="backpack_url('payment')" />
        @endif
            @if(in_array('4', $capabilities) || in_array('5', $capabilities) || in_array('6', $capabilities) || in_array('7', $capabilities))
                <li class="nav-item dropdown">
                    <a id="navbarDropdownDashboard" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="la la-chart-bar"></i> Reports
                    </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownDashboard">
                    @if(in_array('4', $capabilities))
                        <a class="dropdown-item" href="{{ route('report') }}"> <i class="la la-user-check"></i> Daily Checkins</a>
                    @endif
                    @if(in_array('5', $capabilities))
                        <a class="dropdown-item" href="{{ route('reportMembers') }}"> <i class="la la-users"></i> Members</a>
                    @endif
                    @if(in_array('6', $capabilities))
                        <a class="dropdown-item" href="{{ route('reportsPayments')}}"> <i class="la la-hand-holding"></i> Payments</a>
                    @endif
                    @if(in_array('7', $capabilities))
                        <a class="dropdown-item" href="{{ route('cash')}}"> <i class="la la-money-bill-wave"></i> Cash Flow</a>
                    @endif
                </div>
            </li>
        @endif
    @endisset
@endauth
{{-- <x-backpack::menu-item title="Memberships" icon="la la-id-card" :link="backpack_url('membership')" /> --}}