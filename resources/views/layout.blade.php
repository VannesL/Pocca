<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Pocca</title>
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/a18a7749d9.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="py-3 bg-light border-bottom text-center">
            <div class="container d-flex flex-nowrap align-items-center justify-content-between">
                <div>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutConfirmation">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </div>
                <a href="{{ url('/home') }}" class="d-flex align-items-center justify-content-center text-center text-decoration-none text-reset">
                    <img src="{{ asset('storage/logo/Pocca_Text.png') }} " alt="logo error" style="height: 50px; object-fit:cover;">
                </a>
                <div class="text-center d-flex justify-content-end">
                    @if (auth()->guard('customer')->check() || (auth()->guard('vendor')->check() && auth()->guard('vendor')->user()->approved_by != null))
                        <div class="btn btn-outline-dark rounded-circle">
                            @if (auth()->guard('customer')->check())
                                <a href="{{ url('/editProfile') }}"><i class="fa-solid fa-user text-dark"></i></a>
                            @else
                                <a href="{{ url('/vendor-editProfile') }}"><i class="fa-solid fa-user text-dark"></i></a>
                            @endif
                            
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="mt-3 mb-5" style="overflow-x: hidden">
            @yield('content')
        </div>
        @stack('custom-js')

        <div class="w-100 fixed-bottom">
            <nav class="nav navbar-light bg-light d-flex justify-content-evenly border-top border-bottom">
                @if (auth()->guard('customer')->check())
                    <a class="nav-link text-dark {{ request()->is('home') || request()->is('home/*') || request()->is('vendor/*') || request()->is('customer-cart') ? 'fw-bolder ' : '' }}" href="{{ url('/home') }}">Home<span class="sr-only"></a>
                    <div class="vr"></div>
                    <a class="nav-link text-dark {{ request()->is('order/customer') ||  (Route::currentRouteNamed('order-details') && $order->status_id<5)  ? 'fw-bolder ' : '' }}" href="{{ url('/order/customer') }}">Order</a>
                    <div class="vr"></div>
                    <a class="nav-link text-dark  {{  request()->is('order/customer/history') || (Route::currentRouteNamed('order-details') && $order->status_id>=5) ? 'fw-bolder ' : '' }}" href="{{ url('/order/customer/history') }}">History</a>
                @elseif (auth()->guard('vendor')->check() && auth()->guard('vendor')->user()->approved_by != null)
                    <a class="nav-link text-dark {{ request()->is('vendor-dash') || request()->is('vendor-dash/reviews') ? 'fw-bolder ' : '' }}" href="{{ url('/vendor-dash') }}">Home</a>
                    <div class="vr"></div>
                    <a class="nav-link text-dark {{ request()->is('order/vendor') ||  ( Route::currentRouteNamed('order-details') && $order->status_id<5 )  ? 'fw-bolder ' : '' }}" href="{{ url('/order/vendor') }}">Orders<span class="sr-only"></a>
                    <div class="vr"></div>
                    <a class="nav-link text-dark {{ request()->is('order/vendor/history') ||  (Route::currentRouteNamed('order-details') && $order->status_id>=5) ? 'fw-bolder ' : '' }}" href="{{ url('/order/vendor/history') }}">History</a>
                    <div class="vr"></div>
                    <a class="nav-link text-dark {{ request()->is('vendor-menu')|| request()->is('vendor-menu/add') || request()->is('vendor-menu/edit/*')  ? 'fw-bolder ' : '' }}" href="{{ url('/vendor-menu') }}">Menu</a>
                @endif 
            </nav>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="logoutConfirmation" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteConfirmationLabel">Do you want to logout?</h5>
                </div>
                {{-- <div class="modal-body">
                  This account will be deleted from the database.
                </div> --}}
                <div class="modal-footer d-flex justify-content-around">    
                  <a href="{{ url('/logout') }}" class="btn btn-danger col" >Yes</a>
                  <button type="button" class="btn btn-secondary col-6 me-1" data-bs-dismiss="modal">No</button> 
                </div>
              </div>
            </div>
        </div>
    </body>
</html>