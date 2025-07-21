<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1e40af; color: white">
    <a class="navbar-brand" href="#">
        <img src="{{asset('assets/images/LOGO_SVG.svg')}}" width="120" height="30" class="d-inline-block align-top" alt="Book Builder Logo">
    </a>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <!-- <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About Us</a>
            </li> -->
        </ul>

        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Stories
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{url('/gratitude-story')}}">Gratitude</a>
                    <a class="dropdown-item" href="{{route('/romance-story')}}">Romancing Your Customers</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{auth()->user()->name}}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{url('/logout')}}">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
