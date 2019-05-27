
    @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
        @include('new.layouts.admin_sidebar')
    @else
        @include('new.layouts.user_sidebar')
    @endif