<div class="bg-dark col-auto bg-dark min-vh-100">
    <div class="mt-4">
        <a href="" class="fs-4 text-white text-decoration-none fw-bold" role="button">{{ config('app.title') }}</a>
        <hr class="text-white">
        <ul class="nav nav-pills flex-column mt-2" id="menu">
            <li class="nav-item">
                <a class="nav-link text-white" aria-current="page" href="#">
                    <i class="fa fa-gauge"></i>
                    <span class="ms-2">Dashboard</span>
                </a>
            </li>
            <li class="nav-item ">
                <a href="#sidemenu" data-bs-toggle="collapse" class="nav-link text-white" aria-controls="sidemenu"
                    aria-current="page" role="button">
                    <i class="fa fa-box"></i>
                    <span class="ms-2">Product</span>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="nav collapse collapse-horizontal ms-1 flex-column" id="sidemenu" data-bs-parent="#menu">
                    <li class="nav-item">
                        <a href="" class="nav-link text-white" aria-current="page">
                            <i class="fa fa-cart-shopping"></i>
                            <span class="ms-2">Item</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-white" aria-current="page">
                            <i class="fa fa-network-wired"></i>
                            <span class="ms-2">Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-white" aria-current="page">
                            <i class="fa fa-tag"></i>
                            <span class="ms-2">Brand</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-white" aria-current="page">
                            <i class="fa fa-scale-balanced"></i>
                            <span class="ms-2">Unit</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" aria-current="page" href="#">
                    <i class="fa fa-toolbox"></i>
                    <span class="ms-2">Service</span>
                </a>
            </li>
            <li class="nav-item">
            <li class="nav-item">
                <a class="nav-link text-white" aria-current="page" href="#">
                    <i class="fa fa-building"></i>
                    <span class="ms-2">Branch</span>
                </a>
            </li>
            </li>
            <li class="nav-item text-white">
                <a class="nav-link text-white" aria-current="page" href="#">
                    <i class="fa fa-truck"></i>
                    <span class="ms-2">Supplier</span>
                </a>
            </li>
            <li class="nav-item text-white">
                <a href="#product-stock" data-bs-toggle="collapse" class="nav-link text-white" aria-current="page">
                    <i class="fa fa-warehouse"></i>
                    <span class="ms-2">Product Stock</span>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="nav collapse collapse-horizontal ms-1 flex-column" id="product-stock" data-bs-parent="#menu">
                    <li class="nav-item">
                        <a href="" class="nav-link text-white" aria-current="page">
                            <i class="fa fa-dolly"></i>
                            <span class="m-2">Stock In</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-white" aria-current="page">
                            <i class="fa fa-truck-ramp-box"></i>
                            <span class="ms-2">Stock Return</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-white" aria-current="page">
                            <i class="fa fa-people-carry-box"></i>
                            <span class="ms-2">Stock Transfer</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-white" aria-current="page">
                            <i class="fa fa-dumpster"></i>
                            <span class="ms-2">Stock Out</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-white" aria-current="page">
                            <i class="fa fa-clipboard-list"></i>
                            <span class="ms-2">Stock Adjustment</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item text-white">
                <a class="nav-link text-white" aria-current="page" href="#">
                    <i class="fa fa-id-card"></i>
                    <span class="ms-2">System Users</span>
                </a>
            </li>
        </ul>
    </div>
</div>
