@extends('layouts.app')
@section('content')

<header class="page-header page-header-dark bg-teal pb-4">
    <div class="container">
        <div class="page-header-content pt-4">
            <h1 class="page-header-title">
                <div class="page-header-icon"></div>
                Dashboard
            </h1>
        </div>
    </div>
</header>
<div class="container">
    <h1>Job Request</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4 bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Main</h5>
                    <a href="#" class="btn btn-light">View Info</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4 bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <a href="#" class="btn btn-light">View Info</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4 bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Accept</h5>
                    <a href="#" class="btn btn-light">View Info</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4 bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Decline</h5>
                    <a href="#" class="btn btn-light">View Info</a>
                </div>
            </div>
        </div>
    </div>
{{--
    <div class="card mb-4">
        <div class="card-header">Cost of Gasoline</div>
        <div class="card-body">
            <div class="chart-area"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
    </div> --}}

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Main Management</div>
        <div class="card-body">
            <div class="datatable">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Content</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th>Total Cost</th>
                            <th>Labor Needed</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($requests as $request) --}}
                        <tr>
                            {{-- <td>{{ $request->email }}</td>
                            <td>{{ $request->content }}</td>
                            <td>{{ $request->quantity }}</td>
                            <td>₱{{ $request->unit_cost }}</td>
                            <td>₱{{ $request->total_cost }}</td>
                            <td>{{ $request->labor_needed }}</td>
                            <td> --}}
                                <form action="" method="POST">
                                    @csrf
                                    <input type="hidden" name="requestId" value="">
                                    <div class="d-flex align-items-center">
                                        <select name="status" class="form-control" style="min-width: 120px;">
                                            <option value="pending">Pending</option>
                                            <option value="accepted">Accept</option>
                                            <option value="declined">Declined</option>
                                        </select>
                                        <div class="input-group-append ml-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i data-feather="refresh-ccw"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRequestModal">
                                    Edit
                                </button>

                                <div class="modal fade" id="editRequestModal" tabindex="-1" role="dialog" aria-labelledby="editRequestModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form id="editRequestForm" method="POST" action="">
                                                {{-- @csrf
                                                @method('PUT') --}}
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editRequestModalLabel">Edit Request</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="content">Content</label>
                                                        <input type="text" class="form-control" id="content" name="content" value="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="quantity">Quantity</label>
                                                        <input type="number" class="form-control" id="quantity" name="quantity" value="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="unit_cost">Unit Cost</label>
                                                        <input type="number" class="form-control" id="unit_cost" name="unit_cost" value="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="labor_needed">Labor Needed</label>
                                                        <input type="text" class="form-control" id="labor_needed" name="labor_needed" value="">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
