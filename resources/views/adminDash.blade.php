@extends('layout')

@section('content')
<div class="container">
    <div class="row px-3">
        <div class="d-flex justify-content-center pb-1 mb-3">
            <span class="h1 text-dark fw-bold">Vendors List</span>
          </div>
        <div class="col table border overflow-scroll">
          <div class="row flex-nowarp bg-dark text-light">
            <div class="col overflow-scroll">Canteen</div>
            <div class="col overflow-scroll">Store Name</div>
            <div class="col text-center overflow-scroll"> Status</div>
          </div>
          @foreach ($vendors as $vendor)
          <a class=" text-decoration-none" href="/admin-vendorDetails/{{$vendor->id}}">
              <div class="row flex-nowarp {{($vendor->approved_by || $vendor->upcoming_deletion_date) ? : 'bg-warning text-dark'}}" >
                  <div class="col border-start border-bottom overflow-scroll">{{$vendor->canteen->name}}</div>
                  <div class="col border-bottom border-end border-start overflow-scroll">{{$vendor->store_name}}</div>
                  @if ($vendor->upcoming_deletion_date)
                      <div class="col border-end border-bottom d-flex overflow-scroll"> 
                          <p class=" mx-auto my-auto p-1 rounded  text-center bg-danger text-light ">Rejected</p>

                      </div>
                  @else
                  <div class="col border-end border-bottom d-flex overflow-scroll "> 
                    <div class="mx-auto my-auto text-center {{($vendor->approved_by)? 'p-1 rounded bg-success text-light ' : ''}}">{{($vendor->approved_by) ? 'Registered' : 'Unregistered'}}
                    </div>
                  </div>
                  @endif

                </div>
              </a>
          @endforeach            
              {{-- {{  $vendors->onEachSide(5)->links() }} --}}
            </div>

    </div>
</div>
    
@endsection

