@extends('layout')

@push('custom-js')
  <script type="text/javascript" src="{{ asset ('js/refreshOrderPage.js') }}"></script>
@endpush

@section('content')    
    <div class="container">
        <div class="row  mb-5">
            <h3 class="text-center">Reviews</h3>
            <h2 class=" text-center fw-bold" style="font-size: 30px">
                <i class="fa-solid fa-star" style="color: #ffec00;"></i>
                {{$avgRating}}
            </h2>
        </div>
        
                {{-- <div class="card mx-2 mb-5" style="">
                @foreach ($countPerRate as $rateCount)
                    <div class="row">

                    </div>
                @endforeach
              </div> --}}
       
        <div class="container">
            {{-- <div class="row"> --}}
                @if (!$reviews->isEmpty())
                    @foreach ($reviews as $review)
                    <div class="card mb-3 text-bg-light border-light" style="box-shadow: 0px 2px 10px 2px #8b9ce956;">
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    <div class="row">
                                        <p class="mb-0 fw-bold">{{$review->order->customer->name}}</p>
                                        
                                    </div>
                                    <div class="row">
                                        <p class="mb-0">
                                            @if ($review->order->type==0)
                                            Takeout
                                            @else
                                            Eat-In
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <p class="mb-0 fw-bold text-end">{{$review->date}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <p>
                                    @for ($i = 0; $i < $review->rating; $i++)
                                        <i class="fa-solid fa-star" style="color: #ffec00;"></i>
                                    @endfor
                                </p>
                            </div>
                          <p class="card-text">{{$review->description}}</p>
                          <div class="row">
                            <div class="container-fluid" style="">
                                <div id="images" class=" row flex-row flex-nowrap " style="overflow-x:scroll">
                                        @foreach ($review->reviewImage as $img)   
                                            <div class="col"> 
                                                <img id="preview-image" src="{{ asset('storage/reviewImages/'.$img->path) }}" class="border-0 " style=" object-fit:contain; max-height:100px;max-width:150px" alt="nothing">
                                            </div>
                                        @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                            
                    </div>
                    @endforeach
                
                @else
                    <h2 class="mt-4 text-center text-wrap">There are no reviews yet, check again later!</h2>
                @endif
            {{-- </div> --}}
        </div>
    </div>
@endsection