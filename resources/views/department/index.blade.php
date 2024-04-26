@extends('layouts.app')
@section('content')

    <div class="card-header bg-success text-white">
        <h3 class="mb-0">Create a Department</h3>
        <button type="button" class="btn btn-success mt-3 bg-dark" data-bs-toggle="modal"
                data-bs-target="#addNewDepartment">
            Add
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addNewDepartment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form>
                <div class="modal-content create-new-department-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create new Department</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-1">
                            <label for="name" class="form-label">Department Name</label>
                            <input type="text" class="form-control" id="name" name="nameid" placeholder="Department"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="descriptionid" rows="5"
                                      required></textarea>
                        </div>

                        <button type="button" id="createDepartmentBtn" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered display" id="dataTable">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Department Name</th>
            <th scope="col">Description</th>
            <th scope="col">Created</th>
            <th scope="col">Update</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>


        </tbody>
    </table>
@endsection
@push('scripts')
    {{-- ajax crud --}}
    <script>


            $(document).ready(function () {
                $('#dataTable').DataTable().destroy();
                $('tbody').empty();

                $.ajax({
                    type: 'get',
                    url: '/admin/datadeparts',
                    success: function (data) {
                        $.each(data.departments, function (index, department) {
                            var key = index + 1;

                            let row =
                                `<tr id="trId${department.id}">
                            <td>${key}</td>
                            <td id="nameid${department.id}">${department.name}</td>
                            <td id="descriptionid${department.id}">${department.description}</td>
                            <td id="createdAtId${department.id}">${formatDate(department.created_at)}</td>
                            <td id="updatedAtId${department.id}">${formatDate(department.updated_at)}</td>
                            <td class="{{auth()->user()->role === 'admin'? '' : 'd-none'}}">
                                <a href="#" id="editDepartmentId${department.id}" data-bs-toggle="modal" data-bs-target="#editDepartmentModal${department.id}">
                                    Edit
                                </a>
                                <a href="#" onclick="confirmDelete(${department.id});" id="deleteDepartmentId${department.id}">
                                    Delete
                                </a>
                            </td>
                        </tr>`;

                            // Append the row to the table body
                            $('tbody').append(row);
                        });
                        $('#dataTable').DataTable();
                    }

                });

                $('#createDepartmentBtn').on('click', function () {
                    let name = $('#name').val();
                    let description = $('#description').val();
                    createDepartment(name, description, function (success) {
                        if (success === true) {
                            Swal.fire("Success!", "Department added successfully.", "success");
                            $('#name').val('');
                            $('#description').val('');
                            datadeparts();
                        }
                    });
                });

                datadeparts();

                function createDepartment(name, description, callback) {
                    $.ajax({
                        type: 'post',
                        url: '/admin/yawa',
                        data: {
                            'name': name,
                            'description': description,
                        },
                        success: function (data) {
                            if (data.message === 'success') {
                                callback(true); // Invoke the callback with true indicating success
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr);
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
                            deleteDepartment(id);
                            Swal.fire("Deleted!", "Successfully deleted.", "success");
                        }
                    });
                }

                function deleteDepartment(id) {
                    $.ajax({
                        type: 'post',
                        url: '/deletebyid',
                        data: {
                            'id': id
                        },
                        success: function (data) {
                            datadeparts();
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr);
                        }
                    });
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
                    return monthNames[monthIndex] + ' ' + day + ', ' + year;
                }

            });
    </script>
@endpush
