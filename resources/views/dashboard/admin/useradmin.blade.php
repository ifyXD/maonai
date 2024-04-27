@extends('layouts.app')
@section('content')

<header class="page-header page-header-dark bg-blue pb-1">
    <div class="container">
        <div class="page-header-content pt-1">
            <div class="row align-items-center justify-content-center -ml-6"> <!-- Changed justify-content-between to justify-content-start -->
                <div class="col-auto mt-1">
                    <h1 class="page-header-title">
                        <div class="page-header-icon -mr-3"></div>
                        Dashboard
                    </h1>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="row mt-2 ml-1">
    <div class="col-xxl-3 col-lg-6">
        <div class="card card-style-1 text-white mb-4 mr-4 bg-primary">
            <div class="card-body">
                <h5 class="card-title">Card Title 1</h5>
                <p class="card-text">Some example text for card 1.</p>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-light">Button 1</a>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-lg-6">
        <div class="card card-style-2 text-white mb-4 mr-4 bg-warning">
            <div class="card-body">
                <h5 class="card-title">Card Title 2</h5>
                <p class="card-text">Some example text for card 2.</p>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-light">Button 2</a>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-lg-6">
        <div class="card card-style-3 text-white mb-4 mr-4 bg-success">
            <div class="card-body">
                <h5 class="card-title">Card Title 3</h5>
                <p class="card-text">Some example text for card 3.</p>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-light">Button 3</a>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-lg-6">
        <div class="card card-style-4 text-white mb-4 mr-4 bg-danger">
            <div class="card-body">
                <h5 class="card-title">Card Title 4</h5>
                <p class="card-text">Some example text for card 4.</p>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-light">Button 4</a>
            </div>
        </div>
    </div>
</div>

<div class="row  ml-1">
    <div class="col-xxl-3 col-lg-6">
        <div class="card card-style-1 text-white mb-4 mr-4 bg-primary">
            <div class="card-body">
                <h5 class="card-title">Card Title 1</h5>
                <p class="card-text">Some example text for card 1.</p>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-light">Button 1</a>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-lg-6">
        <div class="card card-style-2 text-white mb-4 mr-4 bg-warning">
            <div class="card-body">
                <h5 class="card-title">Card Title 2</h5>
                <p class="card-text">Some example text for card 2.</p>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-light">Button 2</a>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-lg-6">
        <div class="card card-style-3 text-white mb-4 mr-4 bg-success">
            <div class="card-body">
                <h5 class="card-title">Card Title 3</h5>
                <p class="card-text">Some example text for card 3.</p>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-light">Button 3</a>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-lg-6">
        <div class="card card-style-4 text-white mb-4 mr-4 bg-danger">
            <div class="card-body">
                <h5 class="card-title">Card Title 4</h5>
                <p class="card-text">Some example text for card 4.</p>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-light">Button 4</a>
            </div>
        </div>
    </div>
</div>


<!-- Example Charts for Dashboard Demo-->
<div class="row">

</div>
<!-- Example DataTable for Dashboard Demo-->
<div class="card mb-10">
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
                                    <option value="pending" >Pending</option>
                                    <option value="accepted" >Accept</option>
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
                        <!-- Button to trigger modal -->
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRequestModal}">
                            Edit
                        </button>

                        <!-- Modal -->
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
                                            <!-- Form fields for editing request data -->
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
@endsection
