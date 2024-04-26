
@extends('layouts.app')
@section('content')


<!-- Example Colored Cards for Dashboard Demo-->
<div class="row">

    <div class="col-xxl-3 col-lg-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mr-3">
                        <div class="text-white-75 small">Total (Pending)</div>
                        <div class="text-lg font-weight-bold">{{ $counts['pending'] }}</div>
                    </div>
                    <i class="feather-xl text-white-50" data-feather="calendar"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="contacts_requests">Return Main</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

</div>



<!-- Example Charts for Dashboard Demo-->
<div class="row">

</div>
<!-- Example DataTable for Dashboard Demo-->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header" style="background-color: #F4A100; color: white;">Pending Requests</div>
            <div class="card-body">
                <div class="datatable">
                    @if ($pendingRequests->isEmpty())
                        <p>No pending requests found.</p>
                    @else
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Contact Name</th>
                                    <th>Email</th>
                                    <th>Content</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingRequests as $request)
                                    <tr>
                                        <td>{{ $request->id }}</td>
                                        <td>{{ $request->contact->name }}</td>
                                        <td>{{ $request->contact->email }}</td>
                                        <td>{{ $request->content }}</td>
                                        <td>{{ $request->quantity }}</td>
                                        <td>{{ $request->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



