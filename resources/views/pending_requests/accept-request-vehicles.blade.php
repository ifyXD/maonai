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
                                All Pending Requests
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container mt-n10">

            <div class="card mb-4">

                <div class="card-header">


                    {{-- <button type="button" class="btn btn-transparent-dark" data-toggle="modal"
                        data-target="#addNewVehicle">
                        <div>
                            <i data-feather="plus-square"></i>
                            Add Vehicles
                        </div>
                    </button> --}}

                </div>
                <div class="card-body">


                    <div class="datatable">
                        <div class="modal fade" id="addNewVehicle" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover" id="dataTable"width="100%" cellspacing="1">
                        <thead>
                            <tr>
                                <th scope="col">#</th> 
                                <th scope="col">User Name</th>
                                <th scope="col">Vehicle</th>
                                <th scope="col">Capacity</th>
                                <th scope="col">Driver</th>
                                <th scope="col">Appointment Start</th>
                                <th scope="col">Appointment End</th>
                                <th scope="col">Status</th> 
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $key=>$item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->vehicle->type}}</td>
                                    <td>{{$item->capacity}}</td>
                                    <td>{{$item->driver->driver_name}}</td>
                                    <td>{{$item->appointment}}</td>
                                    <td>{{$item->appointment_end}}</td>
                                    <td><span class="text-success">{{$item->status}}</span></td>
                                    <td>
                                        <a href="{{url('admin/request-vehicles/print-to-pdf', $item->id)}}" class="btn btn-secondary">Print</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
    </main>
@endsection
 
