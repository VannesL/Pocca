@extends('layout')


@section('content')
@if (auth()->guard("vendor")->user()->upcoming_deletion_date != null)
    <div class="container-fluid p-5" style="height:100vh">
        <p class="h1 text-center mt-5">Sorry your account is rejected by Admin because:</p>
        <p class="h1 text-center mt-5 alert alert-danger">{{auth()->guard("vendor")->user()->rejection_reason}}</p>
        
    </div>
@elseif (auth()->guard("vendor")->user()->approved_by == null)
    <div class="container-fluid p-5" style="height:100vh">
        <p class="h1 text-center mt-5">Please wait for while Admin verify your account</p>
        
    </div>
@else
<div class="px-4">
    <div class="container-fluid">
        <div class="row mb-1"> {{-- page widget--}}
            <div class="col-md-4 mb-1 p-1">
                <div class="card bg-success h-100">
                    <div class="card-body text-light h-100">
                        <h5 class="" style="height:35%;font-size: 15px">This Month Revenue</h5>
                        <div class="mb-3 text-break fw-bold" style="font-size: 18px">
                            {{rupiah($revenueOrders[0]->revenue ?? '', true)}}
                        </div>
                        @if ($revDiff >=0)
                        <h6 class="card-text font-weight-light mb-3" style="font-size: 12px" > Increase by {{ $revDiff }}%</h6>
                        @else
                        <h6 class="card-text font-weight-light mb-3" style="font-size: 12px">Decrease by {{ $revDiff }}%</h6>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-1 p-1">
                <div class="row h-100">
                    <div class="col-6 mb-3 pe-1 h-100">
                        <a class="text-white text-decoration-none " href="{{url('/vendor-dash/reviews')}}">
                        <div class="card  bg-warning h-100">
                                <div class="card-body text-light p-3 h-100">
                                    <h5 class="" style="height:35%;font-size: 15px">Rating</h5>
                                    <div class="mb-3 text-break fw-bold" style="font-size: 18px">
                                        <i class="fa-solid fa-star"></i>
                                        {{$rating}}
                                        <small>/ 5</small>
                                    </div>
                                    <h6 class="card-text font-weight-light" style="font-size: 12px">
                                        See review <i class="fa-solid fa-angle-right" style="color: #ffffff;"></i> 
                                    </h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 mb-3 ps-1">
                        <div class="card  bg-info h-100">
                            <div class="card-body text-light p-3  h-100">
                                <h5 class="" style="height:35%;font-size: 15px">This Month Orders</h5>
                                <div class="mb-3 text-break fw-bold" style="font-size: 18px">
                                    <i class="fa-solid fa-cart-shopping"></i> {{$revenueOrders[0]->total_order}}
                                </div>
                                @if ($ordDiff >=0)
                                <h6 class="card-text font-weight-light " style="font-size: 12px"> Increase by {{ $ordDiff }}% </h6>
                                @else
                                <h6 class="card-text font-weight-light" style="font-size: 12px">Decrease by {{ $ordDiff }}%</h6>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="row px-2"> {{--Sales Report--}}
            <h2 class="text-center mb-3">Sales Report</h2>
            <form action="{{ url('/vendor-dash') }}" method="GET" class="form-loading mb-3" style="padding: 0">
                @csrf
                <div class="input-group @error('search') has-error @enderror">
                    <input name="selectedDate"  id="selectedDate" type="date" value="{{ $selectedDate}}" class="form-control">
                    <button type="submit" class="btn btn-primary btn-block btn_submit ms-0 input-group-text"><i
                        class="fa fa-search"></i></button>
                </div>

            </form>
            <table class="table table-striped table-bordered " style="">
                <thead>
                    <tr>
                    <th class="col-1 text-center"scope="col">#</th>
                    <th class="col-5" scope="col">Menu</th>
                    <th class="col text-center" scope="col">Sold</th>
                    <th class="col-5 text-end"scope="col">Profits (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($report as $menu)
                        @php
                        $menuName = explode('_',$menu->name)
                        @endphp
                        <tr>
                            <th class="text-center" scope="row">{{$loop->iteration}}</th>
                            <td class="text-break">{{$menuName[1]}}</td>
                            <td class="text-break text-center">{{$menu->sold}}</td>
                            <td class="text-end">{{rupiah($menu->profits ?? '')}}</td>
                        </tr>
                        
                    @endforeach
                    <tr>
                    <td  class="text-center fw-bold" colspan="2">Total Profits (Rp)</td>
                    <td class="text-end fw-bold" colspan="2">{{rupiah($totalProfits ?? '')}}</td>
                    </tr>
                </tbody>
                </table>
                
                
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset ('css/searchbar.css') }}">
@endif
@endsection