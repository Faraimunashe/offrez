<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @if (Auth::user()->hasRole('admin'))
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('dashboard')}}">
                    <i class="bi bi-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('students.index') }}">
                    <i class="bi bi-people"></i>
                    <span>Students</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('instructors.index') }}">
                    <i class="bi bi-person"></i>
                    <span>Instructors</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('vehicles.index') }}">
                    <i class="bi bi-truck"></i>
                    <span>Vehicles</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('bookings.index') }}">
                    <i class="bi bi-file-earmark-font"></i>
                    <span>Bookings</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('questions.index') }}">
                    <i class="bi bi-file-earmark-medical"></i>
                    <span>Questions</span>
                </a>
            </li>
        @elseif (Auth::user()->hasRole('landlord'))
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('dashboard')}}">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('houses.index')}}">
                    <i class="bi bi-house"></i>
                    <span>Houses</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('landlord-transactions')}}">
                    <i class="bi bi-list-ul"></i>
                    <span>Transactions</span>
                </a>
            </li>
        @elseif (Auth::user()->hasRole('student'))
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('dashboard')}}">
                    <i class="bi bi-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('bookings.index')}}">
                    <i class="bi bi-file-break"></i>
                    <span>Bookings</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('transactions.index')}}">
                    <i class="bi bi-list-ul"></i>
                    <span>Transactions</span>
                </a>
            </li>

        @endif
        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
            <a class="nav-link collapsed" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="bi bi-lock"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>

</aside><!-- End Sidebar-->
