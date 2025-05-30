<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-futbol"></i>VISCA BARCA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}"><i
                            class=""></i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('map') }}">Map</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('table') }}">Table</a>
                </li>
                @auth


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Data
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('api.points') }}" target="_blank"> <i
                                        class="fa-solid fa-location-dot"></i> Points</a></li>
                            <li><a class="dropdown-item" href="{{ route('api.polylines') }}" target="_blank"> <i
                                        class="fa-solid fa-lines-leaning"></i> Polylines</a></li>
                            <li><a class="dropdown-item" href="{{ route('api.polygons') }}" target="_blank"> <i
                                        class="fa-solid fa-draw-polygon"></i> Polygons</a></li>
                        </ul>
                    </li>
                </ul>
            @endauth
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="nav-link text-danger btn btn-link" type="submit">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </button>
                        </form>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="{{ route('login') }}">
                            <i class="fa-solid fa-right-from-bracket"></i> Login
                        </a>
                    </li>
                @endguest
            </ul>

        </div>
    </div>
</nav>
