@extends('layout')

@section('content')
<div class="container py-3 h-100"> 
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="d-flex justify-content-center mb-3 pb-1">
          <span class="h1 fw-bold">Add a new menu!</span>
        </div>

        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
              <div class="card-body p-4 p-lg-5 text-black">
                <form method="POST" action="{{ url('/vendor-menu/add') }}" enctype="multipart/form-data">
                  @csrf

                  <div class="form-outline mb-4">
                    <label for="image" class="h5 fw-bold">Image</label>
                    <img src="" class="img-top" alt="">
                    <input class="form-control form-control-md @error('image') is-invalid @enderror" id="image" name="image" type="file">
        
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>

                  <div class="form-outline mb-4">
                    <label for="name" class="h5 fw-bold">Name</label>
                    <input id="name" type="text" class="form-control form-control-md @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="ex. Burger"/>

                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="form-outline mb-4">
                    <label for="description" class="h5 fw-bold">Description</label>
                    <textarea id="description" type="textbox" class="form-control form-control-md @error('description') is-invalid @enderror" name="description" autocomplete="description" placeholder="ex. Our signature burger" rows="3" style="resize:none;">{{ Request::old('description') }}</textarea>

                    @error('description')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="form-outline mb-4">
                    <label for="selectCategory" class="h5 fw-bold">Category</label>
                    <select class="form-select @error('selectCategory') is-invalid @enderror" id="selectCategory" name="selectCategory">
                      <option selected value="">Select category</option>
                      @foreach ($categories as $category)
                        @if (Request::old('selectCategory') == $category->id)
                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                        @else
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                      @endforeach
                    </select>

                    @error('selectCategory')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="form-outline mb-4">
                    <label for="price" class="h5 fw-bold">Price</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input id="price" type="number" class="form-control form-control-md @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" autocomplete="price" placeholder="ex. 20000"/>
                    </div>

                    @error('price')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>

                  <div class="form-outline mb-4">
                    <label for="cook" class="h5 fw-bold">Cook Time</label>
                    <div class="input-group">
                        <input id="cook" type="number" class="form-control form-control-md @error('cook') is-invalid @enderror" name="cook" value="{{ old('cook') }}" autocomplete="cook" placeholder="ex. 200"/>
                        <span class="input-group-text">minutes</span>
                    </div>

                    @error('cook')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                    @enderror
                  </div>

                  <div class="d-flex justify-content-center pt-1 mt-4">
                    <button class="btn btn-primary btn-md w-100" type="submit">Add</button>
                  </div>

                </form>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
