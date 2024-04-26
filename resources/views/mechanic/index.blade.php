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
                    <table class="table table-bordered table-hover" id="datatable" width="100%" cellspacing="1">
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


                            $('#datatable').DataTable().destroy();

                            $('tbody').empty();
                            $.ajax({
                                type: 'get',
                                url: '/admin/mechanicsdata',
                                success: function(data) {
                                    console.log(data.mechanics[1]['id']);
                                    // Assuming data is an array of user objects
                                    $.each(data.mechanics, function(index, mechanic) {
                                        var key = index + 1;
                                        var ifdel = mechanic.isdel === 'deleted' ? 'is-deleted' : '';

                                        var action = mechanic.isdel === 'active' ?


                                            `<a href="#" class="editMechanic" data-id="${mechanic.id}" data-bs-toggle="modal" data-bs-target="#mechanicEdit${mechanic.id}">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
        </svg>
    </a>
    <a href="#" onclick="confirmDelete(${mechanic.id});" id="deleteMechanic">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
        </svg>
    </a>` :
                                            `<span class="text-danger">Deleted</span>`;
                                        // Assuming user has properties like id, name, email, etc.
                                        let row = `
    <tr class="${ifdel}" id="trId${mechanic.id}">
        <td>${key}</td>
        <td>${mechanic.mechanics_name}</td>
        <td>${mechanic.contact}</td>
        <td>${mechanic.email}</td>
        <td>${mechanic.description}</td>
        <td>${mechanic.status}</td>
        <td>${formatDate(mechanic.created_at)}</td>
        <td>${formatDate(mechanic.updated_at)}</td>
        <td>
            ${action}
            <div class="modal fade" id="mechanicEdit${mechanic.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Mechanics</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body"> 
                            <div class="mb-3">
                                <label for="editmechanics${mechanic.id}" class="form-label">Mechanics Name</label>
                                <input type="text" value="${mechanic.mechanics_name}" class="form-control" id="editmechanics${mechanic.id}" aria-describedby="emailHelp"> 
                            </div>
                            <div class="mb-3">
                                <label for="editcontact${mechanic.id}" class="form-label">Contact</label>
                                <input type="text" value="${mechanic.contact}" class="form-control" id="editcontact${mechanic.id}" aria-describedby="emailHelp"> 
                            </div>
                            <div class="mb-3">
                                <label for="editdemail${mechanic.id}" class="form-label">Email</label>
                                <input type="text" value="${mechanic.email}" class="form-control" id="editemail${mechanic.id}" aria-describedby="emailHelp"> 
                            </div>
                            <div class="mb-3">
                                <label for="editdescription${mechanic.id}" class="form-label">Description</label>
                                <input type="text" value="${mechanic.description}" class="form-control" id="editdescription${mechanic.id}" aria-describedby="emailHelp"> 
                            </div>
                            <div class="mb-3">
                                <label for="editstatus${mechanic.id}" class="form-label">Status</label>
                                <select name="status" id="editstatus${mechanic.id}" class="form-control" required>
                                    <option value="pending" ${mechanic.status === 'pending' ? 'selected' : ''}>Pending</option>
                                    <option value="active" ${mechanic.status === 'active' ? 'selected' : ''}>Active</option>
                                    <option value="inactive" ${mechanic.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="editSaveBtn" data-id="${mechanic.id}">Save</button>
                        </div>
                    </div>
                </div>
            </div> 
        </td>
    </tr>`;
                                        // Append the row to the 


                                        $('tbody').append(row);
                                    });
                                    $('#datatable').DataTable();


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
        if (data) {
            $('#messageflash').text('Mechanic added successfully');
            $('#exampleModal').modal('hide'); // Close the modal
            callback(true); // Invoke the callback with true indicating success
        }
    },
    error: function(xhr, status, error) {
        // Error handling
        var errorMessage = xhr.responseJSON.message;
        if (errorMessage) {
            $('#messageflash').text('Error: ' + errorMessage);
        } else {
            $('#messageflash').text('An error occurred while adding the mechanic');
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
                timer: 2000, // 2 seconds
                timerProgressBar: true,

            }).then(() => {
                $('#mechanics_name').val('');
                $('#contact').val('');
                $('#email').val('');
                $('#description').val('');
                $('#status').val('');
                location.reload();

                // Reload the DataTable to reflect the new data
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
    $('tbody').on('click', '#editSaveBtn', function() {
        // Get the id of the mechanic being edited
        let id = $(this).attr('data-id');

        // Get the updated values from the modal inputs
        let mechanics_name = $(`#editmechanics${id}`).val();
        let contact = $(`#editcontact${id}`).val();
        let email = $(`#editemail${id}`).val();
        let description = $(`#editdescription${id}`).val();
        let status = $(`#editstatus${id}`).val();
        console.log(mechanics_name+contact+email+description+status);

        // Send the data to the server using AJAX
        $.ajax({
            type: 'post',
            url: '/admin/editbyid',
            data: {
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
                    timer: 2000, // 2 seconds
                    timerProgressBar: true,
                    didClose: () => {
                        // Reload the page to reflect the changes
                        location.reload();
                    }
                });
                $(`#mechanicEdit${id}`).modal('hide');
            },
            error: function(xhr, status, error) {
                // Handle the error response
                Swal.fire("Error!", "Failed to update mechanic.", "error");
            }
        });
    });

                    </script>
                @endpush
