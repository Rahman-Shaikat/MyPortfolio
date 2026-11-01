<div>
    <button type="button" class="nav-link w-100 border-0 bg-transparent text-start {{ request()->routeIs('admin.habit-tracker.*') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#{{ $menuId }}" aria-controls="{{ $menuId }}" aria-expanded="{{ request()->routeIs('admin.habit-tracker.*') ? 'true' : 'false' }}">
        <span class="nav-icon"><i class="ti ti-calendar-check fs-5" aria-hidden="true"></i></span>
        <span class="text">Habit Tracker</span>
        <i class="ti ti-chevron-down ms-auto" aria-hidden="true"></i>
    </button>
    <ul id="{{ $menuId }}" class="collapse list-unstyled ps-4 {{ request()->routeIs('admin.habit-tracker.*') ? 'show' : '' }}">
        <li><a class="nav-link {{ request()->routeIs('admin.habit-tracker.edit') ? 'active' : '' }}" href="{{ route('admin.habit-tracker.edit') }}" @if(request()->routeIs('admin.habit-tracker.edit')) aria-current="page" @endif><span class="text">Page Info</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('admin.habit-tracker.orders.*') ? 'active' : '' }}" href="{{ route('admin.habit-tracker.orders.index') }}" @if(request()->routeIs('admin.habit-tracker.orders.*')) aria-current="page" @endif><span class="text">Orders</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('admin.habit-tracker.payments.*') ? 'active' : '' }}" href="{{ route('admin.habit-tracker.payments.edit') }}" @if(request()->routeIs('admin.habit-tracker.payments.*')) aria-current="page" @endif><span class="text">Payment Settings</span></a></li>
    </ul>
</div>
