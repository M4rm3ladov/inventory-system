<nav class="navbar navbar-light bg-dark d-flex justify-content-end sticky-top">
    <span class="fs-10 me-auto text-white">{{ Auth::user()->branch->name }}</span>
    <div class="btn-group">
        <a class="btn border-none outline-none dropdown-toggle text-white" href="#" id="userdropdownMenuLink"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user"></i>
            <span
                class="ms-2">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }} ({{ Auth::user()->role->name  }})
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdownMenuLink">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item logout" href="">Logout</button>
            </form>
        </div>
    </div>
</nav>
