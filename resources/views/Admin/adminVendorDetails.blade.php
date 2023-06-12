@extends('layout')

@section('content')
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-item-center">
            <div class="col col-xl-10 mt-3">
                <div class="d-flex row justify-content-center pb-1 mb-1">
                  <span class="h1 text-dark text-center fw-bold">Vendor Details</span>
                  @if($vendor->upcoming_deletion_date)
                    <div class="alert alert-warning">
                        This Vendor has been rejected and will be deleted by {{$vendor->upcoming_deletion_date}}
                    </div>
                  @endif
                </div>
                <div class="row d-flex justify-content-center">
                  <img src="{{ asset('storage/profiles/'.$vendor->image) }}" class="img-thumbnail py-3 w-75" style="object-fit:contain, width:10px" alt="No image Included">
                </div>
                <div class="card border-rounded border-light shadow-lg my-4">
                    <div class="row g-0">

                      <div class="card-body p-4 p-lg-5 text-black">
                        <div class="col flex-nowarp">
                          @if ($vendor->approved_by)
                            <div class="row border-bottom mb-2">
                              <div class="col-5">
                                <p class="h-4 fw-bold">Approved By</p>
                              </div>
                              <div class="col-7">
                                <p><span class="fw-bold">:</span> {{$approved_by->name}} </p>
                              </div>
                            </div>
                          
                          @endif
                            <div class="row border-bottom mb-2">
                              <div class="col-5">
                                <p class="h-4 fw-bold">Owner</p>
                              </div>
                              <div class="col-7">
                                <p><span class="fw-bold">:</span> {{$vendor->name}} </p>
                              </div>
                            </div>

                            <div class="row border-bottom mb-2">
                              <div class="col-5">
                                <p class="h-4 fw-bold">Email</p>
                              </div>
                              <div class="col-7">
                                <p><span class="fw-bold">:</span> {{$vendor->email}} </p>
                              </div>
                            </div>
                          </div>

                          <div class="row border-bottom mb-2">
                            <div class="col-5">
                              <p class="h-4 fw-bold">Canteen</p>
                            </div>
                            <div class="col-7">
                              <p><span class="fw-bold">:</span> {{$vendor->canteen->name}} </p>
                            </div>
                          </div>

                          <div class="row border-bottom mb-2">
                            <div class="col-5">
                              <p class="h-4 fw-bold">Store Name</p>
                            </div>
                            <div class="col-7">
                              <p><span class="fw-bold">:</span> {{$vendor->store_name}} </p>
                            </div>
                          </div>

                          <div class="row border-bottom mb-2">
                            <div class="col-5">
                              <p class="h-4 fw-bold">Phone Number</p>
                            </div>
                            <div class="col-7">
                              <p><span class="fw-bold">:</span> {{$vendor->phone_number}} </p>
                            </div>
                          </div>

                          <div class="row border-bottom mb-2">
                            <div class="col-5">
                              <p class="h-4 fw-bold">Address</p>
                            </div>
                            <div class="col-7">
                              <p><span class="fw-bold">:</span> {{$vendor->address}} </p>
                            </div>
                          </div>

                          <div class="row border-bottom mb-2">
                            <div class="col-5">
                              <p class="h-4 fw-bold">Description</p>
                            </div>
                            <div class="col-7">
                              <p><span class="fw-bold">:</span> {{$vendor->description}} </p>
                            </div>
                          </div>

                          <div class="row mb-2">
                              <div class="col">
                                <div class="row">
                                  <p class="h-5 fw-bold text-center">Qris</p>
                                </div>

                                <div class="row d-flex justify-content-center">
                                  <img src="{{ asset('storage/qris/'.$vendor->qris) }}" class="img-thumbnail py-3 w-75" style="object-fit:contain, width:10px" alt="No image Included">
                                </div>

                                @if (!$vendor->rejection_reason && !$vendor->approved_by)    
                                <div class="row d-flex justify-content-center">
                                  <div class="buttons row d-flex justify-content-around pt-1 mt-4">
                                    <div class="col d-flex">
                                      <div class="btn btn-danger btn-md ms-auto" data-bs-toggle="modal" data-bs-target="#rejectForm">
                                          Reject
                                      </div>
                                    </div>
                                    <div class="col d-flex">
                                      <form action="{{url('admin-acceptVendor/'.$vendor->id)}}" method="POST" class="ms-0">
                                        @csrf
                                        <button class="btn btn-primary btn-md" type="submit">Accept</button>
                                      </form>
                                    </div>
                                  </div>

                                  <div class="modal fade" id="rejectForm" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="z-3 modal-dialog position-absolute mb-0 start-0 end-0 bottom-0 " style="" role="document">
                                        <div class="modal-content" style="height: 500px">
                                            <div class="container">
                                                <div class="row">
                                                    <a class="btn btn-plus rounded-0 btn-danger" data-bs-dismiss="modal">
                                                        <i class="fa-solid fa-times"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="modal-header ">
                                                <h5 class="modal-title mx-auto" id="addToCartLabel">Rejection Reason</h5>
                            
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{url('admin-rejectVendor/'.$vendor->id)}}" method="POST">
                                                    @csrf
                                                    <div class="form-outline mb-4">
                                                      <textarea name="rejection_reason" id="rejection_reason"  class="form-control form-control-md" rows="3" placeholder="Please Input the rejection reason to help vendor fix their details!" required></textarea>
                                                      </div>
                                                      <div class="container">
                                                          <div class="buttons row d-flex justify-content-around pt-1 mt-5">
                                                            <button class="btn btn-danger btn-md w-100 col m-2" type="submit">Send</button>
                                                            <div class="btn btn-secondary col-6 m-2"  data-bs-dismiss="modal">
                                                                Cancel
                                                            </div>
                                                          </div>
                                                      </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                @else
                                  <div class="d-flex justify-content-center pt-1 mt-4">
                                      <button class="btn btn-danger btn-md mx-auto" data-bs-toggle="modal" data-bs-target="#removeConfirmation"><i class="fa-solid fa-trash-can me-1"></i> Remove Vendor</button>                                 
                                  </div>
                                  <!-- Modal -->
                                  <div class="modal fade" id="removeConfirmation" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" style="" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="deleteConfirmationLabel">Do you want to remove vendor?</h5>
                                        </div>
                                        <div class="modal-body">
                                          This vendor account will be deleted from the database.
                                        </div>
                                        <div class="modal-footer d-flex justify-content-around">
                                          <form class="col" action="{{url('admin-removeVendor/'.$vendor->id)}}" method="POST" class="ms-0">
                                          @csrf
                                          <button  class="btn btn-danger w-100" >Yes</button>
                                          </form>
                                          <button type="button" class="btn btn-secondary col-6 me-1" data-bs-dismiss="modal">No</button> 
                                        </div>
                                      </div>
                                    </div>
                                @endif
                
                                </div>
                              </div>
                          </div>
                        </div>
                    </div>
                  </div>
        </div>
    </div>

@endsection


