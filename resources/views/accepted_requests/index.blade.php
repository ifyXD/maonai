@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-xxl-3 col-lg-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mr-3">
                        <div class="text-white-75 small">Total (Accepted)</div>
                        <div class="text-lg font-weight-bold">{{ $counts['total'] }}</div>
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

<div class="row"></div>

<!-- Example DataTable for Dashboard Demo-->
<div class="card mb-4">
    <!-- Card header with export button -->
    <div class="card-header" style="background-color: #01A868; color: white; border-bottom: 0; display: flex; justify-content: space-between;">
        <div>Accepted Request</div>
        <div>
            <!-- Export button -->
            <a href="{{ route('export.accepted.requests.pdf') }}" class="btn btn-primary">Export as PDF</a>
        </div>
    </div>
    <div class="card-body">
        <div class="datatable">

            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Contact Email</th>
                        <th>Content</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>Total Cost</th>
                        <th>Labor Needed</th>
                        <th>Export</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($acceptedRequests as $request)
                    <tr>
                        <td>{{ $request->contact->email }}</td>
                        <td>{{ $request->content }}</td>
                        <td>{{ $request->quantity }}</td>
                        <td>₱{{ $request->unit_cost }}</td>
                        <td>₱{{ $request->total_cost }}</td>
                        <td>{{ $request->labor_needed }}</td>
                        <td>
                            <!-- Action button to export individual request as PDF -->
                            <div class="action-table-container">
                                <a href="{{ route('export.individual.accepted.request.pdf', ['requestId' => $request->id]) }}" class="btn btn-datatable btn-icon btn-transparent-dark">
                                    <i data-feather="aperture"></i>
                                </a>
                            </div>
                        </td>
                        <td>
                            <!-- Button to trigger the modal for editing request -->
                            <button type="button" class="btn btn-datatable btn-icon btn-transparent-dark mr-2 edit-request-btn" data-toggle="modal" data-target="#editRequestModal{{ $request->id }}">
                                <i data-feather="edit"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for editing request -->
@foreach ($acceptedRequests as $request)
<div class="modal fade" id="editRequestModal{{ $request->id }}" tabindex="-1" role="dialog" aria-labelledby="editRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRequestModalLabel">Edit Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Edit request form -->
                <form method="POST" action="{{ route('contacts_requests.update', $request->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Form fields for editing request data -->
                    <div class="form-group">
                        <label for="content">Content</label>
                        <input type="text" class="form-control" id="content" name="content" value="{{ $request->content }}">
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $request->quantity }}">
                    </div>

                    <div class="form-group">
                        <label for="unit_cost">Unit Cost</label>
                        <input type="number" class="form-control" id="unit_cost" name="unit_cost" value="{{ $request->unit_cost }}">
                    </div>

                    <div class="form-group">
                        <label for="labor_needed">Labor Needed</label>
                        <input type="text" class="form-control" id="labor_needed" name="labor_needed" value="{{ $request->labor_needed }}">
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
