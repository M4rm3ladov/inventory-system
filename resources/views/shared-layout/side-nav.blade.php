<div class="bg-dark col-12 col-sm-12 col-md-2 bg-dark">
    <div class="mt-4 position-fixed" style="width: 15%">
        <a href="" class="text-center text-white text-decoration-none" role="button">
            <h1 class="fs-5 fw-bold">{{ config('app.title') }}</h1>
        </a>
        <ul class="nav nav-pills flex-column mt-2" id="menu">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link text-white" aria-current="page" href="#">
                    <i class="fa fa-gauge"></i>
                    <span class="ms-2">Dashboard</span>
                </a>
            </li>
            @can('admin')
                <li class="nav-item ">
                    <a href="#productmenu" data-bs-toggle="collapse" class="nav-link text-white" aria-controls="productmenu"
                        aria-current="page" role="button">
                        <i class="fa fa-box"></i>
                        <span class="ms-2">Product</span>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="nav collapse collapse-horizontal ms-1 flex-column" id="productmenu" data-bs-parent="#menu">
                        <li class="nav-item">
                            <a href="{{ route('items') }}" class="nav-link text-white" aria-current="page">
                                <i class="fa fa-cart-shopping"></i>
                                <span class="ms-2">Item</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('items.categories') }}" class="nav-link text-white" aria-current="page">
                                <i class="fa fa-network-wired"></i>
                                <span class="ms-2">Category</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('items.brands') }}" class="nav-link text-white" aria-current="page">
                                <i class="fa fa-tag"></i>
                                <span class="ms-2">Brand</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('items.units') }}" class="nav-link text-white" aria-current="page">
                                <i class="fa fa-scale-balanced"></i>
                                <span class="ms-2">Unit</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#servicemenu" data-bs-toggle="collapse" class="nav-link text-white" aria-controls="servicemenu"
                        aria-current="page" role="button">
                        <i class="fa fa-toolbox"></i>
                        <span class="ms-2">Service</span>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="nav collapse collapse-horizontal ms-1 flex-column" id="servicemenu" data-bs-parent="#menu">
                        <li class="nav-item">
                            <a href="{{ route('services') }}" class="nav-link text-white" aria-current="page">
                                <i class="fa fa-wrench"></i>
                                <span class="ms-2">Item</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('services.categories') }}" class="nav-link text-white" aria-current="page">
                                <i class="fa fa-network-wired"></i>
                                <span class="ms-2">Category</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('branches') }}" class="nav-link text-white" aria-current="page">
                        <i class="fa fa-building"></i>
                        <span class="ms-2">Branch</span>
                    </a>
                </li>
                <li class="nav-item text-white">
                    <a href="{{ route('suppliers') }}" class="nav-link text-white" aria-current="page">
                        <i class="fa fa-truck"></i>
                        <span class="ms-2">Supplier</span>
                    </a>
                </li>
            @endcan
            @can('manager')
                <li class="nav-item text-white">
                    <a href="#product-stock" data-bs-toggle="collapse" class="nav-link text-white" aria-current="page">
                        <i class="fa fa-warehouse"></i>
                        <span class="ms-2">Product Stock</span>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="nav collapse collapse-horizontal ms-1 flex-column" id="product-stock"
                        data-bs-parent="#menu">
                        <li class="nav-item">
                            <a href="{{ route('inventories') }}" class="nav-link text-white" aria-current="page">
                                <i class="fa fa-dolly"></i>
                                <span class="m-2">Stock On Hand</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stock-in') }}" class="nav-link text-white" aria-current="page">
                                <i class="fa fa-dolly"></i>
                                <span class="m-2">Stock In</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stock-return') }}" class="nav-link text-white" aria-current="page">
                                <i class="fa fa-truck-ramp-box"></i>
                                <span class="ms-2">Stock Return</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stock-transfer') }}" class="nav-link text-white" aria-current="page">
                                <i class="fa fa-people-carry-box"></i>
                                <span class="ms-2">Stock Transfer</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stock-out') }}" class="nav-link text-white" aria-current="page">
                                <i class="fa fa-dumpster"></i>
                                <span class="ms-2">Stock Out</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stock-count') }}" class="nav-link text-white" aria-current="page">
                                <i class="fa fa-clipboard-list"></i>
                                <span class="ms-2">Stock Adjustment</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('admin')
                <li class="nav-item text-white">
                    <a class="nav-link text-white" aria-current="page" href="{{ route('users') }}">
                        <i class="fa fa-id-card"></i>
                        <span class="ms-2">System Users</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</div>
