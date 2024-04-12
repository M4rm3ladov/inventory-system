<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css">
    <title>Inventory Management System</title>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            {{-- side navigation --}}
            <div class="bg-dark col-auto bg-dark min-vh-100">
                <div class="mt-4">
                    <a href="" class="fs-4 text-white text-decoration-none fw-bold" role="button">Inventory
                        System</a>
                    <hr class="text-white">
                    <ul class="nav nav-pills flex-column mt-2" id="menu">
                        <li class="nav-item">
                            <a class="nav-link text-white" aria-current="page" href="#">
                                <i class="fa fa-gauge"></i>
                                <span class="ms-2">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="#sidemenu" data-bs-toggle="collapse" class="nav-link text-white"
                                aria-controls="sidemenu" aria-current="page" role="button">
                                <i class="fa fa-box"></i>
                                <span class="ms-2">Product</span>
                                <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="nav collapse collapse-horizontal ms-1 flex-column" id="sidemenu"
                                data-bs-parent="#menu">
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
                                <span class="ms-2">Services</span>
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
                            <a href="#product-stock" data-bs-toggle="collapse" class="nav-link text-white"
                                aria-current="page">
                                <i class="fa fa-warehouse"></i>
                                <span class="ms-2">Product Stock</span>
                                <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="nav collapse collapse-horizontal ms-1 flex-column" id="product-stock"
                                data-bs-parent="#menu">
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
            {{-- content column --}}
            <div class="col no-gutters">
                {{-- nav & current account  --}}
                <nav class="navbar navbar-light bg-dark d-flex justify-content-end">
                    <div class="btn-group">
                        <a class="btn border-none outline-none dropdown-toggle text-white" href="#"
                            id="userdropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-user"></i>
                            <span class="ms-2">admin</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdownMenuLink">
                            <a class="dropdown-item" href="#">Profile</a>
                            <a class="dropdown-item logout" href="#">Logout</a>
                        </div>
                    </div>
                </nav>
                {{-- dashboard cards --}}
                <div class="container-fluid pt-3">
                    <div class="row row-cols-1 row-cols-md-5 g-3">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h1 class="card-title">0</h5>
                                            <p class="card-text">Item</p>
                                        </div>
                                        <i class="fa fa-cart-shopping fa-4x"></i>
                                    </div>        
                                </div>
                                <div class="card-footer text-center">
                                    <a class="text-decoration-none" href="">More Info</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h1 class="card-title">0</h5>
                                            <p class="card-text">Service</p>
                                        </div>
                                        <i class="fa fa-toolbox fa-4x"></i>
                                    </div>        
                                </div>
                                <div class="card-footer text-center">
                                    <a class="text-decoration-none" href="">More Info</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h1 class="card-title">0</h5>
                                            <p class="card-text">Category</p>
                                        </div>
                                        <i class="fa fa-network-wired fa-4x"></i>
                                    </div>        
                                </div>
                                <div class="card-footer text-center">
                                    <a class="text-decoration-none" href="">More Info</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h1 class="card-title">0</h5>
                                            <p class="card-text">Brand</p>
                                        </div>
                                        <i class="fa fa-tag fa-4x"></i>
                                    </div>        
                                </div>
                                <div class="card-footer text-center">
                                    <a class="text-decoration-none" href="">More Info</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h1 class="card-title">0</h5>
                                            <p class="card-text">Branch</p>
                                        </div>
                                        <i class="fa fa-building fa-4x"></i>
                                    </div>        
                                </div>
                                <div class="card-footer text-center">
                                    <a class="text-decoration-none" href="">More Info</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h1 class="card-title">0</h5>
                                            <p class="card-text">Supplier</p>
                                        </div>
                                        <i class="fa fa-truck fa-4x"></i>
                                    </div>        
                                </div>
                                <div class="card-footer text-center">
                                    <a class="text-decoration-none" href="">More Info</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h1 class="card-title">0</h5>
                                            <p class="card-text">Stock Purchased</p>
                                        </div>
                                        <i class="fa fa-dolly fa-4x"></i>
                                    </div>        
                                </div>
                                <div class="card-footer text-center">
                                    <a class="text-decoration-none" href="">More Info</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h1 class="card-title">0</h5>
                                            <p class="card-text">Stock Returned</p>
                                        </div>
                                        <i class="fa fa-truck-ramp-box fa-4x"></i>
                                    </div>        
                                </div>
                                <div class="card-footer text-center">
                                    <a class="text-decoration-none" href="">More Info</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h1 class="card-title">0</h5>
                                            <p class="card-text">Stock Transfered</p>
                                        </div>
                                        <i class="fa fa-people-carry-box fa-4x"></i>
                                    </div>        
                                </div>
                                <div class="card-footer text-center">
                                    <a class="text-decoration-none" href="">More Info</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h1 class="card-title">0</h5>
                                            <p class="card-text">Stock Disposed</p>
                                        </div>
                                        <i class="fa fa-dumpster fa-4x"></i>
                                    </div>        
                                </div>
                                <div class="card-footer text-center">
                                    <a class="text-decoration-none" href="">More Info</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h1 class="card-title">0</h5>
                                            <p class="card-text">Stock Adjusted</p>
                                        </div>
                                        <i class="fa fa-clipboard-list fa-4x"></i>
                                    </div>        
                                </div>
                                <div class="card-footer text-center">
                                    <a class="text-decoration-none" href="">More Info</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h1 class="card-title">0</h5>
                                            <p class="card-text">System Users</p>
                                        </div>
                                        <i class="fa fa-id-card fa-4x"></i>
                                    </div>        
                                </div>
                                <div class="card-footer text-center">
                                    <a class="text-decoration-none" href="">More Info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
