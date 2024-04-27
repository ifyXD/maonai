@extends('layouts.app')
@section('content')

<main class="mb-1">


    <header class="page-header page-header-dark bg-teal pb-10">
       <div class="container">
           <div class="page-header-content pt-4">
               <div class="row align-items-center justify-content-between">
                   <div class="col-auto mt-4">
                       <h1 class="page-header-title">
                           <div class="page-header-icon"><i data-feather="book"></i></div>
                           Drivers
                       </h1>
                   </div>
               </div>
           </div>
       </div>
   </header>
   
       <body>
           
           
   
       <div class="container mt-n10">
           
               <div class="card mb-4">
                   
                   <div class="card-header">
                       
                       
                       <button type="button" class="btn btn-transparent-dark" data-toggle="modal" data-target="#addNewVehicle">
                           <div>
                               <i data-feather="plus-square"></i>
                               Add Driver
                           </div>
                       </button>
                       
                   </div>
                   <div class="card-body">
                       
                       
                       <div class="datatable">
                           <div class="modal fade" id="addNewVehicle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                               <div class="modal-dialog">
                                   <form>
                                       @csrf
                                       <div class="modal-content create-new-vehicle-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Driver</h1>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
    
                                            <div class="mb-3">
                                                <label for="driver_name" class="form-label">Driver Name</label>
                                                <input type="text" class="form-control" id="driver_name" name="driver_name"
                                                    placeholder="Driver Name" required>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="contact" class="form-label">Contact</label>
                                                <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact"
                                                    required>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                                    required>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="driver_license" class="form-label">Driver License</label>
                                                <input type="text" class="form-control" id="driver_license" name="driver_license"
                                                    placeholder="Driver License" required>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Address</label>
                                                <textarea class="form-control" id="address" name="address" rows="3"
                                                    placeholder="Address" required></textarea>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-control" required>
                                                    <option value="pending">Pending</option>
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>
                                                </select>
                                            </div>
                           
                                            <button type="submit" id="createDriverBtn" class="btn btn-primary">Create</button>                                           </div>
                                       </div>
                                   </form>
                               </div>
                           </div>
                           </div>
   
                           <table class="table table-bordered table-hover" id="dataTable"width="100%" cellspacing="1">
                               <thead>
                                   <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Driver Name</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Driver License</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Update</th>
                                    <th scope="col">Action</th>
                                   </tr>
                               </thead>
      
   
                           </table>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>    
   </main>        

@endsection
@push('scripts')
    {{-- ajax crud --}}
    

