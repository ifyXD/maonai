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
                                All Requests
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container mt-n10">
            <div class="card">


                <div class="container mt-3">
                    <div class="row">
                        <div class="col-12">
                            <label for="status" class="mr-2">Filter Status:</label>
                        </div>
                        <div class="col-12">
                            <form action="{{ url('user/all-requests') }}" method="get" class="form-inline">

                                <select name="status" id="status" class="form-control mr-2">
                                    <option {{ $status == 'pending' ? 'selected' : '' }} value="pending">Pending</option>
                                    <option {{ $status == 'accept' ? 'selected' : '' }} value="accept">Accept</option>
                                    <option {{ $status == 'decline' ? 'selected' : '' }} value="decline">Decline</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover" id="dataTable"width="100%" cellspacing="1">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Vehicle</th>
                                <th scope="col">Passenger Capacity</th>
                                <th scope="col">Driver</th>
                                <th scope="col">Appointment Start</th>
                                <th scope="col">Appointment End</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($myrequests) > 0)
                                @foreach ($myrequests as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ Str::ucfirst($item->user->lname) . ', ' . ucfirst($item->user->uname) }}</td>
                                        <td>{{ Str::ucfirst($item->vehicle->type) }}</td>
                                        <td>{{ $item->capacity }}</td>
                                        <td>{{ $item->driver->driver_name }}</td>
                                        <td>{{ $item->appointment }}</td>
                                        <td>{{ $item->appointment_end }}</td>
                                        <td><span
                                                class="{{ $item->status == 'pending' ? 'text-primary' : ($item->status == 'accept' ? 'text-success' : ($item->status == 'decline' ? 'text-danger' : '')) }}">{{ $item->status }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center text-danger">
                                    <td  colspan="8"> No data found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
