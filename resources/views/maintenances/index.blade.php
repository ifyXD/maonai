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
                                Maintenances
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
                        data-target="#addNewMaintenance">
                        <div>
                            <i data-feather="plus-square"></i>
                            Add Maintenance
                        </div>
                    </button>
                </div>
                <div class="card-body">
                        <table class="table table-bordered table-hover" id="datatable" width="100%" cellspacing="1">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Evaluation</th>
                                    <th scope="col">Time to Finish</th>
                                    <th scope="col">Condition</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">Updated at</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="addNewMaintenance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createMaintenanceForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Maintenance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="evaluation">Evaluation</label>
                            <input type="text" class="form-control" id="evaluation" name="evaluation">
                        </div>
                        <div class="form-group">
                            <label for="condition">Condition</label>
                            <input type="text" class="form-control" id="condition" name="condition">
                        </div>
                        <div class="form-group">
                            <label for="timefinish">Time Finish</label>
                            <input type="datetime-local" class="form-control" id="timefinish" name="timefinish">
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" value="pending" id="status" name="status">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="createMaintenanceBtn" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $('option[value="decline"]').hide();
  
          maintenance();
  
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
        function maintenance() {

            $('#datatable').DataTable().destroy();
            $('tbody').empty();
            $.ajax({
                type: 'get',
                url: '/admin/maintenancedata',
                success: function(data) {
                    // Assuming data is an array of user objects
                    $.each(data.maintenances, function(index, maintenance) {
                        var key = index + 1;
                        var ifdel = maintenance.isdel === 'deleted' ? 'is-deleted' : '';

                        var action = maintenance.isdel === 'active' ?
    `<a href="#" class="editMaintenance" data-id="${maintenance.id}" data-bs-toggle="modal" data-bs-target="#maintenanceEdit${maintenance.id}">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
        </svg>
    </a>
    <a href="#" onclick="confirmDelete(${maintenance.id});" id="deleteMaintenance">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
        </svg>
    </a>` :
    `<span class="text-danger">Deleted</span>`;

// Append the row to the table body
let row = `
<tr class="${ifdel}" id="trId${maintenance.id}">
    <td>${key}</td>
    <td id="evaluationId${maintenance.id}">${maintenance.evaluation}</td>
    <td id="timefinishId${maintenance.id}">${formatDate(maintenance.timefinish)}</td>
    <td id="conditionId${maintenance.id}">${maintenance.condition}</td>
    <td id="statusId${maintenance.id}">${maintenance.status}</td>
    <td id="createdAtId${maintenance.id}">${formatDate(maintenance.created_at)}</td>
    <td id="updatedAtId${maintenance.id}">${formatDate(maintenance.updated_at)}</td>
    <td>
        ${action}
                    <div class="modal fade" id="maintenanceEdit${maintenance.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit maintenances</h1>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                            </button>
                                </div>
                                <div class="modal-body"> 
                                    <div class="mb-3">
                                        <label for="editevaluation${maintenance.id}" class="form-label">Evaluation</label>
                                        <input type="text" value="${maintenance.evaluation}" class="form-control" id="editevaluation${maintenance.id}" aria-describedby="emailHelp"> 
                                    </div>
                                    <div class="mb-3">
                                        <label for="edittimefinish${maintenance.id}" class="form-label">Timefinish</label>
                                        <input type="datetime-local" value="${maintenance.timefinish}" class="form-control" id="edittimefinish${maintenance.id}" aria-describedby="emailHelp"> 
                                    </div>
                                    <div class="mb-3">
                                        <label for="editcondition${maintenance.id}" class="form-label">condition</label>
                                        <input type="text" value="${maintenance.condition}" class="form-control" id="editcondition${maintenance.id}" aria-describedby="emailHelp"> 
                                    </div>
                                    <div class="mb-1">
                                    <label for="editstatus" class="form-label">Status</label>
                                    <select name="status" id="status${maintenance.id}"  class="form-control" required>
                                        <option value="pending">Pending</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>



                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="editSaveBtn" data-id="${maintenance.id}">Save</button>
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
                url: '/admin/maintenance/deletebyid',
                data: {
                    'id': userid
                },
                success: function(data) {

                    maintenance();
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

        function createmaintenance(evaluation, timefinish, condition, status,callback) {
            $.ajax({
                type: 'post',
                url: '/admin/addmaintenance',
                data: {
                    'evaluation': evaluation,
                    'timefinish': timefinish,
                    'condition': condition,
                    'status': status,

                },
                success: function(data) {
                    if (data.message === 'success') {
                        $('#messageflash').text('Maintenances added successfully');
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
        $('#createMaintenanceBtn').on('click', function(e) {
            e.preventDefault(); // Prevent the default form submission behavior

            let evaluation = $('#evaluation').val();
            let timefinish = $('#timefinish').val();
            let condition = $('#condition').val();
            let status = $('#status').val();
          
            createmaintenance(evaluation, timefinish, condition, status, function(success) {
                if (success === true) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: " Maintenance Added successfully.",
                        showConfirmButton: true,
                        timer: 2000, // 2 seconds
                        timerProgressBar: true,

                    }).then(() => {
                        $('#evaluation').val('');
                        $('#timefinish').val('');
                        $('#condition').val('');
                        $('#status').val('');
                      

                        // Redirect to the same page to refresh
                        location.reload();
                    });
                }
            });
        });

        $('tbody').on('click', '.editMaintenance', function() {
    // Get the id of the maintenance record to edit
    let id = $(this).data('id');

    // Show the edit modal
    $(`#maintenanceEdit${id}`).modal('show');

    // Get the current maintenance data
    let evaluation = $(`#editevaluation${id}`).val();
    let timefinish = $(`#edittimefinish${id}`).val();
    let condition = $(`#editcondition${id}`).val();
    let status = $(`#status${id}`).val();

    // Update the modal inputs with the current maintenance data
    $(`#editevaluation${id}`).val(evaluation);
    $(`#edittimefinish${id}`).val(timefinish);
    $(`#editcondition${id}`).val(condition);
    $(`#status${id}`).val(status);
});

        // Save button click event listener
        $('tbody').on('click', '#editSaveBtn', function() {
    // Get the id of the maintenance record being edited
    let id = $(this).data('id');

    // Get the updated values from the modal inputs
    let evaluation = $(`#editevaluation${id}`).val();
    let timefinish = $(`#edittimefinish${id}`).val();
    let condition = $(`#editcondition${id}`).val();
    let status = $(`#status${id}`).val();
    console.log(evaluation+timefinish+condition+status);

    // Send the data to the server using AJAX
    $.ajax({
        type: 'post',
        url: '/admin/editbyid',
        data: {
            'id': id,
            'evaluation': evaluation,
            'timefinish': timefinish,
            'condition': condition,
            'status': status
        },
        success: function(response) {
            // Handle the success response
            Swal.fire({
                title: 'Success!',
                text: 'Maintenance updated successfully.',
                icon: 'success',
                timer: 2000, // 2 seconds
                timerProgressBar: true,
                didClose: () => {
                    // Reload the page to reflect the changes
                    location.reload();
                }
            });
            $(`#maintenanceEdit${id}`).modal('hide');
        },
        error: function(xhr, status, error) {
            // Handle the error response
            Swal.fire("Error!", "Failed to update maintenance: " + xhr.responseJSON.message, "error");
        }
    });

});

$(document).on('click', '[data-bs-dismiss="modal"]', function() {
    $(this).closest('.modal').modal('hide');
});

    </script>
@endpush
