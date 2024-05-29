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
                                Mechanics
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
                            Add Mechanics
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
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Create new Mechanics info
                                            </h1>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-1">
                                                <label for="mechanics_name">Mechanics Name</label>
                                                <input type="text" name="mechanics_name" id="mechanics_name"
                                                    class="form-control" required>
                                            </div>
                                            <div class="mb-1">
                                                <label for="contact">Contact</label>
                                                <input type="number" name="contact" id="contact" class="form-control"
                                                    required>
                                            </div>
                                            <div class="mb-1">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control">
                                            </div>
                                            <div class="mb-1">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" class="form-control"></textarea>
                                            </div>
                                            <div class="mb-1">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-control" required>
                                                    <option value="pending">Pending</option>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                </select>
                                            </div>
                                            <button type="submit" id="addMechanicForm"
                                                class="btn btn-primary">Create</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="1">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Mechanics Name</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Email</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Updated at</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        mechanics();

        function formatDate(dateString) {
            var date = new Date(dateString);

            var day = date.getDate();
            var monthIndex = date.getMonth();
            var year = date.getFullYear();
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var seconds = date.getSeconds();

            // Pad the hours, minutes, and seconds with leading zeros if needed
            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            var monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            return monthNames[monthIndex] + ' ' + day + ', ' + year + ' ' + hours + ':' + minutes + ':' + seconds;
        }


        function mechanics() {
            // Destroy the existing DataTable
            $('#dataTable').DataTable().destroy();

            // Empty the table body
            $('tbody').empty();

            // Fetch data using AJAX
            $.ajax({
                type: 'get',
                url: '/admin/mechanicsdata',
                success: function(data) {
                    // Assuming data is an array of mechanic objects
                    $('tbody').html(data.html);
                    $('#dataTable').DataTable();


                }

            });
        }

        function deleteUser(userid) {
            $.ajax({
                type: 'post',
                url: '/admin/mechanic/deletebyid',
                data: {
                    'id': userid
                },
                success: function(data) {

                    mechanics();
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
                    Swal.fire("Deleted!", "Successfully deleted.", "success");
                }
            });
        }

        // Modify the createMechanics function to include a callback
        function createMechanics(mechanics_name, contact, email, description, status, callback) {
            $.ajax({
                type: 'post',
                url: '/admin/addmechanics',
                data: {
                    'mechanics_name': mechanics_name,
                    'contact': contact,
                    'email': email,
                    'description': description,
                    'status': status,
                    '_token': '{{ csrf_token() }}' // Add the CSRF token
                },
                success: function(data) {
                    if (data.success == 'success') {
                        $('#messageflash').text('Mechanic added successfully');
                        // $('#exampleModal').modal('hide'); // Close the modal
                        $('tbody').html(data.html); // Inject the generated HTML into the table body
                        $('#dataTable').DataTable();
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
                        Swal.fire("Error!", "An error occurred while adding the mechanic.", "error");
                    }
                    callback(false); // Invoke the callback with false indicating failure
                }
            });
        }

        // Use the form ID to handle form submission

        $('#addMechanicForm').click(function(e) {
            e.preventDefault(); // Prevent the default form submission behavior

            let mechanics_name = $('#mechanics_name').val();
            let contact = $('#contact').val();
            let email = $('#email').val();
            let description = $('#description').val();
            let status = $('#status').val();

            createMechanics(mechanics_name, contact, email, description, status, function(success) {
                if (success === true) {
                    // Display a success message and clear the form
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Mechanic added successfully.",
                        showConfirmButton: true,
                        timer: 1500, // 2 seconds
                        timerProgressBar: true,

                    }).then(() => {
                        $('#mechanics_name').val('');
                        $('#contact').val('');
                        $('#email').val('');
                        $('#description').val('');
                        $('#status').val('');
                        // location.reload();

                        // Reload the DataTable to reflect the new data
                        $('#addNewVehicle').modal('hide');
                        mechanics();
                    });
                }
            });
        });

        // Save button click event listener
        $('tbody').on('click', '.editMechanic', function() {
            // Get the id of the vehicle to edit
            let id = $(this).data('id');

            // Show the edit modal
            $(`#mechanicEdit${id}`).modal('show');

            // Get the current vehicle data
            let mechanics_name = $('#mechanics_name').val();
            let contact = $('#contact').val();
            let email = $(`#email${id}`).text();
            let description = $('#description').val();
            let status = $('#status').val();
            // Update the modal inputs with the current vehicle data
            $(`#editmechanics_name${id}`).val(mechanic.mechanics_name);
            $(`#editcontact${id}`).val(mechanic.contact);
            $(`#editemail${id}`).val(email);
            $(`#editdescription${id}`).val(mechanic.description);
            $(`#editstatus${id}`).val(mechanic.status);

        });

        // Save button click event listener

        // Save button click event listener for mechanics
        function formatErrors(errors) {
            let errorMessage = '';
            for (const field in errors) {
                if (errors.hasOwnProperty(field)) {
                    errorMessage += `${errors[field].join(', ')}<br>`;
                }
            }
            return errorMessage;
        }

        $('tbody').on('click', '#editSaveBtn', function() {
            // Get the id of the mechanic being edited
            let id = $(this).attr('data-id');

            // Get the updated values from the modal inputs
            let mechanics_name = $(`#editmechanics${id}`).val();
            let contact = $(`#editcontact${id}`).val();
            let email = $(`#editemail${id}`).val();
            let description = $(`#editdescription${id}`).val();
            let status = $(`#editstatus${id}`).val();
            console.log(mechanics_name + ' ' + contact + ' ' + email + ' ' + description + ' ' + status);

            // Send the data to the server using AJAX
            $.ajax({
                type: 'post',
                url: '/admin/editbyid-mechanic',
                data: {
                    '_token': '{{ csrf_token() }}', // Include CSRF token for security
                    'id': id,
                    'mechanics_name': mechanics_name,
                    'contact': contact,
                    'email': email,
                    'description': description,
                    'status': status
                },
                success: function(response) {
                    // Handle the success response
                    Swal.fire({
                        title: 'Success!',
                        text: 'Mechanic updated successfully.',
                        icon: 'success',
                        timer: 1500, // 2 seconds
                        timerProgressBar: true,
                        didClose: () => {
                            // Reload the data to reflect the changes
                            mechanics();
                        }
                    });
                    $(`#mechanicEdit${id}`).modal('hide');
                },
                error: function(xhr, status, error) {
                    // Log the error to the console for debugging
                    console.log(xhr.responseText);

                    // Parse the response JSON to extract errors
                    var response = xhr.responseJSON;
                    if (response && response.errors) {
                        var formattedErrors = formatErrors(response.errors);
                        Swal.fire("Error!", formattedErrors, "error");
                    } else {
                        Swal.fire("Error!", "Failed to update mechanic.", "error");
                    }
                }
            });
        });
    </script>
@endpush
