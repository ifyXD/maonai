
@extends('layouts.landing')

@section('design')


<!-- Example Colored Cards for Dashboard Demo-->

<div class="row">

    <div class="col-xxl-3 col-lg-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mr-3">
                        <div class="text-white-75 small">Total (Requester)</div>
                        <div class="text-lg font-weight-bold">{{ $counts['total'] }}</div>
                    </div>
                    <i class="feather-xl text-white-50" data-feather="calendar"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="contacts_requests">View Here</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-lg-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mr-3">
                        <div class="text-white-75 small">Pending (Request)</div>
                        <div class="text-lg font-weight-bold">{{ $counts['pending'] }}</div>
                    </div>
                    <i class="feather-xl text-white-50" data-feather="book"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="pending_requests">View Table</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-lg-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mr-3">
                        <div class="text-white-75 small">Accepted</div>
                        <div class="text-lg font-weight-bold">{{ $counts['accepted'] }}</div>
                    </div>
                    <i class="feather-xl text-white-50" data-feather="check-square"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="accepted_requests">View Table</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-lg-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mr-3">
                        <div class="text-white-75 small">Declined</div>
                        <div class="text-lg font-weight-bold">{{ $counts['declined'] }}</div>
                    </div>
                    <i class="feather-xl text-white-50" data-feather="bell-off"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="declined_requests">View Table</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

</div>


<!-- Example Charts for Dashboard Demo-->
<div class="row">

</div>
<!-- Example DataTable for Dashboard Demo-->
<div class="card mb-4">
    <div class="card-header" style="background-color: #0061F2; color: white;">Main Management</div>
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
                    @foreach ($requests as $request)
                    <tr>
                        <td>{{ $request->email }}</td>
                        <td>{{ $request->content }}</td>
                        <td>{{ $request->quantity }}</td>
                        <td>₱{{ $request->unit_cost }}</td>
                        <td>₱{{ $request->total_cost }}</td>
                        <td>{{ $request->labor_needed }}</td>
                        <td>
                            <form action="{{ route('update_status') }}" method="POST">
                                @csrf
                                <input type="hidden" name="requestId" value="{{ $request->id }}">
                                <div class="d-flex align-items-center">
                                    <select name="status" class="form-control" style="min-width: 120px;">
                                        <option value="pending" {{ $request->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="accepted" {{ $request->status === 'accepted' ? 'selected' : '' }}>Accept</option>
                                        <option value="declined" {{ $request->status === 'declined' ? 'selected' : '' }}>Declined</option>
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
                            <!-- Button to trigger modal -->
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRequestModal{{ $request->id }}">
                                Edit
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="editRequestModal{{ $request->id }}" tabindex="-1" role="dialog" aria-labelledby="editRequestModalLabel{{ $request->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form id="editRequestForm{{ $request->id }}" method="POST" action="{{ route('edit_request', $request->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editRequestModalLabel{{ $request->id }}">Edit Request</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form fields for editing request data -->
                                                <div class="form-group">
                                                    <label for="content{{ $request->id }}">Content</label>
                                                    <input type="text" class="form-control" id="content{{ $request->id }}" name="content" value="{{ $request->content }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="quantity{{ $request->id }}">Quantity</label>
                                                    <input type="number" class="form-control" id="quantity{{ $request->id }}" name="quantity" value="{{ $request->quantity }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="unit_cost{{ $request->id }}">Unit Cost</label>
                                                    <input type="number" class="form-control" id="unit_cost{{ $request->id }}" name="unit_cost" value="{{ $request->unit_cost }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="labor_needed{{ $request->id }}">Labor Needed</label>
                                                    <input type="text" class="form-control" id="labor_needed{{ $request->id }}" name="labor_needed" value="{{ $request->labor_needed }}">
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
                    @endforeach
                </tbody>
            </table>





        </div>
    </div>
</div>



@endsection



