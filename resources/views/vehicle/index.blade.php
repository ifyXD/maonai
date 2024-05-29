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

                                            <div class="mb-1">
                                                <label for="platenumber" class="form-label">Plate Number</label>
                                                <input type="text" class="form-control" id="platenumber"
                                                    name="platenumber" placeholder="Plate Number" required>
                                            </div>

                                            <div class="mb-1">
                                                <label for="type" class="form-label">Car Name</label>
                                                <input type="text" class="form-control" id="type" name="type"
                                                    placeholder="Type">
                                            </div>
                                            <div class="mb-1">
                                                <label for="type" class="form-label">Seat Capacity</label>
                                                <input type="number" class="form-control" id="seat" name="seat"
                                                    min="1">
                                            </div>

                                            <div class="mb-1">
                                                <label for="driver" class="form-label">Driver</label>
                                                {{-- <input type="text" class="form-control" id="driver" name="driver" placeholder="Driver"> --}}
                                                <select name="driver" id="driver" class="form-control">
                                                    <option value="" selected>Select Driver</option>
                                                    @foreach ($drivers as $driver)
                                                        @php
                                                            $isAssigned = \App\Models\Vehicle::where(
                                                                'driver_id',
                                                                $driver->id,
                                                            )->exists();
                                                        @endphp
                                                        <option value="{{ $driver->id }}"
                                                            {{ $isAssigned ? 'disabled' : '' }}>
                                                            {{ $driver->driver_name }}{!! $isAssigned ? ' | <small class="text-danger">Not Available</small>' : '' !!}
                                                        </option>
                                                    @endforeach
                                                </select>



                                            </div>
                                            <div class="mb-1">
                                                <label for="driver" class="form-label">Fuel type</label>
                                                {{-- <input type="text" class="form-control" id="driver" name="driver" placeholder="Driver"> --}}
                                                <select name="fuel" id="fuel" class="form-control">
                                                    <option value="" selected>Select Fuel Type</option>
                                                    @foreach ($fuels as $fuel)
                                                        <option value="{{ $fuel->id }}">{{ $fuel->fuel_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
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
                                <th scope="col">Plate Number</th>
                                <th scope="col">Car Name</th>
                                <th scope="col">Fuel Type</th>
                                <th scope="col">Seat Capacity</th>
                                <th scope="col">Driver</th>
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
    <script>
        datausers();

        function datausers() {

            $('#dataTable').DataTable().destroy();
            $('tbody').empty();
            $.ajax({
                type: 'get',
                url: '/admin/vehiclesdata',
                success: function(data) {
                    // Assuming data is an array of user objects
                    $.each(data.vehicles, function(index, vehicle) {
                        var key = index + 1;
                        var ifdel = vehicle.visdel === 'deleted' ? 'is-deleted' : '';

                        var action = vehicle.visdel === 'active' ?


                            `<a href="#" class="editVehicle" data-id="${vehicle.vid}" data-bs-toggle="modal" data-bs-target="#vehicleEdit${vehicle.vid}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                            <a href="#" onclick="confirmDelete(${vehicle.vid});" id="deleteUserId">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </a>` :
                            `<span class="text-danger">Deleted</span>`;
                        // Assuming user has properties like id, name, email, etc.
                        let row =
                            `<tr class="${ifdel}" id="trId${vehicle.vid}">
                                    <td> ${key }</td>
                                    <td id="platenumberId${vehicle.id}"> ${vehicle.platenumber}</td>
                                    <td id="typeId${vehicle.vid}"> ${vehicle.type} </td>
                                    <td id="typeId${vehicle.vid}"> ${vehicle.fuel_type} </td>
                                    <td id="typeId${vehicle.vid}"> ${vehicle.seat_capacity} seat/s</td>
                                    <td id="driverId${vehicle.vid}"> ${vehicle.driver_name}</td> 
                                    <td id="descriptionId${vehicle.vid}"> ${vehicle.description}</td>
                                    <td id="statusId${vehicle.vid}"> ${vehicle.vstatus} </td> 
                                    <td id="createdAtId${vehicle.vid}">${formatDate(vehicle.created_at)}</td>
                                    <td id="updatedAtId${vehicle.vid}">${formatDate(vehicle.updated_at)}</td>
                                    <td> 
                                        ${action}
                                                <div class="modal fade" id="vehicleEdit${vehicle.vid}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                    <label for="editplatenumber${vehicle.vid}" class="form-label">Plate Number</label>
                                                                    <input type="text" value="${vehicle.platenumber}" class="form-control" id="editplatenumber${vehicle.vid}" aria-describedby="emailHelp"> 
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="edittype${vehicle.vid}" class="form-label">Car Name</label>
                                                                    <input type="text" value="${vehicle.type}" class="form-control" id="edittype${vehicle.vid}" aria-describedby="emailHelp"> 
                                                                </div>
                                                                <div class="mb-1">
                                                                    <label for="editseat${vehicle.vid}" class="form-label">Seat Capacity</label>
                                                                    <input type="number" class="form-control" id="editseat${vehicle.vid}" value="${vehicle.seat_capacity}" name="seat"
                                                                        min="1">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="editdriver${vehicle.vid}" class="form-label">Driver</label>
                                                                    <select name="driver" id="editdriver${vehicle.vid}" class="form-control">
                                                                            <option value="" selected>Select Driver</option>
                                                                        @foreach ($drivers as $driver) 
                                                                            <option value="{{ $driver->id }}" ${vehicle.driver_id == {{ $driver->id }} ? 'selected' : '' }>{{ $driver->driver_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div> 
                                                                <div class="mb-3">
                                                                    <label for="editfuel${vehicle.vid}" class="form-label">Fuel</label>
                                                                    <select name="driver" id="editfuel${vehicle.vid}" class="form-control">
                                                                            <option value="" selected>Select Driver</option>
                                                                        @foreach ($fuels as $driver) 
                                                                            <option value="{{ $driver->id }}" ${vehicle.fuel_id == {{ $driver->id }} ? 'selected' : '' }>{{ $driver->fuel_type }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div> 

                                                                <div class="mb-3">
                                                                    <label for="editdescription${vehicle.vid}" class="form-label">Description</label>
                                                                    <input type="text" value="${vehicle.description}" class="form-control" id="editdescription${vehicle.vid}" aria-describedby="emailHelp"> 
                                                                </div>
                                                                <div class="mb-1">
                                                                                    <label for="status" class="form-label">Status</label>
                                                                                    <select name="status" id="status${vehicle.vid}"  class="form-control">
                                                                                        <option ${vehicle.vstatus == 'pending' ? 'selected' : ''} value="pending">Pending</option>
                                                                                        <option ${vehicle.vstatus == 'active'?  'selected' : ''} value="active">Active</option>
                                                                                        <option ${vehicle.vstatus == 'inactive'?  'selected' : ''} value="inactive">Inactive</option>
                                                                                    </select>
                                                                                </div>



                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary" id="editSaveBtn" data-id="${vehicle.vid}">Save</button>
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
        $('option[value="decline"]').hide();

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
                        timer: 1300, // 2 seconds
                        timerProgressBar: true
                    }).then(() => {
                        // Reload the page or do any other necessary action
                        location.reload();
                    });
                }
            });
        }



        function formatErrors(errors) {
            let errorMessage = '';
            for (const field in errors) {
                if (errors.hasOwnProperty(field)) {
                    errorMessage += `${errors[field].join(', ')}<br>`;
                }
            }
            return errorMessage;
        }

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

        function createVehicle(platenumber, type, driver, description, fuel, seat, status, callback) {
            $.ajax({
                type: 'post',
                url: '/admin/addnewvehicle',
                data: {
                    '_token': '{{ csrf_token() }}', // Add the CSRF token
                    platenumber: platenumber,
                    type: type,
                    driver_id: driver,
                    description: description,
                    fuel_id: fuel,
                    seat_capacity: seat,
                    status: status,
                },
                success: function(data) {
                    if (data.message === 'success') {
                        Swal.fire("Success!", "Vehicle added successfully", "success");
                        callback(true); // Invoke the callback with true indicating success
                    }
                },
                error: function(xhr, status, error) {
                    // Log the error to the console for debugging
                    console.log(xhr.responseText);

                    // Parse the response JSON to extract errors
                    var response = xhr.responseJSON;
                    if (response && response.errors) {
                        var formattedErrors = formatErrors(response.errors);
                        Swal.fire("Error!", formattedErrors, "error");
                    } else if (response && response.message) {
                        Swal.fire("Error!", response.message, "error");
                    } else {
                        Swal.fire("Error!", "An error occurred while adding the fuel.", "error");
                    }

                    callback(false); // Invoke the callback with false indicating failure
                }
            });
        }


        $(document).ready(function() {
            $('#createVehicleBtn').on('click', function(e) {
                e.preventDefault(); // Prevent the default form submission behavior

                let platenumber = $('#platenumber').val();
                let type = $('#type').val();
                let driver = $('#driver').val();
                let description = $('#description').val();
                let fuel = $('#fuel').val();
                let seat = $('#seat').val();
                let status = $('#status').val();

                createVehicle(platenumber, type, driver, description, fuel, seat, status, function(
                    success) {
                    if (success === true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Vehicle added successfully.",
                            showConfirmButton: true,
                            timer: 1300, // 2 seconds
                            timerProgressBar: true,

                        }).then(() => {
                            // Reset the form
                            $('#platenumber').val('');
                            $('#type').val('');
                            $('#driver').val('');
                            $('#description').val('');
                            $('#fuel').val('');
                            $('#seat').val('');
                            $('#status').val('');

                            // Reload the page to refresh
                            $(`#addNewVehicle`).modal('hide');
                            datausers();
                        });
                    } else {
                        // Handle the failure case if needed
                        console.log('Vehicle creation failed.');
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
                let seat = $('#seat').val();
                let driver = $('#driver').val();
                let fuel = $('#fuel').val();
                let description = $('#description').val();
                let status = $('#status').val();


                // Update the modal inputs with the current vehicle data
                $(`#editplatenumber${id}`).val(vehicle.platenumber);
                $(`#edittype${id}`).val(vehicle.type);
                $(`#editdriver${id}`).val(vehicle.driver_name);
                $(`#editcondition${id}`).val(vehicle.condition);
                $(`#editdescription${id}`).val(vehicle.description);
                $(`#status${id}`).val(vehicle.status);
                $(`#editseat${id}`).val(vehicle.seat_capacity);
            });
            // Save button click event listener
            $('tbody').on('click', '#editSaveBtn', function() {
                // Get the id of the vehicle being edited
                let id = $(this).attr('data-id');
                // Get the updated values from the modal inputs
                let platenumber = $(`#editplatenumber${id}`).val();
                let type = $(`#edittype${id}`).val();
                let seat = $(`#editseat${id}`).val(); // 
                let driver = $(`#editdriver${id} option:selected`).val();
                let fuel = $(`#editfuel${id}`).val();
                let description = $(`#editdescription${id}`).val();
                let status = $(`#status${id}`).val(); // Corrected line 
                // Send the data to the server using AJAX
                $.ajax({
                    type: 'post',
                    url: '/admin/editbyid-vehicle',
                    data: {
                        'id': id,
                        'platenumber': platenumber,
                        'type': type,
                        'seat_capacity': seat,
                        'driver_id': driver,
                        'fuel_id': fuel,
                        'description': description,
                        'status': status
                    },
                    success: function(response) {
                        // Handle the success response
                        Swal.fire({
                            title: 'Success!',
                            text: 'Vehicle updated successfully.',
                            icon: 'success',
                            timer: 1300, // 2 seconds
                            timerProgressBar: true,
                            didClose: () => {
                                // Reload the page to reflect the changes
                                // location.reload();
                                datausers();
                            }
                        });
                        $(`#vehicleEdit${id}`).modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        // Handle the error response 
                        Swal.fire("Error!", formatErrors(xhr.responseJSON.errors), "error");
                    }
                });
            });


            $(document).on('click', '[data-bs-dismiss="modal"]', function() {
                $(this).closest('.modal').modal('hide');
            });
        });
    </script>
@endpush
