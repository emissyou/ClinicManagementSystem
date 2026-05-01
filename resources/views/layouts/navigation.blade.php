<div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white">
    <a href="{{ route('dashboard') }}" class="d-flex align-items-center mb-4 text-white text-decoration-none">
        <span class="fs-4 fw-bold">Dashboard</span>
    </a>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('patients.index') }}"
               class="nav-link text-white {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                Patients
            </a>
        </li>

        <li>
            <a href="{{ route('doctors.index') }}"
               class="nav-link text-white {{ request()->routeIs('doctors.*') ? 'active' : '' }}">
                Doctors
            </a>
        </li>

        <li>
            <a href="{{ route('appointments.index') }}"
               class="nav-link text-white {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                Appointments
            </a>
        </li>

        <li>
            <a href="{{ route('billing.index') }}"
               class="nav-link text-white {{ request()->routeIs('billing.*') ? 'active' : '' }}">
                Billing
            </a>
        </li>

        <li>
            <a href="{{ route('calendar.index') }}"
               class="nav-link text-white {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                Calendar
            </a>
        </li>
    </ul>

    <hr class="text-white">

    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
           data-bs-toggle="dropdown" aria-expanded="false">
            <strong>{{ Auth::user()->name }}</strong>
        </a>

        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                    Log Out
                </a>
            </li>
        </ul>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>