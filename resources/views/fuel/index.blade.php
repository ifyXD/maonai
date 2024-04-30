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
                                Fuels
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <body>



            <div class="container mt-n10">

                <div class="card mb-4">

                    <div class="card-header">


                        <button type="button" class="btn btn-transparent-dark" data-toggle="modal"
                            data-target="#addNewfuel">
                            <div>
                                <i data-feather="plus-square"></i>
                                Add Fuel types
                            </div>
                        </button>

                    </div>
                    <div class="card-body">


                        <div class="datatable">
                            <div class="modal fade" id="addNewfuel" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form>
                                        @csrf
                                        <div class="modal-content create-new-vehicle-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Create new Fuel Record
                                                </h1>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-1">
                                                    <label for="date" class="form-label">Date</label>
                                                    <input type="date" class="form-control" id="date" name="date"
                                                        required>
                                                </div>

                                                <div class="mb-1">
                                                    <label for="fuel_type" class="form-label">Fuel Type</label>
                                                    <input type="text" class="form-control" id="fuel_type"
                                                        name="fuel_type" placeholder="Fuel Type" required>
                                                </div>

                                                <div class="mb-1">
                                                    <label for="fuel_quantity" class="form-label">Fuel Quantity</label>
                                                    <input type="number" class="form-control" id="fuel_quantity"
                                                        name="fuel_quantity" placeholder="Fuel Quantity" required>
                                                </div>

                                                <div class="mb-1">
                                                    <label for="fuel_cost" class="form-label">Fuel Cost</label>
                                                    <input type="number" class="form-control" id="fuel_cost"
                                                        name="fuel_cost" placeholder="Fuel Cost" required>
                                                </div>

                                                <div class="mb-1">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select name="status" id="status" class="form-control" required>
                                                        <option value="unavailable">Unavailable</option>
                                                        <option value="available">Available</option>
                                                    </select>
                                                </div>


                                                <button type="submit" id="createFuelBtn"
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
                                    <th scope="col">Date</th>
                                    <th scope="col">Fuel Type</th>
                                    <th scope="col">Fuel Quantity</th>
                                    <th scope="col">Fuel Cost</th>
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
                url: '/admin/fueldata',
                success: function(data) {
                    // Assuming data is an array of user objects
                    $.each(data.fuels, function(index, fuel) {
                        var key = index + 1;
                        var ifdel = fuel.isdel === 'deleted' ? 'is-deleted' : '';

                        var action = fuel.isdel === 'active' ?


                            `<a href="#" class="editFuel" data-id="${fuel.id}" data-bs-toggle="modal" data-bs-target="#fuelEdit${fuel.id}">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
        </svg>
    </a>
    <a href="#" onclick="confirmDelete(${fuel.id});" id="deleteUserId">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
        </svg>
    </a>` :
                            `<span class="text-danger">Deleted</span>`;
                        // Assuming user has properties like id, name, email, etc.
                        let row =
                            `<tr class="${ifdel}" id="trId${fuel.id}">
        <td > ${key }</td>
        <td id="dateId${fuel.id}"> ${fuel.date}</td>
        <td id="fuel_typeId${fuel.id}"> ${fuel.fuel_type} </td>
        <td id="fuel_quantityId${fuel.id}"> ${fuel.fuel_quantity}</td>
        <td id="fuel_costId${fuel.id}"> ${fuel.fuel_cost} </td>
        <td id="statusId${fuel.id}"> ${fuel.status} </td> 
        <td id="createdAtId${fuel.id}">${formatDate(fuel.created_at)}</td>
        <td id="updatedAtId${fuel.id}">${formatDate(fuel.updated_at)}</td>
        <td> 
            ${action}
            <div class="modal fade" id="fuelEdit${fuel.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Fuel</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <i class="fas fa-times"></i>
</button>
                        </div>
                        <div class="modal-body"> 
                            <div class="mb-3">
                                <label for="editdate${fuel.id}" class="form-label">Plate Number</label>
                                <input type="date" value="${fuel.date}" class="form-control" id="editdate${fuel.id}" aria-describedby="emailHelp"> 
                            </div>
                            <div class="mb-3">
                                <label for="editfuel_type${fuel.id}" class="form-label">Type</label>
                                <input type="text" value="${fuel.fuel_type}" class="form-control" id="editfuel_type${fuel.id}" aria-describedby="emailHelp"> 
                            </div>
                            <div class="mb-3">
                                <label for="editfuel_quantity${fuel.id}" class="form-label">Fuel Quantity</label>
                                <input type="number" value="${fuel.fuel_quantity}" step="0.01" class="form-control" id="editfuel_quantityr${fuel.id}" aria-describedby="emailHelp"> 
                            </div>
                            <div class="mb-3">
                                <label for="editfuel_cost${fuel.id}" class="form-label">Condition</label>
                                <input type="text" value="${fuel.fuel_cost}" class="form-control" id="editfuel_cost${fuel.id}" aria-describedby="emailHelp"> 
                            </div>
                           
                            <div class="mb-1">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status${fuel.id}"  class="form-control" required>
                                                    <option value="unavailable">Unavailable</option>
                                                    <option value="available">Available</option>
                                                </select>
                                            </div>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="editSaveBtn" data-id="${fuel.id}">Save</button>
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
                url: '/admin/fuel/deletebyid',
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

        function createFuel(date, fuel_type, fuel_quantity, fuel_cost, status, callback) {
    $.ajax({
        type: 'post',
        url: '/admin/addnewfuel',
        data: {
            'date': date,
            'fuel_type': fuel_type,
            'fuel_quantity': fuel_quantity,
            'fuel_cost': fuel_cost,
            'status': status,
        },
        success: function(data) {
            if (data.message === 'success') {
                $('#messageflash').text(' added successfully');
                callback(true); // Invoke the callback with true indicating success
            }
        },
        error: function(xhr, status, error) {
            // Log the error to the console for debugging
            console.log(xhr.responseText);
            callback(false); // Invoke the callback with false indicating failure
        }
    });
}

    </script>

    {{-- jquery code --}}
    <script>
        $('#createFuelBtn').on('click', function(e) {
            e.preventDefault(); // Prevent the default form submission behavior

            let date = $('#date').val();
            let fuel_type = $('#fuel_type').val();
            let fuel_quantity = $('#fuel_quantity').val();
            let fuel_cost = $('#fuel_cost').val();
            let status = $('#status').val();
            console.log(date+fuel_type+fuel_quantity+fuel_cost+status);
            createFuel(date, fuel_type, fuel_quantity, fuel_cost, status, function(success) {
                if (success === true) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Fuel added successfully.",
                        showConfirmButton: true,
                        timer: 2000, // 2 seconds
                        timerProgressBar: true,

                    }).then(() => {
                        $('#date').val('');
                        $('#fuel_type').val('');
                        $('#fuel_quantity').val('');
                        $('#fuel_cost').val('');
                        $('#status').val('');

                        // Redirect to the same page to refresh
                        location.reload();
                    });
                }
            });
        });

        $('tbody').on('click', '.editFuel', function() {
            // Get the id of the vehicle to edit
            let id = $(this).data('id');

            // Show the edit modal
            $(`#fuelEdit${id}`).modal('show');

            // Get the current vehicle data
            let date = $('#date').val();
            let fuel_type = $('#fuel_type').val();
            let fuel_quantity = $('#fuel_quantity').val();
            let fuel_cost = $('#fuel_cost').val();
            let status = $('#status').val();

            // Update the modal inputs with the current vehicle data
            $(`#editdate${id}`).val(fuel.fuel_type);
            $(`#editfuel_type${id}`).val(fuel.type);
            $(`#editfuel_quantity${id}`).val(fuel.fuel_quantity);
            $(`#editfuel_cost${id}`).val(fuel.condition);
            $(`#status${id}`).val(fuel.status);
        });

        // Save button click event listener
        $('tbody').on('click', '#editSaveBtn', function() {
            // Get the id of the vehicle being edited
            let id = $(this).attr('data-id');

            // Get the updated values from the modal inputs
            let date = $(`#editdate${id}`).val();
            let fuel_type = $(`#editfuel_type${id}`).val();
            let fuel_quantity = $(`#editfuel_quantity${id}`).val();
            let fuel_cost = $(`#editfuel_cost${id}`).val();
            let status = $(`#status${id}`).val();

            // Send the data to the server using AJAX
            $.ajax({
                type: 'post',
                url: '/admin/editbyid',
                data: {
                    'id': id,
                    'date': date,
                    'fuel_type': fuel_type,
                    'fuel_quantity': fuel_quantity,
                    'fuel_cost': fuel_cost,
                    'status': status
                },
                success: function(response) {
                    // Handle the success response
                    Swal.fire({
                        title: 'Success!',
                        text: 'Fuel updated successfully.',
                        icon: 'success',
                        timer: 2000, // 2 seconds
                        timerProgressBar: true,
                        didClose: () => {
                            // Reload the page to reflect the changes
                            location.reload();
                        }
                    });
                    $(`#fuelEdit${id}`).modal('hide');
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
