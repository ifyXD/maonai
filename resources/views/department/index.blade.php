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
                                Departments
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
                        data-target="#addNewDepartment">
                        <div>
                            <i data-feather="plus-square"></i>
                            Add Department
                        </div>
                    </button>

                </div>

                <div class="card-body">

                    <div class="datatable">
                        <div class="modal fade" id="addNewDepartment" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <form>
                                    <div class="modal-content create-new-department-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Create new Department</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="mb-1">
                                                <label for="name" class="form-label">Department Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="Department" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                                            </div>

                                            <button type="button" id="createDepartmentBtn"
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
                                <th scope="col">Department Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Created</th>
                                <th scope="col">Updated</th>
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
                url: '/admin/departmentdata',
                success: function(data) {
                    $.each(data.departments, function(index, department) {
                        var key = index + 1;
                        var ifdel = department.isdel === 'deleted' ? 'is-deleted' : '';
                        var action = department.isdel === 'active' ?
                            `<a href="#" class="editDepartment" data-id="${department.id}" data-bs-toggle="modal" data-bs-target="#departmentEdit${department.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                            <a href="#" onclick="confirmDelete(${department.id});" id="deleteUserId">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </a>` :
                            `<span class="text-danger">Deleted</span>`;
                        let row = `
                            <tr class="${ifdel}" id="trId${department.id}">
                                <td>${key}</td>
        <td>${department.name}</td>
        <td>${department.description}</td>
        <td>${formatDate(department.created_at)}</td>
        <td>${formatDate(department.updated_at)}</td>
        <td>

            ${action}
            <div class="modal fade" id="departmentEdit${department.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Department</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editname${department.id}" class="form-label">Department</label>
                                <input type="text" value="${department.name}" class="form-control" id="editname${department.id}" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="editdescription${department.id}" class="form-label">Type</label>
                                <textarea class="form-control" id="editdescription${department.id}" rows="5" required>${department.description}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="editSaveBtn" data-id="${department.id}">Save</button>
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
                url: '/admin/department/deletebyid',
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
        function createDepartment(name, description, callback) {
    $.ajax({
        type: 'post',
        url: '/admin/addnewdepartment',
        data: {
            'name': name,
            'description': description,
        },
        success: function(data) {
            if (data.message === 'success') {
                $('#messageflash').text('Department added successfully');
                callback(true); // Invoke the callback with true indicating success
            }
        },
        error: function(xhr, status, error) {
            // Error handling
            var errorMessage = xhr.responseJSON.message;
            if (errorMessage) {
                $('#messageflash').text('Error: ' + errorMessage);
            } else {
                $('#messageflash').text('An error occurred while adding the department');
            }
            callback(false); // Invoke the callback with false indicating failure
        }
    });
}
    </script>

    {{-- jquery code --}}
    <script>
        $('#createDepartmentBtn').on('click', function(e) {
            e.preventDefault(); // Prevent the default form submission behavior

            let name = $('#name').val();
            let description = $('#description').val();
           

            createDepartment(name, description, function(success) {
                if (success === true) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Department added successfully.",
                        showConfirmButton: true,
                        timer: 2000, // 2 seconds
                        timerProgressBar: true,

                    }).then(() => {
                        $('#name').val('');
                        $('#description').val('');
                    

                        // Redirect to the same page to refresh
                        location.reload();
                    });
                }
            });
        });

        $('tbody').on('click', '.editDepartment', function() {
            // Get the id of the vehicle to edit
            let id = $(this).data('id');

            // Show the edit modal
            $(`#departmentEdit${id}`).modal('show');

            // Get the current vehicle data
            let name = $('#name').val();
            let description = $('#description').val();

            // Update the modal inputs with the current vehicle data
            $(`#editname${id}`).val(department.name);
            $(`#editdescription${id}`).val(department.description);
          
        });

        // Save button click event listener
        $('tbody').on('click', '#editSaveBtn', function() {
            // Get the id of the vehicle being edited
            let id = $(this).attr('data-id');

            // Get the updated values from the modal inputs
            let name = $(`#editname${id}`).val();
            let description = $(`#editdescription${id}`).val();
            console.log(name+description);


            // Send the data to the server using AJAX
            $.ajax({
                type: 'post',
                url: '/admin/editbyid',
                data: {
                    'id': id,
                    'name': name,
                    'description': description,
                
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
