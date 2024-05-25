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
                                Vehicles
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>




        <div class="container mt-n10">

            <div class="card mb-4">

                <div class="card-header">


                    <button type="button" class="btn btn-transparent-dark" data-toggle="modal"
                        data-target="#addNewVehicle">
                        <div>
                            <i data-feather="plus-square"></i>
                            Add Vehicles
                        </div>
                    </button>

                </div>
                <div class="card-body">


                 
                    <div class="datatable">
                        <div class="modal fade" id="addNewVehicle" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <form>
                                    @csrf
                                    <div class="modal-content create-new-vehicle-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Create new Vehicles</h1>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="driver_name" class="form-label">Driver Name</label>
                                                <select class="form-select" id="driver_name" name="driver_name" required>
                                                    <option value="" selected disabled>Select Driver</option>
                                                    @foreach ($driver as $driver)
                                                        <option value="{{ $driver->id }}"
                                                            data-driver_license="{{ $driver->driver_license }}">   {{ $driver->driver_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="mb-1">
                                                <label for="driver_license" class="form-label">Driver License</label>
                                                <input type="text" class="form-control" id="driver_license" name="driver_license" placeholder="Driver License" required readonly>
                                            </div>
                                          

                                            <div class="mb-1">
                                                <label for="platenumber" class="form-label">Plate Number</label>
                                                <input type="text" class="form-control" id="platenumber"
                                                    name="platenumber" placeholder="Plate Number" required>
                                            </div>

                                            <div class="mb-1">
                                                <label for="type" class="form-label">Type</label>
                                                <input type="text" class="form-control" id="type" name="type"
                                                    placeholder="Type">
                                            </div>

                                            <div class="mb-1">
                                                <label for="name" class="form-label">name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="Driver">
                                            </div>

                                            <div class="mb-1">
                                                <label for="condition" class="form-label">Condition</label>
                                                <input type="text" class="form-control" id="condition" name="condition"
                                                    placeholder="Condition">
                                            </div>

                                            <div class="mb-1">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description"></textarea>
                                            </div>

                                            <div class="mb-1">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-control" required>
                                                    <option value="pending">Pending</option>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                </select>
                                            </div>

                                            <button type="submit" id="createVehicleBtn"
                                                class="btn btn-primary">Create</button>
                                        </div>
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
                                <th scope="col">Drive License</th>   
                                <th scope="col">Plate Number</th>   
                                <th scope="col">Type</th>
                                <th scope="col">Driver</th>
                                <th scope="col">Condition</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="date-header">Created at (UTC)</th>
                                <th scope="col" class="date-header">Updated at (UTC)</th>
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
    <script>
       $(document).ready(function() {
            $('#driver_name').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var selectedDriverLicense = selectedOption.data('driver_license');
                

                $('#driver_license').val(selectedDriverLicense);

            });
        });
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
                url: '/admin/vehiclesdata',
                success: function(data) {
                    console.log(data);
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
                                <td>${key}</td>
                        <td>${vehicle.driver_name}</td>
                        <td>${vehicle.driver_license}</td>
                        <td>${vehicle.platenumber}</td>
                        <td>${vehicle.type}</td>
                        <td>${vehicle.name}</td>
                        <td>${vehicle.condition}</td>
                        <td>${vehicle.description}</td>
                        <td>${vehicle.status}</td>
                        <td>${formatDate(vehicle.created_at)}</td>
                        <td>${formatDate(vehicle.updated_at)}</td>
                        <td>${action}</td>
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
                                <label for="editnamer${vehicle.id}" class="form-label">Driver</label>
                                <input type="text" value="${vehicle.name}" class="form-control" id="editname${vehicle.id}" aria-describedby="emailHelp"> 
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
                                                <select name="status" id="status${vehicle.id}"  class="form-control">
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
                url: '/admin/vehicle/deletebyid',
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

        function createVehicle(drivers_id, driver_name, driver_license, platenumber, type, name, condition, description, status, callback) {
    $.ajax({
        type: 'post',
        url: '/admin/addnewvehicle',
        data: {
            'drivers_id': drivers_id,
            'driver_name': driver_name,
            'driver_license': driver_license,
            'platenumber': platenumber,
            'type': type,
            'name': name,
            'condition': condition,
            'description': description,
            'status': status,
        },
        success: function(data) {
            if (data.message === 'Record created successfully') {
                $('#messageflash').text('Vehicle added successfully');
                console.log('Vehicle added successfully');

                callback(true); // Invoke the callback with true indicating success
            } else {
                $('#messageflash').text('Unexpected response format');
                console.log('Unexpected response format:', data);
                callback(false);
            }
        },
        error: function(xhr, status, error) {
            var errorMessage = xhr.responseJSON.message || 'An error occurred while adding the vehicle';
            $('#messageflash').text('Error: ' + errorMessage);
            console.log('Error:', errorMessage);
            callback(false); // Invoke the callback with false indicating failure
        }
    });
}

$('#createVehicleBtn').on('click', function(e) {
    e.preventDefault(); // Prevent the default form submission behavior
    let driver_name = $('#driver_name option:selected').text();
    let driver_id = $('#driver_name').val();
    let driver_license = $('#driver_license').val();
    let platenumber = $('#platenumber').val();
    let type = $('#type').val();
    let name = $('#name').val();
    let condition = $('#condition').val();
    let description = $('#description').val();
    let status = $('#status').val();

    console.log(driver_id + driver_name + status + platenumber + type + name + condition + description);

    createVehicle(driver_id, driver_name, driver_license, platenumber, type, name, condition, description, status, function(success) {
        if (success === true) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Vehicle added successfully.",
                showConfirmButton: true,
                timer: 2000, // 2 seconds
                timerProgressBar: true,
            }).then(() => {
                console.log('SweetAlert closed');

                $('#driver_id').val('');
                $('#driver_name').val('');
                $('#driver_license').val('');
                $('#platenumber').val('');
                $('#type').val('');
                $('#name').val('');
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
});

$('tbody').on('click', '#editSaveBtn', function() {
    // Get the id of the vehicle being edited
    let id = $(this).attr('data-id');

    // Get the updated values from the modal inputs
    let platenumber = $(`#editplatenumber${id}`).val();
    let type = $(`#edittype${id}`).val();
    let name = $(`#editname${id}`).val();
    let condition = $(`#editcondition${id}`).val();
    let description = $(`#editdescription${id}`).val();
    let status = $(`#status${id}`).val();

    // Send the data to the server using AJAX
    $.ajax({
        type: 'post',
        url: '/admin/editbyid',
        data: {
            'id': id,
            'platenumber': platenumber,
            'type': type,
            'name': name,
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
