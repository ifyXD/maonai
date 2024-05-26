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
                                Drivers
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
                            data-target="#addNewDriver">
                            <div>
                                <i data-feather="plus-square"></i>
                                Add Driver
                            </div>
                        </button>

                    </div>
                    <div class="card-body">


                        <div class="datatable">
                            <div class="modal fade" id="addNewDriver" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form>
                                        @csrf
                                        <div class="modal-content create-new-vehicle-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Driver</h1>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="mb-3">
                                                    <label for="driver_name" class="form-label">Driver Name</label>
                                                    <input type="text" class="form-control" id="driver_name"
                                                        name="driver_name" placeholder="Driver Name" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="contact" class="form-label">Contact</label>
                                                    <input type="text" class="form-control" id="contact" name="contact"
                                                        placeholder="Contact" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        placeholder="Email" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="driver_license" class="form-label">Driver License</label>
                                                    <input type="text" class="form-control" id="driver_license"
                                                        name="driver_license" placeholder="Driver License" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Address</label>
                                                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Address" required></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select name="status" id="status" class="form-control" required>
                                                        <option value="pending">Pending</option>
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>


                                                <button type="submit" id="createDriverBtn"
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
                                    <th scope="col">Contact</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Driver License</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Update</th>
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
        driver();

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

        function driver() {
            $('#dataTable').DataTable().destroy();
            $('tbody').empty();
            $.ajax({
                type: 'get',
                url: '/admin/driverdatatae',
                success: function(data) {
                    $('tbody').html(data.html);
                    $('#dataTable').DataTable();
                }
            });
        }

        function deleteUser(userid) {
            $.ajax({
                type: 'post',
                url: '/admin/driver/deletebyid',
                data: {
                    'id': userid
                },
                success: function(data) {
                    // Assuming data contains a success message or indication
                    console.log('User deleted successfully');
                    datausers(); // Reload the data
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting user:', error);
                    console.log(xhr.responseText); // Log the response from the server
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
                        // location.reload();
                        driver();
                    });
                }
            });
        }

        function createDriver(driver_name, contact, email, driver_license, address, status, callback) {
            // $.ajax({
            //     type: 'post',
            //     url: '/admin/addnewDriver',
            //     data: {
            //         driver_name: driver_name,
            //         contact: contact,
            //         email: email,
            //         driver_license: driver_license,
            //         address: address,
            //         status: status,
            //     },
            //     success: function(data) {
            //         $('#messageflash').text('Driver added successfully');
            //         callback(true); // Invoke the callback with true indicating success
            //     },
            //     error: function(xhr, status, error) {
            //         // Error handling
            //         var response = xhr.responseJSON;
            //         if (response && response.errors) {
            //             var errorMessages = '';
            //             $.each(response.errors, function(key, messages) {
            //                 errorMessages += messages.join(' ') + '<br>';
            //             });
            //             Swal.fire("Error!", errorMessages, "error");
            //         } else if (response && response.message) {
            //             Swal.fire("Error!", response.message, "error");
            //         } else {
            //             Swal.fire("Error!", "An error occurred while adding the driver.", "error");
            //         }
            //         callback(false); // Invoke the callback with false indicating failure
            //     }
            // });
            $.ajax({
                type: 'post',
                url: '/admin/addnewDriver',
                data: {
                    driver_name: driver_name,
                    contact: contact,
                    email: email,
                    driver_license: driver_license,
                    address: address,
                    status: status,
                },
                success: function(data) {
                    if (data.message === 'Driver created successfully') {
                        $('#messageflash').text('Driver added successfully');
                        $('tbody').html(data.html); // Inject the generated HTML into the table body
                        $('#dataTable').DataTable();
                        callback(true); // Invoke the callback with true indicating success
                    }
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON;
                    if (response && response.errors) {
                        var errorMessages = '';
                        $.each(response.errors, function(key, messages) {
                            errorMessages += messages.join(' ') + '<br>';
                        });
                        Swal.fire("Error!", errorMessages, "error");
                    } else if (response && response.message) {
                        Swal.fire("Error!", response.message, "error");
                    } else {
                        Swal.fire("Error!", "An error occurred while adding the driver.", "error");
                    }
                    callback(false); // Invoke the callback with false indicating failure
                }
            });


        }

        $('#createDriverBtn').on('click', function(e) {
            e.preventDefault(); // Prevent the default form submission behavior

            let driver_name = $('#driver_name').val();
            let contact = $('#contact').val();
            let email = $('#email').val();
            let driver_license = $('#driver_license').val();
            let address = $('#address').val();
            let status = $('#status').val();

            createDriver(driver_name, contact, email, driver_license, address, status, function(success) {
                if (success === true) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Driver added successfully.",
                        showConfirmButton: true,
                        timer: 2000, // 2 seconds
                        timerProgressBar: true,
                    }).then(() => {
                        $('#driver_name').val('');
                        $('#contact').val('');
                        $('#email').val('');
                        $('#driver_license').val('');
                        $('#address').val('');
                        $('#status').val('');

                        // Redirect to the same page to refresh
                        // location.reload();
                        $('#addNewDriver').modal('hide');
                        driver();

                    });
                }
            });
        });



        $('tbody').on('click', '.editDriver', function() {
            // Get the id of the vehicle to edit
            let id = $(this).attr('data-id');

            // Show the edit modal
            $(`#driverEdit${id}`).modal('show');

            // Get the current vehicle data
            let driver_name = $('#driver_name').val();
            let type = $('#type').val();
            let driver = $('#driver').val();
            let condition = $('#condition').val();
            let description = $('#description').val();
            let status = $('#status').val();
            // Update the modal inputs with the current vehicle data
            $(`#editdriver_name${id}`).val(driver.driver_name);
            $(`#editcontact${id}`).val(driver.contact);
            $(`#editemail${id}`).val(driver.email);
            $(`#editdriver_license${id}`).val(driver.driver_license);
            $(`#editaddress${id}`).val(driver.address);
            $(`#editstatus${id}`).val(driver.status);

        });

        // Save button click event listener
        $('tbody').on('click', '#editSaveBtn', function() {
            // Get the id of the driver being edited
            let id = $(this).attr('data-id');

            // Get the updated values from the modal inputs
            let driver_name = $(`#editdriver_name${id}`).val();
            let contact = $(`#editcontact${id}`).val();
            let email = $(`#editemail${id}`).val();
            let driver_license = $(`#editdriver_license${id}`).val();
            let address = $(`#editaddress${id}`).val();
            let status = $(`#editstatus${id}`).val();

            // Send the data to the server using AJAX
            $.ajax({
                type: 'post',
                url: '/admin/driver/edit', // Assuming this is the correct URL for editing drivers
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': id,
                    'driver_name': driver_name,
                    'contact': contact,
                    'email': email,
                    'driver_license': driver_license,
                    'address': address,
                    'status': status
                },
                success: function(response) {
                    // Handle the success response
                    Swal.fire({
                        title: 'Success!',
                        text: 'Driver updated successfully.',
                        icon: 'success',
                        timer: 2000, // 2 seconds
                        timerProgressBar: true,
                        didClose: () => {
                            // Reload the page to reflect the changes
                            // location.reload(); 
                            driver();
                        }
                    });
                    $(`#driverEdit${id}`).modal('hide');

                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    Swal.fire("Error!", "Failed to update driver.", "error");
                }
            });
        });
    </script>
@endpush
