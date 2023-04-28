@extends('layout')

@section('content')
<div class="container py-3 h-100"> 
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="d-flex justify-content-center mb-3 pb-1">
            <span class="h1 fw-bold">Edit Menu</span>
        </div>
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
              <div class="card-body p-4 p-lg-5 text-black">
                <form method="POST" action="/vendor-menu/edit/{{$item->id}}" enctype="multipart/form-data">
                  @csrf

                  <div class="form-outline mb-4">
                    <label for="image" class="h5 fw-bold">Image</label>
                    @if ($item->image != '')
                        <img src="{{ asset('storage/menus/'.$item->image) }}" class="img-thumbnail border-0 mb-4 w-100" alt="image error" style="height: 120px; object-fit:contain;">
                    @else
                        <img src="{{ asset('storage/menus/default.jpg') }}" class="img-thumbnail border-0 mb-4 w-100" alt="image error" style="height: 120px; object-fit:contain;">
                    @endif
                    <input class="form-control form-control-md @error('image') is-invalid @enderror" id="image" name="image" type="file">
        
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>

                  @php
                    $itemName = explode('_',$item->name)
                  @endphp

                  <div class="form-outline mb-4">
                    <label for="name" class="h5 fw-bold">Name</label>
                    <input id="name" type="text" class="form-control form-control-md @error('name') is-invalid @enderror" name="name" value="{{$itemName[1]}}" autocomplete="name"/>

                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="form-outline mb-4">
                    <label for="description" class="h5 fw-bold">Description</label>
                    <textarea id="description" type="textbox" class="form-control form-control-md @error('description') is-invalid @enderror" name="description" autocomplete="description" style="resize:none;" rows="3">{{$item->description}}</textarea>

                    @error('description')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="form-outline mb-4">
                    <label for="category" class="h5 fw-bold">Category</label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                      @foreach ($categories as $category)
                        @if ($item->category_id == $category->id)
                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                        @else
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                      @endforeach
                    </select>

                    @error('category')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="form-outline mb-4">
                    <label for="price" class="h5 fw-bold">Price</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input id="price" type="number" class="form-control form-control-md @error('price') is-invalid @enderror" name="price" value="{{$item->price}}" autocomplete="price"/>
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
                        <input id="cook" type="number" class="form-control form-control-md @error('cook') is-invalid @enderror" name="cook" value="{{$item->cook_time}}" autocomplete="cook"/>
                        <span class="input-group-text">minutes</span>
                    </div>

                    @error('cook')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                    @enderror
                  </div>

                  <div class="form-check mb-4">
                    <label for="availability" class="form-check-label h5 fw-bold">Availability</label>
                    <input id="availability" type="checkbox" class="form-check-input switch-input form-control-md" name="availability" value="1" {{ ($item->availability ? 'checked' : '') }}/>
                  </div>

                  <div class="form-check mb-4">
                    <label for="recommended" class="form-check-label h5 fw-bold">Recommended</label>
                    <input id="recommended" type="checkbox" class="form-check-input switch-input form-control-md" name="recommended" value="1" {{ ($item->recommended ? 'checked' : '') }}/>
                  </div>

                  <div class="buttons row d-flex justify-content-around pt-1 mt-4">
                    <div class="btn btn-danger col-3 m-2" data-bs-toggle="modal" data-bs-target="#deleteConfirmation">
                        <i class="fa-solid fa-trash-can"></i>
                    </div>
                    <button class="btn btn-primary btn-md w-100 col m-2" type="submit">Update</button>
                  </div>
                </form>

                <!-- Modal -->
                <div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog" style="" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationLabel">Are you sure?</h5>
                      </div>
                      <div class="modal-body">
                        This menu item will be deleted from the database.
                      </div>
                      <div class="modal-footer d-flex justify-content-around">
                        <div class="col-3"></div>
                        <form method="POST" action="/vendor-menu/delete/{{$item->id}}">
                          @csrf
                          <button type ="submit" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#deleteConfirmation">
                              Yes
                          </button>
                        </form>
                        <button type="button" class="btn btn-secondary col-6 me-1" data-bs-dismiss="modal">No</button> 
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
