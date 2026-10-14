<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">

                <div class="navbar-brand-box horizontal-logo">
                    <a href="" class="logo logo-dark">
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="" height="80">
                        </span>
                    </a>
                </div>

            </div>

            <div class="d-flex align-items-center">

                @guest
                    <div class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                        Guest User
                    </div>
                @else
                    @php
                        $session = auth()->user()->id;
                        $role = App\Models\User::select('users.id', 'roles.name')
                            ->where('users.id', $session)
                            ->join('roles', 'users.role_id', '=', 'roles.id')
                            ->first();
                    @endphp

                    @if ($role->name === 'Guest')
                        <div class="dropdown ms-sm-3 header-item topbar-user">
                          
                        </div>
                    @endif
                @endguest

            </div>
        </div>
    </div>
</header>

