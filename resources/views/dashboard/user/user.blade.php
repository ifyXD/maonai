@extends('layouts.app')

@section('content')
<main class="mb-1">
    <div class="card-body">
        <div class="card mb-4">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <!-- Create Organization-->
                    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11 mt-4">
                        <div class="card text-center h-100">
                            <div class="card-body px-5 pt-5 d-flex flex-column">
                                <div>
                                    <div class="h3 text-primary font-weight-300">Request Vehicles Here!</div>
                                </div>
                                <div class="icons-org-create align-items-center mx-auto mt-auto">
                                    <i class="icon-users" data-feather="users"></i>
                                    <i class="icon-plus fas fa-plus"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent px-5 py-4">
                                <div class="small text-center"><a class="btn btn-block btn-primary" href="{{route('create-request-vehicle.user')}}">Click</a></div>
                            </div>
                        </div>
                    </div>
                    <!-- Join Organization-->
                    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11 mt-4">
                        <div class="card text-center h-100">
                            <div class="card-body px-5 pt-5 d-flex flex-column align-items-between">
                                <div>
                                    <div class="h3 text-success font-weight-300">Technical Request Here!</div>
                                </div>
                                <div class="icons-org-join align-items-center mx-auto">
                                    <i class="icon-user" style="color: green;" data-feather="user"></i>
                                    <i class="icon-arrow fas fa-long-arrow-alt-right" style="color: green;"></i>
                                    <i class="icon-user" style="color: green;" data-feather="copy"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent px-5 py-4">
                                <div class="small text-center">
                                    <a class="btn btn-block btn-success" href="{{ route('contacts.create', ['userId' => auth()->user()->id]) }}">Click</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

{{-- Script for Users JRMS & Its Table --}}

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var dataTable = $('#dataTable').DataTable();

        // Search functionality
        $('#search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            dataTable.search(value).draw();
        });

        // Pagination
        $('#dataTable').on('draw.dt', function() {
            var pageInfo = dataTable.page.info();
            var currentPage = pageInfo.page + 1;
            var totalPages = pageInfo.pages;

            $('.dataTables_paginate .paginate_button').removeClass('disabled');

            // Disable previous button if on first page
            if (currentPage === 1) {
                $('.dataTables_paginate .previous').addClass('disabled');
            }

            // Disable next button if on last page
            if (currentPage === totalPages) {
                $('.dataTables_paginate .next').addClass('disabled');
            }
        });

        $('.dataTables_paginate .previous').on('click', function() {
            dataTable.page('previous').draw('page');
        });

        $('.dataTables_paginate .next').on('click', function() {
            dataTable.page('next').draw('page');
        });
    });
</script>

<div class="container mt-4">

    <div class="card mb-4">
        <div class="card-header">
            <div>
                <i data-feather="database" style="margin-right: 0.25em;"></i> Request
            </div>
        </div>
                <!-- Display flash message -->
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

        <div class="card-body">
            <div class="datatable">
                    <h4>User Information:</h4>
                    <p><strong>Name: {{ ucfirst(Auth::user()->ufname) }} {{ Auth::user()->uname }} {{ Auth::user()->lname }}</strong></p>

                    @if($contacts->isEmpty())
                    <p>You have no contacts.</p>
                @else
                    <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nature of Work</th>
                                <th class="text-center">Department</th>
                                <th class="text-center">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->content }}</td>
                                    <td class="text-center">{{ $contact->department }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm" style="width: 100px;
                                            @if($contact->status == 'pending')
                                                background-color: yellow;
                                            @elseif($contact->status == 'accepted')
                                                background-color: lightgreen;
                                            @elseif($contact->status == 'declined')
                                                background-color: red;
                                                color: black;
                                            @endif">
                                            {{ ucwords($contact->status) }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
{{-- end of JRMS section --}}

@endsection
@push('scripts')
    {{-- ajax crud --}}
    <script>
  $('option[value="decline"]').hide();

        datausers();

        function formatDate(dateString) {
    var date = new Date(dateString);
    var monthNames = [
        "Jan", "Feb", "Mar",
        "Apr", "May", "Jun", "Jul",
        "Aug", "Sep", "Oct",
        "Nov", "Dec"
    ];
    var day = date.getDate();
    var monthIndex = date.getMonth();
    var year = date.getFullYear();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';

    // Convert hours from 24-hour to 12-hour format
    hours = hours % 12;
    hours = hours ? hours : 12; // Handle midnight (0 hours)

    // Pad the hours, minutes, and seconds with leading zeros if needed
    minutes = minutes < 10 ? '0' + minutes : minutes;

    return monthNames[monthIndex] + ' ' + day + ', ' + year + ' ' + hours + ':' + minutes + ' ' + ampm;
}


        function datausers() {

            $('#dataTable').DataTable().destroy();
            $('tbody').empty();
            $.ajax({
                type: 'get',
                url: '/user/vehiclesdata',
                success: function(data) {
                    // Assuming data is an array of user objects
                    $.each(data.vehicles, function(index, vehicle) {
                        var key = index + 1;
                        var ifdel = vehicle.isdel === 'deleted' ? 'is-deleted' : '';

                        var action = vehicle.isdel === 'active' ?


    `<a href="#" class="editVehicle" data-id="${vehicle.id}" data-bs-toggle="modal" data-bs-target="#vehicleEdit${vehicle.id}">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
        </svg>
    </a>
    <a href="#" onclick="confirmDelete(${vehicle.id});" id="deleteUserId">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
        </svg>
    </a>` :
    `<span class="text-danger">Deleted</span>`;
// Assuming user has properties like id, name, email, etc.
let row =
    `<tr class="${ifdel}" id="trId${vehicle.id}">
        <td > ${key }</td>
        <td id="platenumberId${vehicle.id}"> ${vehicle.platenumber}</td>
        <td id="typeId${vehicle.id}"> ${vehicle.type} </td>
    
        <td id="statusId${vehicle.id}"> ${vehicle.status} </td>
        <td id="createdAtId${vehicle.id}">${formatDate(vehicle.created_at)}</td>
        <td>
            ${action}
            <div class="modal fade" id="vehicleEdit${vehicle.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Vehicle</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <i class="fas fa-times"></i>
</button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editplatenumber${vehicle.id}" class="form-label">Plate Number</label>
                                <input type="text" value="${vehicle.platenumber}" class="form-control" id="editplatenumber${vehicle.id}" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="edittype${vehicle.id}" class="form-label">Type</label>
                                <input type="text" value="${vehicle.type}" class="form-control" id="edittype${vehicle.id}" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="editdriver${vehicle.id}" class="form-label">Driver</label>
                                <input type="text" value="${vehicle.driver}" class="form-control" id="editdriver${vehicle.id}" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="editcondition${vehicle.id}" class="form-label">Condition</label>
                                <input type="text" value="${vehicle.condition}" class="form-control" id="editcondition${vehicle.id}" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="editdescription${vehicle.id}" class="form-label">Description</label>
                                <input type="text" value="${vehicle.description}" class="form-control" id="editdescription${vehicle.id}" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-1">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status${vehicle.id}"  class="form-control" required>
                                                    <option value="pending">Pending</option>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                </select>
                                            </div>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="editSaveBtn" data-id="${vehicle.id}">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>`;
                        // Append the row to the


                        $('tbody').append(row);
                    });
                    $('#dataTable').DataTable();


                }

            });
        }

        function deleteUser(userid) {
            $.ajax({
                type: 'post',
                url: '/user/vehicle/deletebyid',
                data: {
                    'id': userid
                },
                success: function(data) {

                    datausers();
                },
                error: function(xhr, status, error) {


                    console.log(xhr);

                }


            });
        }

        function confirmDelete(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",

                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
        // Call your delete function here
        deleteUser(id);

        Swal.fire({
            title: 'Deleted!',
            text: 'User has been deleted.',
            icon: 'success',
            timer: 2000, // 2 seconds
            timerProgressBar: true
        }).then(() => {
            // Reload the page or do any other necessary action
            location.reload();
        });
    }
});
        }

        function createVehicle(platenumber, type, driver, condition, description, status, callback) {
            $.ajax({
                type: 'post',
                url: '/user/addnewvehicle',
                data: {
                    'platenumber': platenumber,
                    'type': type,
                    'driver': driver,
                    'condition': condition,
                    'description': description,
                    'status': status,

                },
                success: function(data) {
                    if (data.message === 'success') {
                        $('#messageflash').text('Vehicle added successfully');
                        callback(true); // Invoke the callback with true indicating success
                    }
                },
                error: function(xhr, status, error) {


                    // Error handling
                    var errorMessage = xhr.responseJSON.message;
                    if (errorMessage) {
                        $('#messageflash').text('Erroryawa: ' + errorMessage);
                    } else {
                        $('#messageflash').text('An error occurred while adding the user');
                    }
                    callback(false); // Invoke the callback with false indicating failure
                }
            });
        }
    </script>

    {{-- jquery code --}}
    <script>

$('#createVehicleBtn').on('click', function(e) {
    e.preventDefault(); // Prevent the default form submission behavior

    let platenumber = $('#platenumber').val();
    let type = $('#type').val();
    let driver = $('#driver').val();
    let condition = $('#condition').val();
    let description = $('#description').val();
    let status = $('#status').val();

    createVehicle(platenumber, type, driver, condition, description, status, function(success) {
        if (success === true) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Vehicle added successfully.",
                showConfirmButton: true,
                timer: 2000, // 2 seconds
                timerProgressBar: true,

            }).then(() => {
                $('#platenumber').val('');
                $('#type').val('');
                $('#driver').val('');
                $('#condition').val('');
                $('#description').val('');
                $('#status').val('');

                // Redirect to the same page to refresh
                location.reload();
            });
        }
    });
});

$('tbody').on('click', '.editVehicle', function() {
    // Get the id of the vehicle to edit
    let id = $(this).data('id');

    // Show the edit modal
    $(`#vehicleEdit${id}`).modal('show');

    // Get the current vehicle data
    let platenumber = $('#platenumber').val();
    let type = $('#type').val();
    let driver = $('#driver').val();
    let condition = $('#condition').val();
    let description = $('#description').val();
    let status = $('#status').val();

    // Update the modal inputs with the current vehicle data
    $(`#editplatenumber${id}`).val(vehicle.platenumber);
    $(`#edittype${id}`).val(vehicle.type);
    $(`#editdriver${id}`).val(vehicle.driver);
    $(`#editcondition${id}`).val(vehicle.condition);
    $(`#editdescription${id}`).val(vehicle.description);
    $(`#editstatus${id}`).val(vehicle.status);
});

// Save button click event listener
$('tbody').on('click', '#editSaveBtn', function() {
    // Get the id of the vehicle being edited
    let id = $(this).attr('data-id');

    // Get the updated values from the modal inputs
    let platenumber = $(`#editplatenumber${id}`).val();
    let type = $(`#edittype${id}`).val();
    let driver = $(`#editdriver${id}`).val();
    let condition = $(`#editcondition${id}`).val();
    let description = $(`#editdescription${id}`).val();
    let status = $(`#status${id}`).val();

    // Send the data to the server using AJAX
    $.ajax({
        type: 'post',
        url: '/user/editbyid',
        data: {
            'id': id,
            'platenumber': platenumber,
            'type': type,
            'driver': driver,
            'condition': condition,
            'description': description,
            'status': status
        },
        success: function(response) {
            // Handle the success response
            Swal.fire({
                title: 'Success!',
                text: 'Vehicle updated successfully.',
                icon: 'success',
                timer: 2000, // 2 seconds
                timerProgressBar: true,
                didClose: () => {
                    // Reload the page to reflect the changes
                    location.reload();
                }
            });
            $(`#vehicleEdit${id}`).modal('hide');
        },
        error: function(xhr, status, error) {
            // Handle the error response
            Swal.fire("Error!", "Failed to update vehicle.", "error");

        }
    });

});

$(document).on('click', '[data-bs-dismiss="modal"]', function() {
    $(this).closest('.modal').modal('hide');
});



    </script>
@endpush

